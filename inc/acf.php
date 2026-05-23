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

/**
 * カスタム ACF ロケーションルール「ページスラッグ」を追加。
 * page-{slug}.php 形式や、テンプレート未割当ページでもスラッグだけで
 * フィールドグループを表示できるようにする。
 */
add_filter( 'acf/location/rule_types', 'efline_acf_location_rule_types' );
function efline_acf_location_rule_types( $choices ) {
	$choices[ __( 'Page', 'acf' ) ]['page_slug'] = __( 'ページスラッグ', 'efline' );
	return $choices;
}

add_filter( 'acf/location/rule_values/page_slug', 'efline_acf_location_rule_values_page_slug' );
function efline_acf_location_rule_values_page_slug( $choices ) {
	$pages = get_pages( array( 'post_status' => array( 'publish', 'draft', 'private' ) ) );
	if ( empty( $choices ) ) {
		$choices = array();
	}
	foreach ( $pages as $page ) {
		if ( $page->post_name === '' ) {
			continue;
		}
		$choices[ $page->post_name ] = $page->post_name . ' （' . $page->post_title . '）';
	}
	return $choices;
}

add_filter( 'acf/location/rule_match/page_slug', 'efline_acf_location_rule_match_page_slug', 10, 3 );
function efline_acf_location_rule_match_page_slug( $match, $rule, $options ) {
	if ( empty( $options['post_id'] ) ) {
		return $match;
	}
	$post = get_post( $options['post_id'] );
	if ( ! $post || $post->post_type !== 'page' ) {
		return $match;
	}
	$slug = $post->post_name;
	if ( '==' === $rule['operator'] ) {
		return $slug === $rule['value'];
	}
	if ( '!=' === $rule['operator'] ) {
		return $slug !== $rule['value'];
	}
	return $match;
}
