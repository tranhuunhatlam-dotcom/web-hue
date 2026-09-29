<?php
/**
 * LanguageEngine - Bộ máy đa ngôn ngữ (Song ngữ Việt 🇻🇳 - Anh 🇬🇧) cho O Hương Xứ Huế
 */
class LanguageEngine {
    private static $currentLang = null;

    /**
     * Khởi tạo và xác định ngôn ngữ hiện tại (từ GET, Session, Cookie)
     */
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        // 1. Kiểm tra tham số URL ?lang=
        if (isset($_GET['lang'])) {
            $lang = strtolower(trim($_GET['lang']));
            if (in_array($lang, ['vi', 'en'], true)) {
                $_SESSION['site_lang'] = $lang;
                @setcookie('site_lang', $lang, time() + (86400 * 30), '/');
                self::$currentLang = $lang;
                return self::$currentLang;
            }
        }

        // 2. Kiểm tra Session
        if (isset($_SESSION['site_lang']) && in_array($_SESSION['site_lang'], ['vi', 'en'], true)) {
            self::$currentLang = $_SESSION['site_lang'];
            return self::$currentLang;
        }

        // 3. Kiểm tra Cookie
        if (isset($_COOKIE['site_lang']) && in_array($_COOKIE['site_lang'], ['vi', 'en'], true)) {
            self::$currentLang = $_COOKIE['site_lang'];
            return self::$currentLang;
        }

