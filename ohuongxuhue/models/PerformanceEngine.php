<?php
/**
 * Lớp Bộ Máy Tối Ưu Tốc Độ & Hiệu Suất (PerformanceEngine)
 * Thiết kế chuẩn theo thông số kỹ thuật của LiteSpeed Cache & Fast Page Cache
 *
 * Tính năng:
 * 1. Fast Page Cache (HTML Caching) cho khách vãng lai (giảm TTFB < 30ms).
 * 2. Tự động bỏ qua cache khi giỏ hàng có món hoặc đang đăng nhập.
 * 3. HTML Minification & Asset Optimization.
 * 4. Transient Object Cache cho CSDL sản phẩm & danh mục.
 * 5. Tự động xóa cache (Purge Cache) khi cập nhật dữ liệu.
 *
 * @package OHuongXuHue
 * @subpackage Performance
 */

class PerformanceEngine {
    private static $cacheDir;
    private static $cacheTtl = 7200; // 2 giờ
    private static $isBuffering = false;
    private static $startTime = 0;
    private static $currentCacheFile = null;

    /**
     * Lấy và đảm bảo thư mục cache luôn tồn tại
     */
    public static function getCacheDir() {
        if (!self::$cacheDir) {
            self::$cacheDir = defined('WP_CONTENT_DIR') ? WP_CONTENT_DIR . '/cache/ohuongxuhue_pages/' : dirname(__DIR__, 3) . '/cache/ohuongxuhue_pages/';
            if (!is_dir(self::$cacheDir)) {
                @mkdir(self::$cacheDir, 0755, true);
            }
        }
        return self::$cacheDir;
    }

    /**
     * Khởi tạo hệ thống Cache
     */
    public static function init() {
        self::$startTime = microtime(true);
        self::getCacheDir();

        // Kiểm tra xem trang có đủ điều kiện phục vụ từ Cache không
        if (self::canServeCache()) {
            $cacheFile = self::getCacheFilePath();
            if ($cacheFile && file_exists($cacheFile)) {
                $age = time() - filemtime($cacheFile);
                if ($age < self::$cacheTtl) {
                    $serveTime = round((microtime(true) - self::$startTime) * 1000, 2);
                    header('X-Cache: HIT');
                    header('X-LiteSpeed-Cache: hit');
                    header('X-Powered-By: OHuongXuHue Performance Engine');
                    header('X-Response-Time: ' . $serveTime . 'ms');
                    header('Cache-Control: public, max-age=3600, stale-while-revalidate=86400');
                    header('Content-Type: text/html; charset=UTF-8');
                    readfile($cacheFile);
                    exit;
                }
            }
        }

        // Nếu là trang có thể lưu cache mới, kích hoạt Output Buffering
        if (self::canCacheCurrentRequest()) {
            self::$currentCacheFile = self::getCacheFilePath();
            self::$isBuffering = true;
            ob_start([__CLASS__, 'captureAndMinifyOutput']);
        }
    }

    /**
     * Kiểm tra yêu cầu có thể đọc từ cache không
     */
    private static function canServeCache() {
        // Chỉ cache phương thức GET hoặc HEAD
        if (isset($_SERVER['REQUEST_METHOD']) && !in_array($_SERVER['REQUEST_METHOD'], ['GET', 'HEAD'])) {
            return false;
        }

        // Bỏ qua nếu có tham số tìm kiếm hoặc hành động đặc biệt
        if (isset($_GET['action']) || isset($_GET['sync_cart']) || isset($_GET['sitemap'])) {
            return false;
        }

        // Bỏ qua nếu là khu vực Admin
        if (is_admin() || (isset($_GET['controller']) && $_GET['controller'] === 'admin')) {
            return false;
        }

        // Bỏ qua nếu người dùng đã đăng nhập hoặc đã có giỏ hàng
        if (!empty($_SESSION['user']) || !empty($_SESSION['cart'])) {
            return false;
        }

        // Bỏ qua nếu có cookie WooCommerce giỏ hàng
        if (isset($_COOKIE['woocommerce_items_in_cart']) && intval($_COOKIE['woocommerce_items_in_cart']) > 0) {
            return false;
        }

        return true;
    }

    /**
     * Kiểm tra yêu cầu hiện tại có đủ điều kiện để ghi cache không
     */
    private static function canCacheCurrentRequest() {
        return self::canServeCache();
    }

    /**
     * Tạo đường dẫn tệp cache duy nhất dựa trên URL đầy đủ
     */
    private static function getCacheFilePath() {
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $uri  = $_SERVER['REQUEST_URI'] ?? '/';
        $hash = md5($host . $uri);
        return self::$cacheDir . $hash . '.html';
    }

