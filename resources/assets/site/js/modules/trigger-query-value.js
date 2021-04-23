'use strict';

/**
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'custom-jquery-methods/fn/has-inited-key';

// ----------------------------------------
// Private
// ----------------------------------------

/**
 * @type {{data: string, selector: string, initialized: string}}
 * @private
 */
const _keys = {
	data: 'trigger-query-value',
	get selector () {
		return `[data-${this.data}]`;
	},
	get initialized () {
		return `${this.data}-initialized`;
	}
};

/**
 * @private
 */
function _handler () {
	const $this = $(this);
	const $targets = $($this.data(_keys.data));
	$targets.val($this.val());
}

// ----------------------------------------
// Public
// ----------------------------------------

function triggerQueryValue ($context) {
	const $triggers = $(_keys.selector, $context).filter((i, trigger) => {
		return !$(trigger).hasInitedKey(_keys.initialized);
	});

	// events subscribe
	$triggers.on('change', _handler);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { triggerQueryValue };
