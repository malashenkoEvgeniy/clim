'use strict';

/**
 * @module
 */

// ----------------------------------------
// Definitions
// ----------------------------------------

/**
 * @typedef {Object} SlickSettings
 * @property {boolean} [__$arrows=false]
 * @property {boolean} [__$dots=false]
 * @property {boolean} [accessibility=true]
 * @property {boolean} [adaptiveHeight=true]
 * @property {boolean} [autoplay=false]
 * @property {number} [autoplaySpeed=3000]
 * @property {boolean} [arrows=true]
 * @property {string|Selector} [asNavFor=null]
 * @property {string|Selector|htmlString|Array|Element|jQuery} [appendArrows=$(element)]
 * @property {string|Selector|htmlString|Array|Element|jQuery} [appendDots=$(element)]
 * @property {Selector|Element|jQuery} [prevArrow='<button type="button" class="slick-prev">Previous</button>']
 * @property {Selector|Element|jQuery} [nextArrow='<button type="button" class="slick-next">Next</button>']
 * @property {boolean} [centerMode=false]
 * @property {string} [centerPadding='50px']
 * @property {string} [cssEase='ease']
 * @property {function} [customPaging]
 * @property {boolean} [dots=false]
 * @property {string} [dotsClass='slick-dots']
 * @property {boolean} [draggable=true]
 * @property {boolean} [fade=false]
 * @property {boolean} [focusOnSelect=false]
 * @property {string} [easing='linear']
 * @property {number} [edgeFriction=0.5]
 * @property {boolean} [infinite=true]
 * @property {number} [initialSlide=0]
 * @property {string} [lazyLoad='ondemand']
 * @property {boolean} [mobileFirst=false]
 * @property {boolean} [pauseOnFocus=true]
 * @property {boolean} [pauseOnHover=true]
 * @property {boolean} [pauseOnDotsHover=false]
 * @property {string} [respondTo='window']
 * @property {SlickSettingsResponsive[]} [responsive]
 * @property {number} [rows=1]
 * @property {Selector|Element|jQuery} [slide]
 * @property {number} [slidesPerRow=1]
 * @property {number} [slidesToShow=1]
 * @property {number} [slidesToScroll=1]
 * @property {number} [speed=300]
 * @property {boolean} [swipe=true]
 * @property {boolean} [swipeToSlide=false]
 * @property {boolean} [touchMove=true]
 * @property {number} [touchThreshold=5]
 * @property {boolean} [useCSS=true]
 * @property {boolean} [useTransform=true]
 * @property {boolean} [variableWidth=false]
 * @property {boolean} [vertical=false]
 * @property {boolean} [verticalSwiping=false]
 * @property {boolean} [rtl=false]
 * @property {boolean} [waitForAnimate=true]
 * @property {number} [zIndex=5]
 */

/**
 * @typedef {Object} SlickSettingsResponsive
 * @property {number} breakpoint
 * @property {SlickSettings} settings
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import Browserizr from 'browserizr';
import 'custom-jquery-methods/fn/index';
import Type from 'assetsSite#/js/type';

import wsTabs from 'wezom-standard-tabs';

// ----------------------------------------
// Private
// ----------------------------------------

/**
 * @implements Type
 * @property {jQuery} $rootElement
 * @property {Object} typeOptions
 */
export class SlickType extends Type {
	/**
	 * @param {jQuery} $rootElement
	 */
	constructor ($rootElement) {
		super($rootElement);
		this._setupUserTypeOptions();
		this._setupOptions();
		this._addCustomEvents();
	}

	/**
	 * @private
	 */
	_setupUserTypeOptions () {
		/**
		 * @type {Object[]}
		 * @private
		 */
		this._userTypeOptions = super._setupUserTypeOptions();
		return this._userTypeOptions;
	}

