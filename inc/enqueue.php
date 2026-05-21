<?php
/**
 * CSS / JS のエンキュー。
 *
 * @package efline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'efline_enqueue_assets' );
function efline_enqueue_assets() {
	wp_enqueue_style(
		'efline-google-fonts',
		'https://fonts.googleapis.com/css2?family=M+PLUS+1:wght@400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'efline-tokens',
		EFLINE_THEME_URI . '/assets/css/tokens.css',
		array(),
		EFLINE_THEME_VERSION
	);

	wp_enqueue_style(
		'efline-base',
		EFLINE_THEME_URI . '/assets/css/base.css',
		array( 'efline-tokens' ),
		EFLINE_THEME_VERSION
	);

	wp_enqueue_style(
		'efline-main',
		EFLINE_THEME_URI . '/assets/css/main.css',
		array( 'efline-base' ),
		EFLINE_THEME_VERSION
	);

	wp_enqueue_script(
		'efline-main',
		EFLINE_THEME_URI . '/assets/js/main.js',
		array(),
		EFLINE_THEME_VERSION,
		true
	);
}

add_filter( 'style_loader_tag', 'efline_preconnect_google_fonts', 10, 2 );
function efline_preconnect_google_fonts( $html, $handle ) {
	if ( 'efline-google-fonts' === $handle ) {
		$preconnect = '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
		$preconnect .= '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
		return $preconnect . $html;
	}
	return $html;
}
