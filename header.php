<?php
/**
 * 共通ヘッダ。
 *
 * @package efline
 */
$primary_nav = efline_default_primary_nav();
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" role="banner">
	<div class="site-header__inner">
		<a class="site-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="site-header__logo-mark" aria-hidden="true">
				<?php
				// TODO: マスコットキャラクター画像（assets/images/logo-mascot.png）が
				// 配置されたら img タグに差し替える。assets/images/README.md 参照。
				if ( file_exists( EFLINE_THEME_DIR . '/assets/images/logo-mascot.png' ) ) {
					echo '<img src="' . esc_url( EFLINE_THEME_URI . '/assets/images/logo-mascot.png' ) . '" alt="" width="80" height="88">';
				} else {
					echo efline_icon( 'tooth', array( 'width' => 56, 'height' => 56 ) );
				}
				?>
			</span>
			<span class="site-header__logo-text">
				<small class="site-header__logo-sub"><?php esc_html_e( '口腔機能訓練装置', 'efline' ); ?></small>
				<span class="site-header__logo-name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
			</span>
		</a>

		<nav class="site-header__nav" aria-label="<?php esc_attr_e( 'グローバルナビ', 'efline' ); ?>">
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<?php wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-header__menu',
					'depth'          => 1,
				) ); ?>
			<?php else : ?>
				<ul class="site-header__menu">
					<?php foreach ( $primary_nav as $item ) :
						$is_current = efline_is_current_nav( $item['key'] );
					?>
						<li class="site-header__menu-item <?php echo $is_current ? 'is-current' : ''; ?>">
							<a href="<?php echo esc_url( $item['url'] ); ?>" class="site-header__menu-link">
								<span class="site-header__menu-icon" aria-hidden="true">
									<?php echo efline_icon( $item['icon'], array( 'width' => 32, 'height' => 32 ) ); ?>
								</span>
								<span class="site-header__menu-label"><?php echo esc_html( $item['label'] ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</nav>
	</div>
</header>

<main id="main" class="site-main" role="main">
