<?php
/**
 * カスタム投稿タイプ「clinic（クリニック紹介）」の登録。
 *
 * @package efline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'efline_register_clinic_taxonomies' );
function efline_register_clinic_taxonomies() {
	register_taxonomy(
		'clinic_area',
		array( 'clinic' ),
		array(
			'labels'            => array(
				'name'              => __( 'エリア', 'efline' ),
				'singular_name'     => __( 'エリア', 'efline' ),
				'menu_name'         => __( 'エリア', 'efline' ),
				'all_items'         => __( 'すべてのエリア', 'efline' ),
				'edit_item'         => __( 'エリアを編集', 'efline' ),
				'view_item'         => __( 'エリアを表示', 'efline' ),
				'update_item'       => __( 'エリアを更新', 'efline' ),
				'add_new_item'      => __( 'エリアを追加', 'efline' ),
				'new_item_name'     => __( '新規エリア名', 'efline' ),
				'search_items'      => __( 'エリアを検索', 'efline' ),
				'parent_item'       => __( '親エリア', 'efline' ),
				'parent_item_colon' => __( '親エリア:', 'efline' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'clinic-area' ),
		)
	);

	register_taxonomy(
		'clinic_service',
		array( 'clinic' ),
		array(
			'labels'            => array(
				'name'          => __( '対応内容', 'efline' ),
				'singular_name' => __( '対応内容', 'efline' ),
				'menu_name'     => __( '対応内容', 'efline' ),
				'all_items'     => __( 'すべての対応内容', 'efline' ),
				'edit_item'     => __( '対応内容を編集', 'efline' ),
				'view_item'     => __( '対応内容を表示', 'efline' ),
				'update_item'   => __( '対応内容を更新', 'efline' ),
				'add_new_item'  => __( '対応内容を追加', 'efline' ),
				'new_item_name' => __( '新規対応内容', 'efline' ),
				'search_items'  => __( '対応内容を検索', 'efline' ),
			),
			'hierarchical'      => false,
			'public'            => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'clinic-service' ),
		)
	);
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