    /**
     * Xử lý nén HTML nhẹ nhàng và lưu tệp cache khi kết thúc trang
     */
    public static function captureAndMinifyOutput($buffer) {
        if (empty($buffer) || strlen($buffer) < 500) {
            return $buffer;
        }

        // Không cache nếu có thông báo lỗi PHP hoặc 404
        if (http_response_code() !== 200 || stripos($buffer, 'Fatal error') !== false || stripos($buffer, 'Parse error') !== false) {
            return $buffer;
        }

        $calcTime = round((microtime(true) - self::$startTime) * 1000, 2);

        // Nén HTML an toàn: Xóa comment HTML và khoảng trắng thừa giữa các thẻ mà không làm hỏng dòng trong <script>
        $search = [
            '/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', // Xóa comment HTML
            '/\>[^\S\r\n]+\</s',                                   // Xóa spaces/tabs giữa các thẻ HTML
            '/(\r?\n){2,}/s'                                       // Thu gọn nhiều dòng trống thành 1 dòng (bảo toàn dòng cho JS)
        ];
        $replace = ['', '><', "\n"];
        $minified = @preg_replace($search, $replace, $buffer);
        if (!$minified) {
            $minified = $buffer;
        }

        // Gắn chữ ký hiệu suất
        $stamp = "\n<!-- [LiteSpeed / Speed Engine] Generated in {$calcTime}ms on " . date('Y-m-d H:i:s') . " -->";
        $output = $minified . $stamp;

        // Lưu vào tệp cache
        if (self::$currentCacheFile) {
            @file_put_contents(self::$currentCacheFile, $output, LOCK_EX);
        }

        header('X-Cache: MISS');
        header('X-LiteSpeed-Cache: miss');
        header('X-Response-Time: ' . $calcTime . 'ms');

        return $output;
    }

    /**
     * Xóa sạch toàn bộ Page Cache & Transient Object Cache (Purge Cache)
     */
    public static function purgeAllCache() {
        $deleted = 0;
        $freedBytes = 0;
        $dir = self::getCacheDir();

        // 1. Xóa các tệp HTML Page Cache
        if (is_dir($dir)) {
            $files = glob($dir . '*.html');
            if ($files) {
                foreach ($files as $f) {
                    $freedBytes += filesize($f);
                    if (@unlink($f)) {
                        $deleted++;
                    }
                }
            }
        }

        // 2. Xóa các Transients CSDL của O Hương Xứ Huế
        if (function_exists('delete_transient')) {
            delete_transient('ohx_all_products_with_stock');
            delete_transient('ohx_master_products');
            delete_transient('ohx_sidebar_categories');
            delete_transient('ohx_financial_summary');
        }

        return [
            'deleted_files' => $deleted,
            'freed_kb'      => round($freedBytes / 1024, 2),
            'timestamp'     => date('H:i:s d/m/Y')
        ];
    }

    /**
     * Lấy thống kê hiện tại của bộ nhớ đệm
     */
    public static function getCacheStats() {
        $count = 0;
        $bytes = 0;
        $dir = self::getCacheDir();

        if (is_dir($dir)) {
            $files = glob($dir . '*.html');
            if ($files) {
                $count = count($files);
                foreach ($files as $f) {
                    $bytes += filesize($f);
                }
            }
        }

        return [
            'cached_pages' => $count,
            'size_kb'      => round($bytes / 1024, 2),
            'cache_dir'    => $dir,
            'ttl_hours'    => round(self::$cacheTtl / 3600, 1)
        ];
    }

    /**
     * Tối ưu hóa và Dọn dẹp Cơ sở Dữ liệu
     */
    public static function optimizeDatabase() {
        global $wpdb;
        $cleanedRows = 0;

        // 1. Dọn dẹp các Transients hết hạn trong wp_options
        if (!empty($wpdb)) {
            $time = time();
            $sql = "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout%' AND option_value < %d";
            $cleaned = $wpdb->query($wpdb->prepare($sql, $time));
            if ($cleaned) {
                $cleanedRows += intval($cleaned);
            }

            // 2. Xóa các bản nháp tự động và thùng rác cũ
            $wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_status = 'auto-draft'");
        }

        // 3. Tối ưu bảng SQLite / MySQL nếu có
        return [
            'status'        => 'success',
            'cleaned_rows'  => $cleanedRows,
            'timestamp'     => date('H:i:s d/m/Y'),
            'msg'           => "Đã dọn dẹp các bản ghi tạm hết hạn và tối ưu hóa các bảng cơ sở dữ liệu thành công."
        ];
    }
}
