'use strict';

/**
 * @module
 */

// ----------------------------------------
// Import
// ----------------------------------------

import 'custom-jquery-methods/fn/get-my-elements';
import 'custom-jquery-methods/fn/change-my-class';

// ----------------------------------------
// Execute
// ----------------------------------------

(function () {
	/**
	 * @type {Object}
	 * @private
	 */
	const _data = {
		selectors: {
			section: '[data-action-bar-section]',
			catalog: '[data-action-bar-catalog]',
			expanded: '[data-action-bar-catalog="expanded"]',
			opener: '[data-action-bar-opener]',
			body: '[data-action-bar-body]'
		},
		classes: {
			opened: 'action-bar-catalog--opened',
			expanded: 'action-bar-catalog--expanded',
			stickySection: 'section--sticky-bar'
		},
		events: {
			toggleCatalog: 'toggle-catalog',
			closeNowCatalog: 'close-now-catalog'
		}
	};

	_data.$sections = $(_data.selectors.section);
	_data.$sections.each(function (i, el) {
		const $section = $(el);
		const $catalog = $section.getMyElements('$catalog', _data.selectors.catalog, 'find');
		const $body = $catalog.getMyElements('$body', _data.selectors.body, 'find');
		const $opener = $catalog.getMyElements('$opener', _data.selectors.opener, 'find');

		$section.on(_data.events.toggleCatalog, () => {
			const hamburger = window.LOCO_DATA.modules.hamburger;
			const $hamburger = hamburger ? $catalog.getMyElements('$hamburger', hamburger.selector, 'find') : [];

			$body.stop().slideToggle(400, () => {
				const isVisible = $body.is(':visible');
				const doClass = isVisible ? 'addClass' : 'removeClass';
				$catalog[doClass](_data.classes.opened);

				if (hamburger && $hamburger.length) {
					const hamburgerEvent = isVisible ? hamburger.events.activate : hamburger.events.deactivate;
					$hamburger.trigger(hamburgerEvent);
				}
			});
		});

		$section.on(_data.events.closeNowCatalog, () => {
			const hamburger = window.LOCO_DATA.modules.hamburger;
			const $hamburger = hamburger ? $catalog.getMyElements('$hamburger', hamburger.selector, 'find') : [];

			$body.stop().hide();
			$catalog.removeClass(_data.classes.opened);
			if (hamburger && $hamburger.length) {
				$hamburger.trigger(hamburger.events.deactivate);
			}
		});

		$opener.on('click', () => {
			$section.trigger(_data.events.toggleCatalog);
		});

		if (!$section.hasClass(_data.classes.stickySection)) {
			sticker($section, $section.next());
		}
	});

	/**
	 * @param {jQuery} $section
	 * @param {jQuery} $frontier
	 */
	function sticker ($section, $frontier) {
		const $window = $(window);
		const $expanded = $section.getMyElements('$expanded', _data.selectors.expanded, 'find');
		let previouslyAdded = $section.hasClass(_data.classes.stickySection);

		$window.on('scroll', () => {
			const top = $window.scrollTop();
			const height = $frontier.offset().top + $frontier.outerHeight();
			previouslyAdded = $section.changeMyClass(top > height, previouslyAdded, _data.classes.stickySection, added => {
				const doClass = added ? 'removeClass' : 'addClass';
				$expanded[doClass](_data.classes.expanded);
				if (!added && $expanded.hasClass(_data.classes.opened)) {
					$section.trigger(_data.events.closeNowCatalog);
				}
			});
		});
	}

	window.LOCO_DATA.modules.actionBar = _data;
})();
