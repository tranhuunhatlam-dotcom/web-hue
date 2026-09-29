<?php
/**
 * View Giỏ Hàng & Thanh Toán (views/cart/index.php)
 */
$theme_uri     = function_exists('get_template_directory_uri') ? get_template_directory_uri() : '.';
$home_url      = function_exists('home_url') ? home_url('/') : 'index.php';
$dacsan_url    = function_exists('home_url') ? home_url('/?controller=dac-san') : 'index.php?controller=dac-san';
$cartItems     = $cartItems ?? [];
$subtotal      = $subtotal ?? 0;
$shippingFee   = $shippingFee ?? 0;
$grandTotal    = $grandTotal ?? 0;
$currentUser   = $currentUser ?? null;
$flashMessage  = $flashMessage ?? null;
?>

<div class="cart-page-master">
    <!-- Header Banner -->
    <section class="cart-hero-banner">
        <div class="cart-hero-content">
            <nav class="cart-breadcrumb">
                <a href="<?php echo esc_url($home_url); ?>">Trang Chủ</a> &rsaquo; <span>Giỏ Hàng Của Bạn</span>
            </nav>
            <h1 class="cart-hero-title">🛒 Giỏ Hàng & Đặt Mua Đặc Sản</h1>
            <p class="cart-hero-desc">Kiểm tra lại các thức quà Cố Đô bạn đã chọn và tiến hành đặt hàng nhận hàng tận nơi.</p>
        </div>
    </section>

    <div class="cart-container">
        <?php if (!empty($flashMessage)): ?>
            <div class="cart-alert-info">
                <span>🔔 <?php echo htmlspecialchars($flashMessage); ?></span>
            </div>
        <?php endif; ?>

        <?php if (empty($cartItems)): ?>
            <!-- Trạng thái giỏ hàng trống -->
            <div class="empty-cart-box">
                <div class="empty-cart-icon">🛍️</div>
                <h2>Giỏ hàng của bạn đang trống!</h2>
                <p>Bạn chưa thêm đặc sản nào vào giỏ hàng. Hãy khám phá những thức bánh, kẹo mè xửng và trà cung đình tuyệt hảo của O Hương Xứ Huế nhé.</p>
                <a href="<?php echo esc_url($dacsan_url); ?>" class="btn-go-shop">
                    🏺 Khám Phá Đặc Sản Huế Ngay
                </a>
            </div>
        <?php else: ?>
            <!-- Bố cục Giỏ hàng 2 cột -->
            <div class="cart-content-grid">
                <!-- Cột Trái: Danh sách sản phẩm trong giỏ -->
                <div class="cart-items-column">
                    <div class="cart-card-box">
                        <div class="cart-box-header">
                            <h3>Danh Sách Món Đã Chọn (<?php echo count($cartItems); ?> loại đặc sản)</h3>
                            <a href="<?php echo esc_url($dacsan_url); ?>" class="link-add-more">&#43; Chọn thêm món khác</a>
                        </div>

                        <div class="cart-items-list">
                            <?php foreach ($cartItems as $item): ?>
                                <?php 
                                    $itemTotal = intval($item['price_raw']) * intval($item['quantity']); 
                                ?>
                                <div class="cart-item-row">
                                    <div class="item-img">
                                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                    </div>
                                    <div class="item-info">
                                        <span class="item-cat"><?php echo htmlspecialchars($item['category']); ?></span>
                                        <h4 class="item-title"><?php echo htmlspecialchars($item['name']); ?></h4>
                                        <div class="item-unit-price"><?php echo htmlspecialchars($item['price']); ?> / phần</div>
                                    </div>
                                    <div class="item-quantity-control">
                                        <a href="?controller=cart&action=update&id=<?php echo $item['id']; ?>&act=dec" class="btn-qty-adj">&minus;</a>
                                        <span class="qty-num"><?php echo $item['quantity']; ?></span>
                                        <a href="?controller=cart&action=update&id=<?php echo $item['id']; ?>&act=inc" class="btn-qty-adj">&#43;</a>
                                    </div>
                                    <div class="item-subtotal">
                                        <?php echo number_format($itemTotal, 0, ',', '.'); ?> ₫
                                    </div>
                                    <div class="item-remove">
                                        <a href="?controller=cart&action=update&id=<?php echo $item['id']; ?>&act=remove" title="Xóa món này" onclick="return confirm('Bạn có chắc muốn xóa đặc sản này khỏi giỏ?')">
                                            🗑️
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="cart-shipping-notice">
                            <?php if ($subtotal >= 300000): ?>
                                <span class="free-ship-tag">🎉 Chúc mừng! Đơn hàng của bạn được MIỄN PHÍ VẬN CHUYỂN toàn quốc!</span>
                            <?php else: ?>
                                <span>🚚 Mua thêm <strong><?php echo number_format(300000 - $subtotal, 0, ',', '.'); ?> ₫</strong> để được <strong>MIỄN PHÍ VẬN CHUYỂN</strong> toàn quốc!</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Cột Phải: Tóm tắt & Form đặt mua thanh toán -->
                <div class="cart-checkout-column">
                    <div class="cart-card-box checkout-box">
                        <h3 class="checkout-title">Thông Tin Đặt Hàng & Giao Nhận</h3>
                        
                        <form action="?controller=cart&action=checkout" method="POST" class="checkout-form" onsubmit="return validateCheckout()">
                            <div class="checkout-form-group">
                                <label for="c_name">Họ và tên người nhận <span class="req">*</span></label>
                                <input type="text" id="c_name" name="customer_name" value="<?php echo htmlspecialchars($currentUser['fullname'] ?? ''); ?>" required placeholder="Ví dụ: Hoàng Mai Lan">
                            </div>

                            <div class="checkout-form-group">
                                <label for="c_phone">Số điện thoại nhận hàng <span class="req">*</span></label>
                                <input type="tel" id="c_phone" name="customer_phone" value="<?php echo htmlspecialchars($currentUser['phone'] ?? ''); ?>" required placeholder="Ví dụ: 0905123456">
                            </div>

                            <div class="checkout-form-group">
                                <label for="c_address">Địa chỉ nhận hàng chi tiết <span class="req">*</span></label>
                                <textarea id="c_address" name="customer_address" rows="2" required placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố..."></textarea>
                            </div>

                            <div class="checkout-form-group">
                                <label for="c_note">Ghi chú giao hàng (nếu có)</label>
                                <input type="text" id="c_note" name="customer_note" placeholder="Ví dụ: Giao giờ hành chính, đóng thùng xốp đi máy bay...">
                            </div>

                            <!-- Phương thức thanh toán -->
                            <div class="checkout-form-group">
                                <label>Phương thức thanh toán</label>
                                <div class="payment-options">
                                    <label class="payment-radio-label">
                                        <input type="radio" name="payment_method" value="cod" checked>
                                        <span class="radio-custom"></span>
                                        <div class="payment-text">
                                            <strong>💵 Thanh toán khi nhận hàng (COD)</strong>
                                            <span>Kiểm tra hàng tươi ngon trước khi thanh toán</span>
                                        </div>
                                    </label>
                                    <label class="payment-radio-label">
                                        <input type="radio" name="payment_method" value="vietqr">
                                        <span class="radio-custom"></span>
                                        <div class="payment-text">
                                            <strong>📱 Chuyển khoản VietQR hỏa tốc</strong>
                                            <span>Quét mã QR qua ứng dụng ngân hàng bất kỳ</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Tổng tính tiền -->
                            <div class="order-summary-table">
                                <div class="summary-row">
                                    <span>Tạm tính tiền hàng:</span>
                                    <strong><?php echo number_format($subtotal, 0, ',', '.'); ?> ₫</strong>
                                </div>
                                <div class="summary-row">
                                    <span>Phí giao hàng:</span>
                                    <span>
                                        <?php if ($shippingFee == 0): ?>
                                            <span style="color: #27ae60; font-weight: 700;">MIỄN PHÍ</span>
                                        <?php else: ?>
                                            <?php echo number_format($shippingFee, 0, ',', '.'); ?> ₫
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <div class="summary-row total-row">
                                    <span>TỔNG THANH TOÁN:</span>
                                    <strong class="grand-total-val"><?php echo number_format($grandTotal, 0, ',', '.'); ?> ₫</strong>
                                </div>
                            </div>

                            <button type="submit" class="btn-submit-order">
                                🚀 XÁC NHẬN ĐẶT HÀNG NGAY
                            </button>
                            <p class="order-guarantee-note">🛡️ Cam kết 100% chính gốc Huế - Đổi trả miễn phí nếu không hài lòng</p>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function validateCheckout() {
    var name = document.getElementById('c_name').value.trim();
    var phone = document.getElementById('c_phone').value.trim();
    var address = document.getElementById('c_address').value.trim();

    if (!name || !phone || !address) {
        alert('Vui lòng điền đầy đủ họ tên, số điện thoại và địa chỉ nhận hàng!');
        return false;
    }
    return true;
}
</script>
