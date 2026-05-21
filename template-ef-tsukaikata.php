<?php
/**
 * Template Name: EFの使い方
 *
 * 装置の使い方ページ。Figma デザイン未受領のため、現状は
 * 「こどものはならび」と同等構造で実装。Figma URL 受領後にレイアウト調整。
 *
 * @package efline
 */
get_header();

while ( have_posts() ) :
	the_post();
?>

<?php
efline_page_hero( array(
	'icon'       => 'info',
	'title'      => get_the_title(),
	'subtitle'   => __( 'EF Line トレーナーの正しい装着方法・お手入れ方法をご紹介します。', 'efline' ),
	'breadcrumb' => get_the_title(),
) );
?>

<div class="l-container p-page-body">
	<article class="entry-content">
		<?php the_content(); ?>
	</article>
</div>

<?php endwhile; get_footer();
