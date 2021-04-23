'use strict';

/**
 * Прослойка для загрузки модуля `jquery-validation`
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import initialize from 'assetsSite#/js/modules/jquery-validation';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $elements
 * @param {ModuleLoader} moduleLoader
 */
function loaderInit ($elements, moduleLoader) {
	$elements.data('moduleLoader', moduleLoader);
	initialize($elements);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
