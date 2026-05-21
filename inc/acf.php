<?php
/**
 * ACF Pro 連携。フィールド定義は acf-json/ で同期する。
 *
 * @package efline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'acf/settings/save_json', 'efline_acf_json_save_point' );
function efline_acf_json_save_point( $path ) {
	return EFLINE_THEME_DIR . '/acf-json';
}

add_filter( 'acf/settings/load_json', 'efline_acf_json_load_point' );
function efline_acf_json_load_point( $paths ) {
	unset( $paths[0] );
	$paths[] = EFLINE_THEME_DIR . '/acf-json';
	return $paths;
}

add_action( 'admin_notices', 'efline_acf_missing_notice' );
function efline_acf_missing_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( class_exists( 'ACF' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p><strong>efline テーマ:</strong> Advanced Custom Fields (ACF Pro) が無効です。クリニック紹介のカスタムフィールドを表示するには ACF Pro を有効化してください。</p></div>';
}
