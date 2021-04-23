'use strict';

/**
 * @module
 */

// ----------------------------------------
// Execute
// ----------------------------------------

(function () {
	const selector = '.js-spritemap-clipboard';
	if ($(selector).length) {
		import('clipboard').then(({ default: ClipboardJS }) => new ClipboardJS(selector));
	}
})();
