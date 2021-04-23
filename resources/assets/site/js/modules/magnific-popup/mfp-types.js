'use strict';

/**
 *
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $mfp
 * @sourceCode
 */
function mfpAjax ($mfp) {
	const config = $.extend(true, {
		type: 'ajax',
		mainClass: 'mfp-animate-zoom-in',
		removalDelay: 300,
		tLoading: '', // remove text from preloader
		ajax: {
			settings: {
				dataType: 'html'
			}
		},
		callbacks: {
			elementParse (item) {
				if (typeof item.el !== 'undefined') {
					const {
						url,
						type = 'POST',
						param: data = {}
					} = item.el.data();
					this.st.ajax.settings = { url, type, data };
				}
			},
			ajaxContentAdded () {
				let $container = this.contentContainer || [];
				if ($container) {
					$mfp.data('moduleLoader').init($container);
				}
			}
		}
	}, $mfp.data('user-config') || {});

	$mfp.magnificPopup(config);
}

/**
 * @param {jQuery} $mfp
 * @sourceCode
 */
function mfpIframe ($mfp) {
	const config = $.extend(true, {
		type: 'iframe',
		removalDelay: 300,
		mainClass: 'mfp-animate-zoom-in',
		closeBtnInside: true
	}, $mfp.data('user-config') || {});

	$mfp.magnificPopup(config);
}

/**
 * @param {jQuery} $mfp
 * @sourceCode
 */
function mfpInline ($mfp) {
	const config = $.extend(true, {
		type: 'inline',
		removalDelay: 300,
		mainClass: 'mfp-animate-zoom-in',
		closeBtnInside: true
	}, $mfp.data('user-config') || {});

	$mfp.magnificPopup(config);
}

/**
 * @param {jQuery} $mfp
 * @sourceCode
 */
function mfpGallery ($mfp) {
	const config = $.extend(true, {
		type: 'image',
		removalDelay: 300,
		mainClass: 'mfp-animate-zoom-in',
		delegate: '[data-mfp-src]',
		closeBtnInside: true,
		gallery: {
			enabled: true,
			preload: [0, 2],
			navigateByImgClick: true,
			arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>'
		},
		callbacks: {
			elementParse (item) {
				if (/youtube|vimeo|maps\.google/.test(item.src)) {
					item.type = 'iframe';
				}
			}
		}
	}, $mfp.data('user-config') || {});

	$mfp.magnificPopup(config);
}

function mfpProductGallery ($mfp) {
	const config = $.extend(true, {
		type: 'image',
		removalDelay: 300,
		mainClass: 'mfp-animate-zoom-in',
		delegate: '.js-product-gallery__item',
		callbacks: {
			markupParse: function (template, values, item) {
				let inf = item.el.closest('[data-product]').data('product');
				values.price = inf.price;
				$(template).find('[data-id]').attr('data-id', inf.id);
			}
		},
		image: {
			markup: $('#popup-product--template').html(),
			titleSrc: function (item) {
				return item.el.closest('[data-product]').data('product').name;
			},
			verticalFit: !0,
			tError: '<a href="%url%">Изображение</a> не может быть загружено.'
		},
		gallery: {
			enabled: !0,
			preload: [0, 2],
			tCounter: '<span class="mfp-counter product-popup__counter">%curr% из %total%</span>'
		}
	}, $mfp.data('user-config') || {});

	$mfp.magnificPopup(config);

	$(document).on('click', '.js-popup-basket', function () {
		let id = $(this).data('id');
		$.magnificPopup.close();

		setTimeout(function () {
			if (window.siteCart.productIsInCart(id)) {
				window.siteCart.open();
			} else {
				window.siteCart.request('add', {
					product_id: [id]
				});
			}
		}, 300);
	});
}

function mfpWysiwygGallery ($mfp) {
	const config = $.extend(true, {
		type: 'image',
		removalDelay: 300,
		mainClass: 'mfp-animate-zoom-in',
		delegate: '[target="_mfp"]',
		closeBtnInside: true,
		gallery: {
			enabled: true,
			preload: [0, 2],
			navigateByImgClick: true,
			arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>'
		}
	}, $mfp.data('user-config') || {});

	$mfp.magnificPopup(config);
}

// ----------------------------------------
// Exports
// ----------------------------------------

export { mfpAjax, mfpIframe, mfpInline, mfpGallery, mfpWysiwygGallery, mfpProductGallery };
