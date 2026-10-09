<?php
/**
 * 取扱いクリニック初期データの一括登録（inc/data/clinics.php）。
 *
 * テーマ ZIP には DB の投稿を含められないため、テーマ有効化後に
 * 管理者が管理画面を開いたタイミングで 1 回だけ自動登録する。
 * 「クリニック紹介 > 一括登録」から手動で再実行も可能。
 *
 * - 同じデータ（シードキー一致）や同名のクリニックが既にあればスキップ
 *   （手動で編集した内容を上書きしない）
 * - 住所・郵便番号・電話は ACF「基本情報」、公式サイトは ACF「WEB予約 / 公式サイト」
 * - エリアは「都道府県 + 市区」で clinic_area タームを作成して付与
 *
 * @package efline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// データ更新時はこのキーを変えると、管理画面を開いた時に 1 回だけ再実行される。
const EFLINE_CLINIC_SEED_OPTION = 'efline_clinic_seed_20261009b';
const EFLINE_CLINIC_SEED_PREFIX = 'xlsx-20261007-';

/**
 * 登録の前提（ACF・CPT・タクソノミー）が揃っているか。
 */
function efline_clinic_seed_ready() {
	return function_exists( 'update_field' )
		&& post_type_exists( 'clinic' )
		&& taxonomy_exists( 'clinic_area' );
}

/**
 * 初期データを登録する。
 *
 * 既存のクリニックは上書きしないが、公式サイト URL が空のものだけ補完する。
 *
 * @return array{created:int,skipped:int,updated:int,errors:string[]}
 */
function efline_clinic_seed_run() {
	$result = array( 'created' => 0, 'skipped' => 0, 'updated' => 0, 'errors' => array() );
	$rows   = require EFLINE_THEME_DIR . '/inc/data/clinics.php';

	foreach ( $rows as $row ) {
		$seed_key = EFLINE_CLINIC_SEED_PREFIX . $row['seed'];

		$exists = get_posts( array(
			'post_type'      => 'clinic',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'meta_key'       => '_efline_seed_key',
			'meta_value'     => $seed_key,
		) );
		if ( empty( $exists ) ) {
			$exists = get_posts( array(
				'post_type'      => 'clinic',
				'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'no_found_rows'  => true,
				'title'          => $row['name'],
			) );
		}
		if ( ! empty( $exists ) ) {
			$changed = efline_clinic_seed_apply_corrections( (int) $exists[0], $row );
			if ( efline_clinic_seed_fill_url( (int) $exists[0], $row['official_url'] ) ) {
				$changed = true;
			}
			if ( $changed ) {
				$result['updated']++;
			} else {
				$result['skipped']++;
			}
			continue;
		}

		$post_id = wp_insert_post( array(
			'post_type'   => 'clinic',
			'post_status' => 'publish',
			'post_title'  => $row['name'],
			'menu_order'  => (int) $row['seed'],
		), true );
		if ( is_wp_error( $post_id ) ) {
			$result['errors'][] = $row['name'] . ': ' . $post_id->get_error_message();
			continue;
		}

		update_post_meta( $post_id, '_efline_seed_key', $seed_key );

		update_field( 'field_clinic_basic', array(
			'postal_code' => $row['postal_code'],
			'address'     => $row['address'],
			'phone'       => $row['phone'],
		), $post_id );

		efline_clinic_seed_fill_url( $post_id, $row['official_url'] );

		if ( $row['area'] !== '' ) {
			$term = term_exists( $row['area'], 'clinic_area' );
			if ( ! $term ) {
				$term = wp_insert_term( $row['area'], 'clinic_area' );
			}
			if ( ! is_wp_error( $term ) ) {
				wp_set_object_terms( $post_id, (int) $term['term_id'], 'clinic_area' );
			}
		}

		$result['created']++;
	}

	return $result;
}

/**
 * 以前のテーマ版が登録した誤った値の訂正（該当する値のときだけ置き換える）。
 *
 * - 2026-10-09 版: 神楽坂矯正歯科クリニックに誤って k-o-c.com
 *   （実際は こいずみ矯正歯科クリニック の公式サイト）を設定していたため削除
 * - 凌雲堂矯正歯科医院の電話のハイフン位置を 053-456-7123 に訂正
 *
 * @return bool 変更した場合 true
 */
function efline_clinic_seed_apply_corrections( $post_id, $row ) {
	$changed = false;

	$wrong_urls = array(
		7 => 'https://k-o-c.com/',
	);
	if ( isset( $wrong_urls[ $row['seed'] ] ) ) {
		$reservation = get_field( 'reservation', $post_id, false );
		$reservation = is_array( $reservation ) ? $reservation : array();
		$current     = (string) ( $reservation['field_clinic_official_url'] ?? $reservation['official_url'] ?? '' );
		if ( untrailingslashit( $current ) === untrailingslashit( $wrong_urls[ $row['seed'] ] ) ) {
			update_field( 'field_clinic_reservation', array(
				'url'          => (string) ( $reservation['field_clinic_reservation_url'] ?? $reservation['url'] ?? '' ),
				'label'        => (string) ( $reservation['field_clinic_reservation_label'] ?? $reservation['label'] ?? '' ),
				'official_url' => '',
			), $post_id );
			$changed = true;
		}
	}

	$wrong_phones = array(
		19 => '0534-56-7123',
	);
	if ( isset( $wrong_phones[ $row['seed'] ] ) ) {
		// group サブフィールドは {group}_{sub} のメタキーに保存される
		$phone = (string) get_post_meta( $post_id, 'basic_info_phone', true );
		if ( $phone === $wrong_phones[ $row['seed'] ] ) {
			update_post_meta( $post_id, 'basic_info_phone', $row['phone'] );
			$changed = true;
		}
	}

	return $changed;
}

