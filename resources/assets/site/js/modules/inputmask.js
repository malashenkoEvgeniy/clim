'use strict';

/**
 *
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'inputmask/dist/jquery.inputmask.bundle';

import 'custom-jquery-methods/fn/has-inited-key';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {JQuery} $elements
 * @param {ModuleLoader} moduleLoader
 * @sourceCode
 */
function phonemask ($elements, moduleLoader) {
	$elements.each((i, el) => {
		const $element = $(el);
		if ($element.hasInitedKey('phonemask-inited')) {
			return true;
		}

		const isComplete = () => $element.data('valid', $element.inputmask('isComplete'));
		$element.inputmask({
			mask: '+389999999999',
			showMaskOnHover: false,
			oncomplete () {
				$element.data('valid', true);
			},
			onincomplete () {
				$element.data('valid', false);
			}
		}).on('change.isComplete', isComplete);
	});
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default phonemask;
