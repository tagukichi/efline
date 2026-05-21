<?php
/**
 * クリニック紹介 アーカイブ。
 *
 * @package efline
 */
get_header();

$current_area    = isset( $_GET['area'] ) ? sanitize_title( wp_unslash( $_GET['area'] ) ) : '';
$current_service = isset( $_GET['service'] ) ? sanitize_title( wp_unslash( $_GET['service'] ) ) : '';
$current_sort    = isset( $_GET['sort'] ) ? sanitize_key( wp_unslash( $_GET['sort'] ) ) : 'recommended';
$total           = (int) $GLOBALS['wp_query']->found_posts;

$areas    = get_terms( array( 'taxonomy' => 'clinic_area', 'hide_empty' => false ) );
$services = get_terms( array( 'taxonomy' => 'clinic_service', 'hide_empty' => false ) );
?>

<div class="l-container">
	<nav class="p-breadcrumb" aria-label="<?php esc_attr_e( 'パンくず', 'efline' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">TOP</a>
		<span aria-hidden="true">&gt;</span>
		<span><?php post_type_archive_title(); ?></span>
	</nav>

	<header class="p-archive__header">
		<h1 class="p-archive__title"><?php post_type_archive_title(); ?></h1>
		<p class="p-archive__lead"><?php esc_html_e( 'EF Line について相談できるクリニックをご紹介します。', 'efline' ); ?></p>
	</header>

	<form class="p-clinic-filter" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'clinic' ) ); ?>">
		<div class="p-clinic-filter__field">
			<label class="p-clinic-filter__label" for="clinic-area"><?php esc_html_e( 'エリア', 'efline' ); ?></label>
			<select id="clinic-area" name="area" class="p-clinic-filter__select">
				<option value=""><?php esc_html_e( 'エリアを選択', 'efline' ); ?></option>
				<?php if ( ! is_wp_error( $areas ) ) : foreach ( $areas as $term ) : ?>
					<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $current_area, $term->slug ); ?>>
						<?php echo esc_html( $term->name ); ?>
					</option>
				<?php endforeach; endif; ?>
			</select>
		</div>

		<div class="p-clinic-filter__field">
			<label class="p-clinic-filter__label" for="clinic-service"><?php esc_html_e( '対応内容', 'efline' ); ?></label>
			<select id="clinic-service" name="service" class="p-clinic-filter__select">
				<option value=""><?php esc_html_e( '対応内容を選択', 'efline' ); ?></option>
				<?php if ( ! is_wp_error( $services ) ) : foreach ( $services as $term ) : ?>
					<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $current_service, $term->slug ); ?>>
						<?php echo esc_html( $term->name ); ?>
					</option>
				<?php endforeach; endif; ?>
			</select>
		</div>

		<?php if ( $current_sort !== 'recommended' ) : ?>
			<input type="hidden" name="sort" value="<?php echo esc_attr( $current_sort ); ?>">
		<?php endif; ?>

		<button type="submit" class="c-button p-clinic-filter__submit"><?php esc_html_e( '検索する', 'efline' ); ?></button>
	</form>

	<div class="p-clinic-results-bar">
		<p class="p-clinic-results-bar__count">
			<?php
			printf(
				/* translators: %s: 件数 */
				esc_html__( '検索結果: %s件', 'efline' ),
				'<strong>' . esc_html( number_format_i18n( $total ) ) . '</strong>'
			);
			?>
		</p>

		<div class="p-clinic-results-bar__sort">
			<label class="screen-reader-text" for="clinic-sort"><?php esc_html_e( '並び順', 'efline' ); ?></label>
			<select id="clinic-sort" class="p-clinic-results-bar__select" data-efline-sort>
				<option value="<?php echo esc_url( efline_clinic_filter_url( array( 'sort' => '' ) ) ); ?>" <?php selected( $current_sort, 'recommended' ); ?>>
					<?php esc_html_e( 'おすすめ順', 'efline' ); ?>
				</option>
				<option value="<?php echo esc_url( efline_clinic_filter_url( array( 'sort' => 'new' ) ) ); ?>" <?php selected( $current_sort, 'new' ); ?>>
					<?php esc_html_e( '新着順', 'efline' ); ?>
				</option>
			</select>
		</div>
	</div>

	<?php if ( have_posts() ) : ?>
		<ul class="p-clinic-grid">
			<?php while ( have_posts() ) : the_post();
				$areas_for_post    = efline_get_clinic_areas();
				$services_for_post = efline_get_clinic_services();
				$basic             = efline_get_clinic_basic_info();
				$hours_summary     = '';
				if ( ! empty( $basic['hours'] ) && is_array( $basic['hours'] ) ) {
					$first = $basic['hours'][0];
					$hours_summary = trim( ( $first['label'] ?? '' ) . ' ' . ( $first['time'] ?? '' ) );
				}
			?>
				<li class="p-clinic-card">
					<a class="p-clinic-card__link" href="<?php the_permalink(); ?>">
						<div class="p-clinic-card__media">
							<?php if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'efline-clinic-card', array( 'class' => 'p-clinic-card__image', 'loading' => 'lazy' ) );
							} else { ?>
								<div class="p-clinic-card__image p-clinic-card__image--placeholder" aria-hidden="true"></div>
							<?php } ?>

							<?php if ( ! empty( $areas_for_post ) ) : ?>
								<span class="p-clinic-card__area-badge">
									<?php echo esc_html( $areas_for_post[0]->name ); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="p-clinic-card__body">
							<h2 class="p-clinic-card__title">
								<?php the_title(); ?>
								<span class="p-clinic-card__arrow" aria-hidden="true">→</span>
							</h2>

							<?php $excerpt = get_the_excerpt();
							if ( $excerpt !== '' ) : ?>
								<p class="p-clinic-card__excerpt"><?php echo esc_html( wp_trim_words( $excerpt, 50, '…' ) ); ?></p>
							<?php endif; ?>

							<?php if ( ! empty( $services_for_post ) ) : ?>
								<dl class="p-clinic-card__services">
									<dt><?php esc_html_e( '対応内容', 'efline' ); ?></dt>
									<dd>
										<ul class="p-clinic-tags">
											<?php foreach ( $services_for_post as $term ) : ?>
												<li class="p-clinic-tags__item"><?php echo esc_html( $term->name ); ?></li>
											<?php endforeach; ?>
										</ul>
									</dd>
								</dl>
							<?php endif; ?>

							<ul class="p-clinic-card__meta">
								<?php if ( $hours_summary !== '' ) : ?>
									<li class="p-clinic-card__meta-item p-clinic-card__meta-item--hours">
										<span class="p-clinic-card__meta-label"><?php esc_html_e( '診療時間', 'efline' ); ?></span>
										<span class="p-clinic-card__meta-value"><?php echo esc_html( $hours_summary ); ?></span>
									</li>
								<?php endif; ?>

								<?php if ( ! empty( $basic['address'] ) ) : ?>
									<li class="p-clinic-card__meta-item p-clinic-card__meta-item--address">
										<span class="p-clinic-card__meta-label"><?php esc_html_e( '住所', 'efline' ); ?></span>
										<span class="p-clinic-card__meta-value"><?php echo esc_html( $basic['address'] ); ?></span>
									</li>
								<?php endif; ?>
							</ul>
						</div>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>

		<nav class="p-pagination" aria-label="<?php esc_attr_e( 'ページネーション', 'efline' ); ?>">
			<?php echo paginate_links( array(
				'mid_size'  => 2,
				'prev_text' => '<span aria-hidden="true">‹</span><span class="screen-reader-text">' . esc_html__( '前へ', 'efline' ) . '</span>',
				'next_text' => '<span aria-hidden="true">›</span><span class="screen-reader-text">' . esc_html__( '次へ', 'efline' ) . '</span>',
			) ); ?>
		</nav>

		<p class="p-clinic-note"><?php esc_html_e( '※掲載情報は変更がある場合があります。最新の情報はクリニックの公式サイトをご確認ください。', 'efline' ); ?></p>
	<?php else : ?>
		<p class="p-clinic-empty"><?php esc_html_e( '条件に一致するクリニックが見つかりませんでした。', 'efline' ); ?></p>
	<?php endif; ?>
</div>

<?php get_footer();
