'use strict';

/**
 *
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import Modernizr from 'modernizr';

// ----------------------------------------
// Public
// ----------------------------------------

function lozad () {
	return new Promise((resolve, reject) => {
		const _initialize = ({ default: lozad }) => {
			const observer = lozad('.js-lozad', {
				loaded (el) {
					el.classList.add('lozad--is-ready');
				}
			});
			resolve(observer);
		};

		if (Modernizr.intersectionobserver) {
			import('lozad').then(_initialize);
		} else {
			import('intersection-observer').then(() => {
				import('lozad').then(_initialize);
			});
		}
	});
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default lozad;
