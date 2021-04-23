'use strict';

/**
 * @module
 */

// ----------------------------------------
// Execute
// ----------------------------------------

(function () {
	/**
	 * @namespace
	 */
	const hamburger = {
		selector: '[data-hamburger]',
		events: {
			activate: 'activate',
			deactivate: 'deactivate',
			toggle: 'toggle'
		},
		classes: {
			active: 'hamburger--is-active'
		},

		init () {
			const _self = this;
			const $hamburgers = $(_self.selector);

			$hamburgers.on(_self.events.activate, function () {
				$(this).addClass(_self.classes.active);
			});

			$hamburgers.on(_self.events.deactivate, function () {
				$(this).removeClass(_self.classes.active);
			});

			$hamburgers.on(_self.events.toggle, function () {
				const $this = $(this);
				if ($this.hasClass(_self.classes.activate)) {
					$this.trigger(_self.events.deactivate);
				} else {
					$this.trigger(_self.events.activate);
				}
			});
		}
	};

	hamburger.init();
	window.LOCO_DATA.modules.hamburger = hamburger;
})();
