<?php
/**
 * Basic 認証によるメンテナンスモード / プレビュー保護。
 *
 * 設定値の優先順位:
 *   1. wp-config.php の定数 (EFLINE_MAINTENANCE / _USER / _PASS / _REALM)
 *      ← 緊急時の強制上書き用
 *   2. WP管理画面「メンテナンス設定」(ACF Options Page) の値
 *      ← 通常運用はこちら
 *   3. テーマのデフォルト値 (off / preview / efline)
 *
 * 除外: 管理画面 / wp-login.php / wp-cron / Ajax / REST API /
 *       edit_posts 権限のあるログインユーザー
 *
 * @package efline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ACF Pro があれば「メンテナンス設定」Options Page を登録。
 */
add_action( 'acf/init', 'efline_maintenance_register_options_page' );
function efline_maintenance_register_options_page() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}
	acf_add_options_page( array(
		'page_title' => __( 'メンテナンス設定', 'efline' ),
		'menu_title' => __( 'メンテナンス設定', 'efline' ),
		'menu_slug'  => 'efline-maintenance',
		'capability' => 'manage_options',
		'icon_url'   => 'dashicons-lock',
		'position'   => 80,
		'redirect'   => false,
		'autoload'   => true,
	) );
}

/**
 * メンテナンスモードの実効設定を返す。
 * 定数 > ACF > デフォルト の優先順でマージする。
 *
 * @return array{enabled:bool,user:string,pass:string,realm:string,message:string}
 */
function efline_maintenance_config() {
	$defaults = array(
		'enabled' => false,
		'user'    => 'preview',
		'pass'    => 'efline',
		'realm'   => 'Site Preview',
		'message' => '',
	);

	// 2) ACF Options から取得（ACF 有効時のみ）
	$acf = array();
	if ( function_exists( 'get_field' ) ) {
		$enabled = get_field( 'maintenance_enabled', 'option' );
		if ( null !== $enabled && false !== $enabled ) {
			$acf['enabled'] = (bool) $enabled;
		}
		foreach ( array(
			'maintenance_user'    => 'user',
			'maintenance_pass'    => 'pass',
			'maintenance_realm'   => 'realm',
			'maintenance_message' => 'message',
		) as $field => $key ) {
			$v = get_field( $field, 'option' );
			if ( is_string( $v ) && $v !== '' ) {
				$acf[ $key ] = $v;
			}
		}
	}
	$config = array_merge( $defaults, $acf );

	// 1) 定数 (最優先)
	if ( defined( 'EFLINE_MAINTENANCE' ) ) {
		$config['enabled'] = (bool) EFLINE_MAINTENANCE;
	}
	if ( defined( 'EFLINE_MAINTENANCE_USER' ) && '' !== EFLINE_MAINTENANCE_USER ) {
		$config['user'] = (string) EFLINE_MAINTENANCE_USER;
	}
	if ( defined( 'EFLINE_MAINTENANCE_PASS' ) && '' !== EFLINE_MAINTENANCE_PASS ) {
		$config['pass'] = (string) EFLINE_MAINTENANCE_PASS;
	}
	if ( defined( 'EFLINE_MAINTENANCE_REALM' ) && '' !== EFLINE_MAINTENANCE_REALM ) {
		$config['realm'] = (string) EFLINE_MAINTENANCE_REALM;
	}

	return $config;
}

