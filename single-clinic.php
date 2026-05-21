<?php
/**
 * クリニック紹介 詳細 (single)。
 * 添付デザイン準拠の全面リデザイン。
 *
 * @package efline
 */
get_header(); ?>

<div class="l-container p-clinic-single">
	<?php while ( have_posts() ) : the_post();
		$basic       = efline_get_clinic_basic_info();
		$reservation = efline_get_clinic_reservation();
		$gallery     = efline_get_clinic_gallery();
		$about       = efline_get_clinic_about();
		$svc_items   = efline_get_clinic_service_items();
		$card_pr     = efline_get_clinic_card_pr();
		$hours_sum   = efline_get_clinic_hours_summary( null, 3 );
		$access      = efline_get_clinic_access();
		$areas       = efline_get_clinic_areas();

		// ギャラリーが空ならアイキャッチを代用。
		if ( empty( $gallery ) && has_post_thumbnail() ) {
			$thumb_id = get_post_thumbnail_id();
			$gallery = array(
				array(
					'url' => get_the_post_thumbnail_url( null, 'large' ),
					'alt' => get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ) ?: get_the_title(),
				),
			);
		}
		$main_image  = ! empty( $gallery ) ? $gallery[0] : null;
		$thumbs      = count( $gallery ) > 1 ? array_slice( $gallery, 1, 4 ) : array();
		$archive_url = get_post_type_archive_link( 'clinic' );
	?>

	<nav class="p-clinic-single__breadcrumb" aria-label="<?php esc_attr_e( 'パンくず', 'efline' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">TOP</a>
		<span aria-hidden="true">&gt;</span>
		<a href="<?php echo esc_url( $archive_url ); ?>"><?php esc_html_e( '取扱いクリニック', 'efline' ); ?></a>
		<span aria-hidden="true">&gt;</span>
		<span><?php the_title(); ?></span>
	</nav>

	<article <?php post_class( 'p-clinic-single__article' ); ?>>
		<!-- ===== ヘッダー: ギャラリー + 情報 ===== -->
		<header class="p-clinic-single__hero">
			<div class="p-clinic-gallery">
				<?php if ( $main_image ) : ?>
					<figure class="p-clinic-gallery__main">
						<img src="<?php echo esc_url( $main_image['url'] ); ?>" alt="<?php echo esc_attr( $main_image['alt'] ); ?>" loading="eager">
					</figure>
				<?php else : ?>
					<div class="p-clinic-gallery__main p-clinic-gallery__main--placeholder" aria-hidden="true"></div>
				<?php endif; ?>

				<?php if ( ! empty( $thumbs ) ) : ?>
					<ul class="p-clinic-gallery__thumbs">
						<?php foreach ( $thumbs as $thumb ) : ?>
							<li><img src="<?php echo esc_url( $thumb['url'] ); ?>" alt="<?php echo esc_attr( $thumb['alt'] ); ?>" loading="lazy"></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="p-clinic-single__info">
				<?php if ( ! empty( $areas ) ) : ?>
					<span class="p-clinic-single__area"><?php echo esc_html( $areas[0]->name ); ?></span>
				<?php endif; ?>

				<h1 class="p-clinic-single__title"><?php the_title(); ?></h1>

				<?php if ( $card_pr !== '' ) : ?>
					<p class="p-clinic-single__lead"><?php echo nl2br( esc_html( $card_pr ) ); ?></p>
				<?php endif; ?>

				<div class="p-clinic-single__contact">
					<?php if ( ! empty( $basic['phone'] ) ) : ?>
						<div class="p-clinic-single__contact-row">
							<span class="p-clinic-single__contact-icon" aria-hidden="true"><?php echo efline_icon( 'phone', array( 'width' => 18, 'height' => 18 ) ); ?></span>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $basic['phone'] ) ); ?>" class="p-clinic-single__contact-value"><?php echo esc_html( $basic['phone'] ); ?></a>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $basic['address'] ) ) : ?>
						<div class="p-clinic-single__contact-row">
							<span class="p-clinic-single__contact-icon" aria-hidden="true"><?php echo efline_icon( 'pin', array( 'width' => 18, 'height' => 18 ) ); ?></span>
							<span class="p-clinic-single__contact-value"><?php echo esc_html( $basic['address'] ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $hours_sum !== '' ) : ?>
						<div class="p-clinic-single__contact-row">
							<span class="p-clinic-single__contact-icon" aria-hidden="true"><?php echo efline_icon( 'clock', array( 'width' => 18, 'height' => 18 ) ); ?></span>
							<span class="p-clinic-single__contact-value"><?php echo esc_html( $hours_sum ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $reservation['url'] !== '' || $reservation['official_url'] !== '' ) : ?>
						<div class="p-clinic-single__ctas">
							<?php if ( $reservation['url'] !== '' ) : ?>
								<a class="c-button p-clinic-single__cta p-clinic-single__cta--primary" href="<?php echo esc_url( $reservation['url'] ); ?>" target="_blank" rel="noopener">
									<?php echo esc_html( $reservation['label'] ); ?>
									<span aria-hidden="true" class="p-clinic-single__cta-icon"><?php echo efline_icon( 'external', array( 'width' => 14, 'height' => 14 ) ); ?></span>
								</a>
							<?php endif; ?>
							<?php if ( $reservation['official_url'] !== '' ) : ?>
								<a class="c-button c-button--outline p-clinic-single__cta" href="<?php echo esc_url( $reservation['official_url'] ); ?>" target="_blank" rel="noopener">
									<?php esc_html_e( '公式サイト', 'efline' ); ?>
									<span aria-hidden="true" class="p-clinic-single__cta-icon"><?php echo efline_icon( 'external', array( 'width' => 14, 'height' => 14 ) ); ?></span>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</header>

		<!-- ===== クリニックについて ===== -->
		<?php if ( $about['heading'] !== '' || $about['body'] !== '' || $about['image'] ) : ?>
			<section class="p-clinic-single__about">
				<div class="p-clinic-single__about-text">
					<?php if ( $about['heading'] !== '' ) : ?>
						<h2 class="p-clinic-single__about-heading">
							<span class="p-clinic-single__about-icon" aria-hidden="true">
								<?php echo efline_icon( 'sparkle-tooth', array( 'width' => 40, 'height' => 40 ) ); ?>
							</span>
							<?php echo esc_html( $about['heading'] ); ?>
						</h2>
					<?php endif; ?>
					<?php if ( $about['body'] !== '' ) : ?>
						<div class="p-clinic-single__about-body">
							<?php echo wp_kses_post( wpautop( $about['body'] ) ); ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $about['image'] ) : ?>
					<figure class="p-clinic-single__about-image">
						<img src="<?php echo esc_url( $about['image']['url'] ); ?>" alt="<?php echo esc_attr( $about['image']['alt'] ?? '' ); ?>" loading="lazy">
					</figure>
				<?php endif; ?>
			</section>
		<?php endif; ?>

		<!-- ===== 対応内容 ===== -->
		<?php if ( ! empty( $svc_items ) ) : ?>
			<section class="p-clinic-single__services">
				<h2 class="p-clinic-single__services-title"><?php esc_html_e( '対応内容', 'efline' ); ?></h2>
				<ul class="p-clinic-single__services-list">
					<?php foreach ( $svc_items as $i => $item ) : ?>
						<li class="p-clinic-single__service" data-color="<?php echo esc_attr( $i % 3 ); ?>">
							<span class="p-clinic-single__service-icon" aria-hidden="true">
								<?php echo efline_icon( 'tooth-outline', array( 'width' => 36, 'height' => 36 ) ); ?>
							</span>
							<h3 class="p-clinic-single__service-name"><?php echo esc_html( $item['name'] ); ?></h3>
							<?php if ( $item['description'] !== '' ) : ?>
								<p class="p-clinic-single__service-desc"><?php echo nl2br( esc_html( $item['description'] ) ); ?></p>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>

		<!-- ===== アクセス ===== -->
		<?php if ( $access['map_query'] !== '' || $access['directions'] !== '' || ! empty( $basic['address'] ) ) : ?>
			<section class="p-clinic-single__access-section">
				<h2 class="p-clinic-single__section-title">
					<span aria-hidden="true"><?php echo efline_icon( 'pin', array( 'width' => 22, 'height' => 22 ) ); ?></span>
					<?php esc_html_e( 'アクセス', 'efline' ); ?>
				</h2>
				<div class="p-clinic-single__access-inner">
					<?php if ( $access['map_query'] !== '' ) : ?>
						<div class="p-clinic-single__map">
							<iframe
								src="https://www.google.com/maps?q=<?php echo rawurlencode( $access['map_query'] ); ?>&output=embed"
								width="100%"
								height="280"
								loading="lazy"
								referrerpolicy="no-referrer-when-downgrade"
								title="<?php echo esc_attr( get_the_title() ); ?>のアクセスマップ"></iframe>
						</div>
					<?php endif; ?>
					<div class="p-clinic-single__access-text">
						<?php if ( ! empty( $basic['address'] ) ) : ?>
							<p class="p-clinic-single__access-address">
								<?php if ( ! empty( $basic['postal_code'] ) ) : ?>
									〒<?php echo esc_html( $basic['postal_code'] ); ?>
								<?php endif; ?>
								<?php echo esc_html( $basic['address'] ); ?>
							</p>
						<?php endif; ?>
						<?php if ( $access['directions'] !== '' ) : ?>
							<div class="p-clinic-single__access-directions">
								<?php echo wp_kses_post( wpautop( $access['directions'] ) ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<!-- ===== 下部 CTA ===== -->
		<?php if ( $reservation['url'] !== '' ) : ?>
			<aside class="p-clinic-single__bottom-cta">
				<img src="<?php echo esc_url( efline_logo_url() ); ?>" alt="" class="p-clinic-single__bottom-cta-mascot" aria-hidden="true">
				<div class="p-clinic-single__bottom-cta-text">
					<h3 class="p-clinic-single__bottom-cta-heading"><?php esc_html_e( 'まずはお気軽にご相談ください', 'efline' ); ?></h3>
					<p class="p-clinic-single__bottom-cta-body"><?php esc_html_e( 'お子さまの歯並びやお口の健康について、気になることがあればお気軽にご相談ください。', 'efline' ); ?></p>
				</div>
				<a class="c-button p-clinic-single__bottom-cta-button" href="<?php echo esc_url( $reservation['url'] ); ?>" target="_blank" rel="noopener">
					<?php echo esc_html( $reservation['label'] ); ?>
					<span aria-hidden="true" class="p-clinic-single__cta-icon"><?php echo efline_icon( 'external', array( 'width' => 14, 'height' => 14 ) ); ?></span>
				</a>
			</aside>
		<?php endif; ?>
	</article>
	<?php endwhile; ?>
</div>

<?php get_footer();
