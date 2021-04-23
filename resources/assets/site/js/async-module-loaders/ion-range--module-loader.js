'use strict';

/**
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import ionRangeInit from 'assetsSite#/js/modules/ion-range';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $elements
 * @param {ModuleLoader} moduleLoader
 */
function loaderInit ($elements, moduleLoader) {
	ionRangeInit($elements);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
