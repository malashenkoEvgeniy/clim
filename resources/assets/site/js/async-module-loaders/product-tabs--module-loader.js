'use strict';

/**
 * Прослойка для загрузки модуля `productTabs`
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import productTabs from 'assetsSite#/js/modules/product-tabs';

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
	productTabs($elements);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
