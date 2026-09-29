<?php
/**
 * View Đăng ký (views/auth/register.php)
 * Kế thừa toàn bộ layout Header & Footer của hệ thống
 */

$registerActionUrl = function_exists('home_url') ? home_url('/?controller=auth&action=register') : 'index.php?controller=auth&action=register';
$loginUrl          = function_exists('home_url') ? home_url('/?controller=auth&action=login') : 'index.php?controller=auth&action=login';

$old = isset($oldData) ? $oldData : [];
?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon">&#128221;</div>
            <h2>Đăng Ký Tài Khoản</h2>
            <p>Trở thành thành viên để thưởng thức trọn vẹn phong vị xứ Huế</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="auth-alert auth-alert-error">
                <span>&#9888;</span> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo esc_url($registerActionUrl); ?>" method="POST" class="auth-form">
            <div class="form-group">
                <label for="fullname">Họ và tên <span class="required">*</span></label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($old['fullname'] ?? ''); ?>" placeholder="Ví dụ: Nguyễn Văn Huế" required autofocus>
            </div>

            <div class="form-row">
                <div class="form-group col-half">
                    <label for="username">Tên đăng nhập <span class="required">*</span></label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($old['username'] ?? ''); ?>" placeholder="Tên tài khoản..." required>
                </div>

                <div class="form-group col-half">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($old['phone'] ?? ''); ?>" placeholder="09xx xxx xxx">
                </div>
            </div>

            <div class="form-group">
                <label for="email">Địa chỉ Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" placeholder="email@vi-du.vn" required>
            </div>

            <div class="form-row">
                <div class="form-group col-half">
                    <label for="password">Mật khẩu <span class="required">*</span></label>
                    <input type="password" id="password" name="password" placeholder="Tối thiểu 6 ký tự..." required>
                </div>

                <div class="form-group col-half">
                    <label for="confirm_password">Nhập lại mật khẩu <span class="required">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu..." required>
                </div>
            </div>

            <div class="form-terms">
                <label>
                    <input type="checkbox" required checked> Tôi đồng ý với các <a href="#">điều khoản sử dụng & bảo mật</a> của O Hương Xứ Huế.
                </label>
            </div>

            <button type="submit" class="btn-auth-submit">ĐĂNG KÝ TÀI KHOẢN</button>
        </form>

        <div class="auth-footer-note">
            <p>Đã có tài khoản? <a href="<?php echo esc_url($loginUrl); ?>">Đăng nhập ngay</a></p>
        </div>
    </div>
</div>