add_action( 'init', 'efline_maintenance_basic_auth', 1 );
function efline_maintenance_basic_auth() {
	$config = efline_maintenance_config();

	if ( ! $config['enabled'] ) {
		return;
	}

	// 管理画面・各種システム経路は除外
	if ( is_admin() ) {
		return;
	}
	if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
		return;
	}
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return;
	}
	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		return;
	}

	$request = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$skip_paths = array(
		'/wp-login.php',
		'/wp-admin',
		'/wp-cron.php',
		'/wp-json',
		'/xmlrpc.php',
		'/favicon.ico',
		'/robots.txt',
	);
	foreach ( $skip_paths as $path ) {
		if ( false !== strpos( $request, $path ) ) {
			return;
		}
	}

	// ログイン中の編集権限ユーザーは素通し
	if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
		return;
	}

	// PHP_AUTH_USER 未対応サーバー向けに HTTP_AUTHORIZATION から抽出
	if ( ! isset( $_SERVER['PHP_AUTH_USER'] ) && ! empty( $_SERVER['HTTP_AUTHORIZATION'] ) ) {
		$auth = (string) wp_unslash( $_SERVER['HTTP_AUTHORIZATION'] );
		if ( 0 === stripos( $auth, 'Basic ' ) ) {
			$decoded = base64_decode( substr( $auth, 6 ) );
			if ( false !== $decoded && false !== strpos( $decoded, ':' ) ) {
				list( $u, $p ) = explode( ':', $decoded, 2 );
				$_SERVER['PHP_AUTH_USER'] = $u;
				$_SERVER['PHP_AUTH_PW']   = $p;
			}
		}
	}

	$user = isset( $_SERVER['PHP_AUTH_USER'] ) ? (string) wp_unslash( $_SERVER['PHP_AUTH_USER'] ) : '';
	$pass = isset( $_SERVER['PHP_AUTH_PW'] ) ? (string) wp_unslash( $_SERVER['PHP_AUTH_PW'] ) : '';

	$user_ok = hash_equals( $config['user'], $user );
	$pass_ok = hash_equals( $config['pass'], $pass );

	if ( $user_ok && $pass_ok ) {
		return; // 認証成功
	}

	// 401 を返してダイアログを出させる
	header( 'WWW-Authenticate: Basic realm="' . esc_attr( $config['realm'] ) . '", charset="UTF-8"' );
	header( 'HTTP/1.0 401 Unauthorized' );
	header( 'Content-Type: text/html; charset=UTF-8' );

	$message = $config['message'] !== ''
		? $config['message']
		: '現在、関係者限定で公開されています。<br>正しい認証情報を入力してください。';
	?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>サイトメンテナンス中 | <?php echo esc_html( get_bloginfo( 'name' ) ); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<style>
	body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: -apple-system, BlinkMacSystemFont, "Hiragino Sans", "Yu Gothic", sans-serif; background: #d6efff; color: #1f2937; padding: 20px; }
	.box { max-width: 480px; padding: 48px 32px; background: #fff; border-radius: 16px; box-shadow: 0 12px 32px rgba(0,0,0,0.08); text-align: center; }
	h1 { margin: 0 0 12px; color: #49bce3; font-size: 20px; font-weight: 700; letter-spacing: 0.04em; }
	p { margin: 0 0 12px; color: #4b5563; font-size: 14px; line-height: 1.7; }
	.lock { display: inline-block; width: 56px; height: 56px; margin-bottom: 16px; background: #49bce3; color: #fff; border-radius: 50%; line-height: 56px; font-size: 26px; }
</style>
</head>
<body>
<div class="box">
	<div class="lock" aria-hidden="true">🔒</div>
	<h1>サイトメンテナンス中</h1>
	<p><?php echo wp_kses( $message, array( 'br' => array(), 'strong' => array() ) ); ?></p>
	<p style="font-size:12px;color:#9ca3af;margin-top:24px;">認証情報をお持ちでない方は管理者へお問い合わせください。</p>
</div>
</body>
</html>
	<?php
	exit;
}

/**
 * 管理画面に「メンテナンスモード ON」通知。
 */
add_action( 'admin_notices', 'efline_maintenance_admin_notice' );
function efline_maintenance_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$config = efline_maintenance_config();
	if ( ! $config['enabled'] ) {
		return;
	}
	$settings_url = admin_url( 'admin.php?page=efline-maintenance' );
	$is_const     = defined( 'EFLINE_MAINTENANCE' ) && EFLINE_MAINTENANCE;
	$source       = $is_const ? __( 'wp-config.php の定数', 'efline' ) : __( '管理画面設定', 'efline' );
	echo '<div class="notice notice-warning"><p>';
	echo '<strong>' . esc_html__( 'メンテナンスモード ON', 'efline' ) . '</strong>: ';
	echo sprintf(
		/* translators: 1: 設定元 */
		esc_html__( 'Basic 認証が有効です（設定元: %s）。ユーザー名: ', 'efline' ),
		esc_html( $source )
	);
	echo '<code>' . esc_html( $config['user'] ) . '</code>';
	if ( ! $is_const ) {
		echo ' / <a href="' . esc_url( $settings_url ) . '">' . esc_html__( '設定を変更', 'efline' ) . '</a>';
	}
	echo '</p></div>';
}
