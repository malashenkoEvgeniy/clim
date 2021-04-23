'use strict';

/**
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import ReviewPagination from 'assetsSite#/js/modules/review-pagination';

// ----------------------------------------
// Public
// ----------------------------------------

function loaderInit ($elements, moduleLoader) {
	$.each($elements, (i, root) => {
		let $root = $(root);

		if ($root.data('ReviewPagination') instanceof ReviewPagination === false) {
			const instance = new ReviewPagination($root, moduleLoader);
			$root.data('ReviewPagination', instance);
		}
	});
}

export { loaderInit };
