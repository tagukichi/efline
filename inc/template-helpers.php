<?php
/**
 * テンプレートで使う共通ヘルパー（ナビ・SVG など）。
 *
 * @package efline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 主要ナビ項目のフォールバック定義。
 * WP 管理画面で「グローバルナビ」メニューが未設定のとき、ここの配列を出力する。
 *
 * 既存サイト（kodomo-kyousei.com）の構成に合わせ、ページスラッグは
 * child / ef / qa / clinic を採用する。
 *
 * @return array<int,array{key:string,label:string,sub_label:string,url:string,normal:string,active:string}>
 */
function efline_default_primary_nav() {
	return array(
		array(
			'key'       => 'child',
			'label'     => __( 'こどもの', 'efline' ),
			'sub_label' => __( 'はならび', 'efline' ),
			'url'       => home_url( '/child/' ),
			'normal'    => 'http://kodomo-kyousei.com/wp-content/uploads/2025/02/Frame-4.png',
			'active'    => 'http://kodomo-kyousei.com/wp-content/uploads/2025/02/Group-3.png',
			'alt'       => __( 'こどものはならび', 'efline' ),
		),
		array(
			'key'       => 'ef',
			'label'     => __( 'EFの', 'efline' ),
			'sub_label' => __( '使い方', 'efline' ),
			'url'       => home_url( '/ef/' ),
			'normal'    => 'http://kodomo-kyousei.com/wp-content/uploads/2025/02/Frame-5.png',
			'active'    => 'http://kodomo-kyousei.com/wp-content/uploads/2025/02/Group-4.png',
			'alt'       => __( 'EFの使い方', 'efline' ),
		),
		array(
			'key'       => 'qa',
			'label'     => __( 'Q&A', 'efline' ),
			'sub_label' => '',
			'url'       => home_url( '/qa/' ),
			'normal'    => 'http://kodomo-kyousei.com/wp-content/uploads/2025/02/Frame-6.png',
			'active'    => 'http://kodomo-kyousei.com/wp-content/uploads/2025/02/Group-5.png',
			'alt'       => __( 'Q&A', 'efline' ),
		),
		array(
			'key'       => 'clinic',
			'label'     => __( '取扱い', 'efline' ),
			'sub_label' => __( 'クリニック', 'efline' ),
			'url'       => home_url( '/clinic/' ),
			'normal'    => 'http://kodomo-kyousei.com/wp-content/uploads/2025/02/Group-1-4.png',
			'active'    => 'http://kodomo-kyousei.com/wp-content/uploads/2025/02/Group-6.png',
			'alt'       => __( '取扱いクリニック', 'efline' ),
		),
	);
}

/**
 * インライン SVG アイコンを出力。
 *
 * @param string $name アイコン名（tooth / info / question / clinic / arrow / arrow-left / arrow-up / sparkle）。
 * @param array  $attrs 追加属性。
 * @return string
 */
function efline_icon( $name, $attrs = array() ) {
	$attrs = array_merge( array(
		'aria-hidden' => 'true',
		'focusable'   => 'false',
		'width'       => 24,
		'height'      => 24,
	), $attrs );

	$attr_str = '';
	foreach ( $attrs as $k => $v ) {
		$attr_str .= sprintf( ' %s="%s"', esc_attr( $k ), esc_attr( $v ) );
	}

	$icons = array(
		'tooth' => '<svg' . $attr_str . ' viewBox="0 0 32 32" fill="currentColor"><path d="M16 3c-3.6 0-5.5 1-8 1-1.6 0-3 1.4-3 3.5 0 4 1.5 7 2.5 11 .8 3.2 1.4 7 2.3 9.5.5 1.5 1.7 2 2.6.6.9-1.4 1.8-5.6 2.6-7 .8-1.4 1.5-1.4 2 0 .5 1.4 1.5 5.5 2.3 7 .9 1.4 2.1 1 2.6-.6.9-2.5 1.5-6.3 2.3-9.5 1-4 2.5-7 2.5-11C24 5.4 22.6 4 21 4c-2.5 0-4.4-1-5-1z"/></svg>',
		'info' => '<svg' . $attr_str . ' viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="16" cy="16" r="13"/><line x1="16" y1="14" x2="16" y2="23"/><circle cx="16" cy="10" r="1.5" fill="currentColor"/></svg>',
		'question' => '<svg' . $attr_str . ' viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="16" cy="16" r="13"/><path d="M11.5 11.5c0-2.5 2-4.5 4.5-4.5s4.5 2 4.5 4.5c0 3-4.5 3-4.5 6.5"/><circle cx="16" cy="23" r="1.5" fill="currentColor" stroke="none"/></svg>',
		'clinic' => '<svg' . $attr_str . ' viewBox="0 0 32 32" fill="currentColor"><path d="M16 3c-3.6 0-5.5 1-8 1-1.6 0-3 1.4-3 3.5 0 4 1.5 7 2.5 11 .8 3.2 1.4 7 2.3 9.5.5 1.5 1.7 2 2.6.6.9-1.4 1.8-5.6 2.6-7 .8-1.4 1.5-1.4 2 0 .5 1.4 1.5 5.5 2.3 7 .9 1.4 2.1 1 2.6-.6.9-2.5 1.5-6.3 2.3-9.5 1-4 2.5-7 2.5-11C24 5.4 22.6 4 21 4c-2.5 0-4.4-1-5-1zm-1 6h2v3h3v2h-3v3h-2v-3h-3v-2h3z"/></svg>',
		'arrow' => '<svg' . $attr_str . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>',
		'arrow-left' => '<svg' . $attr_str . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M11 6l-6 6 6 6"/></svg>',
		'arrow-up' => '<svg' . $attr_str . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M6 11l6-6 6 6"/></svg>',
		'sparkle' => '<svg' . $attr_str . ' viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l1.5 5L19 8.5 13.5 10 12 15l-1.5-5L5 8.5 10.5 7zM18 14l.8 2.7L21.5 17.5l-2.7.8L18 21l-.8-2.7-2.7-.8L17.2 16.7z"/></svg>',
	);

	return $icons[ $name ] ?? '';
}

