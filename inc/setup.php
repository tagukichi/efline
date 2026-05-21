<?php
/**
 * テーマセットアップ。
 *
 * @package efline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', 'efline_setup' );
function efline_setup() {
	load_theme_textdomain( 'efline', EFLINE_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus( array(
		'primary' => __( 'グローバルナビ', 'efline' ),
		'footer'  => __( 'フッターナビ', 'efline' ),
	) );

	add_image_size( 'efline-clinic-card', 498, 360, true );
	add_image_size( 'efline-hero', 1648, 1392, false );
}

add_action( 'init', 'efline_disable_emoji' );
function efline_disable_emoji() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
