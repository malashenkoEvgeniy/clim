'use strict';

/**
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'custom-jquery-methods/fn/has-inited-key';
import 'magnific-popup';
import 'magnific-popup/src/css/main.scss';
import 'assetsSite#/sass/vendors/magnific-popup/mfp-animate-zoom-in.scss/';
import 'assetsSite#/sass/vendors/magnific-popup/mfp-product-popup.scss/';
import 'assetsSite#/sass/vendors/magnific-popup/mfp-style.scss/';
import { mfpAjax, mfpIframe, mfpInline, mfpGallery, mfpWysiwygGallery, mfpProductGallery } from 'assetsSite#/js/modules/magnific-popup/mfp-types';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $elements
 */
function each ($elements) {
	$elements.each((i, el) => {
		const $mfp = $(el);
		if ($mfp.hasInitedKey('mMagnificInitialized')) {
			return true;
		}

		switch ($mfp.data('mfp')) {
			case 'ajax':
				mfpAjax($mfp);
				break;
			case 'inline':
				mfpInline($mfp);
				break;
			case 'iframe':
				mfpIframe($mfp);
				break;
			case 'gallery':
				mfpGallery($mfp);
				break;
			case 'product-gallery':
				mfpProductGallery($mfp);
				break;
			default:
				break;
		}

		if ($mfp.hasClass('wysiwyg')) {
			mfpWysiwygGallery($mfp);
		}
	});

	$(document).on('click', '.js-magnific-close', () => {
		$.magnificPopup.close();
	});
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default each;
