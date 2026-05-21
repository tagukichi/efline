<?php
/**
 * クリニック紹介 詳細 (single)。
 * Figma に沿った最終レイアウトは後続フェーズで調整。まずは ACF フィールドを
 * 構造化マークアップで出力する最小実装。
 *
 * @package efline
 */
get_header(); ?>

<div class="l-container">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$basic       = efline_get_clinic_basic_info();
		$reservation = efline_get_clinic_reservation();
		$services    = efline_get_clinic_services();
		$descriptions = efline_get_clinic_descriptions();
		$access      = efline_get_clinic_access();
		?>
		<article <?php post_class( 'clinic-detail' ); ?>>
			<header class="clinic-detail__header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="clinic-detail__thumb"><?php the_post_thumbnail( 'large' ); ?></figure>
			<?php endif; ?>

			<?php if ( ! empty( $basic ) ) : ?>
				<section class="clinic-detail__basic">
					<h2><?php esc_html_e( '基本情報', 'efline' ); ?></h2>
					<dl class="clinic-info">
						<?php if ( ! empty( $basic['address'] ) ) : ?>
							<dt><?php esc_html_e( '住所', 'efline' ); ?></dt>
							<dd>
								<?php if ( ! empty( $basic['postal_code'] ) ) : ?>
									<span class="clinic-info__postal">〒<?php echo esc_html( $basic['postal_code'] ); ?></span>
								<?php endif; ?>
								<span class="clinic-info__address"><?php echo esc_html( $basic['address'] ); ?></span>
							</dd>
						<?php endif; ?>

						<?php if ( ! empty( $basic['phone'] ) ) : ?>
							<dt><?php esc_html_e( '電話番号', 'efline' ); ?></dt>
							<dd>
								<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $basic['phone'] ) ); ?>">
									<?php echo esc_html( $basic['phone'] ); ?>
								</a>
								<?php if ( ! empty( $basic['phone_note'] ) ) : ?>
									<small class="clinic-info__note"><?php echo esc_html( $basic['phone_note'] ); ?></small>
								<?php endif; ?>
							</dd>
						<?php endif; ?>

						<?php if ( ! empty( $basic['hours'] ) && is_array( $basic['hours'] ) ) : ?>
							<dt><?php esc_html_e( '診療時間', 'efline' ); ?></dt>
							<dd>
								<table class="clinic-hours">
									<tbody>
										<?php foreach ( $basic['hours'] as $row ) : ?>
											<tr>
												<th scope="row"><?php echo esc_html( $row['label'] ?? '' ); ?></th>
												<td><?php echo esc_html( $row['time'] ?? '' ); ?></td>
												<?php if ( ! empty( $row['note'] ) ) : ?>
													<td class="clinic-hours__note"><?php echo esc_html( $row['note'] ); ?></td>
												<?php endif; ?>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</dd>
						<?php endif; ?>

						<?php if ( ! empty( $basic['closed_days'] ) ) : ?>
							<dt><?php esc_html_e( '休診日', 'efline' ); ?></dt>
							<dd><?php echo esc_html( $basic['closed_days'] ); ?></dd>
						<?php endif; ?>
					</dl>
				</section>
			<?php endif; ?>

			<?php if ( ! empty( $services ) ) : ?>
				<section class="clinic-detail__services">
					<h2><?php esc_html_e( '対応内容', 'efline' ); ?></h2>
					<ul class="clinic-services">
						<?php foreach ( $services as $term ) : ?>
							<li><a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; ?>

			<?php if ( ! empty( $descriptions ) ) : ?>
				<section class="clinic-detail__descriptions">
					<?php foreach ( $descriptions as $desc ) : ?>
						<?php if ( $desc['heading'] === '' && $desc['body'] === '' ) {
							continue;
						} ?>
						<div class="clinic-description">
							<?php if ( $desc['heading'] !== '' ) : ?>
								<h2 class="clinic-description__heading"><?php echo esc_html( $desc['heading'] ); ?></h2>
							<?php endif; ?>
							<?php if ( $desc['body'] !== '' ) : ?>
								<div class="clinic-description__body"><?php echo wp_kses_post( $desc['body'] ); ?></div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</section>
			<?php endif; ?>

			<?php if ( ! empty( $access['map'] ) || $access['directions'] !== '' ) : ?>
				<section class="clinic-detail__access">
					<h2><?php esc_html_e( 'アクセス', 'efline' ); ?></h2>

					<?php if ( ! empty( $access['map']['address'] ) ) : ?>
						<p class="clinic-access__address"><?php echo esc_html( $access['map']['address'] ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $access['map']['lat'] ) && ! empty( $access['map']['lng'] ) ) : ?>
						<?php
						$query = isset( $access['map']['address'] ) && $access['map']['address'] !== ''
							? $access['map']['address']
							: $access['map']['lat'] . ',' . $access['map']['lng'];
						?>
						<div class="clinic-access__map">
							<iframe
								src="https://www.google.com/maps?q=<?php echo rawurlencode( $query ); ?>&output=embed"
								width="100%"
								height="400"
								loading="lazy"
								referrerpolicy="no-referrer-when-downgrade"
								title="<?php echo esc_attr( get_the_title() ); ?>のアクセスマップ"></iframe>
						</div>
					<?php endif; ?>

					<?php if ( $access['directions'] !== '' ) : ?>
						<div class="clinic-access__directions">
							<?php echo wp_kses_post( wpautop( $access['directions'] ) ); ?>
						</div>
					<?php endif; ?>
				</section>
			<?php endif; ?>

			<?php if ( $reservation['url'] !== '' ) : ?>
				<aside class="clinic-detail__cta">
					<a class="c-button" href="<?php echo esc_url( $reservation['url'] ); ?>" target="_blank" rel="noopener">
						<?php echo esc_html( $reservation['label'] ); ?>
					</a>
				</aside>
			<?php endif; ?>
		</article>
	<?php endwhile; ?>
</div>

<?php get_footer();