        // Mặc định là Tiếng Việt
        self::$currentLang = 'vi';
        return self::$currentLang;
    }

    /**
     * Lấy mã ngôn ngữ hiện tại
     */
    public static function getLang() {
        if (self::$currentLang === null) {
            self::init();
        }
        return self::$currentLang;
    }

    /**
     * Kiểm tra có phải Tiếng Anh không
     */
    public static function isEn() {
        return self::getLang() === 'en';
    }

    /**
     * Từ điển đa ngôn ngữ
     */
    private static $dictionary = [
        // Header & Top bar
        'top_tag'            => ['vi' => 'CỐ ĐÔ HUẾ', 'en' => 'ANCIENT HUE'],
        'top_slogan'         => ['vi' => 'Tinh hoa ẩm thực Xứ Huế — Chuẩn vị truyền thống cố đô', 'en' => 'The Essence of Hue Royal Cuisine — Authentic Ancient Flavors'],
        'nationwide_ship'    => ['vi' => 'Giao hàng toàn quốc', 'en' => 'Nationwide Delivery'],
        'food_safety'        => ['vi' => 'Đảm bảo ATTP 100%', 'en' => '100% Food Safety Certified'],
        'all_delicacies'     => ['vi' => 'Tất cả đặc sản', 'en' => 'All Delicacies'],
        'search_placeholder' => ['vi' => 'Tìm kiếm đặc sản Huế thơm ngon...', 'en' => 'Search delicious Hue delicacies...'],
        'search_btn'         => ['vi' => 'Tìm kiếm', 'en' => 'Search'],
        'login'              => ['vi' => 'Đăng nhập', 'en' => 'Login'],
        'orders'             => ['vi' => 'Đơn hàng', 'en' => 'Orders'],
        'cart'               => ['vi' => 'Giỏ hàng', 'en' => 'Cart'],
        'hotline_label'      => ['vi' => 'Hotline tư vấn', 'en' => 'Customer Care Hotline'],

        // Menu điều hướng
        'nav_home'           => ['vi' => 'Trang Chủ', 'en' => 'Home'],
        'nav_about'          => ['vi' => 'Giới Thiệu', 'en' => 'About Us'],
        'nav_dacsan'         => ['vi' => 'Đặc Sản Huế', 'en' => 'Hue Specialties'],
        'nav_blog'           => ['vi' => 'Blog', 'en' => 'Blog'],
        'nav_contact'        => ['vi' => 'Liên Hệ', 'en' => 'Contact'],
        'nav_store'          => ['vi' => 'Cửa Hàng', 'en' => 'Stores'],

        // Sidebar & Hero
        'sidebar_title'      => ['vi' => 'DANH MỤC ĐẶC SẢN', 'en' => 'SPECIALTY MENU'],
        'sidebar_badge'      => ['vi' => 'CỐ ĐÔ', 'en' => 'ANCIENT'],
        'trust_traditional'  => ['vi' => '100% Nguyên liệu truyền thống Cố Đô', 'en' => '100% Traditional Royal Ingredients'],
        'trust_icebox'       => ['vi' => 'Đóng thùng xốp đá khô giao hỏa tốc', 'en' => 'Dry Ice Insulated Fast Delivery'],
        'hero_title'         => ['vi' => 'HƯƠNG VỊ CỐ ĐÔ', 'en' => 'FLAVORS OF HUE'],
        'hero_desc'          => ['vi' => 'Hương vị tinh túy cố đô nơi rạng danh nét ẩm thực Hương Xứ Huế', 'en' => 'Exquisite flavors of the ancient capital celebrating the renown of Hue cuisine'],
        'hero_featured'      => ['vi' => 'ĐẶC SẢN NỔI BẬT', 'en' => 'FEATURED SPECIALTIES'],
        'hero_featured_desc' => ['vi' => 'Bao năm theo mẹ gìn giữ hương vị Cố Đô, từng món ăn gắn kết hồn quê xứ Huế.', 'en' => 'Generations preserving ancient recipes, each dish uniting the soul of Hue countryside.'],

        // Sản phẩm & Mua hàng
        'top_featured_title' => ['vi' => 'Top Đặc Sản Huế Nổi Bật', 'en' => 'Top Featured Hue Delicacies'],
        'top_featured_sub'   => ['vi' => 'Tinh hoa ẩm thực Cố Đô lưu truyền ngàn đời, đậm đà phong vị sông Hương núi Ngự', 'en' => 'Ancient culinary heritage preserved through centuries, infused with the essence of the Perfume River'],
        'add_to_cart'        => ['vi' => '🛒 Thêm vào giỏ', 'en' => '🛒 Add to Cart'],
        'buy_now'            => ['vi' => '⚡ Mua ngay', 'en' => '⚡ Buy Now'],
        'price'              => ['vi' => 'Giá', 'en' => 'Price'],
        'reviews'            => ['vi' => 'Đánh giá', 'en' => 'Reviews'],
        'rating'             => ['vi' => 'Sao', 'en' => 'Stars'],
        'verified_buyer'     => ['vi' => 'Đã mua tại O Hương Xứ Huế', 'en' => 'Verified Purchase'],

        // Bộ lọc & Tìm kiếm
        'filter_title'       => ['vi' => 'Bộ Lọc Đặc Sản', 'en' => 'Specialty Filter'],
        'filter_price'       => ['vi' => 'Khoảng giá', 'en' => 'Price Range'],
        'filter_category'    => ['vi' => 'Danh mục', 'en' => 'Category'],
        'filter_all'         => ['vi' => 'Tất cả', 'en' => 'All'],
        'filter_under_50k'   => ['vi' => 'Dưới 50.000₫', 'en' => 'Under 50,000₫'],
        'filter_50_100k'     => ['vi' => '50.000₫ - 100.000₫', 'en' => '50,000₫ - 100,000₫'],
        'filter_100_200k'    => ['vi' => '100.000₫ - 200.000₫', 'en' => '100,000₫ - 200,000₫'],
        'filter_above_200k'  => ['vi' => 'Trên 200.000₫', 'en' => 'Over 200,000₫'],
        'sort_by'            => ['vi' => 'Sắp xếp theo', 'en' => 'Sort By'],
        'sort_price_asc'     => ['vi' => 'Giá tăng dần', 'en' => 'Price: Low to High'],
        'sort_price_desc'    => ['vi' => 'Giá giảm dần', 'en' => 'Price: High to Low'],

        // Khung giờ giao hàng
        'delivery_date'      => ['vi' => 'Ngày nhận hàng mong muốn', 'en' => 'Preferred Delivery Date'],
        'delivery_slot'      => ['vi' => 'Khung giờ nhận hàng', 'en' => 'Delivery Time Slot'],
        'slot_morning'       => ['vi' => '🌅 Sáng: 08:00 - 11:30 (Bánh mới ra lò)', 'en' => '🌅 Morning: 08:00 - 11:30 (Freshly Baked)'],
        'slot_afternoon'     => ['vi' => '☀️ Chiều: 14:00 - 17:30 (Ăn xế, liên hoan)', 'en' => '☀️ Afternoon: 14:00 - 17:30 (Afternoon Tea)'],
        'slot_evening'       => ['vi' => '🌙 Tối: 18:00 - 21:00 (Giao khách sạn, nhà riêng)', 'en' => '🌙 Evening: 18:00 - 21:00 (Hotel / Home)'],
        'slot_express'       => ['vi' => '⚡ Hỏa tốc 2 Giờ (Nội thành Huế / Đà Nẵng)', 'en' => '⚡ 2-Hour Express (Hue / Da Nang Metro)'],

        // Footer
        'footer_about_title' => ['vi' => 'O Hương Xứ Huế', 'en' => 'O Huong Xu Hue'],
        'footer_about_sub'   => ['vi' => 'Vị Ngon Cố Đô', 'en' => 'Flavors of Ancient Hue'],
        'footer_about_desc'  => ['vi' => 'Tự hào gìn giữ và lan tỏa tinh hoa ẩm thực Cố Đô Huế. Từng chiếc bánh tươi, hộp kẹo mè xửng hay hũ tôm chua đều đong đầy tâm tình đất Thần Kinh.', 'en' => 'Proudly preserving and sharing the culinary treasures of Ancient Hue. Every fresh cake, sesame candy box, or pickled shrimp jar embodies the heartfelt tradition of Hue.'],
        'footer_delicacies'  => ['vi' => 'Đặc Sản Nổi Tiếng', 'en' => 'Popular Specialties'],
        'footer_support'     => ['vi' => 'Hỗ Trợ Khách Hàng', 'en' => 'Customer Support'],
        'footer_payment'     => ['vi' => 'Thanh Toán & Kết Nối', 'en' => 'Payments & Social'],
        'footer_rights'      => ['vi' => 'Bảo lưu mọi quyền bởi Thương hiệu Đặc Sản O Hương Xứ Huế.', 'en' => 'All rights reserved by O Huong Xu Hue Specialties.']
    ];

    /**
     * Dịch một khóa văn bản
     */
    public static function t($key, $default = '') {
        $lang = self::getLang();
        if (isset(self::$dictionary[$key][$lang])) {
            return self::$dictionary[$key][$lang];
        }
        if (isset(self::$dictionary[$key]['vi'])) {
            return self::$dictionary[$key]['vi'];
        }
        return !empty($default) ? $default : $key;
    }

    /**
     * Render nút chuyển ngôn ngữ
     */
    public static function renderLanguageSwitcher() {
        $current = self::getLang();
        $targetViUrl = '?lang=vi';
        $targetEnUrl = '?lang=en';

        // Bảo toàn các tham số query hiện có
        $query = $_GET;
        $query['lang'] = 'vi';
        $targetViUrl = '?' . http_build_query($query);
        $query['lang'] = 'en';
        $targetEnUrl = '?' . http_build_query($query);

        ob_start();
        ?>
        <div class="lang-switcher-wrapper">
            <span class="lang-current">
                <?php echo $current === 'en' ? '🇬🇧 English' : '🇻🇳 Tiếng Việt'; ?>
            </span>
            <div class="lang-dropdown">
                <a href="<?php echo htmlspecialchars($targetViUrl); ?>" class="lang-option <?php echo $current === 'vi' ? 'active' : ''; ?>">
                    🇻🇳 Tiếng Việt
                </a>
                <a href="<?php echo htmlspecialchars($targetEnUrl); ?>" class="lang-option <?php echo $current === 'en' ? 'active' : ''; ?>">
                    🇬🇧 English
                </a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
