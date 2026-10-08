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
		efline_asset_ver( '/assets/css/tokens.css' )
	);

	wp_enqueue_style(
		'efline-base',
		EFLINE_THEME_URI . '/assets/css/base.css',
		array( 'efline-tokens' ),
		efline_asset_ver( '/assets/css/base.css' )
	);

	wp_enqueue_style(
		'efline-main',
		EFLINE_THEME_URI . '/assets/css/main.css',
		array( 'efline-base' ),
		efline_asset_ver( '/assets/css/main.css' )
	);

	if ( is_post_type_archive( 'clinic' ) || is_singular( 'clinic' ) || is_tax( array( 'clinic_area', 'clinic_service' ) ) ) {
		wp_enqueue_style(
			'efline-clinic',
			EFLINE_THEME_URI . '/assets/css/clinic.css',
			array( 'efline-main' ),
			efline_asset_ver( '/assets/css/clinic.css' )
		);
	}

	if ( is_front_page() ) {
		wp_enqueue_style(
			'efline-top',
			EFLINE_THEME_URI . '/assets/css/top.css',
			array( 'efline-main' ),
			efline_asset_ver( '/assets/css/top.css' )
		);
	}

	if ( is_page() || is_singular( 'post' ) ) {
		wp_enqueue_style(
			'efline-page',
			EFLINE_THEME_URI . '/assets/css/page.css',
			array( 'efline-main' ),
			efline_asset_ver( '/assets/css/page.css' )
		);
	}

	wp_enqueue_script(
		'efline-main',
		EFLINE_THEME_URI . '/assets/js/main.js',
		array(),
		efline_asset_ver( '/assets/js/main.js' ),
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

/**
 * アセットのバージョン文字列。ファイル更新日時を使い、テーマ更新時に
 * ブラウザの古い CSS / JS キャッシュが残らないようにする。
 */
function efline_asset_ver( $path ) {
	$file = EFLINE_THEME_DIR . $path;
	return file_exists( $file ) ? (string) filemtime( $file ) : EFLINE_THEME_VERSION;
}
