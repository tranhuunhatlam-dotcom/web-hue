<?php
/**
 * Template Name: Trang Giới Thiệu O Hương Xứ Huế
 * Description: Template trang giới thiệu phong cách Cố Đô hoàng gia
 */

// Chuyển hướng hoặc gọi AboutController nếu đang dùng MVC
if (file_exists(__DIR__ . '/controllers/AboutController.php')) {
    require_once __DIR__ . '/controllers/BaseController.php';
    require_once __DIR__ . '/controllers/AboutController.php';
    $about = new AboutController();
    $about->index();
    exit;
}

// Fallback nạp header & footer WordPress chuẩn
get_header();
include __DIR__ . '/views/about/index.php';
get_footer();
