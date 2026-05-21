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
 * @return array<int,array{label:string,url:string,icon:string,key:string}>
 */
function efline_default_primary_nav() {
	return array(
		array(
			'key'   => 'orthodontics',
			'label' => __( 'こどものはならび', 'efline' ),
			'url'   => home_url( '/kodomono-hanarabi/' ),
			'icon'  => 'tooth',
		),
		array(
			'key'   => 'usage',
			'label' => __( 'EFの使い方', 'efline' ),
			'url'   => home_url( '/ef-tsukaikata/' ),
			'icon'  => 'info',
		),
		array(
			'key'   => 'qa',
			'label' => __( 'Q&A', 'efline' ),
			'url'   => home_url( '/qa/' ),
			'icon'  => 'question',
		),
		array(
			'key'   => 'clinics',
			'label' => __( '取扱いクリニック', 'efline' ),
			'url'   => get_post_type_archive_link( 'clinic' ) ?: home_url( '/clinics/' ),
			'icon'  => 'clinic',
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
 */
function efline_is_current_nav( $key ) {
	switch ( $key ) {
		case 'clinics':
			return is_post_type_archive( 'clinic' ) || is_singular( 'clinic' ) || is_tax( array( 'clinic_area', 'clinic_service' ) );
		case 'qa':
			return is_page_template( 'template-qa.php' ) || is_page( 'qa' );
		case 'usage':
			return is_page_template( 'template-ef-tsukaikata.php' ) || is_page( 'ef-tsukaikata' );
		case 'orthodontics':
			return is_page_template( 'template-kodomono-hanarabi.php' ) || is_page( 'kodomono-hanarabi' );
	}
	return false;
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
