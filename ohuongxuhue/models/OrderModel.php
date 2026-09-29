<?php
/**
 * Model Quản lý Đơn hàng (OrderModel)
 * Lưu trữ đơn hàng vào cơ sở dữ liệu MySQL (bảng orders) kèm cơ chế đồng bộ dự phòng
 */

require_once __DIR__ . '/BaseModel.php';

class OrderModel extends BaseModel {
    protected static $backupFile;

    public function __construct() {
        parent::__construct();
        self::$backupFile = __DIR__ . '/../config/orders_backup.json';
        $this->initTable();
    }

    /**
     * Khởi tạo bảng orders nếu chưa tồn tại
     */
    private function initTable() {
        if ($this->db) {
            $sql = "CREATE TABLE IF NOT EXISTS orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                order_code VARCHAR(50) NOT NULL UNIQUE,
                user_id INT NULL,
                customer_name VARCHAR(255) NOT NULL,
                customer_phone VARCHAR(50) NOT NULL,
                customer_address TEXT NOT NULL,
                customer_note TEXT NULL,
                payment_method VARCHAR(50) DEFAULT 'cod',
                total_amount INT NOT NULL,
                items_json LONGTEXT NOT NULL,
                status VARCHAR(50) DEFAULT 'pending',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $this->db->exec($sql);
        }
    }

    /**
     * Tạo mã đơn hàng duy nhất dạng OHX-XXXXXX
     */
    public static function generateOrderCode() {
        return 'OHX-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
    }

    /**
     * Tạo đơn hàng mới
     */
    public function createOrder($data) {
        $orderCode = !empty($data['order_code']) ? $data['order_code'] : self::generateOrderCode();
        $userId    = isset($data['user_id']) ? intval($data['user_id']) : null;
        $name      = trim($data['customer_name'] ?? '');
        $phone     = trim($data['customer_phone'] ?? '');
        $address   = trim($data['customer_address'] ?? '');
        $note      = trim($data['customer_note'] ?? '');
        $payment   = trim($data['payment_method'] ?? 'cod');
        $total     = intval($data['total_amount'] ?? 0);
        $rawItems  = $data['items'] ?? ($data['items_json'] ?? []);
        $itemsJson = is_array($rawItems) ? json_encode($rawItems, JSON_UNESCAPED_UNICODE) : (string)$rawItems;
        $status    = $data['status'] ?? 'pending';

        $insertedId = null;

        if ($this->db) {
            $stmt = $this->db->prepare("INSERT INTO orders 
                (order_code, user_id, customer_name, customer_phone, customer_address, customer_note, payment_method, total_amount, items_json, status, created_at)
                VALUES (:order_code, :user_id, :name, :phone, :address, :note, :payment, :total, :items, :status, NOW())");
            $success = $stmt->execute([
                ':order_code' => $orderCode,
                ':user_id'    => $userId,
                ':name'       => $name,
                ':phone'      => $phone,
                ':address'    => $address,
                ':note'       => $note,
                ':payment'    => $payment,
                ':total'      => $total,
                ':items'      => $itemsJson,
                ':status'     => $status
            ]);
            if ($success) {
                $insertedId = $this->db->lastInsertId();
            }
        }

        // Lưu bản dự phòng vào JSON để đảm bảo dữ liệu luôn khả dụng
        $this->saveBackupOrder([
            'id'               => $insertedId ?? time(),
            'order_code'       => $orderCode,
            'user_id'          => $userId,
            'customer_name'    => $name,
            'customer_phone'   => $phone,
            'customer_address' => $address,
            'customer_note'    => $note,
            'payment_method'   => $payment,
            'total_amount'     => $total,
            'items_json'       => $itemsJson,
            'status'           => $status,
            'created_at'       => date('Y-m-d H:i:s')
        ]);

        // Tự động trừ tồn kho các sản phẩm đã đặt
        $itemsList = is_string($rawItems) ? json_decode($rawItems, true) : $rawItems;
        if (is_array($itemsList)) {
            require_once __DIR__ . '/ProductModel.php';
            $productModel = new ProductModel();
            foreach ($itemsList as $it) {
                $pid = intval($it['id'] ?? 0);
                $qty = intval($it['quantity'] ?? 1);
                if ($pid > 0) {
                    $productModel->deductStock($pid, $qty);
                }
            }
        }

        return [
            'id'         => $insertedId,
            'order_code' => $orderCode
        ];
    }

    /**
     * Lấy toàn bộ đơn hàng (Dành cho Admin)
     */
    public function getAllOrders() {
        if ($this->db) {
            try {
                $stmt = $this->db->query("SELECT * FROM orders ORDER BY created_at DESC");
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($orders)) {
                    return $this->formatOrdersList($orders);
                }
            } catch (Exception $e) {
                // Fallback nếu có lỗi
            }
        }
        return $this->formatOrdersList($this->readBackupOrders());
    }

