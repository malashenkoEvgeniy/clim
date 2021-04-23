'use strict';

/**
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'custom-jquery-methods/fn/has-inited-key';
import PerfectScrollbar from 'perfect-scrollbar';
import 'perfect-scrollbar/css/perfect-scrollbar.css';

// ----------------------------------------
// Private
// ----------------------------------------

/**
 * @param {HTMLElement} element
 * @private
 */
function _init (element) {
	const ps = new PerfectScrollbar(element, { // eslint-disable-line no-unused-vars
		wheelSpeed: 0.5,
		wheelPropagation: true,
		minScrollbarLength: 20
	});
}

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $elements
 */
function each ($elements) {
	$elements.each((i, element) => {
		if ($(element).hasInitedKey('perfect-scrollbar-initialized')) {
			return true;
		}
		_init(element);
	});
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default each;
