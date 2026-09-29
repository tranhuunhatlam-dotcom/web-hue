<?php
/**
 * View Danh Sách Đơn Hàng Đã Đặt Của Khách Hàng (views/cart/orders.php)
 */
$theme_uri        = function_exists('get_template_directory_uri') ? get_template_directory_uri() : '.';
$home_url         = function_exists('home_url') ? home_url('/') : 'index.php';
$dacsan_url       = function_exists('home_url') ? home_url('/?controller=dac-san') : 'index.php?controller=dac-san';
$orders           = $orders ?? [];
$orderSuccessCode = $orderSuccessCode ?? null;

$statusConfig = [
    'pending'   => ['label' => 'Chờ Xác Nhận', 'class' => 'status-pending', 'icon' => '⏳', 'step' => 1],
    'confirmed' => ['label' => 'Đã Duyệt Đơn', 'class' => 'status-confirmed', 'icon' => '📑', 'step' => 2],
    'shipping'  => ['label' => 'Đang Giao Hàng', 'class' => 'status-shipping', 'icon' => '🚚', 'step' => 3],
    'completed' => ['label' => 'Hoàn Thành', 'class' => 'status-completed', 'icon' => '✅', 'step' => 4],
    'cancelled' => ['label' => 'Đã Hủy', 'class' => 'status-cancelled', 'icon' => '❌', 'step' => 0],
];
?>