	/**
	 * @param {Object[]} [userOptions=this._userTypeOptions]
	 * @private
	 */
	_setupOptions (userOptions = this._userTypeOptions) {
		let _typeResponsiveOptions = $.extend([], this._typeDefaultOptions.responsive);
		if (_typeResponsiveOptions.length && userOptions.length) {
			userOptions.forEach(({ responsive: userResponsive = [] }) => {
				userResponsive.forEach(({ breakpoint, settings }) => {
					const founded = _typeResponsiveOptions.filter(responsive => {
						if (responsive.breakpoint !== breakpoint) {
							return false;
						}
						return $.extend(true, responsive.settings, settings);
					});
					if (!founded.length) {
						_typeResponsiveOptions.push({ breakpoint, settings });
					}
				});
			});
		}

		this.typeOptions = super._setupOptions(userOptions);

		if (_typeResponsiveOptions.length) {
			this.typeOptions.responsive = _typeResponsiveOptions;
		}

		if (this.typeOptions.__$arrows && this.$prevArrow.length) {
			this.typeOptions.prevArrow = this.$prevArrow;
		}

		if (this.typeOptions.__$arrows && this.$nextArrow.length) {
			this.typeOptions.nextArrow = this.$nextArrow;
		}

		if (this.typeOptions.__$dots && this.$dots.length) {
			this.typeOptions.appendDots = this.$dots;
		}
	}

	/**
	 * @return {SlickSettings}
	 * @private
	 */
	get _typeDefaultOptions () {
		return {};
	}

	/**
	 * @return {string}
	 * @private
	 */
	get _dataAttrKey () {
		return SlickType.dataAttrKey;
	}

	/**
	 * @public
	 * @return {string}
	 */
	static get dataAttrKey () {
		return 'slick-slider';
	}

	/**
	 * @private
	 */
	_addCustomEvents () {
		let $tabBlock = this.$slider.getMyElements(
			'$tabBlock',
			`[data-${wsTabs.keys.block}]`,
			'closest'
		);

		this.$slider.on('init', () => {
			$tabBlock.on(wsTabs.events.on, () => {
				this.update();
			});
		});
	}

	/**
	 * @private
	 */
	_slick () {
		if (!this.$rootElement.hasInitedKey(this._initedKey)) {
			this.$slider.addClass(this._sliderReadyCSSclass);
			this.$slider.slick(this.typeOptions);
		}
	}

	/**
	 * @private
	 */
	_unslick () {
		if (this.$rootElement.hasInitedKey(this._initedKey, false)) {
			this.$rootElement.removeInitedKey(this._initedKey);
			this.$slider.unslick();
		}
	}

	/**
	 * @return {string}
	 * @private
	 */
	get _initedKey () {
		return 'slickSliderInitializedKey';
	}

	/**
	 * @return {string}
	 * @private
	 */
	get _sliderReadyCSSclass () {
		return 'is-ready';
	}

	/**
	 * @public
	 */
	initialize () {
		if (this.$slider.is(':visible')) {
			this._slick();
		}
	}

	/**
	 * @public
	 */
	destroy () {
		this._unslick();
	}

	/**
	 * @public
	 */
	update () {
		this.$slider.slick('setPosition');
	}

	/**
	 * @return {jQuery}
	 */
	get $slider () {
		return this.$rootElement.getMyElements('$slider', '[data-slick-slider]', 'find');
	}

	/**
	 * @return {jQuery}
	 */
	get $prevArrow () {
		return this.$rootElement.getMyElements('$prevArrow', '[data-slick-arrow-prev]', 'find');
	}

	/**
	 * @return {jQuery}
	 */
	get $nextArrow () {
		return this.$rootElement.getMyElements('$nextArrow', '[data-slick-arrow-next]', 'find');
	}

	/**
	 * @return {jQuery}
	 */
	get $dots () {
		return this.$rootElement.getMyElements('$dots', '[data-slick-dots]', 'find');
	}
}

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @augments SlickType
 */
