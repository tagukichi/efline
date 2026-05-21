<?php
/**
 * 共通ヘッダ。
 *
 * @package efline
 */
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
	<div class="l-container site-header__inner">
		<a class="site-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php bloginfo( 'name' ); ?>
		</a>

		<nav class="site-header__nav" aria-label="<?php esc_attr_e( 'グローバルナビ', 'efline' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'site-header__menu',
				'fallback_cb'    => false,
				'depth'          => 1,
			) );
			?>
		</nav>
	</div>
</header>

<main id="main" class="site-main" role="main">
