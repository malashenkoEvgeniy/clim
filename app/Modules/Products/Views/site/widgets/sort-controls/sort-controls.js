'use strict';

/**
 * @module
 */

(function () {
	$('.js-sort-control').on('change', function () {
		$(this.form).trigger('submit');
	});
})();
