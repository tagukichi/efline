<?php
/**
 * 固定ページ汎用テンプレート。
 *
 * @package efline
 */
get_header(); ?>

<div class="l-container">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</div>

<?php get_footer();
