<?php
/**
 * 共通フッタ。
 *
 * @package efline
 */
?>
</main>

<footer class="site-footer" role="contentinfo">
	<div class="site-footer__inner">
		<a class="site-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="site-footer__logo-mark" aria-hidden="true">
				<?php if ( file_exists( EFLINE_THEME_DIR . '/assets/images/logo-mascot.png' ) ) : ?>
					<img src="<?php echo esc_url( EFLINE_THEME_URI . '/assets/images/logo-mascot.png' ); ?>" alt="" width="80" height="88">
				<?php else : ?>
					<?php echo efline_icon( 'tooth', array( 'width' => 48, 'height' => 48 ) ); ?>
				<?php endif; ?>
			</span>
			<span class="site-footer__logo-text">
				<small class="site-footer__logo-sub"><?php esc_html_e( '口腔機能訓練装置', 'efline' ); ?></small>
				<span class="site-footer__logo-name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
			</span>
		</a>

		<a href="#" class="site-footer__top" aria-label="<?php esc_attr_e( 'ページトップへ戻る', 'efline' ); ?>" data-efline-totop>
			<?php echo efline_icon( 'arrow-up', array( 'width' => 28, 'height' => 28 ) ); ?>
		</a>
	</div>

	<div class="site-footer__bottom">
		<p class="site-footer__copy">
			<?php printf( esc_html__( '© %s 口腔機能訓練装置オーラルトレーナー Line All right reserved.', 'efline' ), esc_html( date_i18n( 'Y' ) ) ); ?>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
