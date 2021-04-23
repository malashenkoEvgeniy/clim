'use strict';

/**
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'assetsSite#/js/vendors/ion.rangeSlider';
import 'assetsSite#/sass/vendors/ion-range/ion.rangeSlider.scss';
import 'assetsSite#/sass/vendors/ion-range/ion.rangeSlider.skinHTML5.scss';

import 'custom-jquery-methods/dist/has-inited-key';

// ----------------------------------------
// Private
// ----------------------------------------

const _presets = {
	double: {
		type: 'double'
	}
};

/**
 * @param {jQuery} $root
 * @param {Object} elements
 * @param {jQuery} elements.$slider
 * @param {jQuery} [elements.$minInput]
 * @param {jQuery} [elements.$maxInput]
 * @param {string} [preset]
 * @param {Object} [clientOptions={}]
 * @private
 */
function _init ($root, elements, preset, clientOptions = {}) {
	const { $slider, $minInput, $maxInput, $pricesInput } = elements;
	const options = $.extend(true, {}, _presets[preset], clientOptions);
	$slider.ionRangeSlider(options);

	$slider.on('change', () => {
		const value = $slider.val().split(';');
		$minInput.val(value[0]);
		$maxInput.val(value[1]);
		$pricesInput.val(value[0] + '-' + value[1]);
	});

	const api = $slider.data('ionRangeSlider');

	$minInput.on('change', () => {
		api.update({
			from: $minInput.val()
		});
	});

	$maxInput.on('change', () => {
		api.update({
			to: $maxInput.val()
		});
	});
}

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $elements
 */
function eachElements ($elements) {
	$elements.each((i, element) => {
		const $el = $(element);
		if ($el.hasInitedKey('ionRangeSliderInitialized')) {
			return true;
		}

		const {
			elements = {},
			options: clientOptions = {},
			preset
		} = $el.data('ionRange');

		for (let key in elements) {
			elements[key] = $el.find(elements[key]);
		}

		_init($el, elements, preset, clientOptions);
	});
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default eachElements;
