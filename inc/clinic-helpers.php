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
 * 診療内容（リピーター）を文字列配列で返す。
 *
 * @param int|null $post_id
 * @return string[]
 */
function efline_get_clinic_services( $post_id = null ) {
	$rows = efline_get_field( 'services', $post_id );
	if ( ! is_array( $rows ) ) {
		return array();
	}
	$names = array();
	foreach ( $rows as $row ) {
		if ( ! empty( $row['name'] ) ) {
			$names[] = (string) $row['name'];
		}
	}
	return $names;
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
