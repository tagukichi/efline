<?php
/**
 * カスタム投稿タイプ「clinic（クリニック紹介）」の登録。
 *
 * @package efline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'efline_register_clinic_cpt' );
function efline_register_clinic_cpt() {
	$labels = array(
		'name'               => __( 'クリニック紹介', 'efline' ),
		'singular_name'      => __( 'クリニック', 'efline' ),
		'menu_name'          => __( 'クリニック紹介', 'efline' ),
		'add_new'            => __( '新規追加', 'efline' ),
		'add_new_item'       => __( '新規クリニックを追加', 'efline' ),
		'edit_item'          => __( 'クリニックを編集', 'efline' ),
		'new_item'           => __( '新規クリニック', 'efline' ),
		'view_item'          => __( 'クリニックを表示', 'efline' ),
		'search_items'       => __( 'クリニックを検索', 'efline' ),
		'not_found'          => __( 'クリニックが見つかりません', 'efline' ),
		'not_found_in_trash' => __( 'ゴミ箱にクリニックはありません', 'efline' ),
	);

	register_post_type(
		'clinic',
		array(
			'labels'             => $labels,
			'public'             => true,
			'has_archive'        => 'clinics',
			'rewrite'            => array( 'slug' => 'clinics', 'with_front' => false ),
			'menu_icon'          => 'dashicons-location-alt',
			'menu_position'      => 5,
			'supports'           => array( 'title', 'thumbnail', 'revisions', 'page-attributes' ),
			'show_in_rest'       => true,
		)
	);
}
