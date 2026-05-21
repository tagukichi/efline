<?php
/**
 * カスタム投稿タイプ「clinic（クリニック紹介）」とタクソノミーの登録。
 *
 * 重要: ACF Pro の「投稿タイプ / タクソノミー」UI で既に同じスラッグ
 * (clinic / clinic_area / clinic_service) を登録している環境では、
 * 二重登録による重大なエラーが発生する。そのため、ここでは
 * `post_type_exists()` / `taxonomy_exists()` チェックを行い、
 * 既存のものがあればテーマ側からの登録はスキップする。
 *
 * フック優先度を 20 にして ACF (デフォルト 10) の後に走らせ、
 * ACF の登録結果を見てから判断する。
 *
 * @package efline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'efline_register_clinic_taxonomies', 20 );
function efline_register_clinic_taxonomies() {
	if ( ! taxonomy_exists( 'clinic_area' ) ) {
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
	}

	if ( ! taxonomy_exists( 'clinic_service' ) ) {
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
}

add_action( 'init', 'efline_register_clinic_cpt', 20 );
function efline_register_clinic_cpt() {
	// ACF（または他プラグイン）で既に登録済みであればスキップ。
	if ( post_type_exists( 'clinic' ) ) {
		return;
	}

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
			'labels'        => $labels,
			'public'        => true,
			'has_archive'   => 'clinics',
			'rewrite'       => array( 'slug' => 'clinics', 'with_front' => false ),
			'menu_icon'     => 'dashicons-location-alt',
			'menu_position' => 5,
			'supports'      => array( 'title', 'thumbnail', 'revisions', 'page-attributes' ),
			'show_in_rest'  => true,
		)
	);
}

/**
 * 管理画面 dashboard / プラグイン一覧で、CPT 重複登録の可能性が高い場合に通知。
 * ACF と本テーマの両方が `clinic` を登録しようとしているケースを検出する。
 */
add_action( 'admin_notices', 'efline_notice_clinic_conflict' );
function efline_notice_clinic_conflict() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! function_exists( 'get_current_screen' ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->id, array( 'dashboard', 'themes' ), true ) ) {
		return;
	}
	// ACF 由来の CPT 登録があるかを推測（acf-post-type 投稿タイプ内に clinic 登録があるか）。
	if ( ! function_exists( 'get_posts' ) ) {
		return;
	}
	$acf_post_types = get_posts( array(
		'post_type'      => 'acf-post-type',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'no_found_rows'  => true,
	) );
	if ( empty( $acf_post_types ) ) {
		return;
	}
	foreach ( $acf_post_types as $pid ) {
		$post_obj = get_post( $pid );
		if ( $post_obj && false !== strpos( $post_obj->post_name, 'clinic' ) ) {
			echo '<div class="notice notice-info"><p><strong>efline テーマ:</strong> ACF で <code>clinic</code> CPT が登録されていることを検出しました。テーマ側からの登録は自動的にスキップされています（重複登録による重大エラーを回避）。</p></div>';
			return;
		}
	}
}
