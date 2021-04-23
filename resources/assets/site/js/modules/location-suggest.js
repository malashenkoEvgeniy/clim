import debounce from 'lodash/debounce';

import {
	prepareIncomingData
} from 'assetsSite#/js/utils';

class LocationSuggest {
	constructor ($root, moduleLoader) {
		let defaults = {
			css: {
				hasResult: 'has-result',
				hasSuccess: 'has-success',
				hasError: 'has-error',
				shortQuery: 'short-query'
			},
			minQueryLength: 3
		};

		this.$root = $root;
		this.moduleLoader = moduleLoader;
		this.$input = $root.find('[data-suggest-input]');
		this.$locationId = $root.find('[data-suggest-location-id]');
		this.$suggestList = $root.find('[data-suggest-list]');
		this.params = $.extend(true, {}, defaults, $root.data('user-config') || {});
		this.query = $.trim(this.$input.val()) || null;
		this.lastRenderHasSuccess = false;

		this.init();
	}

	init () {
		let _self = this;

		this.$input.on('input', debounce((e) => {
			this.$locationId.val('');
			this.query = e.target.value.trim();

			if (this.query && this.query.length >= this.params.minQueryLength) {
				this.toggle('clear');

				$.ajax({
					type: 'POST',
					url: this.$root.data('location-suggest'),
					data: {
						query: this.query
					}
				})
					.done((res) => {
						res = prepareIncomingData(res);
						if (res.success) {
							_self.render(res)
								.then(() => {
									this.toggle('open');
								})
								.catch((err) => {
									this.toggle('error', err);
								});
						}

						if (!res.success) {
							if (res.error) {
								console.warn(res.error);
							}
						}
					})
					.fail((err) => {
						console.warn('Data loading error...', err);
					})
					.always(() => {});
			} else if (!this.query) {
				this.toggle('close');
			} else {
				this.toggle('short-query');
			}
		}, 300)).on('focus', () => {
			if (!this.query) {
				this.toggle('close');
			} else if (this.query && this.query.length >= this.params.minQueryLength && !this.lastRenderHasSuccess) {
				this.toggle('search');
			} else if (this.query && this.query.length >= this.params.minQueryLength && this.lastRenderHasSuccess) {
				this.toggle('open');
			} else {
				this.toggle('short-query');
			}
		}).on('blur', debounce(() => {
			this.toggle('clear');
		}, 250));

		this.$suggestList.on('click', '[data-suggest-item]', (e) => {
			let $currentTarget = $(e.currentTarget);

			this.$input.val($currentTarget.text());
			this.$locationId.val($currentTarget.data('location-id'));
			this.$locationId.closest('form').data('validator').element(this.$locationId.get(0));
		});
	}

	toggle (action = null, err = null) {
		if (!action) {
			return;
		}

		let {
			hasResult,
			hasSuccess,
			hasError,
			shortQuery
		} = this.params.css;

		switch (action) {
			case 'short-query':
				this.$root.removeClass(`${hasResult} ${hasSuccess} ${hasError}`).addClass(shortQuery);
				break;
			case 'clear':
				this.$root.removeClass(`${hasResult} ${hasSuccess} ${hasError} ${shortQuery}`);
				break;
			case 'search':
				this.$input.trigger('input');
				break;
			case 'open':
				this.lastRenderHasSuccess = true;
				this.$root.removeClass(shortQuery).addClass(`${hasResult} ${hasSuccess}`);
				break;
			case 'close':
				this.$root.removeClass(`${hasResult} ${hasSuccess} ${hasError} ${shortQuery}`);
				break;
			case 'error':
				this.lastRenderHasSuccess = false;
				this.$root.removeClass(`${hasResult} ${hasSuccess} ${shortQuery}`).addClass(hasError);
				if (err) { console.warn(err.message, '\n--------------\n', err.incomingData); }
				break;
			default:
				break;
		}
	}

	render (data) {
		let preparedData = prepareIncomingData(data);

		return new Promise((resolve, reject) => {
			if (!preparedData) {
				reject(new Error({
					messgae: 'Incorrect data',
					incomingData: data
				}));
			}

			this.$suggestList.html(preparedData.html);

			resolve();
		});
	}
}

export default LocationSuggest;
