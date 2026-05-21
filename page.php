<?php
/**
 * 固定ページ汎用テンプレート（template-*.php が割り当てられていないページ）。
 *
 * @package efline
 */
get_header();

while ( have_posts() ) :
	the_post();

	efline_page_hero( array(
		'icon'       => 'info',
		'title'      => get_the_title(),
		'breadcrumb' => get_the_title(),
	) );
?>

<div class="l-container p-page-body">
	<article <?php post_class( 'entry-content' ); ?>>
		<?php the_content(); ?>
	</article>
</div>

<?php endwhile; get_footer();
