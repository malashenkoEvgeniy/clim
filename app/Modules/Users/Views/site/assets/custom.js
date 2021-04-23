'use strict';

/**
 * @module
 * @author Vitalii Demianenko
 * @version 1.0.0
 */

(function () {
	$('body').find('form.ajax-form:not(.js-init)').on('submit', function () {
		var $form = $(this);
		$form.addClass('is-pending');
		$.ajax({
			url: $form.attr('action'),
			data: $form.serialize()
		}).done(function (data) {
			console.log(data);
		}).fail((err) => {
			console.error(err);
		}).always(function (data) {
			$form.removeClass('is-pending');
		});
		return false;
	});
})();
