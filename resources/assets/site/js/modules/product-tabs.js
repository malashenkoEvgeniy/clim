'use strict';

/**
 *
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'custom-jquery-methods/fn/has-inited-key';
import wsTabs from 'wezom-standard-tabs';

function _updateHash (str) {
	if (str) {
		window.location.hash = str;
	} else {
		window.history.replaceState(null, null, ' ');
	}
}

function _hash () {
	const $button = $(this);

	console.log($button);
	if ($button.data('wstabsNs') === 'product') {
		const _hash = $button.data('wstabsButton');
		_updateHash(_hash === 'main' ? false : _hash);
	}
}

function _checkHash (scope) {
	const _hash = window.location.hash;
	console.log(_hash);
	if (_hash) {
		$(`[data-${wsTabs.keys.button}="${_hash.split('#')[1]}"]`).filter('.tabs-nav__button').trigger('click');
	} else if (scope === 'popstate') {
		$(`[data-${wsTabs.keys.button}="main"]`).filter('.tabs-nav__button').trigger('click');
	}
}

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $elements
 * @sourceCode
 */
function productTabs ($elements) {
	const {
		on: tabOn
	} = wsTabs.events;
	const wsTabButton = `[data-${wsTabs.keys.button}]`;

	$elements.each((i, el) => {
		const $el = $(el);
		if ($el.hasInitedKey('productTabsInited')) {
			return true;
		}

		_checkHash();

		const $buttons = $(wsTabButton);

		$buttons.on(tabOn, _hash);
	});

	window.onpopstate = function () {
		_checkHash('popstate');
	};
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default productTabs;
