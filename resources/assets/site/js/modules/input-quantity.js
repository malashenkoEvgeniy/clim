import throttle from 'lodash.throttle';

import {
	onlyNumbers,
	isNumeric
} from 'assetsSite#/js/utils';

class InputQuantity {
	constructor ($root, moduleLoader) {
		let defaults = {
			minValue: 1,
			maxValue: 2147483646, // max integer for Database
			step: 1,
			css: {
				hasValue: 'has-value'
			}
		};

		this.$root = $root;
		this.params = $.extend(true, {}, defaults, $root.data('user-config') || {});
		this.moduleLoader = moduleLoader;

		this.params.maxLength = String(parseInt(this.params.maxValue)).length;

		this.$quantityInput = $root.find('[data-quantity="input"]');
		this.$quantityIncrease = $root.find('[data-quantity="increase"]');
		this.$quantityDecrease = $root.find('[data-quantity="decrease"]');
		this.$incDecTriggers = this.$quantityIncrease.add(this.$quantityDecrease);

		this.throttledIncDec = throttle(this.onIncDec, 100);

		this._timeOutID = null;
		this._mouseHolded = false;
		this._prevValue = +this.$quantityInput.val();

		this.init();
	}

	init () {
		onlyNumbers(this.$quantityInput);

		this.$quantityInput.on('keydown', (e) => {
			switch (e.which) {
				case 38: this.throttledIncDec('arrow-up'); break; // arrow-up key
				case 40: this.throttledIncDec('arrow-down'); break; // arrow-down key
				case 33: this.throttledIncDec('page-up', 10); break; // page-up key
				case 34: this.throttledIncDec('page-down', 10); break; // page-down key
				default: break;
			}
		});

		this.$quantityInput.on('input', (e) => {
			this.updateQuantity();
		});

		this.$incDecTriggers.on('click', (e) => {
			let action = $(e.currentTarget).data('quantity');
			this.onIncDec(action);
		});

		this.$incDecTriggers.on('mouseup mouseleave touchend touchmove', () => {
			this._mouseHolded = false;
			window.clearTimeout(this._timeOutID);
		});

		this.$incDecTriggers.on('mousedown touchstart', (e) => {
			this._mouseHolded = true;
			window.clearTimeout(this._timeOutID);
			this._timeOutID = window.setTimeout(() => {
				if (this._mouseHolded) {
					let action = $(e.currentTarget).data('quantity');
					const onMouseHold = () => {
						this.throttledIncDec(action);
						this._timeOutID = window.setTimeout(onMouseHold, 100);
					};

					window.clearTimeout(this._timeOutID);
					this._timeOutID = window.setTimeout(onMouseHold, 100);
				}
			}, 300);
		});

		this.updateQuantity();
	}

	onIncDec (action = null, step = this.params.step) {
		if (!action) {
			return;
		}

		let prevValue = this._prevValue;

		if (/increase|arrow-up|page-up/.test(action) && prevValue < this.params.maxValue) {
			this.$quantityInput.val(prevValue + step);
		} else if (/decrease|arrow-down|page-down/.test(action) && prevValue > this.params.minValue) {
			this.$quantityInput.val(prevValue - step);
		}

		this.updateQuantity();
	}

	updateQuantity () {
		let currentValue = this.$quantityInput.val().replace(/^(0*)?/, '');

		let {
			minValue,
			maxValue,
			maxLength
		} = this.params;

		if (isNumeric(currentValue)) {
			if (+currentValue < minValue) {
				this.$quantityInput.val(minValue);
			}

			if (+currentValue > maxValue || currentValue.length > maxLength) {
				this.$quantityInput.val(currentValue.substr(0, currentValue.length - 1));
			}

			if (+currentValue > minValue && (+currentValue < maxValue || currentValue.length < maxLength)) {
				this.$quantityInput.val(currentValue);
			}
		} else {
			this.$quantityInput.val(minValue);
		}

		this.$quantityInput.toggleClass(this.params.css.hasValue, this.$quantityInput.val() > minValue);

		if (this._prevValue !== +currentValue) {
			this._prevValue = +this.$quantityInput.val();
			this.$quantityInput.trigger('change.quantity');
		}
	}
}

export default InputQuantity;
