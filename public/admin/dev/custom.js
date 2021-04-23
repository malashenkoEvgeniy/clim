// Noty settings
var message = function (message, type) {
	type = type || 'info';
	new Noty({
		text: message,
		timeout: 5000,
		type: type
	}).show();
};

// Noty confirmation window settings
var confirmation = function (text, okCallback, cancelCallback) {
	okCallback = okCallback || function () {
	};
	cancelCallback = cancelCallback || function () {
	};
	$.confirm({
		title: 'Подтверждение действия',
		content: text,
		type: 'red',
		buttons: {
			ok: {
				text: "ok!",
				btnClass: 'btn-danger',
				keys: ['enter'],
				action: () => {
					okCallback();
				}
			},
			cancel: () => {
				cancelCallback();
			}
		}
	});
	return false;
};

var initAjaxSelect2 = function () {
	$('body').find('.js-data-ajax').each(function () {
		var $it = $(this), url = $it.data('href');
		if (!url) {
			return;
		}
		$it.select2({
			minimumInputLength: 1,
			ajax: {
				url: url,
				type: 'POST',
				dataType: 'json',
				data: function (params) {
					return {
						query: params.term,
						page: params.page,
						ignored: $it.data('ignored') || [],
						type: $it.data('type') || 'group',
					};
				},
				processResults: function (data) {
					return {
						results: data.items,
					};
				},
				cache: true
			},
			templateResult: function (repo) {
				if (repo.loading) {
					return repo.text;
				}
				return repo.markup;
			},
			escapeMarkup: function (m) {
				return m;
			},
			templateSelection: function (repo) {
				return repo.selection || repo.text;
			}
		});
	});
};

var multi_select = function () {
	$('.multiSelectBlock select').each(function () {
		if ($(this).prop('multiple')) {
			$(this).multiSelect({
				keepOrder: true,
				selectableHeader: "<div class='multiSelectNavigation custom-header select-all'>Выбрать все</div>",
				selectionHeader: "<div class='multiSelectNavigation custom-header deselect-all'>Отменить все</div>"
			});
		}
	});
	$('.select-all').click(function () {
		$(this).closest('.multiSelectBlock').find('select').multiSelect('select_all');
		return false;
	});
	$('.deselect-all').click(function () {
		$(this).closest('.multiSelectBlock').find('select').multiSelect('deselect_all');
		return false;
	});
};

