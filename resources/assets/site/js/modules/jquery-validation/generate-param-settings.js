'use strict';

/**
 * @module
 */

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQueryValidationParams} params
 * @return {jQueryValidationSettings}
 * @private
 */
const generateParamSettings = params => {
	/** @type {jQueryValidationSettings} */
	let flagSettings = {};

	if (params.focusOnError) {
		/**
		 * @param form
		 * @param {$.validator} validator
		 */
		flagSettings.invalidHandler = function (form, validator) {
			if (!validator.numberOfInvalids()) {
				return;
			}
			$(validator.errorList[0].element).focus();
		};
	}

	return flagSettings;
};

// ----------------------------------------
// Exports
// ----------------------------------------

export default generateParamSettings;
