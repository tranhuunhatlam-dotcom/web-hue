<?php
/**
 * View Đăng nhập (views/auth/login.php)
 * Kế thừa toàn bộ layout Header & Footer của hệ thống
 */

$loginActionUrl    = function_exists('home_url') ? home_url('/?controller=auth&action=login') : 'index.php?controller=auth&action=login';
$registerUrl       = function_exists('home_url') ? home_url('/?controller=auth&action=register') : 'index.php?controller=auth&action=register';
?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon">&#128100;</div>
            <h2>Đăng Nhập</h2>
            <p>Chào mừng bạn quay lại với <strong>O Hương Xứ Huế</strong></p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="auth-alert auth-alert-error">
                <span>&#9888;</span> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="auth-alert auth-alert-success">
                <span>&#10004;</span> <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo esc_url($loginActionUrl); ?>" method="POST" class="auth-form">
            <div class="form-group">
                <label for="username">Tên đăng nhập hoặc Email <span class="required">*</span></label>
                <input type="text" id="username" name="username" placeholder="Nhập tên đăng nhập hoặc email..." required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu <span class="required">*</span></label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu..." required>
            </div>

            <div class="form-actions-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
                </label>
                <a href="#" class="forgot-link">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="btn-auth-submit">ĐĂNG NHẬP</button>
        </form>

        <div style="margin-top: 20px; background: #fdf8f2; border: 1px dashed #d4af37; border-radius: 10px; padding: 12px 15px; font-size: 13px; color: #5c4033;">
            <p style="font-weight: 700; margin-bottom: 5px; color: #8b5a2b;">💡 Tài khoản kiểm thử phân quyền:</p>
            <p>👑 <strong>Admin:</strong> <code>admin</code> / Mật khẩu: <code>admin123</code></p>
            <p>👤 <strong>User:</strong> <code>testuser</code> / Mật khẩu: <code>123456</code></p>
        </div>

        <div class="auth-footer-note">
            <p>Chưa có tài khoản? <a href="<?php echo esc_url($registerUrl); ?>">Đăng ký tài khoản mới</a></p>
        </div>
    </div>
</div>
