<?php
/**
 * 共通フッタ。
 *
 * @package efline
 */
?>
</main>

<footer class="site-footer" role="contentinfo">
	<div class="l-container">
		<nav class="site-footer__nav" aria-label="<?php esc_attr_e( 'フッターナビ', 'efline' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'site-footer__menu',
				'fallback_cb'    => false,
				'depth'          => 1,
			) );
			?>
		</nav>
		<p class="site-footer__copy">
			<?php printf( esc_html__( '© %1$s 口腔機能訓練装置オーラルトレーナー Line All right reserved.', 'efline' ), esc_html( date_i18n( 'Y' ) ) ); ?>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