/**
 * 主要ページの URL/タイトルから「現在のページがそれか」判定するヘルパー。
 * ヘッダーナビのアクティブ状態に利用。
 *
 * 既存スニペット (is_active_page) のロジックを取り込み、
 * ページスラッグ一致 + CPT アーカイブ + テンプレート一致のいずれかで真とする。
 */
function efline_is_active_page( $slug ) {
	global $post;

	// クリニック CPT アーカイブ / 個別 / タクソノミー
	if ( 'clinic' === $slug ) {
		if ( is_post_type_archive( 'clinic' ) || is_singular( 'clinic' ) || is_tax( array( 'clinic_area', 'clinic_service' ) ) ) {
			return true;
		}
	}

	// 固定ページのスラッグ一致
	if ( is_page() && isset( $post->post_name ) && $post->post_name === $slug ) {
		return true;
	}

	// テンプレートファイル一致（スラッグが推奨値と異なる場合の保険）
	if ( is_page() ) {
		$template_map = array(
			'child' => 'template-kodomono-hanarabi.php',
			'ef'    => 'template-ef-tsukaikata.php',
			'qa'    => 'template-qa.php',
		);
		if ( isset( $template_map[ $slug ] ) && is_page_template( $template_map[ $slug ] ) ) {
			return true;
		}
	}

	return false;
}

/**
 * 後方互換: efline_is_current_nav() を efline_is_active_page() に委譲。
 */
function efline_is_current_nav( $key ) {
	return efline_is_active_page( $key );
}

/**
 * グローバルナビ（カスタムメニュー）の HTML を返す。
 * ショートコード [custom_menu] と header.php の両方から利用する。
 */
function efline_render_main_nav() {
	$items = efline_default_primary_nav();
	ob_start();
	?>
	<ul class="custom-menu">
		<?php foreach ( $items as $item ) :
			$is_active = efline_is_active_page( $item['key'] );
		?>
			<li class="menu-item <?php echo $is_active ? 'active' : ''; ?>">
				<a href="<?php echo esc_url( $item['url'] ); ?>">
					<img src="<?php echo esc_url( $item['normal'] ); ?>"
					     alt="<?php echo esc_attr( $item['alt'] ); ?>"
					     class="icon normal-icon"
					     loading="lazy"
					     decoding="async">
					<img src="<?php echo esc_url( $item['active'] ); ?>"
					     alt="<?php echo esc_attr( $item['alt'] ); ?>(<?php esc_attr_e( 'アクティブ', 'efline' ); ?>)"
					     class="icon active-icon"
					     loading="lazy"
					     decoding="async">
					<span>
						<?php echo esc_html( $item['label'] ); ?>
						<?php if ( $item['sub_label'] !== '' ) : ?>
							<br><?php echo esc_html( $item['sub_label'] ); ?>
						<?php endif; ?>
					</span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
	return ob_get_clean();
}
add_shortcode( 'custom_menu', 'efline_render_main_nav' );

