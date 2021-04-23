import debounce from 'lodash/debounce';
import Browserizr from 'browserizr';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $elements
 */
function submenu ($elements) {
	let subMenu = $('.action-bar-inner-menu');
	let mEnter;

	$($elements).on('mouseenter', '.js-submenu-item', mEnter = debounce((e) => {
		let inx = $(e.currentTarget).index();
		let currSubMenu = subMenu.find(`#inner-menu__item-${inx}`);

		subMenu.addClass('is-active');
		currSubMenu.addClass('is-active').siblings().removeClass('is-active');

		if (Browserizr.detect().isDesktop() && Browserizr.detect().isMoz()) {
			let currSubMenuBar = currSubMenu.find('.action-bar-submenu');

			currSubMenuBar.removeAttr('style');
			let subMenuHeight = subMenu.height();
			let currSubMenuBarHeight = currSubMenuBar.height();

			if (currSubMenuBarHeight / 2 < subMenuHeight) {
				currSubMenuBar.height(subMenuHeight - (parseInt(currSubMenuBar.css('padding-top')) * 2));
			} else {
				currSubMenuBar.height(currSubMenuBarHeight / 2);
			}
		}
	}, 300)).on('mouseleave', '.js-submenu-item', () => {
		(debounce(() => {
			if (!subMenu.data('mouseenter')) {
				subMenu.removeClass('is-active');
			}
		}, 300)());
		mEnter.cancel();
	});

	subMenu.on('mouseenter', () => {
		mEnter.cancel();
		subMenu.data('mouseenter', true);
	}).on('mouseleave', debounce(() => {
		subMenu.removeData('mouseenter').removeClass('is-active');
	}, 300));
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default submenu;
