'use strict';

/**
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'custom-jquery-methods/fn/has-inited-key';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $elements
 */
function each ($elements) {
	$elements.each((i, el) => {
		const $root = $(el);
		if ($root.hasInitedKey('relatedInitialized')) {
			return true;
		}

		let relatedNS = $root.data('related');
		relatedNS = Array.isArray(relatedNS) ? relatedNS : [relatedNS];

		const updateRelations = ($relatedMasters, $relatedSlaves) => {
			let css = {
				disabled: 'is-disabled'
			};

			$.each($relatedMasters, (i, elem) => {
				let $relatedMaster = $(elem);
				if (!$relatedMaster.is(':checked')) { return; }
				let relations = $relatedMaster.data('relations') || [];
				relations = Array.isArray(relations) ? relations : [relations];
				if (!relations.length) { return; }
				$relatedSlaves.addClass(css.disabled);
				let $relatedSlavesInputs = $relatedSlaves.is('input') ? $relatedSlaves : $relatedSlaves.find('input');
				$relatedSlavesInputs.prop('checked', false);
				relations.forEach((relation) => {
					$relatedSlavesInputs
						.filter(function () { return this.value === relation; })
						.closest(`.${css.disabled}`)
						.removeClass(css.disabled);
				});
			});
		};

		relatedNS.forEach((ns) => {
			let $relatedSlaves = $root.find(`[data-related-for="${ns}"]`);

			$root.on('change', `[data-related-to="${ns}"]`, (e) => {
				let $relatedMaster = $(e.currentTarget);
				updateRelations($relatedMaster, $relatedSlaves);
			});

			updateRelations($root.find(`[data-related-to="${ns}"]`), $relatedSlaves);
		});
	});
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default each;