/**
 * 公式サイト URL が未入力なら設定する（手動で入力済みの URL は上書きしない）。
 *
 * @return bool 設定した場合 true
 */
function efline_clinic_seed_fill_url( $post_id, $url ) {
	if ( $url === '' ) {
		return false;
	}
	$reservation = get_field( 'reservation', $post_id, false );
	$reservation = is_array( $reservation ) ? $reservation : array();
	$current     = isset( $reservation['field_clinic_official_url'] ) ? $reservation['field_clinic_official_url'] : ( $reservation['official_url'] ?? '' );
	if ( (string) $current !== '' ) {
		return false;
	}
	update_field( 'field_clinic_reservation', array(
		'url'          => (string) ( $reservation['field_clinic_reservation_url'] ?? $reservation['url'] ?? '' ),
		'label'        => (string) ( $reservation['field_clinic_reservation_label'] ?? $reservation['label'] ?? '' ),
		'official_url' => $url,
	), $post_id );
	return true;
}

/**
 * 初回のみ自動登録。
 */
add_action( 'admin_init', 'efline_clinic_seed_auto', 20 );
function efline_clinic_seed_auto() {
	if ( get_option( EFLINE_CLINIC_SEED_OPTION ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) || wp_doing_ajax() || ! efline_clinic_seed_ready() ) {
		return;
	}
	$result = efline_clinic_seed_run();
	update_option( EFLINE_CLINIC_SEED_OPTION, $result, false );
	set_transient( 'efline_clinic_seed_notice', $result, 10 * MINUTE_IN_SECONDS );
}

add_action( 'admin_notices', 'efline_clinic_seed_notice' );
function efline_clinic_seed_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! efline_clinic_seed_ready() && ! get_option( EFLINE_CLINIC_SEED_OPTION ) ) {
		echo '<div class="notice notice-warning"><p><strong>efline:</strong> 取扱いクリニックの初期データは、ACF Pro が有効になると自動登録されます。</p></div>';
		return;
	}
	$result = get_transient( 'efline_clinic_seed_notice' );
	if ( ! $result ) {
		return;
	}
	delete_transient( 'efline_clinic_seed_notice' );
	efline_clinic_seed_print_result( $result );
}

function efline_clinic_seed_print_result( $result ) {
	$class = empty( $result['errors'] ) ? 'notice-success' : 'notice-warning';
	echo '<div class="notice ' . esc_attr( $class ) . ' is-dismissible"><p><strong>efline:</strong> ';
	printf(
		esc_html__( '取扱いクリニックを一括登録しました（新規 %1$d 件 / URL・電話を補完/訂正 %2$d 件 / 変更なし %3$d 件）。', 'efline' ),
		(int) $result['created'],
		(int) ( $result['updated'] ?? 0 ),
		(int) $result['skipped']
	);
	echo '</p>';
	foreach ( $result['errors'] as $error ) {
		echo '<p>' . esc_html( $error ) . '</p>';
	}
	echo '</div>';
}

/**
 * 「クリニック紹介 > 一括登録」画面（手動再実行用）。
 */
add_action( 'admin_menu', 'efline_clinic_seed_menu' );
function efline_clinic_seed_menu() {
	if ( ! post_type_exists( 'clinic' ) ) {
		return;
	}
	add_submenu_page(
		'edit.php?post_type=clinic',
		__( 'クリニック一括登録', 'efline' ),
		__( '一括登録', 'efline' ),
		'manage_options',
		'efline-clinic-seed',
		'efline_clinic_seed_page'
	);
}

function efline_clinic_seed_page() {
	$rows = require EFLINE_THEME_DIR . '/inc/data/clinics.php';
	echo '<div class="wrap"><h1>' . esc_html__( 'クリニック一括登録', 'efline' ) . '</h1>';

	if ( isset( $_POST['efline_clinic_seed'] ) && check_admin_referer( 'efline_clinic_seed' ) ) {
		if ( efline_clinic_seed_ready() ) {
			$result = efline_clinic_seed_run();
			update_option( EFLINE_CLINIC_SEED_OPTION, $result, false );
			efline_clinic_seed_print_result( $result );
		} else {
			echo '<div class="notice notice-error"><p>' . esc_html__( 'ACF Pro が無効のため登録できません。', 'efline' ) . '</p></div>';
		}
	}

	echo '<p>' . sprintf( esc_html__( 'テーマ同梱の初期データ（%d 件）をクリニック紹介に登録します。登録済み・同名のクリニックは新規作成せず、公式サイトURLが空の場合のみ補完します（入力済みの内容は上書きしません）。', 'efline' ), count( $rows ) ) . '</p>';
	echo '<form method="post">';
	wp_nonce_field( 'efline_clinic_seed' );
	echo '<p><button type="submit" name="efline_clinic_seed" value="1" class="button button-primary">' . esc_html__( '未登録のクリニックを登録する', 'efline' ) . '</button></p>';
	echo '</form>';

	echo '<table class="widefat striped" style="max-width:960px"><thead><tr><th>#</th><th>医院名</th><th>エリア</th><th>住所</th><th>電話</th><th>公式サイト</th></tr></thead><tbody>';
	foreach ( $rows as $row ) {
		printf(
			'<tr><td>%d</td><td>%s</td><td>%s</td><td>〒%s %s</td><td>%s</td><td>%s</td></tr>',
			(int) $row['seed'],
			esc_html( $row['name'] ),
			esc_html( $row['area'] ),
			esc_html( $row['postal_code'] ),
			esc_html( $row['address'] ),
			esc_html( $row['phone'] ),
			$row['official_url'] !== '' ? esc_html( $row['official_url'] ) : '—'
		);
	}
	echo '</tbody></table></div>';
}