export class SlickDefault extends SlickType {
	/**
	 * @return {SlickSettings}
	 * @private
	 */
	get _typeDefaultOptions () {
		return {
			mobileFirst: true
		};
	}
}

/**
 * @augments SlickType
 */
export class SlickReviews extends SlickType {
	/**
	 * @return {SlickSettings}
	 * @private
	 */
	get _typeDefaultOptions () {
		return {
			__$arrows: Browserizr.detect().isDesktop(),
			__$dots: true,
			mobileFirst: true,
			adaptiveHeight: true,
			arrows: false,
			dots: true,
			swipeToSlide: true,
			responsive: Browserizr.detect().isMobile() ? [] : [
				{
					breakpoint: 768,
					settings: {
						arrows: Browserizr.detect().isDesktop(),
						dots: Browserizr.detect().isMobile()
					}
				}
			]
		};
	}

	/**
	 * @private
	 */
	_addCustomEvents () {
		// this.$slider.on('init', slick => {
		// 	console.warn('SlickReviews is initialized! test ._addCustomEvent() method');
		// });
	}
}

/**
 * @augments SlickType
 */
export class SlickBrands extends SlickType {
	/**
	 * @return {SlickSettings}
	 * @private
	 */
	get _typeDefaultOptions () {
		return {
			__$arrows: Browserizr.detect().isDesktop(),
			__$dots: true,
			mobileFirst: true,
			arrows: false,
			dots: true,
			swipeToSlide: true,
			slidesToShow: 2,
			responsive: [
				{
					breakpoint: 1280,
					settings: {
						arrows: Browserizr.detect().isDesktop(),
						dots: Browserizr.detect().isMobile(),
						slidesToShow: 6
					}
				}, {
					breakpoint: 1024,
					settings: {
						arrows: Browserizr.detect().isDesktop(),
						dots: Browserizr.detect().isMobile(),
						slidesToShow: 5
					}
				}, {
					breakpoint: 768,
					settings: {
						arrows: Browserizr.detect().isDesktop(),
						dots: Browserizr.detect().isMobile(),
						slidesToShow: 4
					}
				}, {
					breakpoint: 560,
					settings: {
						slidesToShow: 3
					}
				}
			]
		};
	}
}

/**
 * @augments SlickType
 */
export class SlickFeatures extends SlickType {
	/**
	 * @return {Object}
	 * @private
	 */
	get _typeDefaultOptions () {
		return {
			__$dots: true,
			mobileFirst: true,
			arrows: false,
			dots: true,
			swipeToSlide: true,
			slidesToShow: 2,
			infinite: false,
			responsive: [
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 4
					}
				}, {
					breakpoint: 568,
					settings: {
						slidesToShow: 3
					}
				}, {
					breakpoint: 375,
					settings: {
						slidesToShow: 2
					}
				}
			]
		};
	}
}

/**
 * @augments SlickType
 */
export class SlickItem extends SlickType {
	_addCustomEvents () {
		this.$rootElement.data('moduleLoader').init(this.$rootElement);
	}

	/**
	 * @return {SlickSettings}
	 * @private
	 */
	get _typeDefaultOptions () {
		return {
			__$dots: true,
			mobileFirst: true,
			arrows: false,
			dots: true,
			swipeToSlide: true,
			slidesToShow: 2,
			slidesToScroll: 2,
			infinite: false,
			responsive: [
				{
					breakpoint: 1280,
					settings: {
						slidesToShow: 5,
						slidesToScroll: 2
					}
				}, {
					breakpoint: 768,
					settings: {
						slidesToShow: 4,
						slidesToScroll: 2
					}
				}, {
					breakpoint: 480,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 2
					}
				}
			]
		};
	}
}

/**
 * @augments SlickType
 */
