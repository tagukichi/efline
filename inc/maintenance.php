<?php
/**
 * Basic 認証によるメンテナンスモード / プレビュー保護。
 *
 * Elementor のメンテナンスモードを使わずに、テーマ側で簡易ベーシック
 * 認証を提供する。本番公開前のプレビュー保護や、開発中のサイトに
 * 関係者だけアクセスさせたい場合に使用する。
 *
 * 使い方:
 *   wp-config.php に以下を追加して有効化:
 *     define( 'EFLINE_MAINTENANCE', true );
 *     define( 'EFLINE_MAINTENANCE_USER', 'preview' );
 *     define( 'EFLINE_MAINTENANCE_PASS', 'your-strong-password' );
 *
 *   EFLINE_MAINTENANCE_USER / EFLINE_MAINTENANCE_PASS を省略した場合は
 *   デフォルトの 'preview' / 'efline' が使われる（必ず本番では上書き）。
 *
 * 除外: 管理画面 / wp-login.php / wp-cron / Ajax / REST API /
 *       ログイン中の編集権限ユーザー
 *
 * @package efline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'efline_maintenance_basic_auth', 1 );
function efline_maintenance_basic_auth() {
	// 有効化フラグがなければ何もしない
	if ( ! defined( 'EFLINE_MAINTENANCE' ) || ! EFLINE_MAINTENANCE ) {
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

	// ログイン中の管理権限ユーザーは素通し
	if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
		return;
	}

	// PHP_AUTH_USER が無い環境向けフォールバック: HTTP_AUTHORIZATION ヘッダから抽出
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

	$expected_user = defined( 'EFLINE_MAINTENANCE_USER' ) ? (string) EFLINE_MAINTENANCE_USER : 'preview';
	$expected_pass = defined( 'EFLINE_MAINTENANCE_PASS' ) ? (string) EFLINE_MAINTENANCE_PASS : 'efline';

	$user = isset( $_SERVER['PHP_AUTH_USER'] ) ? (string) wp_unslash( $_SERVER['PHP_AUTH_USER'] ) : '';
	$pass = isset( $_SERVER['PHP_AUTH_PW'] ) ? (string) wp_unslash( $_SERVER['PHP_AUTH_PW'] ) : '';

	// hash_equals でタイミング攻撃対策
	$user_ok = hash_equals( $expected_user, $user );
	$pass_ok = hash_equals( $expected_pass, $pass );

	if ( $user_ok && $pass_ok ) {
		return; // 認証成功 → サイト表示続行
	}

	// 認証失敗 → 401 を返してダイアログを出させる
	$realm = defined( 'EFLINE_MAINTENANCE_REALM' ) ? (string) EFLINE_MAINTENANCE_REALM : 'Site Preview';
	header( 'WWW-Authenticate: Basic realm="' . esc_attr( $realm ) . '", charset="UTF-8"' );
	header( 'HTTP/1.0 401 Unauthorized' );
	header( 'Content-Type: text/html; charset=UTF-8' );

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
	<p>現在、関係者限定で公開されています。<br>正しい認証情報を入力してください。</p>
	<p style="font-size:12px;color:#9ca3af;margin-top:24px;">認証情報をお持ちでない方は管理者へお問い合わせください。</p>
</div>
</body>
</html>
	<?php
	exit;
}

/**
 * 管理画面に「Basic 認証が有効です」と通知。誤って公開状態と誤認しないように。
 */
add_action( 'admin_notices', 'efline_maintenance_admin_notice' );
function efline_maintenance_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! defined( 'EFLINE_MAINTENANCE' ) || ! EFLINE_MAINTENANCE ) {
		return;
	}
	$user = defined( 'EFLINE_MAINTENANCE_USER' ) ? EFLINE_MAINTENANCE_USER : 'preview';
	echo '<div class="notice notice-info"><p><strong>efline メンテナンスモード:</strong> Basic 認証が有効です（ユーザー名: <code>' . esc_html( $user ) . '</code>）。公開時は wp-config.php の <code>EFLINE_MAINTENANCE</code> を <code>false</code> にしてください。</p></div>';
}