    /**
     * Lấy đơn hàng theo User ID hoặc SĐT (Dành cho Khách xem lịch sử đơn)
     */
    public function getOrdersForCustomer($userId = null, $phone = null) {
        $all = $this->getAllOrders();
        $filtered = [];

        foreach ($all as $ord) {
            if ($userId && intval($ord['user_id']) === intval($userId)) {
                $filtered[] = $ord;
            } elseif ($phone && trim($ord['customer_phone']) === trim($phone)) {
                $filtered[] = $ord;
            }
        }

        // Nếu người dùng chưa có đơn trong tài khoản nhưng có đơn vừa đặt trong session
        if (empty($filtered) && isset($_SESSION['recent_order_code'])) {
            foreach ($all as $ord) {
                if ($ord['order_code'] === $_SESSION['recent_order_code']) {
                    $filtered[] = $ord;
                }
            }
        }

        return $filtered;
    }

    /**
     * Lấy chi tiết đơn hàng theo mã đơn
     */
    public function getOrderByCode($code) {
        $all = $this->getAllOrders();
        foreach ($all as $ord) {
            if ($ord['order_code'] === $code) {
                return $ord;
            }
        }
        return null;
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus($orderIdOrCode, $newStatus) {
        $validStatuses = ['pending', 'confirmed', 'shipping', 'completed', 'cancelled'];
        if (!in_array($newStatus, $validStatuses)) {
            return false;
        }

        if ($this->db) {
            $stmt = $this->db->prepare("UPDATE orders SET status = :status WHERE id = :id OR order_code = :code");
            $stmt->execute([
                ':status' => $newStatus,
                ':id'     => is_numeric($orderIdOrCode) ? $orderIdOrCode : 0,
                ':code'   => $orderIdOrCode
            ]);
        }

        // Cập nhật trong backup file
        $backup = $this->readBackupOrders();
        foreach ($backup as &$b) {
            if ((isset($b['id']) && $b['id'] == $orderIdOrCode) || (isset($b['order_code']) && $b['order_code'] == $orderIdOrCode)) {
                $b['status'] = $newStatus;
            }
        }
        file_put_contents(self::$backupFile, json_encode($backup, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        return true;
    }

    /**
     * Thống kê tổng quan đơn hàng cho Dashboard Admin
     */
    public function getStats() {
        $orders = $this->getAllOrders();
        $totalOrders    = count($orders);
        $pendingOrders  = 0;
        $totalRevenue   = 0;

        foreach ($orders as $ord) {
            if ($ord['status'] === 'pending') {
                $pendingOrders++;
            }
            if ($ord['status'] !== 'cancelled') {
                $totalRevenue += intval($ord['total_amount']);
            }
        }

        return [
            'total_orders'   => $totalOrders,
            'pending_orders' => $pendingOrders,
            'total_revenue'  => $totalRevenue
        ];
    }

    /**
     * Định dạng giải mã items_json sang mảng PHP
     */
    private function formatOrdersList($orders) {
        foreach ($orders as &$ord) {
            if (isset($ord['items_json']) && is_string($ord['items_json'])) {
                $ord['items'] = json_decode($ord['items_json'], true) ?? [];
            } else {
                $ord['items'] = [];
            }
        }
        return $orders;
    }

    private function readBackupOrders() {
        if (file_exists(self::$backupFile)) {
            $json = file_get_contents(self::$backupFile);
            return json_decode($json, true) ?? [];
        }
        return [];
    }

    private function saveBackupOrder($order) {
        $orders = $this->readBackupOrders();
        array_unshift($orders, $order);
        file_put_contents(self::$backupFile, json_encode($orders, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}
