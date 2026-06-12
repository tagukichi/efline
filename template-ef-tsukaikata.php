<?php
/**
 * Template Name: EFの使い方
 *
 * EF Line トレーナーの装着方法・お手入れ等を解説する固定ページ。
 * テンプレ直書き、画像はトップで使用しているトレーナー画像 (efline_trainer_image_url) を使用。
 *
 * @package efline
 */
get_header();

while ( have_posts() ) :
	the_post();

	// ACF で差し替え可能な画像。未設定なら EF トップのトレーナー画像にフォールバック。
	$ef_fallback = efline_trainer_image_url();
	$ef_images   = array(
		'main'  => array( 'url' => $ef_fallback, 'alt' => '' ),
		'step1' => array( 'url' => $ef_fallback, 'alt' => '' ),
		'step2' => array( 'url' => $ef_fallback, 'alt' => '' ),
		'step3' => array( 'url' => $ef_fallback, 'alt' => '' ),
		'step4' => array( 'url' => $ef_fallback, 'alt' => '' ),
	);
	foreach ( array_keys( $ef_images ) as $slot ) {
		$acf_img = efline_get_field( 'ef_' . $slot . '_image' );
		if ( is_array( $acf_img ) && ! empty( $acf_img['url'] ) ) {
			$ef_images[ $slot ]['url'] = (string) $acf_img['url'];
			$ef_images[ $slot ]['alt'] = isset( $acf_img['alt'] ) ? (string) $acf_img['alt'] : '';
		}
	}
?>

<?php
efline_page_hero( array(
	'icon'       => 'info',
	'title'      => __( 'EF Lineトレーナーの使い方', 'efline' ),
	'breadcrumb' => get_the_title(),
	'variant'    => 'accent',
) );
?>

