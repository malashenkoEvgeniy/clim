'use strict';

/**
 * @module
 */

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $elements
 */
function search ($elements) {
	$elements.on('click', function () {
		$('html').addClass('is-search-view');
		$('[data-search-input]').trigger('focus');
	});

	$('.js-search-close').on('click', function () {
		$('html').removeClass('is-search-view');
	});
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default search;
