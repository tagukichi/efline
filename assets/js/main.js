/* efline theme main JS */
(function () {
	'use strict';

	// クリニックアーカイブのソートセレクト: change で対応する URL に遷移。
	document.querySelectorAll('[data-efline-sort]').forEach(function (select) {
		select.addEventListener('change', function () {
			if (select.value) {
				window.location.href = select.value;
			}
		});
	});
})();
