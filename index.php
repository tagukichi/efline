<?php
/**
 * フォールバックテンプレート。
 *
 * @package efline
 */
get_header(); ?>

<div class="l-container">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?>>
				<h1><?php the_title(); ?></h1>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>

		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( '投稿が見つかりませんでした。', 'efline' ); ?></p>
	<?php endif; ?>
</div>

<?php get_footer();
