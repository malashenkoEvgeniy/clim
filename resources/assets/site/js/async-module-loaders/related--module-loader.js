'use strict';

/**
 * Прослойка для асинхронной загрузки модуля `related`
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import relatedInit from 'assetsSite#/js/modules/related';

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
	relatedInit($elements);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
