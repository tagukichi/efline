<?php
/**
 * クリニックアーカイブの検索・並び替えロジック。
 *
 * URL パラメータ:
 *   ?area=<term_slug>       エリア絞り込み
 *   ?service=<term_slug>    対応内容絞り込み
 *   ?sort=recommended|new   並び順（既定: recommended）
 *
 * @package efline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'pre_get_posts', 'efline_clinic_archive_query' );
function efline_clinic_archive_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( ! $query->is_post_type_archive( 'clinic' ) ) {
		return;
	}

	$query->set( 'posts_per_page', 12 );

	$tax_query = array();

	$area = isset( $_GET['area'] ) ? sanitize_title( wp_unslash( $_GET['area'] ) ) : '';
	if ( $area !== '' ) {
		$tax_query[] = array(
			'taxonomy' => 'clinic_area',
			'field'    => 'slug',
			'terms'    => $area,
		);
	}

	$service = isset( $_GET['service'] ) ? sanitize_title( wp_unslash( $_GET['service'] ) ) : '';
	if ( $service !== '' ) {
		$tax_query[] = array(
			'taxonomy' => 'clinic_service',
			'field'    => 'slug',
			'terms'    => $service,
		);
	}

	if ( ! empty( $tax_query ) ) {
		$tax_query['relation'] = 'AND';
		$query->set( 'tax_query', $tax_query );
	}

	$sort = isset( $_GET['sort'] ) ? sanitize_key( wp_unslash( $_GET['sort'] ) ) : 'recommended';
	if ( 'new' === $sort ) {
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'DESC' );
	} else {
		// 推奨順: メニューオーダー（page-attributes）昇順、同値は新着順。
		$query->set( 'orderby', array( 'menu_order' => 'ASC', 'date' => 'DESC' ) );
	}
}

/**
 * 現在の URL に GET パラメータをマージしたリンクを返す（フィルター/ソート切り替え用）。
 *
 * @param array $params 上書き/追加する key=>value。空文字なら削除。
 * @return string
 */
function efline_clinic_filter_url( array $params ) {
	$base    = get_post_type_archive_link( 'clinic' );
	$current = array();
	foreach ( array( 'area', 'service', 'sort' ) as $key ) {
		if ( isset( $_GET[ $key ] ) ) {
			$current[ $key ] = sanitize_key( wp_unslash( $_GET[ $key ] ) );
		}
	}
	$merged = array_merge( $current, $params );
	foreach ( $merged as $k => $v ) {
		if ( $v === '' || $v === null ) {
			unset( $merged[ $k ] );
		}
	}
	if ( empty( $merged ) ) {
		return $base;
	}
	return add_query_arg( $merged, $base );
}
