var prepareIncomingData = function(data) {
	try {
		var temp;

		if (typeof data === 'string') {
			temp = JSON.parse(data);
		} else {
			temp = JSON.parse(JSON.stringify(data));
		}

		return temp;
	} catch (err) {
		return null;
	}
};

$.ajaxSetup({
	method: 'POST',
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
		'Accept': 'application/json, text/javascript, */*; q=0.01',
	},
});

$(document).ready(function () {
	$('body').on('click', 'button[data-dismiss="modal"]', function () {
		$.magnificPopup.close();
	});
});

$(document).ajaxComplete(function (event, jqxhr) {
	var response = prepareIncomingData(jqxhr.responseJSON);

	if (!response) {
		return false;
	}

	if (response.notyMessage && typeof response.notyMessage === 'string') {
		new Noty({
			type: response.success ? 'success' : (!response.success || response.error || response.errors) ? 'error' : 'info',
			timeout: 3000,
			text: response.notyMessage,
		}).show();
	}

	if (response.text) {
		$.alert({
			columnClass: 'col-md-6 col-md-offset-3',
			title: response.text.title,
			content: response.text.content,
			icon: response.text.icon,
			type: 'blue',
			animation: 'scale',
			draggable: false,
			closeAnimation: 'scale'
		});
	}

	if (response.console) {
		$.alert({
			title: 'Ошибка',
			content: response.console,
			type: response.success ? 'blue' : 'red',
			animation: 'scale',
			draggable: false,
			closeAnimation: 'scale'
		});
	}

	if (response.success && response.mfpNoty) {
		$.magnificPopup.open({
			items: {
				src: response.mfpNoty
			},
			type: 'inline',
			mainClass: 'mfp-animate-zoom-in',
			modal: false,
			callbacks: {
				open: function () {},
				close: function () {},
				beforeOpen: function() {  this.wrap.removeAttr('tabindex') }
			}
		});
		return;
	}

	if (response.reload || window.location.href === response.redirect) {
		return window.location.reload();
	}

	if (response.redirect) {
		return (window.location.href = response.redirect);
	}

	if (response.success) {
		if (response.mfpClose) {
			$.magnificPopup.close();
		}
	}

	if (response.delete) {
		$(response.delete).fadeOut(300, function () {
			$(this).remove();
		});
	}

	if (response.featureCreate) {
		var valuesSelect = $('#feature-value-select');
		var	featureSelect = $('#feature-select');
		if (response.success) {
			var newOptions = [];
			newOptions.push(new Option('—', '', false, false));
			for (var index in response.insert.features) {
				var option = response.insert.features[index];
				newOptions.push(new Option(option.current.name, option.id, (option.id === response.insert.feature_id), (option.id === response.insert.feature_id)));
			}
			featureSelect.prop('disabled', false);
			featureSelect.prop('multiple', false);
			featureSelect.select2('destroy');
			featureSelect.select2();
			featureSelect.empty().append(newOptions).trigger('change');
		}
	}
	if (response.ajaxFeatureValues) {
		valuesSelect = $('#feature-value-select');
		if (response.success) {
			newOptions = [];
			newOptions.push(new Option('—', '', false, false));
			for (index in response.ajaxFeatureValues) {
				option = response.ajaxFeatureValues[index];
				newOptions.push(new Option(option.current.name, option.id, (option.id === response.currentValue), (option.id === response.currentValue)));
			}
			valuesSelect.prop('disabled', false);
			valuesSelect.prop('multiple', false);
			console.log(response.featureType);
			console.log(response.featureType === 'multiple');
			if (response.featureType === 'multiple') {
				valuesSelect.prop('multiple', true);
			}
			valuesSelect.select2('destroy');
			valuesSelect.select2();
			valuesSelect.empty().append(newOptions).trigger('change');
		}
	}
});
