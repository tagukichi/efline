<?php
/**
 * クリニック紹介 詳細 (single)。
 * 後続フェーズで ACF フィールド（基本情報・WEB予約・診療内容・説明文・Google Map）を出力する。
 *
 * @package efline
 */
get_header(); ?>

<div class="l-container">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'clinic-detail' ); ?>>
			<h1 class="entry-title"><?php the_title(); ?></h1>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="clinic-detail__thumb"><?php the_post_thumbnail( 'large' ); ?></div>
			<?php endif; ?>

			<!-- TODO: ACF フィールド出力
				- 基本情報（名称・住所・電話・診療時間）
				- WEB予約リンク
				- 診療内容
				- 説明文（見出し + 本文）
				- アクセスマップ（Google Map）
			-->
		</article>
	<?php endwhile; ?>
</div>

<?php get_footer();