<div class="orders-page-master">
    <!-- Header Banner -->
    <section class="orders-hero-banner">
        <div class="orders-hero-content">
            <nav class="orders-breadcrumb">
                <a href="<?php echo esc_url($home_url); ?>">Trang Chủ</a> &rsaquo; <span>Đơn Hàng Của Tôi</span>
            </nav>
            <h1 class="orders-hero-title">📦 Lịch Sử Đơn Hàng Đã Đặt</h1>
            <p class="orders-hero-desc">Theo dõi tiến độ chế biến, đóng gói và hành trình vận chuyển đặc sản Cố Đô đến tận tay bạn.</p>
        </div>
    </section>

    <div class="orders-container">
        <!-- Thông báo chúc mừng nếu vừa đặt hàng thành công -->
        <?php if (!empty($orderSuccessCode)): ?>
            <div class="order-placed-success-alert">
                <div class="success-alert-icon">🎉</div>
                <div class="success-alert-body">
                    <h3>Đặt Hàng Thành Công! Mã đơn của bạn là: <code><?php echo htmlspecialchars($orderSuccessCode); ?></code></h3>
                    <p>Đơn hàng đã được chuyển ngay sang hệ thống quản lý của O Hương Xứ Huế. Chúng tôi đang chuẩn bị những mẻ đặc sản tươi ngon nhất để gửi đến bạn!</p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($orders)): ?>
            <!-- Trạng thái chưa có đơn hàng -->
            <div class="empty-orders-box">
                <div class="empty-orders-icon">📦</div>
                <h2>Bạn chưa có đơn hàng nào!</h2>
                <p>Hãy chọn cho mình những món bánh nậm lọc, mè xửng dẻo hay tách trà cung đình thơm ngát để thưởng thức nhé.</p>
                <a href="<?php echo esc_url($dacsan_url); ?>" class="btn-go-shop">
                    🏺 Khám Phá Đặc Sản Huế Ngay
                </a>
            </div>
        <?php else: ?>
            <div class="orders-list-wrapper">
                <div class="orders-count-heading">
                    <h2>Danh Sách Đơn Hàng (<?php echo count($orders); ?> đơn)</h2>
                    <a href="<?php echo esc_url($dacsan_url); ?>" class="btn-order-more">&#43; Đặt Thêm Đặc Sản</a>
                </div>

                <?php foreach ($orders as $order): ?>
                    <?php 
                        $statusKey = $order['status'] ?? 'pending';
                        $statusInfo = $statusConfig[$statusKey] ?? $statusConfig['pending'];
                        $currentStep = $statusInfo['step'];
                    ?>
                    <div class="order-card-item">
                        <div class="order-card-header">
                            <div class="order-header-left">
                                <span class="order-code-badge">Mã Đơn: <strong>#<?php echo htmlspecialchars($order['order_code']); ?></strong></span>
                                <span class="order-date-text">📅 Ngày đặt: <?php echo htmlspecialchars($order['created_at']); ?></span>
                            </div>
                            <div class="order-header-right">
                                <span class="order-status-pill <?php echo $statusInfo['class']; ?>">
                                    <?php echo $statusInfo['icon']; ?> <?php echo $statusInfo['label']; ?>
                                </span>
                            </div>
                        </div>

                        <!-- Thanh tiến trình đơn hàng (Chỉ hiển thị nếu không bị hủy) -->
                        <?php if ($statusKey !== 'cancelled'): ?>
                            <div class="order-progress-stepper">
                                <div class="step-point <?php echo ($currentStep >= 1) ? 'active' : ''; ?>">
                                    <div class="step-circle">1</div>
                                    <span class="step-text">Đã Tiếp Nhận</span>
                                </div>
                                <div class="step-line <?php echo ($currentStep >= 2) ? 'active' : ''; ?>"></div>
                                <div class="step-point <?php echo ($currentStep >= 2) ? 'active' : ''; ?>">
                                    <div class="step-circle">2</div>
                                    <span class="step-text">Đã Duyệt Đơn</span>
                                </div>
                                <div class="step-line <?php echo ($currentStep >= 3) ? 'active' : ''; ?>"></div>
                                <div class="step-point <?php echo ($currentStep >= 3) ? 'active' : ''; ?>">
                                    <div class="step-circle">3</div>
                                    <span class="step-text">Đang Giao Hàng</span>
                                </div>
                                <div class="step-line <?php echo ($currentStep >= 4) ? 'active' : ''; ?>"></div>
                                <div class="step-point <?php echo ($currentStep >= 4) ? 'active' : ''; ?>">
                                    <div class="step-circle">4</div>
                                    <span class="step-text">Đã Hoàn Thành</span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Thông tin người nhận -->
                        <div class="order-recipient-box">
                            <div class="recipient-col">
                                <strong>👤 Người nhận:</strong> <?php echo htmlspecialchars($order['customer_name']); ?>
                            </div>
                            <div class="recipient-col">
                                <strong>📞 Số điện thoại:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?>
                            </div>
                            <div class="recipient-col">
                                <strong>📍 Địa chỉ giao:</strong> <?php echo htmlspecialchars($order['customer_address']); ?>
                            </div>
                            <?php if (!empty($order['customer_note'])): ?>
                                <div class="recipient-col">
                                    <strong>📝 Ghi chú:</strong> <em><?php echo htmlspecialchars($order['customer_note']); ?></em>
                                </div>
                            <?php endif; ?>
                            <div class="recipient-col">
                                <strong>💳 Thanh toán:</strong> <?php echo ($order['payment_method'] === 'vietqr') ? 'Chuyển khoản VietQR' : 'Thanh toán khi nhận hàng (COD)'; ?>
                            </div>
                        </div>

                        <!-- Danh sách món đã đặt -->
                        <div class="order-items-table-box">
                            <table class="order-items-table">
                                <thead>
                                    <tr>
                                        <th>Món Đặc Sản</th>
                                        <th>Đơn Giá</th>
                                        <th>Số Lượng</th>
                                        <th style="text-align: right;">Thành Tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <?php $lineTotal = intval($item['price_raw'] ?? 0) * intval($item['quantity'] ?? 1); ?>
                                        <tr>
                                            <td class="item-name-col">
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="" class="mini-item-img">
                                                <?php endif; ?>
                                                <span><?php echo htmlspecialchars($item['name']); ?></span>
                                            </td>
                                            <td><?php echo htmlspecialchars($item['price'] ?? number_format($item['price_raw'], 0, ',', '.') . ' ₫'); ?></td>
                                            <td><strong>x<?php echo $item['quantity']; ?></strong></td>
                                            <td style="text-align: right; font-weight: 700;">
                                                <?php echo number_format($lineTotal, 0, ',', '.'); ?> ₫
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Chân thẻ đơn hàng -->
                        <div class="order-card-footer">
                            <span class="support-hint">Cần hỗ trợ đơn hàng? Gọi ngay hotline <strong>0234 388 9999</strong></span>
                            <div class="order-total-block">
                                <span class="total-label">Tổng thanh toán:</span>
                                <span class="total-val"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> ₫</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
