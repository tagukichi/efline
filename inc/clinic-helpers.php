<?php
/**
 * clinic CPT 用のテンプレートヘルパー。
 * ACF が無効でもエラーにならないよう get_field() を薄くラップする。
 *
 * @package efline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ACF の get_field() を安全に呼ぶラッパー。ACF 未導入時は null を返す。
 *
 * @param string   $selector フィールド名。
 * @param int|null $post_id  投稿ID（省略時は現在の投稿）。
 * @return mixed
 */
function efline_get_field( $selector, $post_id = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}
	return get_field( $selector, $post_id );
}

/**
 * クリニックの基本情報を取得（住所・電話・診療時間などのグループ）。
 *
 * @param int|null $post_id
 * @return array
 */
function efline_get_clinic_basic_info( $post_id = null ) {
	$info = efline_get_field( 'basic_info', $post_id );
	return is_array( $info ) ? $info : array();
}

/**
 * カード用 PR 文を返す。ACF card_pr が空なら post excerpt にフォールバック。
 *
 * @param int|null $post_id
 * @return string
 */
function efline_get_clinic_card_pr( $post_id = null ) {
	$pr = efline_get_field( 'card_pr', $post_id );
	if ( is_string( $pr ) && trim( $pr ) !== '' ) {
		return $pr;
	}
	$excerpt = get_the_excerpt( $post_id );
	return wp_strip_all_tags( $excerpt );
}

/**
 * 診療時間を「平日 9:00〜18:30  土曜 9:00〜17:00」のような1行表示用に整形。
 *
 * @param int|null $post_id
 * @param int      $limit   最大表示行数。
 * @return string
 */
function efline_get_clinic_hours_summary( $post_id = null, $limit = 3 ) {
	$basic = efline_get_clinic_basic_info( $post_id );
	if ( empty( $basic['hours'] ) || ! is_array( $basic['hours'] ) ) {
		return '';
	}
	$parts = array();
	foreach ( array_slice( $basic['hours'], 0, $limit ) as $row ) {
		$label = isset( $row['label'] ) ? trim( (string) $row['label'] ) : '';
		$time  = isset( $row['time'] ) ? trim( (string) $row['time'] ) : '';
		if ( $label === '' && $time === '' ) {
			continue;
		}
		$parts[] = trim( $label . ' ' . $time );
	}
	return implode( '  ', $parts );
}

/**
 * クリニックの予約情報を取得。url が空なら CTA は表示しない判断に使う。
 *
 * @param int|null $post_id
 * @return array{url:string,label:string}
 */
function efline_get_clinic_reservation( $post_id = null ) {
	$reservation = efline_get_field( 'reservation', $post_id );
	return array(
		'url'   => isset( $reservation['url'] ) ? (string) $reservation['url'] : '',
		'label' => isset( $reservation['label'] ) && $reservation['label'] !== '' ? (string) $reservation['label'] : __( 'WEB予約はこちら', 'efline' ),
	);
}

/**
 * 対応内容タクソノミー (clinic_service) のタームを返す。
 *
 * @param int|null $post_id
 * @return WP_Term[]
 */
function efline_get_clinic_services( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$terms   = get_the_terms( $post_id, 'clinic_service' );
	return ( is_array( $terms ) ) ? $terms : array();
}

/**
 * エリアタクソノミー (clinic_area) のタームを返す。先頭の1件のみ表示用途。
 *
 * @param int|null $post_id
 * @return WP_Term[]
 */
function efline_get_clinic_areas( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$terms   = get_the_terms( $post_id, 'clinic_area' );
	return ( is_array( $terms ) ) ? $terms : array();
}

/**
 * 説明文セット（見出し + 本文）を返す。
 *
 * @param int|null $post_id
 * @return array<int,array{heading:string,body:string}>
 */
function efline_get_clinic_descriptions( $post_id = null ) {
	$rows = efline_get_field( 'descriptions', $post_id );
	if ( ! is_array( $rows ) ) {
		return array();
	}
	$out = array();
	foreach ( $rows as $row ) {
		$out[] = array(
			'heading' => isset( $row['heading'] ) ? (string) $row['heading'] : '',
			'body'    => isset( $row['body'] ) ? (string) $row['body'] : '',
		);
	}
	return $out;
}

/**
 * アクセス情報（Google Map + 補足）を返す。
 *
 * @param int|null $post_id
 * @return array{map:array|null,directions:string}
 */
function efline_get_clinic_access( $post_id = null ) {
	$access = efline_get_field( 'access', $post_id );
	return array(
		'map'        => isset( $access['map'] ) && is_array( $access['map'] ) ? $access['map'] : null,
		'directions' => isset( $access['directions'] ) ? (string) $access['directions'] : '',
	);
}
