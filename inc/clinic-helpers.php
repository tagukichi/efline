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
 * カード用 PR 文を返す。
 * card_pr ACF カスタムフィールド（任意。フィールド名は固定）に値があればそれを、
 * なければ post_excerpt を、それも空なら post_content の先頭文字を返す。
 * ACF 未導入でも問題なく動作する。
 *
 * @param int|null $post_id
 * @return string
 */
function efline_get_clinic_card_pr( $post_id = null ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();
	if ( $post_id <= 0 ) {
		return '';
	}

	// ACF があれば card_pr を優先（フィールドグループに登録されていなければ空が返る）。
	if ( function_exists( 'get_field' ) ) {
		$pr = get_field( 'card_pr', $post_id );
		if ( is_string( $pr ) && trim( $pr ) !== '' ) {
			return $pr;
		}
	}

	// post_excerpt に直接アクセス（CPT が excerpt サポートしていなくても DB 保存されていれば読める）。
	$post = get_post( $post_id );
	if ( $post instanceof WP_Post ) {
		if ( $post->post_excerpt !== '' ) {
			return wp_strip_all_tags( $post->post_excerpt );
		}
		if ( $post->post_content !== '' ) {
			return wp_strip_all_tags( wp_trim_words( $post->post_content, 30, '…' ) );
		}
	}
	return '';
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
 * カード表示用の対応内容を返す（文字列配列）。
 * ACF card_services (チェックボックス) が設定されていればそれを優先、
 * 空ならタクソノミー clinic_service の名前を返す。
 *
 * @param int|null $post_id
 * @param int      $limit
 * @return string[]
 */
function efline_get_clinic_card_services( $post_id = null, $limit = 3 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();
	if ( $post_id <= 0 ) {
		return array();
	}

	// 1) ACF card_services があればそれを使用
	if ( function_exists( 'get_field' ) ) {
		$acf = get_field( 'card_services', $post_id );
		if ( is_array( $acf ) && ! empty( $acf ) ) {
			return array_slice( array_values( array_filter( array_map( 'strval', $acf ) ) ), 0, $limit );
		}
	}

	// 2) タクソノミーへフォールバック
	$terms = efline_get_clinic_services( $post_id );
	if ( ! empty( $terms ) ) {
		$names = array_map( static function ( $term ) { return $term->name; }, $terms );
		return array_slice( $names, 0, $limit );
	}

	return array();
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
 * アクセス情報を返す。Google Map は API キー不要のシンプル iframe 埋め込み用に
 * 検索ワード（map_query もしくは基本情報の住所）を返す。
 *
 * @param int|null $post_id
 * @return array{map_query:string,directions:string}
 */
function efline_get_clinic_access( $post_id = null ) {
	$access = efline_get_field( 'access', $post_id );
	$query  = isset( $access['map_query'] ) ? trim( (string) $access['map_query'] ) : '';
	if ( $query === '' ) {
		$basic = efline_get_clinic_basic_info( $post_id );
		$query = isset( $basic['address'] ) ? trim( (string) $basic['address'] ) : '';
	}
	return array(
		'map_query'  => $query,
		'directions' => isset( $access['directions'] ) ? (string) $access['directions'] : '',
	);
}
