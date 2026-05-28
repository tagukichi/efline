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
		<?php echo efline_render_logo( array( 'context' => 'footer' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

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
