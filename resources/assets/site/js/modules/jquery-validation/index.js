'use strict';

/**
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'custom-jquery-methods/fn/has-inited-key';
import fireUp from './fire-up';
import { defaultParams, defaultSettings } from './default-configs';
import generateParamSettings from './generate-param-settings';

// ----------------------------------------
// Private
// ----------------------------------------

/**
 * @type {LOCO_DATA.validation.bySelector}
 * @private
 */
const _locoDataSelectors = window.LOCO_DATA.validation.bySelector;

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $forms
 */
function initialize ($forms) {
	/**
	 * @type {string[]}
	 * @private
	 */
	const _selectors = Object.keys(_locoDataSelectors);

	$forms.each((i, el) => {
		const $form = $(el);
		if ($form.hasInitedKey('jQueryValidationInitialized')) {
			return true;
		}

		/** @type {jQueryValidationlocoDataConfig} */
		let locoDataConfig = {};
		for (let i = 0; i < _selectors.length; i++) {
			if ($form.is(_selectors[i])) {
				locoDataConfig = _locoDataSelectors[_selectors[i]];
			}
		}

		/** @type {jQueryValidationParams} */
		const params = $.extend(true, {}, defaultParams, locoDataConfig.params);
		/** @type {jQueryValidationSettings} */
		const paramSettings = generateParamSettings(params);
		/** @type {jQueryValidationSettings} */
		const settings = $.extend(true, {}, defaultSettings, locoDataConfig.settings, paramSettings);

		fireUp($form, settings, params);
	});

	let $controls = $('.control--input').add($('.control--textarea'));

	$.each($controls, (i, control) => {
		let $control = $(control);
		let $field = $control.find('.control__field');

		$field.on('focus', (e) => {
			$control.addClass('in-focus');
		});

		$field.on('blur', (e) => {
			$control.removeClass('in-focus');
		});

		$field.on('input', (e) => {
			$control.toggleClass('has-value', $field.val().trim().length > 0);
		});
	});
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default initialize;

// ----------------------------------------
// Definitions
// ----------------------------------------

/**
 * @typedef {Object} jQueryValidationlocoDataConfig
 * @property {jQueryValidationParams} params
 * @property {jQueryValidationSettings} settings
 */
