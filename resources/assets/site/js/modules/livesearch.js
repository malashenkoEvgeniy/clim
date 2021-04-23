import debounce from 'lodash/debounce';

import {
	prepareIncomingData
} from 'assetsSite#/js/utils';

window.LiveSearch = null;

export default class LiveSearch {
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
		this.$form = $root.find('[data-search-form]');
		this.$input = $root.find('[data-search-input]');
		this.$suggestions = $root.find('[data-search-suggestions]');
		this.params = $.extend(true, {}, defaults, $root.data('user-config') || {});
		this.moduleLoader = moduleLoader;
		this.query = $.trim(this.$input.val()) || null;
		this.lastRenderHasSuccess = false;

		this.init();
	}

	init () {
		let _self = this;

		this.$input.on('input', debounce((e) => {
			if (e.keyCode === 13) {
				this.$form.submit();
				return;
			}

			this.query = e.target.value.trim();

			if (this.query && this.query.length >= this.params.minQueryLength) {
				this.toggle('clear');

				$.ajax({
					type: 'POST',
					url: this.$form.attr('action'),
					data: {
						query: this.query
					}
				})
					.done((res) => {
						res = prepareIncomingData(res);
						_self.render(res)
							.then(() => {
								this.toggle('open');
							})
							.catch((err) => {
								this.toggle('error', err);
							});
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
			this.switchInstance();
			if (!this.query) {
				this.toggle('close');
			} else if (this.query && this.query.length >= this.params.minQueryLength && !this.lastRenderHasSuccess) {
				this.toggle('search');
			} else if (this.query && this.query.length >= this.params.minQueryLength && this.lastRenderHasSuccess) {
				this.toggle('open');
			} else {
				this.toggle('short-query');
			}
		}).on('blur', () => {
			this.toggle('clear');
		});

		this.$form.on('reset', () => {
			this.toggle('clear');
			this.query = null;
		});

		this.$form.on('submit', (e) => {
			if (!this.query || this.query.length < this.params.minQueryLength) {
				e.preventDefault();
				this.toggle('clear');
			}
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
				this.switchInstance();
				this.lastRenderHasSuccess = true;
				this.$root.removeClass(shortQuery).addClass(`${hasResult} ${hasSuccess}`);
				break;
			case 'close':
				this.$root.removeClass(`${hasResult} ${hasSuccess} ${hasError} ${shortQuery}`);
				break;
			case 'error':
				this.lastRenderHasSuccess = false;
				this.$root.removeClass(`${hasResult} ${hasSuccess} ${shortQuery}`).addClass(hasError);
				if (err) {
					console.warn(err.message, '\n--------------\n', err.incomingData);
				}
				break;
			default:
				break;
		}
	}

	switchInstance () {
		if (window.LiveSearch) {
			window.LiveSearch.toggle('close');
		}
		window.LiveSearch = this;
	}

	search () {
		this.$input.trigger('input');
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

			this.$suggestions.html(preparedData.html);

			resolve();
		});
	}
}
