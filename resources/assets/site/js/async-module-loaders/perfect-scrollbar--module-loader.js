'use strict';

/**
 * Прослойка для загрузки модуля `perfect-scrollbar`
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import Modernizr from 'modernizr';
import Browserizr from 'browserizr';
import perfectScrollbar from 'assetsSite#/js/modules/perfect-scrollbar-init';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $elements
 * @param {ModuleLoader} moduleLoader
 * @sourceCode
 */
function loaderInit ($elements, moduleLoader) {
	if (Browserizr.detect().isDesktop() && !Modernizr.cssscrollbar) {
		perfectScrollbar($elements);
	}
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { loaderInit };
