'use strict';

/**
 * Прослойка для загрузки модуля `s2s`
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import googleMapInit from 'assetsSite#/js/modules/google-map';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {JQuery} $elements
 * @param {ModuleLoader} moduleLoader
 * @sourceCode
 */
function loaderInit ($elements, moduleLoader) {
	googleMapInit($elements, moduleLoader);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
