'use strict';

/**
 *
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import slickSliderEach from 'assetsSite#/js/modules/slick-slider/slick-slider';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $elements
 */
function loaderInit ($elements) {
	slickSliderEach($elements);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
