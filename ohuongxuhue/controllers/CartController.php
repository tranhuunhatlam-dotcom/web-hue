<?php
/**
 * Controller Quản lý Giỏ hàng & Đặt hàng (CartController)
 */

class CartController extends BaseController {
    private $productModel;
    private $orderModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $this->productModel = new ProductModel();
        $this->orderModel   = new OrderModel();
    }

    /**
     * Xem trang Giỏ hàng & Thanh toán
     */
    public function index() {
        $cartItems = $_SESSION['cart'] ?? [];
        $subtotal = 0;

        foreach ($cartItems as $item) {
            $subtotal += intval($item['price_raw']) * intval($item['quantity']);
        }

        // Chính sách vận chuyển: Đơn >= 300.000₫ miễn phí giao hàng, dưới tính 30.000₫
        $shippingFee = ($subtotal > 0 && $subtotal >= 300000) ? 0 : ($subtotal > 0 ? 30000 : 0);
        $grandTotal  = $subtotal + $shippingFee;

        $currentUser = $_SESSION['user'] ?? null;

        $this->render('cart/index', [
            'pageTitle'    => 'Giỏ Hàng & Đặt Mua Đặc Sản - O Hương Xứ Huế',
            'currentNav'   => 'cart',
            'cartItems'    => $cartItems,
            'subtotal'     => $subtotal,
            'shippingFee'  => $shippingFee,
            'grandTotal'   => $grandTotal,
            'currentUser'  => $currentUser,
            'flashMessage' => $_SESSION['cart_flash'] ?? null
        ]);

        unset($_SESSION['cart_flash']);
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add() {
        $productId = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 1;
        $quantity  = isset($_REQUEST['quantity']) ? max(1, intval($_REQUEST['quantity'])) : 1;

        $product = $this->productModel->findProductById($productId);
        if (!$product) {
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm!']);
                exit;
            }
            header('Location: ?controller=cart');
            exit;
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'id'        => $product['id'],
                'name'      => $product['name'],
                'price'     => $product['price'],
                'price_raw' => $product['raw_price'],
                'image'     => $product['image'],
                'category'  => $product['category'],
                'quantity'  => $quantity
            ];
        }

        $totalCartCount = $this->getCartTotalCount();

        if ($this->isAjax()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success'    => true,
                'message'    => 'Đã thêm "' . $product['name'] . '" vào giỏ hàng thành công!',
                'cart_count' => $totalCartCount
            ]);
            exit;
        }

        $_SESSION['cart_flash'] = 'Đã thêm "' . $product['name'] . '" vào giỏ hàng thành công!';
        $redirect = isset($_REQUEST['redirect']) ? $_REQUEST['redirect'] : '?controller=cart';
        header('Location: ' . $redirect);
        exit;
    }

    /**
     * Cập nhật số lượng hoặc xóa sản phẩm khỏi giỏ
     */
    public function update() {
        $productId = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $act       = isset($_REQUEST['act']) ? $_REQUEST['act'] : 'inc';

        if (isset($_SESSION['cart'][$productId])) {
            if ($act === 'inc') {
                $_SESSION['cart'][$productId]['quantity']++;
            } elseif ($act === 'dec') {
                $_SESSION['cart'][$productId]['quantity']--;
                if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
                    unset($_SESSION['cart'][$productId]);
                }
            } elseif ($act === 'remove') {
                unset($_SESSION['cart'][$productId]);
            }
        }

        header('Location: ?controller=cart');
        exit;
    }

    /**
     * Xử lý Đặt hàng (Checkout)
     */
    public function checkout() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controller=cart');
            exit;
        }

        $cartItems = $_SESSION['cart'] ?? [];
        if (empty($cartItems)) {
            $_SESSION['cart_flash'] = 'Giỏ hàng của bạn đang trống! Vui lòng chọn sản phẩm trước khi đặt hàng.';
            header('Location: ?controller=cart');
            exit;
        }

        $name    = sanitize_text_field($_POST['customer_name'] ?? '');
        $phone   = sanitize_text_field($_POST['customer_phone'] ?? '');
        $address = sanitize_text_field($_POST['customer_address'] ?? '');
        $note    = sanitize_textarea_field($_POST['customer_note'] ?? '');
        $payment = sanitize_text_field($_POST['payment_method'] ?? 'cod');

        if (empty($name) || empty($phone) || empty($address)) {
            $_SESSION['cart_flash'] = 'Vui lòng điền đầy đủ họ tên, số điện thoại và địa chỉ nhận hàng!';
            header('Location: ?controller=cart');
            exit;
        }

        // Tính tổng tiền
        $subtotal = 0;
        $orderItems = [];
        foreach ($cartItems as $item) {
            $subtotal += intval($item['price_raw']) * intval($item['quantity']);
            $orderItems[] = [
                'id'       => $item['id'],
                'name'     => $item['name'],
                'price'    => $item['price'],
                'price_raw'=> $item['price_raw'],
                'quantity' => $item['quantity'],
                'image'    => $item['image']
            ];
        }

        $shippingFee = ($subtotal >= 300000) ? 0 : 30000;
        $totalAmount = $subtotal + $shippingFee;

        $userId = isset($_SESSION['user']['id']) ? intval($_SESSION['user']['id']) : null;

        // Lưu đơn hàng vào cơ sở dữ liệu
        $orderResult = $this->orderModel->createOrder([
            'user_id'          => $userId,
            'customer_name'    => $name,
            'customer_phone'   => $phone,
            'customer_address' => $address,
            'customer_note'    => $note,
            'payment_method'   => $payment,
            'total_amount'     => $totalAmount,
            'items'            => $orderItems
        ]);

        $orderCode = $orderResult['order_code'];
        $_SESSION['recent_order_code'] = $orderCode;
        $_SESSION['recent_order_phone']= $phone;

        // Xóa giỏ hàng sau khi đặt thành công
        $_SESSION['cart'] = [];

        // Chuyển hướng đến trang lịch sử đơn hàng với thông báo thành công
        header('Location: ?controller=cart&action=orders&order_success=' . urlencode($orderCode));
        exit;
    }

    /**
     * Xem danh sách các đơn hàng đã đặt
     */
    public function orders() {
        $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
        $phone  = isset($_SESSION['recent_order_phone']) ? $_SESSION['recent_order_phone'] : null;

        $orders = $this->orderModel->getOrdersForCustomer($userId, $phone);
        $orderSuccessCode = isset($_GET['order_success']) ? sanitize_text_field($_GET['order_success']) : null;

        $this->render('cart/orders', [
            'pageTitle'        => 'Đơn Hàng Của Tôi - O Hương Xứ Huế',
            'currentNav'       => 'orders',
            'orders'           => $orders,
            'orderSuccessCode' => $orderSuccessCode
        ]);
    }

    /**
     * Đếm tổng số món trong giỏ hàng
     */
    public static function getCartTotalCount() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $count = 0;
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $count += intval($item['quantity']);
            }
        }
        return $count;
    }

    private function isAjax() {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') || isset($_REQUEST['ajax']);
    }
}
