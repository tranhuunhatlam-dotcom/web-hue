<?php
/**
 * Lớp Controller cơ sở (BaseController)
 * Quản lý nạp layout và truyền dữ liệu ra View
 */

class BaseController {
    /**
     * Nạp giao diện View cùng với Layout Header và Footer
     *
     * @param string $view Tên đường dẫn view (ví dụ: 'home/index', 'about/index')
     * @param array $data Mảng dữ liệu truyền sang View
     */
    protected function render($view, $data = []) {
        // Trích xuất các key của mảng thành biến tương ứng
        extract($data);

        // Xác định đường dẫn gốc
        $theme_uri = function_exists('get_template_directory_uri') ? get_template_directory_uri() : '.';
        $site_url  = function_exists('home_url') ? home_url('/') : 'index.php';
        $about_url = function_exists('home_url') ? home_url('/?controller=about') : 'index.php?controller=about';

        // Nạp Header
        require_once __DIR__ . '/../views/layouts/header.php';

        // Nạp View chính
        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "<p style='color:red; text-align:center;'>Không tìm thấy View: " . htmlspecialchars($view) . "</p>";
        }

        // Nạp Footer
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
