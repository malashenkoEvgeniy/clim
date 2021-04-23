'use strict';

/**
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'jquery-validation';
import './laravel-extend';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $form
 * @param {jQueryValidationSettings} settings
 * @param {jQueryValidationParams} params
 */
function fireUp ($form, settings, params) {
	if ($form.hasClass('ajax-form')) {
		$form.on('submit', event => event.preventDefault());
	}
	$form.validate(settings);
	$form.data('validator');
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default fireUp;