export class SlickItemWithArrow extends SlickType {
	/**
	 * @return {SlickSettings}
	 * @private
	 */
	get _typeDefaultOptions () {
		return {
			__$dots: true,
			mobileFirst: true,
			arrows: true,
			dots: true,
			swipeToSlide: true,
			slidesToShow: 2,
			infinite: false,
			prevArrow: $('.js-prev-arrow', this.$rootElement.closest('.section')),
			nextArrow: $('.js-next-arrow', this.$rootElement.closest('.section')),
			responsive: [
				{
					breakpoint: 1280,
					settings: {
						slidesToShow: 5
					}
				}, {
					breakpoint: 768,
					settings: {
						slidesToShow: 4
					}
				}, {
					breakpoint: 480,
					settings: {
						slidesToShow: 3
					}
				}
			]
		};
	}
}

/**
 * @augments SlickType
 */
export class SlickActionBar extends SlickType {
	/**
	 * @return {SlickSettings}
	 * @private
	 */
	get _typeDefaultOptions () {
		return {
			__$dots: true,
			__$arrows: true,
			mobileFirst: true,
			dots: true,
			arrows: false,
			swipeToSlide: true,
			slidesToShow: 1,
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						arrows: true
					}
				}
			]
		};
	}
}

/**
 * @augments SlickType
 */
export class SlickProduct extends SlickType {
	/**
	 * @return {SlickSettings}
	 * @private
	 */
	get _typeDefaultOptions () {
		return {
			mobileFirst: true,
			adaptiveHeight: true,
			arrows: false,
			infinite: false,
			draggable: false,
			slidesToShow: 1,
			swipeToSlide: true,
			__$dots: true,
			dots: true,
			fade: Browserizr.detect().isDesktop(),
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						swipeToSlide: Browserizr.detect().isMobile(),
						__$dots: Browserizr.detect().isMobile(),
						dots: Browserizr.detect().isMobile(),
						swipe: Browserizr.detect().isMobile(),
						touchMove: Browserizr.detect().isMobile(),
						fade: Browserizr.detect().isDesktop()
					}
				}
			]
		};
	}
}

/**
 * @augments SlickType
 */
export class SlickProductThumbs extends SlickType {
	_addCustomEvents () {
		super._addCustomEvents();

		const self = this;
		self.$rootElement.on('click', '.product-thumbs-slide', function () {
			const index = $(this).getMyElements('$slickSlide', '.slick-slide', 'closest').data('slick-index');
			self.$slider.slick('slickGoTo', index);
		});
	}

	/**
	 * @return {SlickSettings}
	 * @private
	 */
	get _typeDefaultOptions () {
		return {
			__$arrows: Browserizr.detect().isDesktop(),
			__$dots: true,
			infinite: false,
			mobileFirst: true,
			adaptiveHeight: true,
			arrows: false,
			dots: true,
			swipeToSlide: true,
			slidesToShow: 4,
			responsive: [
				{
					breakpoint: 1280,
					settings: {
						arrows: Browserizr.detect().isDesktop(),
						dots: Browserizr.detect().isMobile(),
						slidesToShow: 5
					}
				},
				{
					breakpoint: 1380,
					settings: {
						arrows: Browserizr.detect().isDesktop(),
						dots: Browserizr.detect().isMobile(),
						slidesToShow: 6
					}
				},
				{
					breakpoint: 1480,
					settings: {
						arrows: Browserizr.detect().isDesktop(),
						dots: Browserizr.detect().isMobile(),
						slidesToShow: 7
					}
				}
			]
		};
	}
}

export class SlickTimeline extends SlickType {
	/**
	 * @return {SlickSettings}
	 * @private
	 */
	get _typeDefaultOptions () {
		return {
			__$dots: true,
			__$arrows: true,
			mobileFirst: true,
			dots: true,
			arrows: true,
			swipeToSlide: true,
			slidesToShow: 1,
			fade: Browserizr.detect().isDesktop(),
			customPaging: function (slider, i) {
				return `<div class="date-dot"><div class="date-dot__text">${$(slider.$slides[i]).find('.timeline__slide').data('date')}</div></div>`;
			},
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						arrows: false
					}
				}
			]
		};
	}
}
