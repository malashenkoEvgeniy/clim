'use strict';

/**
 *
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'slick-carousel';
import 'slick-carousel/slick/slick.scss';
import 'custom-jquery-methods/fn/has-inited-key';
import * as types from './slick-types';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $containers
 */
function each ($containers) {
	$containers.each((i, el) => {
		const $container = $(el);
		if ($container.hasInitedKey('slick-slider-initialized')) {
			return true;
		}

		const type = $container.data(types.SlickType.dataAttrKey).type;
		/** @type {SlickType} */
		const TypeClass = types[type] || types.SlickDefault; // eslint-disable-line import/namespace
		const slickSlider = new TypeClass($container);
		slickSlider.initialize();
	});
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default each;
