'use strict';

/**
 * @module
 * @author Oleg Dutchenko <dutchenko.o.dev@gmail.com>
 * @version 1.0.0
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'assetsSite#/js/polyfills/mdn';
import 'assetsSite#/js/polyfills/promise-polyfill';
import 'assetsSite#/js/modules/modernizr';
import 'assetsSite#/js/ajax-global-config';
import wsTabs from 'wezom-standard-tabs';
import moduleLoader from 'assetsSite#/js/async-module-loader';
import lozad from 'assetsSite#/js/modules/lozad-load';

// ----------------------------------------
// Private
// ----------------------------------------

const $window = window.jQuery(window);
const $document = window.jQuery(document);
const $html = window.jQuery(document.documentElement);

const _statusClasses = {
	ready: '_document-is-ready',
	load: '_window-is-load'
};

// ----------------------------------------
// Ready
// ----------------------------------------

window.jQuery(function () {
	wsTabs.init();
	require('assetsSite#/js/_site-modules/all.js');
	moduleLoader.init($document);
	$html.addClass(_statusClasses.ready);

	lozad().then(observer => observer.observe());

	$document.on('click', '[data-print]', (e) => {
		if (e.currentTarget.tagName.toLocaleLowerCase() === 'a' && e.currentTarget.hasAttribute('href')) {
			return true;
		}

		if ($(e.currentTarget).data('print') === 'container') {
			$html.addClass('is-print-container');
		}

		window.print();
	});

	$document.on('input', 'textarea', (e) => {
		let textarea = e.currentTarget;
		let offset = textarea.offsetHeight - textarea.clientHeight;

		textarea.style.height = 'auto';
		textarea.style.height = `${textarea.scrollHeight + offset}px`;
	});

	$('.js-filter-show').on('click', () => {
		$html.addClass('is-filter-show');
	});

	$('.js-filter-close').on('click', () => {
		$html.removeClass('is-filter-show');
	});
});

// ----------------------------------------
// Load
// ----------------------------------------

$window.on('load', function () {
	$html.addClass(_statusClasses.load);
});

window.onafterprint = function () {
	$('html').removeClass('is-print-container');
};
