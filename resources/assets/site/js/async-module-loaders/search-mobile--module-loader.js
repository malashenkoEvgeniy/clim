'use strict';

/**
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import search from 'assetsSite#/js/modules/search-mobile';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $elements
 * @param {ModuleLoader} moduleLoader
 * @sourceCode
 */
function loaderInit ($elements, moduleLoader) {
	$elements.data('moduleLoader', moduleLoader);
	search($elements);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
