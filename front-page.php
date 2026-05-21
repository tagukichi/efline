<?php
/**
 * フロントページ (TOP)。
 * Figma node 0:4 (PC) / 0:299 (SP) ベース。
 *
 * @package efline
 */
get_header();

// 取扱いクリニックカルーセル用に最新の clinic 投稿を最大 6 件取得。
$clinics = get_posts( array(
	'post_type'      => 'clinic',
	'posts_per_page' => 6,
	'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
	'no_found_rows'  => true,
) );

$archive_url = get_post_type_archive_link( 'clinic' );
?>

<section class="p-hero" aria-labelledby="hero-title">
	<div class="p-hero__inner">
		<div class="p-hero__media">
			<img src="<?php echo esc_url( efline_hero_image_url() ); ?>" alt="" class="p-hero__image" loading="eager" fetchpriority="high">
		</div>
		<div class="p-hero__content">
			<p class="p-hero__catch"><?php esc_html_e( 'キャッチコピーを入れることも可能です', 'efline' ); ?></p>
			<h1 id="hero-title" class="p-hero__title">
				<?php esc_html_e( 'タイトルをいれたり', 'efline' ); ?><br>
				<?php esc_html_e( 'この部分をスライダーにしたり', 'efline' ); ?><br>
				<?php esc_html_e( '自由に設定することが可能です', 'efline' ); ?>
			</h1>
			<a href="#trainer" class="c-button p-hero__cta">
				<?php esc_html_e( 'ボタンを付けたりもできます', 'efline' ); ?>
			</a>
		</div>
		<img src="<?php echo esc_url( efline_logo_url() ); ?>" alt="" class="p-hero__mascot" aria-hidden="true" loading="eager">
	</div>
</section>

