<?php
/**
 * クリニック紹介 一覧 (アーカイブ)。
 * 後続フェーズで Figma に沿ったカードレイアウトを実装する。
 *
 * @package efline
 */
get_header(); ?>

<div class="l-container">
	<header class="archive-header">
		<h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<ul class="clinic-list">
			<?php while ( have_posts() ) : the_post(); ?>
				<li class="clinic-card">
					<a href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'efline-clinic-card' );
						} ?>
						<h2 class="clinic-card__title"><?php the_title(); ?></h2>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>

		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'クリニックがまだ登録されていません。', 'efline' ); ?></p>
	<?php endif; ?>
</div>

<?php get_footer();
