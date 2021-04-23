'use strict';

/**
 * Прослойка для асинхронной загрузки модуля `mmenu`
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import mmenuInitialize from 'assetsSite#/js/modules/mmenu/mmenu-initialize';

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
	mmenuInitialize($elements);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
