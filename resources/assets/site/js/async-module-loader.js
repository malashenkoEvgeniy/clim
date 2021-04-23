'use strict';

/**
 * @module
 * @author Oleg Dutchenko <dutchenko.o.dev@gmail.com>
 * @version 1.0.0
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import ModuleLoader from 'wezom-module-loader';

// ----------------------------------------
// Public
// ----------------------------------------

const moduleLoader = new ModuleLoader({
	debug: IS_DEVELOPMENT,
	importPromise: moduleName => import('./async-module-loaders/' + moduleName),
	initSelector: '.js-init',
	initFunctionName: 'loaderInit',
	loadingClass: '_async-module-loading',
	loadedClass: '_async-module-loaded',
	list: {
		/* eslint-disable key-spacing */
		'jquery-validation--module-loader': 'form',
		'inputmask--module-loader':         '[data-phonemask]',
		// 's2s--module-loader':               '[data-s2s]',
		'magnific-popup--module-loader':    '[data-mfp]',
		// 'wrap-media--module-loader':        '[data-wrap-media]',
		// 'prismjs--module-loader':           '[data-prismjs]',
		'google-map--module-loader':        '[data-google-map]',
		'scroll-window--module-loader':     '[data-scroll-window]',
		// 'draggable-table--module-loader':   '[data-draggable-table]',
		'accordion--module-loader':         '[data-accordion]',
		'review-pagination--module-loader': '[data-review]',
		'product-tabs--module-loader':      '[data-product-tabs]',
		'submenu--module-loader':           '[data-submenu]',
		'slick-slider--module-loader':      '[data-slick-slider]',
		'mmenu--module-loader':             '[data-mmenu-module]',
		'perfect-scrollbar--module-loader': '[data-perfect-scrollbar]',
		'droparea--module-loader':          '[data-droparea]',
		'search-mobile--module-loader':     '[data-search-mobile="button"]',
		'toggle--module-loader':            '[data-toggle]',
		'livesearch--module-loader':        '[data-livesearch]',
		'input-quantity--module-loader':    '[data-quantity]',
		'related--module-loader':           '[data-related]',
		'location-suggest--module-loader':  '[data-location-suggest]',
		'ion-range--module-loader':         '[data-ion-range]'
	}
});

// ----------------------------------------
// Exports
// ----------------------------------------

export default moduleLoader;
