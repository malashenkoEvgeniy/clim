'use strict';

/**
 * Прослойка для загрузки модуля `accordion`
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import accordion from 'assetsSite#/js/modules/accordion';

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
	accordion($elements);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
