<?php
/**
 * Template Name: Q&A
 *
 * よくある質問ページ。ACF リピーター field_qa_items の各項目を
 * <details>/<summary> でアコーディオン表示する。
 *
 * @package efline
 */
get_header();

while ( have_posts() ) :
	the_post();
	$items = efline_get_field( 'qa_items' );
	$items = is_array( $items ) ? $items : array();
?>

<?php
efline_page_hero( array(
	'icon'    => 'question',
	'title'   => get_the_title(),
	'variant' => 'accent',
) );
?>

<div class="l-container p-page-body">
	<?php if ( get_the_content() !== '' ) : ?>
		<div class="p-page-body__intro entry-content">
			<?php the_content(); ?>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $items ) ) : ?>
		<div class="p-qa">
			<?php foreach ( $items as $item ) :
				$question = isset( $item['question'] ) ? (string) $item['question'] : '';
				$answer   = isset( $item['answer'] ) ? (string) $item['answer'] : '';
				$category = isset( $item['category'] ) ? (string) $item['category'] : '';
				if ( $question === '' ) {
					continue;
				}
			?>
				<details class="p-qa__item">
					<summary class="p-qa__summary">
						<span class="p-qa__marker" aria-hidden="true">Q</span>
						<span class="p-qa__question">
							<?php if ( $category !== '' ) : ?>
								<small class="p-qa__category"><?php echo esc_html( $category ); ?></small>
							<?php endif; ?>
							<?php echo esc_html( $question ); ?>
						</span>
						<span class="p-qa__toggle" aria-hidden="true"></span>
					</summary>
					<div class="p-qa__body">
						<span class="p-qa__marker p-qa__marker--answer" aria-hidden="true">A</span>
						<div class="p-qa__answer entry-content">
							<?php echo wp_kses_post( wpautop( $answer ) ); ?>
						</div>
					</div>
				</details>
			<?php endforeach; ?>
		</div>
	<?php elseif ( get_the_content() === '' ) : ?>
		<p class="p-page-body__empty"><?php esc_html_e( 'まだ質問が登録されていません。WP 管理画面のこのページで Q&A を追加してください。', 'efline' ); ?></p>
	<?php endif; ?>
</div>

<?php endwhile; get_footer();
