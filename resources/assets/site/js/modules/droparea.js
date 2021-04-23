'use strict';

/**
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'custom-jquery-methods/fn/has-inited-key';

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {jQuery} $elements
 */
function each ($elements) {
	$elements.each((i, el) => {
		const $droparea = $(el);
		if ($droparea.hasInitedKey('dropareaInitialized')) {
			return true;
		}

		let defaults = {
			maxSize: 1024,
			errorMessage: 'This file is not acceptable',
			css: {
				error: 'has-error',
				success: 'has-success',
				file: 'has-file'
			}
		};
		let params = $.extend(true, {}, defaults, $droparea.data('user-config') || {});

		let $input = $droparea.find('[data-droparea="input"]');
		let $fileInfo = $droparea.find('[data-droparea="file-info"]');
		let $clear = $droparea.find('[data-droparea="clear"]');

		let extensionIsOk = false;
		let fileSizeIsOk = false;

		$input.on('change', () => {
			if (!$input[0].files.length) {
				$droparea.removeClass(`${params.css.error} ${params.css.success} ${params.css.file}`);
				return;
			}

			let fileName = $input[0].files[0].name;

			$droparea.removeClass(`${params.css.error} ${params.css.success} ${params.css.file}`);

			fileSizeIsOk = params.maxSize >= ($input[0].files[0].size / 1024);
			extensionIsOk = $input.attr('accept').split(', ').some((ext) => {
				let regexp = new RegExp(`${ext}$`, 'i');
				return regexp.test(fileName);
			});

			if (fileSizeIsOk && extensionIsOk) {
				$fileInfo.text(fileName);
				$droparea.removeClass(params.css.error).addClass(`${params.css.success} ${params.css.file}`);
			} else {
				$input.val('');
				$fileInfo.html(params.errorMessage);
				$droparea.removeClass(params.css.success).addClass(`${params.css.error} ${params.css.file}`);
			}
		}).trigger('change');

		$input.on('dragover dragenter', () => {
			$droparea.addClass(`${params.css.success}`);
		}).on('dragleave dragend', function () {
			$droparea.removeClass(`${params.css.success}`);
		});

		$clear.on('click', () => {
			$input.val('');
			$droparea.removeClass(`${params.css.error} ${params.css.success} ${params.css.file}`);
		});
	});
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default each;
