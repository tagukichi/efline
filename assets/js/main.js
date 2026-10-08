/* efline theme main JS */
(function () {
	'use strict';

	// クリニックアーカイブのソートセレクト
	document.querySelectorAll('[data-efline-sort]').forEach(function (select) {
		select.addEventListener('change', function () {
			if (select.value) {
				window.location.href = select.value;
			}
		});
	});

	// ハンバーガーメニュー（1023px 以下）
	var header = document.querySelector('.site-header');
	var toggle = document.querySelector('[data-efline-nav-toggle]');
	if (header && toggle) {
		var setOpen = function (open) {
			header.classList.toggle('is-nav-open', open);
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		};
		toggle.addEventListener('click', function () {
			setOpen(!header.classList.contains('is-nav-open'));
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && header.classList.contains('is-nav-open')) {
				setOpen(false);
				toggle.focus();
			}
		});
		header.querySelectorAll('.site-header__nav a').forEach(function (a) {
			a.addEventListener('click', function () { setOpen(false); });
		});
		window.matchMedia('(min-width: 1024px)').addEventListener('change', function (mq) {
			if (mq.matches) setOpen(false);
		});
	}

	// ページトップへ戻る
	document.querySelectorAll('[data-efline-totop]').forEach(function (el) {
		el.addEventListener('click', function (e) {
			e.preventDefault();
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
	});

	// クリニックカルーセル（横スクロール + 矢印ボタン）
	document.querySelectorAll('[data-efline-carousel]').forEach(function (root) {
		var track = root.querySelector('[data-efline-carousel-track]');
		var prev  = root.querySelector('[data-efline-carousel-prev]');
		var next  = root.querySelector('[data-efline-carousel-next]');
		if (!track) return;

		function step() {
			var item = track.querySelector('li');
			if (!item) return 300;
			var gap = parseFloat(getComputedStyle(track).columnGap || '0');
			return item.offsetWidth + (isNaN(gap) ? 0 : gap);
		}

		if (prev) prev.addEventListener('click', function () { track.scrollBy({ left: -step(), behavior: 'smooth' }); });
		if (next) next.addEventListener('click', function () { track.scrollBy({ left: step(), behavior: 'smooth' }); });
	});
})();
