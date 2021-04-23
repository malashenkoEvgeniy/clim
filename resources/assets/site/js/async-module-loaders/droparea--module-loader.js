'use strict';

/**
 * Прослойка для асинхронной загрузки модуля `droparea`
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import droparea from 'assetsSite#/js/modules/droparea';

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
	droparea($elements);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
