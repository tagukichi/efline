<?php
/**
 * Template Name: こどものはならび
 *
 * Figma node 0:245 (PC v2) を反映した固定ページ。コンテンツは
 * テンプレート直書き。画像は picsum.photos のサンプルを使用するので、
 * 実画像が用意でき次第 `assets/images/` 内のファイルに差し替える。
 *
 * @package efline
 */
get_header();

while ( have_posts() ) :
	the_post();
?>

<?php
efline_page_hero( array(
	'icon'       => 'tooth',
	'title'      => __( 'こどものはならび治療について', 'efline' ),
	'breadcrumb' => get_the_title(),
	'variant'    => 'accent',
) );
?>

<div class="l-container p-kodomo">

	<!-- ===== Step 1: 小児矯正って必要？ ===== -->
	<section class="p-kodomo-card p-kodomo-card--with-image">
		<div class="p-kodomo-card__body">
			<header class="p-kodomo-card__head">
				<span class="p-kodomo-card__num" aria-hidden="true">1</span>
				<h2 class="p-kodomo-card__title"><?php esc_html_e( '「うちの子、小児矯正って必要？」と思ったら…', 'efline' ); ?></h2>
			</header>
			<p class="p-kodomo-card__lead">
				<?php esc_html_e( 'お子さんの歯並びやあごの成長に気になるところがある場合、「小児矯正（1期治療）」を検討するタイミングかもしれません。', 'efline' ); ?>
			</p>

			<div class="p-kodomo-subcard">
				<h3 class="p-kodomo-subcard__title"><?php esc_html_e( '小児矯正が必要になることが多いのはこんなケース', 'efline' ); ?></h3>
				<ul class="p-kodomo-checklist">
					<li>
						<span class="p-kodomo-checklist__main"><?php esc_html_e( 'あごが小さくて、永久歯が並ぶスペースが足りない', 'efline' ); ?></span>
						<span class="p-kodomo-checklist__sub"><?php esc_html_e( '→ 将来、歯を抜かなくて済むように、あごを広げる治療が必要になることがあります。', 'efline' ); ?></span>
					</li>
					<li>
						<span class="p-kodomo-checklist__main"><?php esc_html_e( '受け口や出っ歯など、あごのバランスに問題がある', 'efline' ); ?></span>
						<span class="p-kodomo-checklist__sub"><?php esc_html_e( '→ 成長期の力を使って、あごの位置を整えることで改善が期待できます。', 'efline' ); ?></span>
					</li>
					<li>
						<span class="p-kodomo-checklist__main"><?php esc_html_e( '歯の生え方が大きくズレている', 'efline' ); ?></span>
						<span class="p-kodomo-checklist__sub"><?php esc_html_e( '→ 噛み合わせを正しく導く治療が必要です。', 'efline' ); ?></span>
					</li>
					<li>
						<span class="p-kodomo-checklist__main"><?php esc_html_e( '口呼吸・指しゃぶり・舌のクセなどがある', 'efline' ); ?></span>
						<span class="p-kodomo-checklist__sub"><?php esc_html_e( '→ 放っておくと歯並びに悪影響が出ることも。口の筋肉の使い方を整える治療が効果的です。', 'efline' ); ?></span>
					</li>
					<li>
						<span class="p-kodomo-checklist__main"><?php esc_html_e( '学校の歯科検診で「歯並びが気になる」と言われた', 'efline' ); ?></span>
						<span class="p-kodomo-checklist__sub"><?php esc_html_e( '→ 早めに歯医者さんで診てもらうのがおすすめです。', 'efline' ); ?></span>
					</li>
				</ul>
			</div>
		</div>
		<figure class="p-kodomo-card__media">
			<img src="https://picsum.photos/seed/kodomo1/520/520" alt="" loading="lazy">
		</figure>
	</section>

	<!-- 治療判断の青枠 -->
	<aside class="p-kodomo-callout">
		<div class="p-kodomo-callout__icon" aria-hidden="true">
			<?php echo efline_icon( 'sparkle-tooth', array( 'width' => 64, 'height' => 64 ) ); ?>
		</div>
		<div class="p-kodomo-callout__body">
			<h3 class="p-kodomo-callout__title"><?php esc_html_e( '治療を始めるかどうかの判断は？', 'efline' ); ?></h3>
			<p>
				<?php esc_html_e( '「今すぐ始めるべきか」よりも、「このままだと将来どうなるか？」を見て判断します。実際には、約3割のお子さんが1期治療だけで終わりますが、残りの7割は2期治療（本格的な矯正）が必要になることもあります。', 'efline' ); ?>
			</p>
		</div>
	</aside>

	<!-- ===== Step 2: 小児矯正のゴール ===== -->
	<section class="p-kodomo-card p-kodomo-card--with-image">
		<div class="p-kodomo-card__body">
			<header class="p-kodomo-card__head">
				<span class="p-kodomo-card__num" aria-hidden="true">2</span>
				<h2 class="p-kodomo-card__title"><?php esc_html_e( '小児矯正のゴールは「きれいな歯並びの土台づくり」', 'efline' ); ?></h2>
			</header>
			<p class="p-kodomo-card__lead">
				<?php esc_html_e( '1期治療の目的は、今の歯並びを完璧にすることではなく、将来、永久歯がきれいに並ぶための「準備」をすることです。', 'efline' ); ?>
			</p>

			<div class="p-kodomo-subcard">
				<h3 class="p-kodomo-subcard__title"><?php esc_html_e( '治療のゴールはこんな感じです', 'efline' ); ?></h3>
				<ul class="p-kodomo-checklist p-kodomo-checklist--compact">
					<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '永久歯が並ぶスペースをつくる', 'efline' ); ?></span></li>
					<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '出っ歯や受け口など、あごのバランスを整える', 'efline' ); ?></span></li>
					<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '噛み合わせのズレを予防する', 'efline' ); ?></span></li>
					<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '口呼吸や舌のクセなどを改善する', 'efline' ); ?></span></li>
					<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '将来の本格矯正（2期治療）の負担を減らす', 'efline' ); ?></span></li>
				</ul>
			</div>

			<p class="p-kodomo-card__note">
				<?php esc_html_e( '※1期治療だけで終われる場合もありますが、多くは経過観察を経て、必要に応じて2期治療へ進みます。', 'efline' ); ?>
			</p>
		</div>
		<figure class="p-kodomo-card__media">
			<img src="https://picsum.photos/seed/kodomo2/520/520" alt="" loading="lazy">
		</figure>
	</section>

	<!-- ===== Step 3 + 4: 2-column ===== -->
	<div class="p-kodomo-grid">
		<!-- 3: 装置 -->
		<section class="p-kodomo-card">
			<header class="p-kodomo-card__head">
				<span class="p-kodomo-card__num" aria-hidden="true">3</span>
				<h2 class="p-kodomo-card__title"><?php esc_html_e( '使う装置ってどんなもの？', 'efline' ); ?></h2>
			</header>
			<p class="p-kodomo-card__lead">
				<?php esc_html_e( 'お子さんの年齢や歯並びの状態によって、使う装置はさまざまです。', 'efline' ); ?>
			</p>

			<table class="p-kodomo-device-table">
				<thead>
					<tr>
						<th><?php esc_html_e( '装置の種類', 'efline' ); ?></th>
						<th><?php esc_html_e( '特徴', 'efline' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<span class="p-kodomo-device-table__icon" aria-hidden="true"><?php echo efline_icon( 'tooth', array( 'width' => 32, 'height' => 32 ) ); ?></span>
							<?php esc_html_e( '固定式', 'efline' ); ?>
						</td>
						<td><?php esc_html_e( '歯に直接つけるタイプ。取り外し不可。例：急速拡大装置など', 'efline' ); ?></td>
					</tr>
					<tr>
						<td>
							<span class="p-kodomo-device-table__icon" aria-hidden="true"><?php echo efline_icon( 'tooth-outline', array( 'width' => 32, 'height' => 32 ) ); ?></span>
							<?php esc_html_e( '取り外し式', 'efline' ); ?>
						</td>
						<td><?php esc_html_e( 'EFプレート型やマウスピース型。自分で外せる。例：拡大床、ラインなど', 'efline' ); ?></td>
					</tr>
					<tr>
						<td>
							<span class="p-kodomo-device-table__icon" aria-hidden="true"><?php echo efline_icon( 'sparkle-tooth', array( 'width' => 32, 'height' => 32 ) ); ?></span>
							<?php esc_html_e( '顎外装置', 'efline' ); ?>
						</td>
						<td><?php esc_html_e( '顎の成長をコントロールするために口の外につける。例：ヘッドギアなど', 'efline' ); ?></td>
					</tr>
				</tbody>
			</table>

			<p class="p-kodomo-card__note">
				<?php esc_html_e( '装置の選び方は、歯科医師の診断と、お子さんの生活スタイルに合わせて決めていきます。', 'efline' ); ?>
			</p>
		</section>

		<!-- 4: タイミング -->
		<section class="p-kodomo-card">
			<header class="p-kodomo-card__head">
				<span class="p-kodomo-card__num p-kodomo-card__num--icon" aria-hidden="true"><?php echo efline_icon( 'clock', array( 'width' => 22, 'height' => 22 ) ); ?></span>
				<h2 class="p-kodomo-card__title"><?php esc_html_e( '治療を始めるタイミングは？', 'efline' ); ?></h2>
			</header>
			<p class="p-kodomo-card__lead">
				<?php esc_html_e( 'おすすめのスタート時期は 6〜8歳ごろ。この時期は乳歯と永久歯が混ざっていて、あごの成長をコントロールしやすいタイミングです。', 'efline' ); ?>
			</p>

			<div class="p-kodomo-subcard">
				<h3 class="p-kodomo-subcard__title"><?php esc_html_e( 'こんなときは早めの相談を！', 'efline' ); ?></h3>
				<ul class="p-kodomo-checklist p-kodomo-checklist--compact">
					<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '前歯の永久歯が生え始めた', 'efline' ); ?></span></li>
					<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '出っ歯・受け口など骨格の問題がある', 'efline' ); ?></span></li>
					<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '指しゃぶりや口呼吸などのクセがある', 'efline' ); ?></span></li>
				</ul>
			</div>

			<p class="p-kodomo-card__note">
				<?php esc_html_e( '※早すぎても遅すぎても効果が出にくいことがあるので、6歳前後で一度、矯正専門医に相談するのが安心です。', 'efline' ); ?>
			</p>
		</section>
	</div>

	<!-- ===== Step 5 + 6: 2-column ===== -->
	<div class="p-kodomo-grid">
		<!-- 5: 期間 -->
		<section class="p-kodomo-card">
			<header class="p-kodomo-card__head">
				<span class="p-kodomo-card__num" aria-hidden="true">4</span>
				<h2 class="p-kodomo-card__title"><?php esc_html_e( '治療期間と通院ペースは？', 'efline' ); ?></h2>
			</header>
			<ul class="p-kodomo-dot-list">
				<li>
					<strong><?php esc_html_e( '治療期間の目安：', 'efline' ); ?></strong>
					<?php esc_html_e( '平均 1〜2年（症状によって半年〜3年ほどかかることも）', 'efline' ); ?>
				</li>
				<li>
					<strong><?php esc_html_e( '通院ペース：', 'efline' ); ?></strong>
					<ul class="p-kodomo-dot-list__sub">
						<li><?php esc_html_e( '初期：1〜2週間に1回', 'efline' ); ?></li>
						<li><?php esc_html_e( '安定期：月1回', 'efline' ); ?></li>
						<li><?php esc_html_e( '経過観察期：2〜3ヶ月に1回', 'efline' ); ?></li>
					</ul>
				</li>
			</ul>
			<p class="p-kodomo-card__note">
				<?php esc_html_e( '※取り外し式の装置の場合、使い方の確認のために通院回数が少し増えることもあります。', 'efline' ); ?>
			</p>
			<div class="p-kodomo-card__deco" aria-hidden="true">
				<?php echo efline_icon( 'clock', array( 'width' => 80, 'height' => 80 ) ); ?>
			</div>
		</section>

		<!-- 6: 費用 -->
		<section class="p-kodomo-card">
			<header class="p-kodomo-card__head">
				<span class="p-kodomo-card__num p-kodomo-card__num--icon" aria-hidden="true"><?php echo efline_icon( 'info', array( 'width' => 22, 'height' => 22 ) ); ?></span>
				<h2 class="p-kodomo-card__title"><?php esc_html_e( '費用と保険について', 'efline' ); ?></h2>
			</header>
			<ul class="p-kodomo-dot-list">
				<li><?php esc_html_e( '基本的に自費診療（保険は使えません）', 'efline' ); ?></li>
				<li><?php esc_html_e( '保険が使えるケースもあり（特定の病気や症候群がある場合）', 'efline' ); ?></li>
				<li>
					<strong><?php esc_html_e( '医療費控除の対象になることも', 'efline' ); ?></strong>
					<ul class="p-kodomo-dot-list__sub">
						<li><?php esc_html_e( '年間10万円以上かかった場合、確定申告で税金が戻る可能性があります。', 'efline' ); ?></li>
					</ul>
				</li>
			</ul>
			<p class="p-kodomo-card__note">
				<?php esc_html_e( '※費用は歯科医院によって異なるので、初診時にしっかり確認しましょう。', 'efline' ); ?>
			</p>
			<div class="p-kodomo-card__deco" aria-hidden="true">
				<svg viewBox="0 0 80 80" width="80" height="80" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<circle cx="40" cy="44" r="28" fill="#49bce3"/>
					<text x="40" y="55" text-anchor="middle" font-size="28" font-weight="bold" fill="white" font-family="sans-serif">¥</text>
					<path d="M22 24 L34 22 L40 14 L46 22 L58 24" stroke="#49bce3" stroke-width="2.5" fill="none" stroke-linecap="round"/>
				</svg>
			</div>
		</section>
	</div>

	<!-- ===== Step 7 + 8: 2-column ===== -->
	<div class="p-kodomo-grid">
		<!-- 7: 大切なこと -->
		<section class="p-kodomo-card">
			<header class="p-kodomo-card__head">
				<span class="p-kodomo-card__num" aria-hidden="true">5</span>
				<h2 class="p-kodomo-card__title"><?php esc_html_e( '治療を成功させるために大切なこと', 'efline' ); ?></h2>
			</header>
			<p class="p-kodomo-card__lead">
				<?php esc_html_e( 'お子さんの協力がとっても大事！特に取り外し式の装置は、使う時間を守ることがポイントです。', 'efline' ); ?>
			</p>

			<h3 class="p-kodomo-card__subtitle"><?php esc_html_e( '嫌がるときの工夫', 'efline' ); ?></h3>
			<ul class="p-kodomo-icon-list">
				<li>
					<span class="p-kodomo-icon-list__icon"><?php echo efline_icon( 'tooth', array( 'width' => 22, 'height' => 22 ) ); ?></span>
					<div>
						<strong><?php esc_html_e( 'わかりやすく説明する：', 'efline' ); ?></strong>
						<?php esc_html_e( '「歯並びがきれいになると、もっと笑顔が素敵になるよ」など前向きな言葉で。', 'efline' ); ?>
					</div>
				</li>
				<li>
					<span class="p-kodomo-icon-list__icon"><?php echo efline_icon( 'clock', array( 'width' => 22, 'height' => 22 ) ); ?></span>
					<div>
						<strong><?php esc_html_e( '短時間からスタート：', 'efline' ); ?></strong>
						<?php esc_html_e( '「テレビの時間だけ」「寝る前の30分だけ」など、少しずつ慣らす。', 'efline' ); ?>
					</div>
				</li>
				<li>
					<span class="p-kodomo-icon-list__icon"><?php echo efline_icon( 'sparkle', array( 'width' => 22, 'height' => 22 ) ); ?></span>
					<div>
						<strong><?php esc_html_e( 'ごほうび作戦：', 'efline' ); ?></strong>
						<?php esc_html_e( 'カレンダーにシールを貼るなど、ゲーム感覚で続ける。', 'efline' ); ?>
					</div>
				</li>
				<li>
					<span class="p-kodomo-icon-list__icon"><?php echo efline_icon( 'question', array( 'width' => 22, 'height' => 22 ) ); ?></span>
					<div>
						<strong><?php esc_html_e( '違和感がないか確認：', 'efline' ); ?></strong>
						<?php esc_html_e( '痛みやしゃべりにくさがある場合は、歯科医師に相談。', 'efline' ); ?>
					</div>
				</li>
				<li>
					<span class="p-kodomo-icon-list__icon"><?php echo efline_icon( 'clinic', array( 'width' => 22, 'height' => 22 ) ); ?></span>
					<div>
						<strong><?php esc_html_e( '家族みんなで応援：', 'efline' ); ?></strong>
						<?php esc_html_e( '「今日はいいか」と妥協すると、子どもも甘えがち。家族で一緒に取り組むことが大切です。', 'efline' ); ?>
					</div>
				</li>
			</ul>
		</section>

		<!-- 8: 目的 -->
		<section class="p-kodomo-card">
			<header class="p-kodomo-card__head">
				<span class="p-kodomo-card__num p-kodomo-card__num--icon" aria-hidden="true"><?php echo efline_icon( 'sparkle-tooth', array( 'width' => 22, 'height' => 22 ) ); ?></span>
				<h2 class="p-kodomo-card__title"><?php esc_html_e( '小児矯正の本当の目的は？', 'efline' ); ?></h2>
			</header>
			<p class="p-kodomo-card__lead">
				<?php esc_html_e( '見た目を整えるだけじゃなく、子どもの成長に合わせて口の環境を整えることが目的です。', 'efline' ); ?>
			</p>

			<ul class="p-kodomo-checklist p-kodomo-checklist--compact">
				<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '永久歯がきれいに並ぶスペースをつくる', 'efline' ); ?></span></li>
				<li><span class="p-kodomo-checklist__main"><?php esc_html_e( 'あごのバランスを整える', 'efline' ); ?></span></li>
				<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '呼吸や発音などの口の機能を改善', 'efline' ); ?></span></li>
				<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '将来の矯正の負担を減らす', 'efline' ); ?></span></li>
				<li><span class="p-kodomo-checklist__main"><?php esc_html_e( '自信を持って笑えるようになる', 'efline' ); ?></span></li>
			</ul>

			<p class="p-kodomo-card__conclude">
				<?php esc_html_e( '「歯を動かす」よりも、「あごを育てる」「クセを直す」ことが中心です。だからこそ、成長期の今がチャンスなんです。', 'efline' ); ?>
			</p>
			<div class="p-kodomo-card__deco p-kodomo-card__deco--large" aria-hidden="true">
				<?php echo efline_icon( 'sparkle-tooth', array( 'width' => 120, 'height' => 120 ) ); ?>
			</div>
		</section>
	</div>

	<!-- ===== Closing CTA ===== -->
	<aside class="p-kodomo-closing">
		<div class="p-kodomo-closing__body">
			<header class="p-kodomo-closing__head">
				<span class="p-kodomo-card__num" aria-hidden="true">6</span>
				<h2 class="p-kodomo-closing__title"><?php esc_html_e( '気になることがあれば、まずは専門の先生に相談してみてください😊', 'efline' ); ?></h2>
			</header>
			<p>
				<?php esc_html_e( 'お子さんの未来の笑顔のために、歯医者さんと一緒に今できることを考えてみませんか？', 'efline' ); ?>
			</p>
		</div>
		<img src="<?php echo esc_url( efline_logo_url() ); ?>" alt="" class="p-kodomo-closing__mascot" aria-hidden="true">
	</aside>

</div>

<?php endwhile; get_footer();
