<?php
/**
 * Controller Quản trị viên (AdminController)
 * Quản lý thành viên, danh mục, sản phẩm và tiếp nhận đơn hàng đã đặt
 */

class AdminController extends BaseController {
    private $userModel;
    private $productModel;
    private $categoryModel;
    private $orderModel;

    public function __construct() {
        $this->userModel     = new UserModel();
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->orderModel    = new OrderModel();

        // Kiểm tra phân quyền: Chỉ Admin mới được truy cập
        $this->checkAdminAuth();
    }

    /**
     * Middleware kiểm tra quyền hạn Admin
     */
    private function checkAdminAuth() {
        if (!UserModel::isAdmin()) {
            $_SESSION['flash_error'] = 'Khu vực hạn chế! Bạn cần đăng nhập tài khoản Quản trị viên (Admin) để tiếp tục.';
            $loginUrl = function_exists('home_url') ? home_url('/?controller=auth&action=login') : 'index.php?controller=auth&action=login';
            header("Location: " . $loginUrl);
            exit;
        }
    }

    /**
     * Trang Dashboard quản trị tổng quan
     */
    public function index() {
        $users              = $this->userModel->getAllUsers();
        $categories         = $this->categoryModel->getSidebarCategories();
        $productsWithStock  = $this->productModel->getAllProductsWithStock();
        $importHistory      = $this->productModel->getImportHistory(15);
        $financials         = $this->productModel->getFinancialSummary($this->orderModel);

        $orders             = $this->orderModel->getAllOrders();
        $orderStats         = $this->orderModel->getStats();

        $totalProducts      = count($productsWithStock);
        $totalUsers         = count($users);
        $totalCats          = count($categories);

        $flashNotice = $_SESSION['admin_flash'] ?? null;
        unset($_SESSION['admin_flash']);

        $this->render('admin/dashboard', [
            'pageTitle'          => 'Bảng Điều Khiển Quản Trị - O Hương Xứ Huế',
            'currentNav'         => 'admin',
            'users'              => $users,
            'orders'             => $orders,
            'orderStats'         => $orderStats,
            'productsWithStock'  => $productsWithStock,
            'importHistory'      => $importHistory,
            'financials'         => $financials,
            'totalProducts'      => $totalProducts,
            'totalUsers'         => $totalUsers,
            'totalCats'          => $totalCats,
            'flashNotice'        => $flashNotice
        ]);
    }

    /**
     * Cập nhật trạng thái đơn hàng (Duyệt đơn, Đang giao, Hoàn thành, Hủy)
     */
    public function updateOrderStatus() {
        $orderId = isset($_REQUEST['order_id']) ? sanitize_text_field($_REQUEST['order_id']) : '';
        $status  = isset($_REQUEST['status']) ? sanitize_text_field($_REQUEST['status']) : '';

        if (!empty($orderId) && !empty($status)) {
            $this->orderModel->updateStatus($orderId, $status);
            
            $statusLabels = [
                'pending'   => 'Chờ xác nhận',
                'confirmed' => 'Đã duyệt đơn',
                'shipping'  => 'Đang giao hàng',
                'completed' => 'Hoàn thành',
                'cancelled' => 'Đã hủy đơn'
            ];
            $label = $statusLabels[$status] ?? $status;
            $_SESSION['admin_flash'] = "Đã cập nhật trạng thái đơn hàng #{$orderId} sang '{$label}' thành công!";
        }

        header('Location: ?controller=admin');
        exit;
    }

    /**
     * Nhập hàng thêm vào kho (Tăng số lượng tồn kho & ghi nhận chi phí vốn)
     */
    public function importProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId   = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
            $quantity    = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
            $importPrice = isset($_POST['import_price']) ? intval($_POST['import_price']) : 0;
            $supplier    = isset($_POST['supplier']) ? sanitize_text_field($_POST['supplier']) : '';
            $note        = isset($_POST['note']) ? sanitize_text_field($_POST['note']) : '';

            if ($productId > 0 && $quantity > 0) {
                $res = $this->productModel->importStock($productId, $quantity, $importPrice, $supplier, $note);
                $_SESSION['admin_flash'] = "✓ Nhập hàng thành công! Đã thêm {$quantity} phần '{$res['product_name']}' vào kho (Mã phiếu: {$res['import_code']}, Tổng tiền vốn: " . number_format($res['total_cost']) . " ₫)";
            } else {
                $_SESSION['admin_flash'] = "Lỗi: Vui lòng chọn sản phẩm và nhập số lượng lớn hơn 0!";
            }
        }

        header('Location: ?controller=admin#section-inventory');
        exit;
    }
}
