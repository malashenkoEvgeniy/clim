'use strict';

/**
 * Скролл window
 * @see {@link https://greensock.com/docs/Plugins/ScrollToPlugin}
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import GSAP from 'GSAP#/gsap';
import TweenMax from 'GSAP#/TweenMax';
import 'GSAP#/plugins/ScrollToPlugin';

// ----------------------------------------
// Private
// ----------------------------------------

/**
 * Длительность скролла, в секундах
 * @type {number}
 * @private
 */
const defaultDuration = 1;

/**
 * @type {JQuery}
 * @private
 */
const $window = $(window);

/**
 * @type {number}
 * @private
 */
const showHeight = 500;

/**
 * @type {string}
 * @private
 */
const showClass = 'up-button--show';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {JQuery} $elements
 * @param {ModuleLoader} moduleLoader
 * @sourceCode
 */
function scrollWindow ($elements, moduleLoader) {
	$elements.on('click', function () {
		let $this = $(this);
		let scroll = $this.data('scroll-window') || 0;
		let scrollPX = 0;
		let duration = defaultDuration;

		if (typeof scroll !== 'object') {
			return true;
		}

		if (scroll.target === 'up') {
			let x = $window.scrollTop();
			let y = $window.outerHeight() * 2;
			let s = parseFloat((x / y).toFixed(2));
			scrollPX = 0;
			if (s < defaultDuration) {
				duration = s;
			}
		} else if (scroll.target === 'down') {
			scrollPX = 'max';
		}

		if (scroll.hasOwnProperty('offsetY')) {
			scrollPX = $(scroll.target).offset().top - parseInt(scroll.offsetY);
		}

		TweenMax.to(window, duration, {
			scrollTo: {
				y: scrollPX,
				autoKill: false
			},
			ease: GSAP.Power2.easeOut,
			onComplete () {
				if (scroll.hasOwnProperty('focus')) {
					$(scroll.focus).trigger('focus');
				}
			}
		});
	});

	const $scrollUp = $elements.filter('[data-scroll-window=\'{"target": "up"}\']');
	if ($scrollUp.length) {
		const onScroll = () => {
			let scroll = $window.scrollTop();
			let doClass = scroll > showHeight ? 'addClass' : 'removeClass';
			$scrollUp[doClass](showClass);
		};

		$window.on('scroll', onScroll);
		onScroll();
	}
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default scrollWindow;
