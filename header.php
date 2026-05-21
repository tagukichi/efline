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
	<div class="site-header__inner">
		<?php echo efline_render_logo( array( 'context' => 'header' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

		<nav class="site-header__nav" aria-label="<?php esc_attr_e( 'グローバルナビ', 'efline' ); ?>">
			<?php echo efline_render_main_nav(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</nav>
	</div>
</header>

<main id="main" class="site-main" role="main">
