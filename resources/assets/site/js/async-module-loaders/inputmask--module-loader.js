'use strict';

/**
 * Прослойка для загрузки модуля `phonemask`
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import phonemask from 'assetsSite#/js/modules/inputmask';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {JQuery} $elements
 * @param {ModuleLoader} moduleLoader
 * @sourceCode
 */
function loaderInit ($elements, moduleLoader) {
	phonemask($elements, moduleLoader);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
