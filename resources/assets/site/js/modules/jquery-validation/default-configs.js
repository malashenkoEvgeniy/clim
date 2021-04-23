'use strict';

/**
 * @module
 */

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @type {jQueryValidationParams}
 * @private
 */
export const defaultParams = {};

/**
 * @type {jQueryValidationSettings}
 * @private
 */
export const defaultSettings = {
	/** @type {jQueryValidationSettings._cssClasses} */
	get _cssClasses () {
		return {
			error: 'has-error',
			valid: 'is-valid',
			labelError: 'label-error',
			formError: 'form--error',
			formValid: 'form--valid',
			formPending: 'form--pending'
		};
	},
	errorElement: 'label',
	get errorClass () {
		return this._cssClasses.error;
	},
	get validClass () {
		return this._cssClasses.valid;
	},

	/**
	 * Валидировать элементы при потере фокуса.
	 * Или false или функция
	 * @this {$.validator}
	 * @param {HTMLElement} element
	 * @see {@link https://jqueryvalidation.org/validate/#onfocusout}
	 */
	onfocusout (element) {
		if (element.value.length || element.classList.contains(this.settings._cssClasses.error)) {
			this.element(element);
		}
	},

	/**
	 * Валидировать элементы при keyup.
	 * Или false или функция
	 * @this {$.validator}
	 * @param {HTMLElement} element
	 * @see {@link https://jqueryvalidation.org/validate/#onkeyup}
	 */
	onkeyup (element) {
		if (element.classList.contains(this.settings._cssClasses.error)) {
			this.element(element);
		}
	},

	/**
	 * Подсветка элементов с ошибками
	 * @this {$.validator}
	 * @param {HTMLElement} element
	 */
	highlight (element) {
		element.classList.remove(this.settings._cssClasses.valid);
		element.classList.add(this.settings._cssClasses.error);
	},

	/**
	 * Удаление подсветки элементов с ошибками
	 * @this {$.validator}
	 * @param {HTMLElement} element
	 */
	unhighlight (element) {
		const doClass = (typeof element.value === 'string' && element.value.length) ? 'add' : 'remove';
		element.classList.remove(this.settings._cssClasses.error);
		element.classList[doClass](this.settings._cssClasses.valid);
	},

	/**
	 * Обработчик сабмита формы
	 * @param {HTMLFormElement} form
	 * @returns {boolean}
	 */
	submitHandler (form) {
		/**
		 * @type {JQuery}
		 */
		const $form = $(form);
		const ajaxForm = $form.hasClass('ajax-form');
		if (!ajaxForm || $form.hasClass('is-pending')) {
			return true;
		}

		const actionUrl = $form.attr('action');
		// const formData = new window.FormData(form);
		// formData.append('xhr-lang', document.documentElement.lang || 'ru');

		$form.addClass('is-pending');

		$.ajax({
			url: actionUrl,
			data: new window.FormData(form),
			processData: false,
			contentType: false
		}).done(function (data) {
			if (data.success) {
				if ($.magnificPopup && $.magnificPopup.instance.isOpen) {
					if (data.mfpNoty) {
						$.magnificPopup.instance.items.push({
							type: 'inline',
							src: data.mfpNoty
						});

						$.magnificPopup.instance.next();

						return;
					}

					if (data.mfpClose) {
						$.magnificPopup.close();
					}
				}

				if (data.replaceForm) {
					$form.parent().html(data.replaceForm);
				}

				if (data.reset) {
					$form.trigger('reset');
					$form.find('input, textarea, select').each((i, element) => {
						$(element).trigger('input');
					});
				}
			}
		}).fail((err) => {
			console.error(err);
		}).always(function () {
			$form.removeClass('is-pending');
		});

		return false;
	}
};

// ----------------------------------------
// Definitions
// ----------------------------------------

/**
 * @typedef {Object} jQueryValidationParams
 * @property {boolean} [focusOnError]
 * @property {number} [durationAnimate]
 */

/**
 * @typedef {Object} jQueryValidationSettings
 * @property {function|Object} [_cssClasses]
 * @property {string} [_cssClasses.error]
 * @property {string} [_cssClasses.valid]
 * @property {string} [_cssClasses.labelError]
 * @property {string} [_cssClasses.formError]
 * @property {string} [_cssClasses.formValid]
 * @property {string} [_cssClasses.formPending]
 * @property {string} [errorElement]
 * @property {string} [errorClass]
 * @property {string} [ignore]
 * @property {function} [errorPlacement]
 * @property {function} [highlight]
 * @property {function} [unhighlight]
 * @property {function} [success]
 * @property {boolean} [focusInvalid]
 * @property {function} [invalidHandler]
 */
