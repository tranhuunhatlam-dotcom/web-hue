<?php
/**
 * Layout Footer chung cho website O Hương Xứ Huế
 */
$theme_uri = function_exists('get_template_directory_uri') ? get_template_directory_uri() : '.';
?>
    <!-- ============================================================== -->
    <!-- CHÂN TRANG HOÀNG GIA CỐ ĐÔ HUẾ (ROYAL LUXURY FOOTER) -->
    <!-- ============================================================== -->
    <footer class="main-footer">
        <div class="footer-top-trust">
            <div class="footer-trust-container">
                <div class="footer-trust-card">
                    <div class="trust-card-icon">👑</div>
                    <div class="trust-card-text">
                        <h4>100% Vị Cố Đô Gốc</h4>
                        <p>Bí quyết gia truyền lưu giữ ẩm thực Hoàng Gia Huế</p>
                    </div>
                </div>
                <div class="footer-trust-card">
                    <div class="trust-card-icon">🚀</div>
                    <div class="trust-card-text">
                        <h4>Giao Hàng Hỏa Tốc</h4>
                        <p>Đóng thùng xốp đá khô bảo quản bánh tươi trọn vẹn</p>
                    </div>
                </div>
                <div class="footer-trust-card">
                    <div class="trust-card-icon">🛡️</div>
                    <div class="trust-card-text">
                        <h4>Đảm Bảo Vệ Sinh ATTP</h4>
                        <p>Chứng nhận an toàn thực phẩm, không hóa chất độc hại</p>
                    </div>
                </div>
                <div class="footer-trust-card">
                    <div class="trust-card-icon">❤️</div>
                    <div class="trust-card-text">
                        <h4>Đổi Trả 24H Miễn Phí</h4>
                        <p>Cam kết bồi hoàn 100% nếu sản phẩm lỗi hay hỏng hóc</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-main-container">
            <!-- Cột 1: Thông tin thương hiệu -->
            <div class="footer-col footer-col-brand">
                <div class="footer-logo">
                    <img src="<?php echo esc_url($theme_uri); ?>/assets/images/logo.jpg" alt="Logo O Hương Xứ Huế">
                    <div class="footer-logo-text">
                        <h3>O Hương Xứ Huế</h3>
                        <span>Vị Ngon Cố Đô</span>
                    </div>
                </div>
                <p class="footer-brand-desc">
                    Tự hào gìn giữ và lan tỏa tinh hoa ẩm thực Cố Đô Huế. Từng chiếc bánh tươi, hộp kẹo mè xửng hay hũ tôm chua đều đong đầy tâm tình đất Thần Kinh.
                </p>
                <ul class="footer-contact-list">
                    <li>
                        <span class="f-icon">📍</span>
                        <span>22 Lê Lợi, Phường Vĩnh Ninh, TP. Huế</span>
                    </li>
                    <li>
                        <span class="f-icon">📞</span>
                        <span>Hotline: <a href="tel:0342684980">0342.684.980</a> (07:00 - 22:00)</span>
                    </li>
                    <li>
                        <span class="f-icon">✉️</span>
                        <span>Email: <a href="mailto:lienhe@ohuongxuhue.vn">lienhe@ohuongxuhue.vn</a></span>
                    </li>
                </ul>
            </div>

            <!-- Cột 2: Danh mục đặc sản tuyển chọn -->
            <div class="footer-col">
                <h4 class="footer-heading">Đặc Sản Nổi Tiếng</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url(home_url('/dac-san/?cat=banh-ep-hue')); ?>">Bánh Ép &amp; Nem Tré Huế</a></li>
                    <li><a href="<?php echo esc_url(home_url('/dac-san/?cat=keo-hue')); ?>">Kẹo Huế &amp; Mè Xửng Giòn</a></li>
                    <li><a href="<?php echo esc_url(home_url('/dac-san/?cat=tra-hue')); ?>">Trà Cung Đình &amp; Trà Sen</a></li>
                    <li><a href="<?php echo esc_url(home_url('/dac-san/?cat=mam-hue')); ?>">Mắm Tôm Chua, Ruốc, Nêm, Sò</a></li>
                    <li><a href="<?php echo esc_url(home_url('/dac-san/?cat=hat-sen-hue')); ?>">Hạt Sen Huế Tịnh Tâm</a></li>
                </ul>
            </div>

            <!-- Cột 3: Hướng dẫn & Chính sách -->
            <div class="footer-col">
                <h4 class="footer-heading">Hỗ Trợ Khách Hàng</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url(home_url('/gioi-thieu/')); ?>">Về Chúng Tôi (Câu Chuyện Cố Đô)</a></li>
                    <li><a href="<?php echo esc_url(home_url('/don-hang/')); ?>">Tra Cứu Tiến Độ Đơn Hàng</a></li>
                    <li><a href="<?php echo esc_url(home_url('/lien-he/')); ?>">Chính Sách Đổi Trả & Hoàn Tiền</a></li>
                    <li><a href="<?php echo esc_url(home_url('/lien-he/')); ?>">Quy Trình Đóng Gói Thùng Xốp</a></li>
                    <li><a href="<?php echo esc_url(home_url('/lien-he/')); ?>">Bảo Mật Thông Tin Khách Hàng</a></li>
                </ul>
            </div>

            <!-- Cột 4: Thanh toán & Kết nối -->
            <div class="footer-col">
                <h4 class="footer-heading">Thanh Toán & Kết Nối</h4>
                <p class="footer-payment-desc">Kênh liên hệ & Hỗ trợ đặt hàng trực tiếp:</p>
                <div class="footer-channel-circles">
                    <!-- 1. Facebook Fanpage -->
                    <a href="https://www.facebook.com/share/17ZYCnJpnx/" target="_blank" rel="noopener noreferrer" class="footer-circle-btn btn-fb" aria-label="Facebook Fanpage" title="Fanpage Facebook: O Hương Xứ Huế">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="circle-tooltip">Fanpage Facebook</span>
                    </a>

                    <!-- 2. Zalo Chat & Tư Vấn -->
                    <a href="https://zalo.me/0342684980" target="_blank" rel="noopener noreferrer" class="footer-circle-btn btn-zalo" aria-label="Zalo" title="Zalo Tư Vấn: 0342.684.980">
                        <span style="font-weight:900; font-size:12px; font-family:'Segoe UI', Tahoma, sans-serif; letter-spacing:-0.4px;">Zalo</span>
                        <span class="circle-tooltip">Zalo: 0342.684.980</span>
                    </a>

                    <!-- 3. TikTok -->
                    <a href="https://www.tiktok.com/@ohuongxuhue" target="_blank" rel="noopener noreferrer" class="footer-circle-btn btn-tiktok" aria-label="TikTok" title="TikTok @ohuongxuhue">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.298-.002.595.042.88.13V9.4a6.33 6.33 0 0 0-1-.08A6.34 6.34 0 0 0 3 15.66a6.34 6.34 0 0 0 10.82 4.49 6.27 6.27 0 0 0 1.87-4.49v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-.87-.09z"/>
                        </svg>
                        <span class="circle-tooltip">TikTok @ohuongxuhue</span>
                    </a>

                    <!-- 4. Instagram -->
                    <a href="https://www.instagram.com/ohuongxuhue" target="_blank" rel="noopener noreferrer" class="footer-circle-btn btn-insta" aria-label="Instagram" title="Instagram @ohuongxuhue">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                        <span class="circle-tooltip">Instagram</span>
                    </a>

                    <!-- 5. Email -->
                    <a href="mailto:lienhe@ohuongxuhue.vn" class="footer-circle-btn btn-email" aria-label="Email" title="Email: lienhe@ohuongxuhue.vn">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span class="circle-tooltip">Email Liên Hệ</span>
                    </a>
                </div>
                <div class="footer-payment-badges">
                    <span class="pay-badge">💳 VietQR Pro</span>
                    <span class="pay-badge">📦 COD Tận Nơi</span>
                    <span class="pay-badge">🏦 37 Ngân Hàng</span>
                    <span class="pay-badge">🛡️ SSL 256-bit</span>
                </div>
            </div>
        </div>

        <!-- Dòng đáy bản quyền -->
        <div class="footer-bottom-bar">
            <div class="footer-bottom-container">
                <p>&copy; <?php echo date('Y'); ?> <strong>O Hương Xứ Huế</strong> — Vị Ngon Cố Đô. <?php echo class_exists('LanguageEngine') ? LanguageEngine::t('footer_rights', 'Bảo lưu mọi quyền bởi Thương hiệu Đặc Sản O Hương Xứ Huế.') : 'Bảo lưu mọi quyền bởi Thương hiệu Đặc Sản O Hương Xứ Huế.'; ?></p>
                <div class="footer-bottom-links">
                    <span>Chuẩn vị truyền thống Cố Đô</span>
                    <span class="sep">•</span>
                    <span>Giao hàng toàn quốc</span>
                    <span class="sep">•</span>
                    <span>Hỗ trợ 24/7</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Nạp Buttonizer Speed Dial & Trợ Lý AI Hương Huế Chatbot -->
    <?php 
        $currentCtrl = isset($_GET['controller']) ? strtolower(trim($_GET['controller'])) : '';
        if ($currentCtrl !== 'admin') {
            $widgetFile = __DIR__ . '/../components/floating_widgets.php';
            if (file_exists($widgetFile)) {
                require_once $widgetFile;
            }
        }
    ?>

    <!-- File JavaScript chính (Bộ nhớ đệm 304 / Disk Cache) -->
    <script src="<?php echo esc_url($theme_uri); ?>/assets/js/main.js?v=1.1.0" defer></script>
    <!-- Trải Nghiệm Độc Bản: Không Gian Cố Đô -->
    <script src="<?php echo esc_url($theme_uri); ?>/assets/js/hue-ambient.js?v=3.0.0" defer></script>
    <!-- Bản Đồ Tương Tác Ẩm Thực Cố Đô -->
    <script src="<?php echo esc_url($theme_uri); ?>/assets/js/hue-food-map.js?v=1.1.0" defer></script>

    <?php if (function_exists('wp_footer')) wp_footer(); ?>
</body>
</html>
