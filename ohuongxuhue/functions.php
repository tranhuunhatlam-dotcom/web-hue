<?php
/**
 * O Hương Xứ Huế functions and definitions
 *
 * @package WordPress
 * @subpackage OHuongXuHue
 * @since 1.0.0
 */

if ( ! function_exists( 'ohuongxuhue_setup' ) ) :
	function ohuongxuhue_setup() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	}
endif;
add_action( 'after_setup_theme', 'ohuongxuhue_setup' );

/**
 * Đăng ký và nạp stylesheet & javascript từ thư mục assets
 */
function ohuongxuhue_scripts() {
	wp_enqueue_style( 'ohuongxuhue-style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0.0' );
	wp_enqueue_script( 'ohuongxuhue-script', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'ohuongxuhue_scripts' );
