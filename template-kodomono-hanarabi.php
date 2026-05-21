<?php
/**
 * Template Name: こどものはならび
 *
 * こどものはならびの解説ページ。本文は WP 管理画面（Gutenberg）で編集する。
 * 治療の流れセクションは ACF リピーター field_flow_steps が登録されていれば
 * テンプレート末尾に自動で出力する。
 *
 * @package efline
 */
get_header();

while ( have_posts() ) :
	the_post();
	$steps = efline_get_field( 'flow_steps' );
	$steps = is_array( $steps ) ? $steps : array();
?>

<?php
efline_page_hero( array(
	'icon'       => 'tooth',
	'title'      => get_the_title(),
	'subtitle'   => __( 'こどもの矯正と EF Line トレーナーについて、ご家族向けにわかりやすくご案内します。', 'efline' ),
	'breadcrumb' => get_the_title(),
) );
?>

<div class="l-container p-page-body">
	<article class="entry-content">
		<?php the_content(); ?>
	</article>

	<?php if ( ! empty( $steps ) ) : ?>
		<section class="p-flow" aria-labelledby="flow-title">
			<h2 id="flow-title" class="p-flow__title">
				<?php esc_html_e( 'こどもの歯ならび治療の流れ', 'efline' ); ?>
			</h2>

			<ol class="p-flow__list">
				<?php foreach ( $steps as $index => $step ) :
					$step_title = isset( $step['title'] ) ? (string) $step['title'] : '';
					$step_body  = isset( $step['body'] ) ? (string) $step['body'] : '';
					$step_image = isset( $step['image'] ) && is_array( $step['image'] ) ? $step['image'] : null;
					if ( $step_title === '' && $step_body === '' ) {
						continue;
					}
				?>
					<li class="p-flow__item">
						<span class="p-flow__number" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<div class="p-flow__body">
							<?php if ( $step_title !== '' ) : ?>
								<h3 class="p-flow__step-title"><?php echo esc_html( $step_title ); ?></h3>
							<?php endif; ?>
							<?php if ( $step_body !== '' ) : ?>
								<div class="p-flow__step-body"><?php echo wp_kses_post( wpautop( $step_body ) ); ?></div>
							<?php endif; ?>
						</div>
						<?php if ( $step_image ) : ?>
							<figure class="p-flow__image">
								<img src="<?php echo esc_url( $step_image['url'] ); ?>" alt="<?php echo esc_attr( $step_image['alt'] ?? '' ); ?>" width="<?php echo esc_attr( $step_image['width'] ?? '' ); ?>" height="<?php echo esc_attr( $step_image['height'] ?? '' ); ?>" loading="lazy">
							</figure>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ol>
		</section>
	<?php endif; ?>
</div>

<?php endwhile; get_footer();
