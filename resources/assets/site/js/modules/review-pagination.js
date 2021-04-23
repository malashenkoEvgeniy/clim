import {
	prepareIncomingData
} from 'assetsSite#/js/utils';
import TweenMax from 'GSAP#/TweenMax';
import GSAP from 'GSAP#/gsap';
import 'GSAP#/plugins/ScrollToPlugin';

export default class ReviewPagination {
	constructor ($root, moduleLoader) {
		this.$root = $root;
		this.$url = $root.data('review');
		this.$container = $root.closest('.review-container');
		this.moduleLoader = moduleLoader;

		this.init();
	}

	init () {
		let _self = this;

		$(document).on('click', '.js-pagination-item', (e) => {
			let $page = e.target.dataset.page;

			this.pending(true);

			$.ajax({
				type: 'POST',
				url: _self.$url,
				data: {
					page: $page
				}
			}).done((res) => {
				res = prepareIncomingData(res);
				_self.scrollCorrection().then().then(() => {
					_self.render(res).then(() => {
						_self.pending(false);
					}).catch((err) => {
						console.warn('Data loading error...', err);
					});
				});
			}).fail((err) => {
				console.warn('Data loading error...', err);
			});
		});
	}

	pending (status = null) {
		if (typeof status !== 'boolean') {
			return;
		}

		this.$container.toggleClass('is-pending', status);
	}

	render (data) {
		let preparedData = prepareIncomingData(data);

		return new Promise((resolve, reject) => {
			if (!preparedData) {
				reject(new Error({
					message: 'Incorrect data',
					incomingData: data
				}));
			}

			this.$container.html(preparedData.html);

			resolve();
		});
	}

	scrollCorrection () {
		let _self = this;

		return new Promise((resolve, reject) => {
			TweenMax.to(window, 1, {
				scrollTo: {
					y: _self.$container.closest('[data-product-tabs]').offset().top - 64, // minus 64px fixed top panel
					autoKill: false
				},
				ease: GSAP.Power2.easeOut,
				onComplete: resolve
			});
		});
	}
}
