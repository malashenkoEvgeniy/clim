'use strict';

/**
 * Прослойка для асинхронной загрузки модуля `magnific-popup`
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import mfpInitialize from 'assetsSite#/js/modules/magnific-popup/mfp-initialize';

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
	mfpInitialize($elements);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
