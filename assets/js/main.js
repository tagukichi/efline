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
