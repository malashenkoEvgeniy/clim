import {
	prepareIncomingData
} from 'assetsSite#/js/utils';

$.ajaxSetup({
	method: 'POST',
	beforeSend: function (xhr, url) {
		if (!url.crossDomain) {
			xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
		}
	},
	headers: {
		'Content-Language': document.documentElement.lang,
		'Accept': 'application/json, text/javascript, */*; q=0.01'
	}
});

$(document).ajaxComplete(function (event, jqxhr, settings) {
	let response = prepareIncomingData(jqxhr.responseJSON);

	if (!response) {
		return false;
	}

	if (response.notyMessage && typeof response.notyMessage === 'string') {
		import('assetsSite#/js/modules/notifier').then(({ default: Notifier }) => {
			Notifier.create(Object.assign({
				type: response.success ? 'success' : (!response.success || response.error || response.errors) ? 'error' : 'info',
				timeout: 3000
			}, {
				text: response.notyMessage
			})).show();
		});
	}

	if (response.console) {
		console.warn(response.console);
	}

	if (response.reload || window.location.href === response.redirect) {
		return window.location.reload();
	}

	if (response.redirect) {
		return (window.location.href = response.redirect);
	}
});