<div class="l-container p-kodomo">

	<!-- ===== Step 1: EF Lineトレーナーとは？ ===== -->
	<section class="p-kodomo-card p-kodomo-card--with-image">
		<div class="p-kodomo-card__body">
			<header class="p-kodomo-card__head">
				<span class="p-kodomo-card__num" aria-hidden="true">1</span>
				<h2 class="p-kodomo-card__title"><?php esc_html_e( 'EF Lineトレーナーとは？', 'efline' ); ?></h2>
			</header>
			<p class="p-kodomo-card__lead">
				<?php esc_html_e( 'EF Lineトレーナーは、お子さまの口腔機能をサポートする取り外し式のマウスピース型装置です。歯を直接動かすのではなく、口腔機能を整えることで、本格矯正治療のための土台づくりを目的としています。', 'efline' ); ?>
			</p>

			<div class="p-kodomo-subcard">
				<h3 class="p-kodomo-subcard__title"><?php esc_html_e( 'EF Lineトレーナーの特徴', 'efline' ); ?></h3>
				<ul class="p-kodomo-checklist p-kodomo-checklist--compact">
					<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '柔らかい素材で、お子さまでも痛みを感じにくい', 'efline' ); ?></span></li>
					<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '取り外し式なので、食事や歯磨きの際は外せる', 'efline' ); ?></span></li>
					<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '日中1〜3時間と就寝時の装着で効果が期待できる', 'efline' ); ?></span></li>
					<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '歯を直接動かす矯正装置と比べて違和感が少ない', 'efline' ); ?></span></li>
					<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '成長期のお子さまの口腔機能を整えるのに最適', 'efline' ); ?></span></li>
				</ul>
			</div>
		</div>
		<figure class="p-kodomo-card__media p-kodomo-card__media--contain">
			<img src="<?php echo esc_url( $ef_images["main"]["url"] ); ?>" alt="<?php echo esc_attr( $ef_images["main"]["alt"] ); ?>" loading="lazy">
		</figure>
	</section>

	<!-- 効果 callout -->
	<aside class="p-kodomo-callout">
		<div class="p-kodomo-callout__icon" aria-hidden="true">
			<?php echo efline_icon( 'sparkle-tooth', array( 'width' => 64, 'height' => 64 ) ); ?>
		</div>
		<div class="p-kodomo-callout__body">
			<h3 class="p-kodomo-callout__title"><?php esc_html_e( '期待できる効果', 'efline' ); ?></h3>
			<p>
				<?php esc_html_e( '口呼吸から鼻呼吸への切り替え、舌の正しい位置の習慣化、口周りの筋肉のバランス調整、唇や舌のクセ防止、嚥下運動の促進、正しい歯の生え変わりの誘導、あごの正しい成長を促すなど、お子さまの将来の健やかな成長をサポートします。', 'efline' ); ?>
			</p>
		</div>
	</aside>

	<!-- ===== Step 2: 装着ステップ ===== -->
	<section class="p-kodomo-card">
		<header class="p-kodomo-card__head">
			<span class="p-kodomo-card__num" aria-hidden="true">2</span>
			<h2 class="p-kodomo-card__title"><?php esc_html_e( '正しい装着方法（4ステップ）', 'efline' ); ?></h2>
		</header>
		<p class="p-kodomo-card__lead">
			<?php esc_html_e( '装着前にトレーナーが清潔か確認してから、以下の手順で正しく装着しましょう。', 'efline' ); ?>
		</p>

		<ol class="p-ef-steps">
			<li class="p-ef-steps__item">
				<span class="p-ef-steps__num" aria-hidden="true">STEP 1</span>
				<div class="p-ef-steps__body">
					<h3 class="p-ef-steps__title"><?php esc_html_e( '装着前の準備', 'efline' ); ?></h3>
					<p><?php esc_html_e( '手と口を清潔にし、トレーナーを軽く水洗いします。装着まえに上下の向きを確認しましょう。', 'efline' ); ?></p>
				</div>
				<figure class="p-ef-steps__image">
					<img src="<?php echo esc_url( $ef_images["step1"]["url"] ); ?>" alt="<?php echo esc_attr( $ef_images["step1"]["alt"] ); ?>" loading="lazy">
				</figure>
			</li>
			<li class="p-ef-steps__item">
				<span class="p-ef-steps__num" aria-hidden="true">STEP 2</span>
				<div class="p-ef-steps__body">
					<h3 class="p-ef-steps__title"><?php esc_html_e( '上下の歯にセット', 'efline' ); ?></h3>
					<p><?php esc_html_e( 'トレーナーを口に入れる時は、まず上の歯にしっかりとはめてから下の歯を合わせます。無理に押し込まないでください。', 'efline' ); ?></p>
				</div>
				<figure class="p-ef-steps__image">
					<img src="<?php echo esc_url( $ef_images["step2"]["url"] ); ?>" alt="<?php echo esc_attr( $ef_images["step2"]["alt"] ); ?>" loading="lazy">
				</figure>
			</li>
			<li class="p-ef-steps__item">
				<span class="p-ef-steps__num" aria-hidden="true">STEP 3</span>
				<div class="p-ef-steps__body">
					<h3 class="p-ef-steps__title"><?php esc_html_e( '舌の位置を整える', 'efline' ); ?></h3>
					<p><?php esc_html_e( '正しい嚥下運動を日常的に行うことで、舌は上に持ち上がってきます。トレーナー内の前方・裏側にある壁となる部分（タングランプ）が、正しい嚥下運動をサポートします。', 'efline' ); ?></p>
				</div>
				<figure class="p-ef-steps__image">
					<img src="<?php echo esc_url( $ef_images["step3"]["url"] ); ?>" alt="<?php echo esc_attr( $ef_images["step3"]["alt"] ); ?>" loading="lazy">
				</figure>
			</li>
			<li class="p-ef-steps__item">
				<span class="p-ef-steps__num" aria-hidden="true">STEP 4</span>
				<div class="p-ef-steps__body">
					<h3 class="p-ef-steps__title"><?php esc_html_e( '唇を閉じて鼻呼吸', 'efline' ); ?></h3>
					<p><?php esc_html_e( '唇を閉じて鼻でゆっくり呼吸します。口を開けないよう意識することがポイントです。', 'efline' ); ?></p>
				</div>
				<figure class="p-ef-steps__image">
					<img src="<?php echo esc_url( $ef_images["step4"]["url"] ); ?>" alt="<?php echo esc_attr( $ef_images["step4"]["alt"] ); ?>" loading="lazy">
				</figure>
			</li>
		</ol>
	</section>

	<!-- ===== Step 3 + 4: 装着時間 / お手入れ ===== -->
	<div class="p-kodomo-grid">
		<!-- 装着時間 -->
		<section class="p-kodomo-card">
			<header class="p-kodomo-card__head">
				<span class="p-kodomo-card__num p-kodomo-card__num--icon" aria-hidden="true"><?php echo efline_icon( 'clock', array( 'width' => 22, 'height' => 22 ) ); ?></span>
				<h2 class="p-kodomo-card__title"><?php esc_html_e( '装着時間の目安', 'efline' ); ?></h2>
			</header>

			<ul class="p-ef-time">
				<li>
					<span class="p-ef-time__label"><?php esc_html_e( '日中', 'efline' ); ?></span>
					<span class="p-ef-time__value">1〜3<small><?php esc_html_e( '時間', 'efline' ); ?></small></span>
					<span class="p-ef-time__note"><?php esc_html_e( 'テレビを見ながら、宿題中などに装着', 'efline' ); ?></span>
				</li>
				<li class="p-ef-time__plus" aria-hidden="true">+</li>
				<li>
					<span class="p-ef-time__label"><?php esc_html_e( '就寝時', 'efline' ); ?></span>
					<span class="p-ef-time__value">7〜9<small><?php esc_html_e( '時間', 'efline' ); ?></small></span>
					<span class="p-ef-time__note"><?php esc_html_e( '寝ている間は必ず装着しましょう', 'efline' ); ?></span>
				</li>
			</ul>

			<p class="p-kodomo-card__note">
				<?php esc_html_e( '※毎日コツコツ続けることが大切。お子さまに合ったペースで習慣化を目指しましょう。', 'efline' ); ?>
			</p>
		</section>

		<!-- お手入れ -->
		<section class="p-kodomo-card">
			<header class="p-kodomo-card__head">
				<span class="p-kodomo-card__num" aria-hidden="true">3</span>
				<h2 class="p-kodomo-card__title"><?php esc_html_e( '毎日のお手入れ方法', 'efline' ); ?></h2>
			</header>
			<p class="p-kodomo-card__lead">
				<?php esc_html_e( 'トレーナーを清潔に保つことで、長く快適に使用できます。', 'efline' ); ?>
			</p>

			<ul class="p-kodomo-icon-list">
				<li>
					<span class="p-kodomo-icon-list__icon"><?php echo efline_icon( 'sparkle', array( 'width' => 20, 'height' => 20 ) ); ?></span>
					<div>
						<strong><?php esc_html_e( '使用後は水洗い：', 'efline' ); ?></strong>
						<?php esc_html_e( '装着後すぐに流水で軽くすすぎます。お湯は変形の原因になるので避けてください。', 'efline' ); ?>
					</div>
				</li>
				<li>
					<span class="p-kodomo-icon-list__icon"><?php echo efline_icon( 'tooth', array( 'width' => 20, 'height' => 20 ) ); ?></span>
					<div>
						<strong><?php esc_html_e( '柔らかい歯ブラシで洗浄：', 'efline' ); ?></strong>
						<?php esc_html_e( '週2〜3回、歯磨き粉を使わず柔らかい歯ブラシで優しくこすり洗いを。', 'efline' ); ?>
					</div>
				</li>
				<li>
					<span class="p-kodomo-icon-list__icon"><?php echo efline_icon( 'info', array( 'width' => 20, 'height' => 20 ) ); ?></span>
					<div>
						<strong><?php esc_html_e( '専用ケースで保管：', 'efline' ); ?></strong>
						<?php esc_html_e( '使わないときは付属のケースに入れて、直射日光・高温を避けて保管します。', 'efline' ); ?>
					</div>
				</li>
			</ul>
		</section>
	</div>

	<!-- ===== Step 5: 注意点 ===== -->
	<section class="p-kodomo-card">
		<header class="p-kodomo-card__head">
			<span class="p-kodomo-card__num" aria-hidden="true">4</span>
			<h2 class="p-kodomo-card__title"><?php esc_html_e( '使用時の注意点', 'efline' ); ?></h2>
		</header>
		<p class="p-kodomo-card__lead">
			<?php esc_html_e( 'トラブルを防ぎ、効果を最大限に引き出すために、以下のポイントにご注意ください。', 'efline' ); ?>
		</p>

		<div class="p-kodomo-grid">
			<div class="p-ef-warn p-ef-warn--ng">
				<h3 class="p-ef-warn__title">
					<span class="p-ef-warn__icon" aria-hidden="true">×</span>
					<?php esc_html_e( 'やってはいけないこと', 'efline' ); ?>
				</h3>
				<ul class="p-kodomo-dot-list">
					<li><?php esc_html_e( '装着したまま食事・飲水（水以外）をする', 'efline' ); ?></li>
					<li><?php esc_html_e( 'ガムを噛む・ペットや兄弟が触れる場所に置く', 'efline' ); ?></li>
					<li><?php esc_html_e( '熱湯・電子レンジでの消毒（変形します）', 'efline' ); ?></li>
					<li><?php esc_html_e( '無理に噛みしめる・歯ぎしりをする', 'efline' ); ?></li>
					<li><?php esc_html_e( '誤った状態の装着や、咬み込んで遊んでしまうこと', 'efline' ); ?></li>
				</ul>
			</div>

			<div class="p-ef-warn p-ef-warn--ok">
				<h3 class="p-ef-warn__title">
					<span class="p-ef-warn__icon" aria-hidden="true">✓</span>
					<?php esc_html_e( '気をつけたいこと', 'efline' ); ?>
				</h3>
				<ul class="p-kodomo-dot-list">
					<li><?php esc_html_e( '装着中に痛みや違和感が続く場合は使用を中止し、歯科医師に相談', 'efline' ); ?></li>
					<li><?php esc_html_e( '装置に変形・破損があれば、自己判断せず交換相談を', 'efline' ); ?></li>
					<li><?php esc_html_e( '定期検診で歯科医師に経過をチェックしてもらう', 'efline' ); ?></li>
					<li><?php esc_html_e( 'トレーナーを装着する本人が、どうしても装置を使用できない場合は、歯科医師にほかの方法を相談', 'efline' ); ?></li>
					<li><?php esc_html_e( '家族全体で「続けることが大事」と共有することが成功の鍵', 'efline' ); ?></li>
				</ul>
			</div>
		</div>
	</section>

	<!-- ===== Q&A 誘導 ===== -->
	<section class="p-ef-qa-link">
		<div class="p-ef-qa-link__body">
			<h2 class="p-ef-qa-link__title">
				<span aria-hidden="true"><?php echo efline_icon( 'question', array( 'width' => 32, 'height' => 32 ) ); ?></span>
				<?php esc_html_e( 'もっと詳しく知りたい方へ', 'efline' ); ?>
			</h2>
			<p><?php esc_html_e( 'EFトレーナーの装着時間が短い場合・痛みがある場合・効果が出ないと感じる場合など、よくあるご質問への回答をQ&Aページにまとめています。', 'efline' ); ?></p>
		</div>
		<a class="c-button p-ef-qa-link__button" href="<?php echo esc_url( home_url( '/qa/' ) ); ?>">
			<?php esc_html_e( 'Q&Aを見る', 'efline' ); ?>
			<span aria-hidden="true">&nbsp;＞</span>
		</a>
	</section>

	<!-- ===== Closing CTA ===== -->
	<aside class="p-kodomo-closing">
		<div class="p-kodomo-closing__body">
			<header class="p-kodomo-closing__head">
				<span class="p-kodomo-card__num" aria-hidden="true">5</span>
				<h2 class="p-kodomo-closing__title"><?php esc_html_e( '正しい使い方で、お子さまの未来をサポート', 'efline' ); ?></h2>
			</header>
			<p>
				<?php esc_html_e( '装着方法やお手入れで不安なことがあれば、お近くの取扱いクリニックへお気軽にご相談ください。', 'efline' ); ?>
			</p>
		</div>
		<img src="<?php echo esc_url( efline_logo_url() ); ?>" alt="" class="p-kodomo-closing__mascot" aria-hidden="true">
	</aside>

</div>

<?php endwhile; get_footer();
