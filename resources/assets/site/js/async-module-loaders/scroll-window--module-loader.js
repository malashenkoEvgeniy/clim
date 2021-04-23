'use strict';

/**
 * Прослойка для загрузки модуля `scroll-window`
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import scrollWindow from 'assetsSite#/js/modules/scroll-window';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {JQuery} $elements
 * @param {ModuleLoader} moduleLoader
 * @sourceCode
 */
function loaderInit ($elements, moduleLoader) {
	scrollWindow($elements, moduleLoader);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