/**
 * ロゴ画像 URL。ローカルアップロードがあればそれを優先、なければ既存サイトの SVG。
 *
 * NOTE: ユーザー指定により下記 URL を使用。
 * 既存 WP 環境 (kodomo-kyousei.com) と同一ドメインで動作させる前提のため
 * クロスドメインホットリンクの考慮は不要。
 */
function efline_logo_url() {
	if ( file_exists( EFLINE_THEME_DIR . '/assets/images/logo.svg' ) ) {
		return EFLINE_THEME_URI . '/assets/images/logo.svg';
	}
	if ( file_exists( EFLINE_THEME_DIR . '/assets/images/logo.png' ) ) {
		return EFLINE_THEME_URI . '/assets/images/logo.png';
	}
	return 'http://kodomo-kyousei.com/wp-content/uploads/2026/05/image-13.svg';
}

/**
 * FV の女の子画像 URL。ローカル assets/images/hero.png|jpg があれば優先。
 */
function efline_hero_image_url() {
	foreach ( array( 'hero.png', 'hero.jpg' ) as $name ) {
		if ( file_exists( EFLINE_THEME_DIR . '/assets/images/' . $name ) ) {
			return EFLINE_THEME_URI . '/assets/images/' . $name;
		}
	}
	return 'http://kodomo-kyousei.com/wp-content/uploads/2025/02/image-14.png';
}

/**
 * 完全なロゴ（マスコット画像 + テキストロックアップ）を出力。
 * ヘッダー・フッターから利用する。FV のマスコットは別途 front-page.php で
 * 直接 <img class="p-hero__mascot"> を配置すること。
 *
 * 構造:
 *   <a class="site-logo site-logo--header">
 *     <img class="site-logo__mark" src="image-13.svg">
 *     <span class="site-logo__text">
 *       <small class="site-logo__sub">口腔機能訓練装置</small>
 *       <span class="site-logo__name">こどもの矯正</span>
 *     </span>
 *   </a>
 *
 * @param array $args { 'context' => 'header' | 'footer' }
 */
function efline_render_logo( $args = array() ) {
	$context  = $args['context'] ?? 'header';
	$home_url = home_url( '/' );
	$site     = get_bloginfo( 'name' );
	$image    = efline_logo_url();
	$class    = 'site-logo site-logo--' . $context;
	ob_start();
	?>
	<a href="<?php echo esc_url( $home_url ); ?>" class="<?php echo esc_attr( $class ); ?>" aria-label="<?php echo esc_attr( $site ); ?>">
		<img src="<?php echo esc_url( $image ); ?>" alt="" class="site-logo__mark" aria-hidden="true">
		<span class="site-logo__text">
			<small class="site-logo__sub"><?php esc_html_e( '口腔機能訓練装置', 'efline' ); ?></small>
			<span class="site-logo__name"><?php esc_html_e( 'こどもの矯正', 'efline' ); ?></span>
		</span>
	</a>
	<?php
	return ob_get_clean();
}

/**
 * ページヘッダー（ヒーロー）を出力。
 *
 * @param array{icon:string,title:string,subtitle?:string,breadcrumb?:string,variant?:string} $args
 *        variant: 'default' (デフォルト: 濃いアイコン丸 + ダーク見出し)
 *                 'accent'  (淡いシアン帯 + アウトラインアイコン + シアン見出し)
 */
function efline_page_hero( $args ) {
	$icon       = $args['icon'] ?? 'tooth';
	$title      = $args['title'] ?? '';
	$subtitle   = $args['subtitle'] ?? '';
	$breadcrumb = $args['breadcrumb'] ?? '';
	$variant    = $args['variant'] ?? 'default';

	$classes = array( 'p-page-hero' );
	if ( $variant === 'accent' ) {
		$classes[] = 'p-page-hero--accent';
	}
	?>
	<header class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<div class="l-container">
			<?php if ( $breadcrumb !== '' ) : ?>
				<nav class="p-breadcrumb" aria-label="<?php esc_attr_e( 'パンくず', 'efline' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">TOP</a>
					<span aria-hidden="true">&gt;</span>
					<span><?php echo esc_html( $breadcrumb ); ?></span>
				</nav>
			<?php endif; ?>

			<div class="p-page-hero__title-row">
				<span class="p-page-hero__icon" aria-hidden="true">
					<?php echo efline_icon( $icon, array( 'width' => 56, 'height' => 56 ) ); ?>
				</span>
				<h1 class="p-page-hero__title"><?php echo esc_html( $title ); ?></h1>
			</div>

			<?php if ( $subtitle !== '' ) : ?>
				<p class="p-page-hero__lead"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</div>
	</header>
	<?php
}