$(document).ready(function () {

	$('body').on('change', '.file-attach input[type="file"]', function () {
		if (this.files && this.files[0]) {
			var reader = new FileReader(), $input = $(this), $label = $input.closest('label');
			reader.onload = function (e) {
				$label.attr('style', `background-image: url(${e.target.result});`);
				$label.find('i').hide();
			};
			reader.readAsDataURL(this.files[0]);
		}
	});
	$('#modifications').on('click', '.delete-modification-image', function () {
		$(this).closest('.file-attach').fadeOut(300, function () {
			$(this).remove();
		});
		return false;
	});
	$('#modifications').on('click', '.add-modification-image', function () {
		var $button = $(this),
			$block = $button.closest('.modification'),
			$files = $block.find('.modification-images'),
			index = $block.data('index'),
			template = '<div class="file-attach">' +
			'<a href="#" class="delete-modification-image">' +
			'<i class="fa fa-close"></i>' +
			'</a>' +
			'<label class="label">' +
			'<i class="glyphicon glyphicon-paperclip"></i>' +
			'<input type="file" name="modification[' + index + '][images][]">' +
			'</label>' +
			'</div>';
		$files.append(template);
	});

	$('body').find('select.hidden-block-trigger').on('change', function () {
		var $it = $(this), val = $it.val(), $form = $it.closest('form');
		$form.find('.show-hidden-block').removeClass('show-hidden-block');
		$form.find(`[name="${val}"]`).closest('.hidden-block').addClass('show-hidden-block');
	});

	$('a[data-toggle="confirmation"]').each(function () {
		var $it = $(this);
		$it.on('click', () => {
			return confirmation($it.data('message') || null, function () {
				window.location.href = $it.attr('href');
			});
		});
	});

	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth() + 1; //January is 0!
	var yyyy = today.getFullYear();

	if (dd < 10) {
		dd = '0' + dd
	}

	if (mm < 10) {
		mm = '0' + mm
	}

	today = yyyy + '-' + mm + '-' + dd;
	var lastMonth = new Date();
	var lastMm = parseInt(mm) - 1;
	var lastYear = yyyy;
	if (lastMm < 10) {
		lastMm = '0' + lastMm;
	}
	if (lastMm == 0) {
		lastMm = '12';
		var lastYear = parseInt(yyyy) - 1;
	}
	lastMonth = lastYear + '-' + lastMm + '-' + dd;

	var url_string = window.location.href;
	var url = new URL(url_string);
	var datarange1 = url.searchParams.get("dateRange_reviews");
	var datarange2 = url.searchParams.get("dateRange");
	if (datarange1 !== null || datarange2 !== null) {
		var dateString = '';
		if (datarange1 !== null) {
			dateString = datarange1;
		}
		if (datarange2 !== null) {
			dateString = datarange2;
		}
		var datesArr = dateString.split(' - ');
		lastMonth = datesArr[0];
		today = datesArr[1];
	}
	$('.dateRangePicker').daterangepicker({
		"autoApply": true,
		"autoUpdateInput": false,
		"linkedCalendars": false,
		"showDropdowns": true,
		"locale": {
			"format": "YYYY-MM-DD",
			"separator": " - ",
			"applyLabel": "Принять",
			"cancelLabel": "Отменить",
			"fromLabel": "С",
			"toLabel": "По",
			"customRangeLabel": "Custom",
			"daysOfWeek": [
				"Вс",
				"Пн",
				"Вт",
				"Ср",
				"Чт",
				"Пт",
				"Сб"
			],
			"monthNames": [
				"Январь",
				"Февраль",
				"Март",
				"Апрель",
				"Май",
				"Июнь",
				"Июль",
				"Август",
				"Сентябрь",
				"Октябрь",
				"Ноябрь",
				"Декабрь"
			],
			"firstDay": 1,
		},
	}, function (start, end, label) {
		$('.dateRangePicker').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'))
	});

	if ($('.multiSelectBlock').length) {
		multi_select();
	}

	// CSRF token settings for ajax requests
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	// Reverse status for element
	$('body').on('click', '.change-status', function (e) {
		e.preventDefault();
		var $it = $(this), url = $it.data('url');
		$.ajax({
			url,
			type: 'PUT',
			dataType: 'JSON',
			success: function (data) {
				if (data.success) {
					if ($it.hasClass('label-success')) {
						$it.removeClass('label-success');
						$it.addClass('label-danger');
						$it.html('<i class="fa fa-close"></i>');
					} else {
						$it.removeClass('label-danger');
						$it.addClass('label-success');
						$it.html('<i class="fa fa-check"></i>');
					}
				} else {
					if (data.message) {
						message(data.message, 'error');
					}
				}
			},
			error: function () {
				message('Server error!', 'error');
			}
		});
	});

	// Button as link
	$('body').on('click', 'button[type="href"]', function () {
		if (!$(this).hasClass('show-confirmation-window')) {
			window.location.href = $(this).attr('href');
		}
	});

	// Link as submit button
	$('body').on('click', 'a[type="submit"]', function () {
		var $it = $(this);
		if ($it.hasClass('confirmation-window') === false) {
			var $form = $it.closest('form');
			if ($form.hasClass('filter-form')) {
				var arr = [];
				var key;
				var value;
				$form.find('input,select').each(function () {
					if (!$(this).attr('type') || $(this).attr('type') !== 'submit') {
						key = $(this).attr('name');
						value = $(this).val();
						if (value !== "") {
							arr.push(key + '=' + value);
						}
					}
				});
				var link = $form.attr('action');
				if (arr.length) {
					link += '?' + arr.join('&');
				}
				window.location.href = link;
			} else {
				$form.submit();
			}
		}
	});

	// Confirmation window
	$('body').on('click', '.show-confirmation-window', function (e) {
		e.preventDefault();
		var $it = $(this), text = $it.data('message') || 'Пожалуйста, подтвердите действие';
		confirmation(text, function () {
			if ($it.is('a') && $it.attr('type') === 'submit' && $it.closest('form').length) {
				$it.closest('form').submit();
			} else if ($it.is('a') || ($it.is('button') && $it.attr('type') === 'href' && $it.attr('href'))) {
				window.location.href = $it.attr('href');
			}
		});
	});

	// Close message button
	$('body').on('click', '.messagesBlock button.close', function () {
		$(this).closest('.callout').slideUp(350);
	});

	// Colorpicker initialization
	if ($(".colorPicker").length) {
		$.each($('.colorPicker'), function () {
			$(this).colorpicker();
		});
	}

	// Date picker
	if ($('.datePicker').length) {
		$.each($('.datePicker'), function () {
			$(this).datepicker({
				autoclose: true,
				format: 'yyyy-mm-dd',
				language: 'ru'
			});
		});
	}

	// Initialize Select2 Elements
	if ($('.select2').length) {
		$(".select2").select2();
	}

	// Save sidebar status open or collapse
	$('.sidebar-toggle').on('click', function () {
		if (wCookie.get('sidebar') === 'collapse') {
			wCookie.delete('sidebar');
		} else {
			wCookie.set('sidebar', 'collapse', {
				expires: 365 * 24 * 60 * 60
			});
		}
	});

	//iCheck for checkbox and radio inputs
	if ($('input[type="checkbox"].minimal, input[type="radio"].minimal').length) {
		$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
	}

	//Red color scheme for iCheck
	if ($('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').length) {
		$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
			checkboxClass: 'icheckbox_minimal-red',
			radioClass: 'iradio_minimal-red'
		});
	}

	//Flat red color scheme for iCheck
	if ($('input[type="checkbox"].flat-red, input[type="radio"].flat-red').length) {
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});
	}

	// Input mask
	if ($("[data-mask]").length) {
		$("[data-mask]").inputmask();
	}

	// TinyMCE editor
	if ($('.tinymceEditor').length) {
		tinymce.init({
			selector: "textarea.tinymceEditor",
			skin: "wezom",
			language: 'ru',
			content_css: '/assets/css/bundle-wysiwyg.css',
			body_class: 'wysiwyg',
			plugins: [
				"advlist autolink lists link image charmap print preview hr",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons paste textcolor colorpicker textpattern responsivefilemanager"
			],
			table_class_list: [
				{title: 'По умолчанию', value: ''},
				{title: 'Без границ', value: 'table-null'},
				{title: 'Зебра', value: 'table-zebra'},
				{title: 'Обводка', value: 'table-thin'},
                {title: '2 колонки', value: 'table-2-columns'},
                {title: '3 колонки', value: 'table-3-columns'},
                {title: '4 колонки', value: 'table-4-columns'}
			],
			image_class_list: [
				{title: 'По умолчанию', value: ''}
			],
			link_class_list: [
				{title: 'None', value: ''},
				{title: 'Download', value: 'wysiwyg-download'}
			],
            target_list: [
                {title: 'None', value: ''},
                {title: 'В новом окне', value: '_blank'},
                {title: 'В попап окне', value: '_mfp'}
			],
			toolbar1: "undo redo pastetext | bold italic forecolor backcolor fontsizeselect styleselect | alignleft aligncenter alignright alignjustify",
			toolbar2: 'bullist numlist | link unlink image responsivefilemanager fullscreen',
			image_advtab: true,
			external_filemanager_path: "/admin/plugins/tinymce/filemanager/",
			filemanager_title: "Менеджер файлов",
			external_plugins: {"filemanager": "filemanager/plugin.min.js"},
			document_base_url: "http://" + window.location.hostname + "/",
			convert_urls: true,
			plugin_preview_width: "1000",
			relative_urls: false,
			default_language: 'ru',
			fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
            style_formats: [
                {
                    title: 'Стили блоков',
                    items: [
                        {
                            title: "Зеленая линия",
                            block: "div",
                            classes: "wysiwyg-green-line",
                            wrapper: true
                        },
                        {
                            title: "Зарплата",
                            inline: "span",
                            classes: "wysiwyg-salary",
                            wrapper: true
                        },
                        {
                            title: "Город",
                            inline: "span",
                            classes: "wysiwyg-location",
                            wrapper: true
                        }
                    ]
                }
            ],
            style_formats_merge: true
		});

		var wLastSmall, wLastBig;
		if ($(window).width() > 700) {
			wLastSmall = false;
			wLastBig = true;
		} else {
			wLastSmall = true;
			wLastBig = false;
		}

		$(window).on('resize', function () {
			if ($(window).width() > 700 && wLastSmall) {
				wLastSmall = false;
				wLastBig = true;
				parent.tinyMCE.activeEditor.windowManager.close(window);
			}
			if ($(window).width() < 700 && wLastBig) {
				wLastSmall = true;
				wLastBig = false;
				parent.tinyMCE.activeEditor.windowManager.close(window);
			}
		})
	}


	// MY NESTABLE SCRIPT START
	if ($('#myNest').length) {
		var depth = parseInt($('#myNest').data('depth'));
		if (!depth) {
			depth = 5;
		}
		var updateOutput = function (e) {
			var list = e.length ? e : $(e.target),
				output = list.data('output');
			if ($(e.target).length) {
				if (window.JSON) {
					output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
				} else {
					output.val('JSON browser support required for this demo.');
				}
			}
		};

		//Кнопки для сворачивания/разворачивания всех списков
		$("#nestable_list_menu").on("click", function (e) {
			var target = $(e.target),
				action = target.data('action');
			if (action === 'expand-all') {
				$('.dd').nestable('expandAll');
			}
			if (action === 'collapse-all') {
				$('.dd').nestable('collapseAll');
			}
			return false;
		});
		//Кнопки для сворачивания/разворачивания всех списков
		$("[data-action=expand-all]").on("click", function (e) {
			$('.dd').nestable('expandAll');
			return false;
		});
		$("[data-action=collapse-all]").on("click", function (e) {
			$('.dd').nestable('collapseAll');
			return false;
		});

		var myUpdateOutput = function (e) {
			var list = e.length ? e : $(e.target),
				output = list.data('output');
			if ($(e.target).length) {
				if (window.JSON) {
					output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
				} else {
					output.val('JSON browser support required for this demo.');
				}
			}
		};
		var mySortable = function (e) {
			if (e.target.outerHTML == '<input type="checkbox">') {
				return;
			}
			myUpdateOutput(e);
			var json = $("#myNestJson").val();
			$.ajax({
				url: $('#parameters').data('url'),
				type: 'PUT',
				dataType: 'JSON',
				data: {
					json
				},
				success: function (data) {
					// console.log(data);
				}
			});
		};

		$("#myNest").not('.pageList-del').nestable({
			dragClass: 'pageList dd-dragel',
			itemClass: 'dd-item',
			group: 1,
			maxDepth: depth
		}).on("change", mySortable);
		myUpdateOutput($("#myNest").data("output", $("#myNestJson")));
	}
	// если нужно больше одного на странице (меню)
	if ($('.myNest').length) {

		var myUpdateOutput = function (e) {
			var list = e.length ? e : $(e.target),
				output = list.find('.myNestJson');
			if ($(e.target).length) {
				if (window.JSON) {
					output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
				} else {
					output.val('JSON browser support required for this demo.');
				}
			}
		};
		var mySortable = function (e) {
			if (e.target.outerHTML == '<input type="checkbox">') {
				return;
			}
			myUpdateOutput(e);
			$.ajax({
				url: '/admin/ajax/sortable',
				type: 'PUT',
				dataType: 'JSON',
				data: {
					json: $(this).find('.myNestJson').val(),
					table: $(this).find('.parameters').data('table'),
					type: $(this).data('type'),
				},
				success: function (data) {
					// console.log(data);
				}
			});
		};

		$(".myNest").each(function (index) {
			$(".myNest_" + $(this).data('type')).not('.pageList-del').nestable({
				dragClass: 'pageList dd-dragel',
				itemClass: 'dd-item',
				group: $(this).data('type'),
				maxDepth: $(this).data('depth')
			}).on("change", mySortable);
		});
	}

	$('#excelForm').on('submit', function () {
		$('.progressBar').removeClass('hidden');
	});

	$('body').on('change', 'input:radio[name="company_or_persona"]', function () {
		var $this = $(this);
		var val = $this.val();
		var hidden = $('#company-data');
		if (val == 0) {
			hidden.removeClass('hidden');
		} else {
			hidden.addClass('hidden');
			$('.company_name_ajax').val(null);
			$('.code_ajax').val(null);
		}
	});

	$('body').on('change', '#user_id', function () {
		var $this = $(this);
		var val = $this.val();
		$.ajax({
			url: '/admin/ajax/user-select-info',
			type: 'POST',
			dataType: 'JSON',
			data: {
				id: val
			},
			success: function (data) {
				var user = data.user;
				var $radio = $('input:radio[name="company_or_persona"]').val();
				if ($radio == 0) {
					$('.company_name_ajax').val(data.user.company);
					$('.code_ajax').val(data.user.code);
				}
				$('.second_name_ajax').val(data.user.second_name);
				$('.first_name_ajax').val(data.user.first_name);
				$('.phone_ajax').val(data.user.phone);
				$('.state_ajax').val(data.user.state);
				$('.city_ajax').val(data.user.city);
				$('.address_ajax').val(data.user.address);
			}
		})
	});

	$('body').on('click', '.edit-item', function () {
		var $this = $(this);
		var id = $this.data('id');
		var count = $('.items-count[data-id=' + id + ']').val();
		var value = $('.items-values[data-id=' + id + ']').val();
		if (count <= 0) {
			message('Количество не может быть равно 0', 'error');
		} else {
			$.ajax({
				url: '/admin/ajax/edit-order-item',
				type: 'POST',
				dataType: 'JSON',
				data: {
					id: id,
					count: count,
					value: value,
				},
				success: function (data) {
					if (data.success) {
						message('Данные успешно изменены', 'success');
						$('.items-price[data-id=' + id + ']').empty().append(data.price)
						$('.total-price-order').empty().append(data.amount);
					} else {
						message('Ошибка сервера', 'error');
					}
				}
			});
		}
	});

	$('body').on('click', '.delete-item', function () {
		var $this = $(this);
		var id = $this.data('id');
		$.ajax({
			url: '/admin/ajax/delete-order-item',
			type: 'POST',
			dataType: 'JSON',
			data: {
				id: id,
			},
			success: function (data) {
				if (data.success) {
					message('Товар успешно удален из заказа', 'success');
					$("#items-table").empty().append(data.html);
					$('.total-price-order').empty().append(data.amount);
				} else {
					message('Ошибка сервера', 'error');
				}
			}
		});
	});

	$('body').on('click', '.add-item', function () {
		var $this = $(this);
		var order_id = $this.data('id');
		var value = $('.add-items-values').val();
		var count = $('.add-items-count').val();
		var product_id = $('.add-item_id').val();
		if (count <= 0) {
			message('Количество не может быть равно 0', 'error');
		} else {
			$.ajax({
				url: '/admin/ajax/add-order-item',
				type: 'POST',
				dataType: 'JSON',
				data: {
					order_id: order_id,
					value: value,
					count: count,
					product_id: product_id,
				},
				success: function (data) {
					if (data.success) {
						message('Товар успешно добавлен', 'success');
						$("#items-table").empty().append(data.html);
						$('.total-price-order').empty().append(data.amount);
					} else {
						message('Ошибка сервера', 'error');
					}
				}
			});
		}
	});

	if ($('.dateTimePicker').length) {
		$('.dateTimePicker').each(function () {
			$(this).datetimepicker({
				autoclose: true,
				format: 'yyyy-mm-dd hh:ii:ss',
				language: 'ru'
			});
		})
	}

	var timeout = null;
	function makeSlug($origin, $destination, $slugButton) {
		if (timeout !== null) {
			clearTimeout(timeout);
		}
		timeout = setTimeout(function () {
			$.ajax({
				url: $slugButton.data('url'),
				type: 'POST',
				dataType: 'JSON',
				data: {
					_method: 'PUT',
					name: $origin.val()
				},
				success: function (data) {
					if (data.slug) {
						$destination.val(data.slug);
					}
				}
			});
		}, 250);
	}

	$('body').on('click', 'button[data-slug-button]', function () {
		var $slugDestination = $(this).closest('.form-group').find('input[data-slug-button-destination]'),
			$slugOrigin = $(this).closest('.field-set-with-translit').find('input[data-slug-button-origin]');
		makeSlug($slugOrigin, $slugDestination, $(this));
	});

	function checkDependence() {
		$('.dependent-field-block').each(function () {
			var $block = $(this),
				$masterFieldName = $block.data('dependent-from'),
				$masterFieldValue = $block.data('dependent-from-value'),
				$masterField = $(`[name=${$masterFieldName}]`);
			if (!$masterField.length) {
				return;
			}
			if ($masterField.val() === $masterFieldValue) {
				$block.show();
			} else {
				$block.hide();
			}
		});
	}

	checkDependence();
	$('[data-master]').on('change', function () {
		checkDependence();
	});

    $('body').on('click', '.loadedDelete', function () {
        $(this).removeClass('loadedDelete');
    });

	//////////////// DAMN DROPZONE
	$(function () {
		var dropzone = $('.dropZone');
		if (dropzone.length) {
			var upl = dropzone.data('upload');
			var sort = dropzone.data('sortable');
			var def = dropzone.data('default');

			var getUploadedPhotos = function () {
				$.ajax({
					type: 'POST',
					url: upl,
					dataType: 'JSON',
					data: {
						model: dropzone.data('model'),
						type: dropzone.data('type'),
						id: dropzone.data('id'),
					},
					success: function (data) {
						$('.dropDownload').html(data.images);
						if (parseInt(data.count)) {
							$('.loadedBox .checkAll').fadeIn(300);
						}
					}
				});
			};
			getUploadedPhotos();

			$('.dropDownload').sortable({
				connectWith: ".loadedBlock",
				handle: ".loadedDrag",
				cancel: '.loadedControl',
				placeholder: "loadedBlockPlaceholder",
				update: function () {
					var order = [];
					$(this).find('.loadedBlock').each(function () {
						order.push($(this).data('image'));
					});
					$.ajax({
						type: "POST",
						url: sort,
						data: {
							order: order
						}
					});
				}
			});

			$('.dropDownload').on('click', '.loadedCover .btn.btn-success', function () {
				var it = $(this),
					itP = it.closest('.loadedBlock'),
					id = itP.data('image');
				$.ajax({
					url: def,
					type: 'POST',
					data: {
						id: id
					}
				});
			});

			$('.dropModule').on('click', '.checkAll', function (event) {
				event.preventDefault();
				var block = $(this).closest('.loadedBox').find('.dropDownload').find('.loadedBlock');
				block.addClass('chk');
				block.find('.loadedCheck').find('input').prop('checked', true);
				$('.loadedBox .uncheckAll, .loadedBox .removeCheck').fadeIn(300);
			});

			$('.dropModule').on('click', '.uncheckAll', function (event) {
				event.preventDefault();
				var block = $(this).closest('.loadedBox').find('.dropDownload').find('.loadedBlock');
				block.removeClass('chk');
				block.find('.loadedCheck').find('input').prop('checked', false);
				$('.loadedBox .uncheckAll, .loadedBox .removeCheck').fadeOut(300);
			});

			$('.dropDownload').on('click', '.loadedCheck label', function (event) {
				if ($(this).children('input').is(':checked')) {
					$(this).closest('.loadedBlock').addClass('chk');
				} else {
					$(this).closest('.loadedBlock').removeClass('chk');
				}
				if ($('.dropDownload .chk').length > 0) {
					$('.loadedBox .uncheckAll, .loadedBox .removeCheck').fadeIn(300);
				} else {
					$('.loadedBox .uncheckAll, .loadedBox .removeCheck').fadeOut(300);
				}
			});
		}
	});
	// THE END OF DROPZONE

	// Colorpicker
	$('.my-colorpicker1').colorpicker();
	// color picker with addon
	$('.my-colorpicker2').colorpicker();

	initAjaxSelect2();

	$('body').on('click', '.ajax-request', function (e) {
		e.preventDefault();
		var $it = $(this), text = $it.data('confirmation') || null;
		var data = $it.data('body') || {}, method = 'GET';
		if (Object.keys(data).length > 0) {
			data['_method'] = $it.data('method') || undefined;
			method = $it.data('method') || 'GET';
		}
		if (text) {
			confirmation(text, function () {
				$.ajax({
					type: method,
					url: $it.attr('href'),
					data: data,
				});
			});
		} else {
			$.ajax({
				type: method,
				url: $it.attr('href'),
				data: data,
			});
		}
	});

	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	// bootstrap WYSIHTML5 - text editor
	$('.wysihtml5').each(function () {
		$(this).wysihtml5({
			toolbar: {
				'font-styles': false,
				blockquote: false,
				lists: false,
				link: true,
				image: false
			}
		});
	});
    $('.changeCity').on('change', function () {
        var cityRef = $(this).val();
        var block = $(this).attr('insert-block');
        $.ajax({
            url: $(this).attr('href'),
            type: 'POST',
            data: {
            cityRef: cityRef
			},
			success: function (data) {
				$(block).html(data.html);
			}
    	});
    });
});