<section class="p-clinics" aria-labelledby="clinics-title">
	<div class="p-clinics__inner">
		<div class="p-clinics__intro">
			<div class="p-clinics__intro-icon" aria-hidden="true">
				<?php echo efline_icon( 'clinic', array( 'width' => 96, 'height' => 96 ) ); ?>
			</div>
			<h2 id="clinics-title" class="p-clinics__heading">
				<?php esc_html_e( '取扱いクリニック', 'efline' ); ?>
			</h2>
			<a class="p-clinics__cta" href="<?php echo esc_url( $archive_url ); ?>">
				<span class="p-clinics__cta-text">
					<?php esc_html_e( '取扱いクリニック', 'efline' ); ?><br>
					<?php esc_html_e( '一覧はコチラ', 'efline' ); ?>
				</span>
			</a>
		</div>

		<?php if ( ! empty( $clinics ) ) : ?>
			<div class="p-clinics__carousel" data-efline-carousel>
				<button type="button" class="p-clinics__nav p-clinics__nav--prev" aria-label="<?php esc_attr_e( '前のクリニック', 'efline' ); ?>" data-efline-carousel-prev>
					<?php echo efline_icon( 'arrow-left', array( 'width' => 24, 'height' => 24 ) ); ?>
				</button>

				<ul class="p-clinics__list" data-efline-carousel-track>
					<?php foreach ( $clinics as $clinic ) :
						setup_postdata( $clinic );
						$areas    = efline_get_clinic_areas( $clinic->ID );
						$services = efline_get_clinic_services( $clinic->ID );
						$basic    = efline_get_clinic_basic_info( $clinic->ID );
						$pr       = efline_get_clinic_card_pr( $clinic->ID );
						$hours    = efline_get_clinic_hours_summary( $clinic->ID, 3 );
						$address  = isset( $basic['address'] ) ? (string) $basic['address'] : '';
					?>
						<li class="p-clinics__item">
							<a class="p-clinic-card-mini" href="<?php echo esc_url( get_permalink( $clinic ) ); ?>">
								<div class="p-clinic-card-mini__media">
									<?php if ( has_post_thumbnail( $clinic ) ) {
										echo get_the_post_thumbnail( $clinic, 'efline-clinic-card', array( 'class' => 'p-clinic-card-mini__image', 'loading' => 'lazy' ) );
									} else { ?>
										<div class="p-clinic-card-mini__image p-clinic-card-mini__image--placeholder" aria-hidden="true"></div>
									<?php } ?>
									<?php if ( ! empty( $areas ) ) : ?>
										<span class="p-clinic-card-mini__area"><?php echo esc_html( $areas[0]->name ); ?></span>
									<?php endif; ?>
								</div>

								<div class="p-clinic-card-mini__inner">
									<div class="p-clinic-card-mini__title-row">
										<h3 class="p-clinic-card-mini__title"><?php echo esc_html( get_the_title( $clinic ) ); ?></h3>
										<span class="p-clinic-card-mini__arrow" aria-hidden="true">
											<?php echo efline_icon( 'chevron-right', array( 'width' => 16, 'height' => 16 ) ); ?>
										</span>
									</div>

									<?php if ( $pr !== '' ) : ?>
										<p class="p-clinic-card-mini__body"><?php echo esc_html( wp_trim_words( $pr, 32, '…' ) ); ?></p>
									<?php endif; ?>

									<?php if ( ! empty( $services ) ) : ?>
										<div class="p-clinic-card-mini__group p-clinic-card-mini__group--services">
											<span class="p-clinic-card-mini__label"><?php esc_html_e( '対応内容', 'efline' ); ?></span>
											<ul class="p-clinic-card-mini__tags">
												<?php foreach ( array_slice( $services, 0, 3 ) as $term ) : ?>
													<li class="p-clinic-card-mini__tag"><?php echo esc_html( $term->name ); ?></li>
												<?php endforeach; ?>
											</ul>
										</div>
									<?php endif; ?>

									<?php if ( $hours !== '' ) : ?>
										<div class="p-clinic-card-mini__group p-clinic-card-mini__group--info">
											<span class="p-clinic-card-mini__icon" aria-hidden="true">
												<?php echo efline_icon( 'clock', array( 'width' => 14, 'height' => 14 ) ); ?>
											</span>
											<span class="p-clinic-card-mini__label"><?php esc_html_e( '診療時間', 'efline' ); ?></span>
											<span class="p-clinic-card-mini__value"><?php echo esc_html( $hours ); ?></span>
										</div>
									<?php endif; ?>

									<?php if ( $address !== '' ) : ?>
										<div class="p-clinic-card-mini__group p-clinic-card-mini__group--info">
											<span class="p-clinic-card-mini__icon" aria-hidden="true">
												<?php echo efline_icon( 'pin', array( 'width' => 14, 'height' => 14 ) ); ?>
											</span>
											<span class="p-clinic-card-mini__label"><?php esc_html_e( '住所', 'efline' ); ?></span>
											<span class="p-clinic-card-mini__value"><?php echo esc_html( $address ); ?></span>
										</div>
									<?php endif; ?>
								</div>
							</a>
						</li>
					<?php endforeach; wp_reset_postdata(); ?>
				</ul>

				<button type="button" class="p-clinics__nav p-clinics__nav--next" aria-label="<?php esc_attr_e( '次のクリニック', 'efline' ); ?>" data-efline-carousel-next>
					<?php echo efline_icon( 'arrow', array( 'width' => 24, 'height' => 24 ) ); ?>
				</button>
			</div>
		<?php else : ?>
			<p class="p-clinics__empty"><?php esc_html_e( 'クリニックを登録すると、ここに表示されます。', 'efline' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="p-feature p-feature--orthodontics" aria-labelledby="orthodontics-title">
	<div class="p-feature__inner">
		<div class="p-feature__head">
			<div class="p-feature__icon" aria-hidden="true">
				<?php echo efline_icon( 'tooth', array( 'width' => 110, 'height' => 110 ) ); ?>
				<?php echo efline_icon( 'sparkle', array( 'width' => 40, 'height' => 40, 'class' => 'p-feature__sparkle' ) ); ?>
			</div>
			<h2 id="orthodontics-title" class="p-feature__heading">
				<?php esc_html_e( 'こどものはならび', 'efline' ); ?>
			</h2>
		</div>
		<div class="p-feature__body">
			<p>
				<?php esc_html_e( 'お子さまの将来の歯並びは、乳歯のうちからのケアと生活習慣に大きく左右されます。日常の口腔機能をサポートする EF Line トレーナーで、お子さま本来の健やかな成長を後押しします。', 'efline' ); ?>
			</p>
			<p>
				<?php esc_html_e( '本セクションのテキストは管理画面の固定ページ「こどものはならび」から差し替えられるよう、次フェーズで連携予定です。', 'efline' ); ?>
			</p>
		</div>
	</div>
</section>

<section class="p-feature p-feature--trainer" id="trainer" aria-labelledby="trainer-title">
	<div class="p-feature__inner p-feature__inner--split">
		<div class="p-feature__visual">
			<?php if ( file_exists( EFLINE_THEME_DIR . '/assets/images/product-trainer.png' ) ) : ?>
				<img src="<?php echo esc_url( EFLINE_THEME_URI . '/assets/images/product-trainer.png' ); ?>" alt="<?php esc_attr_e( 'EF Line トレーナー本体', 'efline' ); ?>" class="p-feature__image">
			<?php else : ?>
				<div class="p-feature__image p-feature__image--placeholder" aria-hidden="true"></div>
			<?php endif; ?>
		</div>
		<div class="p-feature__content">
			<h2 id="trainer-title" class="p-feature__display-heading"><?php esc_html_e( 'トレーナー', 'efline' ); ?></h2>
			<p class="p-feature__display-body">
				<?php esc_html_e( '本格矯正治療前に', 'efline' ); ?><br>
				<?php esc_html_e( '口腔環境を整える機能訓練装置', 'efline' ); ?>
			</p>
			<a class="c-button c-button--outline" href="<?php echo esc_url( home_url( '/ef/' ) ); ?>">
				<?php esc_html_e( 'くわしく見る', 'efline' ); ?>
				<span aria-hidden="true">&nbsp;＞</span>
			</a>
		</div>
	</div>
</section>

<section class="p-feature p-feature--qa" aria-labelledby="qa-title">
	<div class="p-feature__inner">
		<div class="p-feature__head">
			<div class="p-feature__icon" aria-hidden="true">
				<?php echo efline_icon( 'question', array( 'width' => 110, 'height' => 110 ) ); ?>
			</div>
			<h2 id="qa-title" class="p-feature__heading">
				<?php esc_html_e( 'Q&A', 'efline' ); ?>
			</h2>
		</div>
		<div class="p-feature__body">
			<p>
				<?php esc_html_e( 'よくいただく質問への回答を Q&A ページにまとめています。装置の使い方やお手入れ方法、装着時間の目安など、ご利用前にぜひご確認ください。', 'efline' ); ?>
			</p>
			<p class="p-feature__cta-wrap">
				<a class="c-button c-button--outline" href="<?php echo esc_url( home_url( '/qa/' ) ); ?>">
					<?php esc_html_e( 'くわしく見る', 'efline' ); ?>
					<span aria-hidden="true">&nbsp;＞</span>
				</a>
			</p>
		</div>
	</div>
</section>

<?php get_footer();
