'use strict';

/**
 * @module
 * @author Oleg Dutchenko <dutchenko.o.dev@gmail.com>
 * @version 1.0.0
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'custom-jquery-methods/fn/has-inited-key';
import 'jquery.mmenu/dist/jquery.mmenu.all';
import 'assetsSite#/sass/vendors/mmenu/mmenu-customize.scss';
import * as types from './mmenu-types';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $containers
 */
function each ($menus) {
	$menus.each((i, el) => {
		const $menu = $(el);
		if ($menu.hasInitedKey('mMenuInitialized')) {
			return true;
		}

		const type = $menu.data(types.MobileMenuType.dataAttrKey).type;
		const TypeClass = types[type] || types.MenuNav; // eslint-disable-line import/namespace
		const mmenu = new TypeClass($menu);
		mmenu.initialize();
	});
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default each;
