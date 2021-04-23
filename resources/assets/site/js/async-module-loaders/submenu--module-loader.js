'use strict';

// ----------------------------------------
// Imports
// ----------------------------------------

import submenu from 'assetsSite#/js/modules/submenu';

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
	submenu($elements);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
