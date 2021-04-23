import moduleLoader from 'assetsSite#/js/async-module-loader';

const $document = $(document);

class Comparelist {
	constructor () {
		this.params = {
			delay: 300,
			css: {
				pending: 'is-pending',
				active: 'is-active'
			}
		};
		this.currentRequest = null;
		this.moduleLoader = moduleLoader;
		this.$comparelistCards = null;
		this.$comparelistTogglers = null;
		this.$counters = $document.find('[data-comparelist-counter]');
		this.$link = $document.find('[data-comparelist-link]');

		this.init();
	}

	init () {
		$document.on('click', '[data-comparelist-toggle]', (e) => {
			this.killPrevRequest();
			let $currentTarget = $(e.currentTarget);
			this.currentRequest = this.request($currentTarget.data('comparelist-toggle'));
		});

		this.updateState();
	}

	killPrevRequest () {
		this.currentRequest && this.currentRequest.abort();
	}

	request (productID = null) {
		if (!productID) {
			return;
		}

		productID = Array.isArray(productID) ? productID : [productID];

		let data = {
			product_id: productID
		};

		this.pending(true, productID);

		return $.ajax({
			method: 'GET',
			dataType: 'JSON',
			url: `/compare/toggle/${productID}`,
			data: data
		})
			.done((response) => {
				if (response.success) {
					if (this.$comparelistCards.length && /compare/.test(window.location.pathname)) {
						this.removeItemsFromPage(productID);

						window.setTimeout(() => {
							this.updateState(productID, response);
						}, this.params.delay + 100);
					} else {
						this.updateState(productID, response);
					}
				}
			})
			.fail((err) => {
				console.error(err);
			})
			.always(() => {
				this.pending(false, productID);
				this.currentRequest = null;
			});
	}

	pending (status = null, productID) {
		if (typeof status !== 'boolean') {
			return;
		}

		$document.find('[data-comparelist-toggle]').toggleClass(this.params.css.pending, status);

		if (this.$comparelistCards.length) {
			productID.forEach((id) => {
				this.getComparelistCardById(id).toggleClass(this.params.css.pending, status);
			});
		}
	}

	updateState (productID = null, response = null) {
		if (response) {
			this.updateCounters({
				'total': response.total
			});

			$document.find('[data-comparelist-popover]').toggleClass('_hide', response.total > 0);

			if (/compare/i.test(window.location.pathname) && !response.total > 0) {
				window.location.reload();
			}

			this.setUnLink(response.total > 0);
		}

		this.$comparelistCards = $document.find('[data-comparelist-card]');
		this.$comparelistTogglers = $document.find('[data-comparelist-toggle]');

		if (productID) {
			productID.forEach((id) => {
				this.getComparelistTogglerById(id).toggleClass(this.params.css.active);
			});
		}
	}

	updateCounters (oInfo = null) {
		if (!oInfo) {
			return;
		}

		this.$counters.each((i, counter) => {
			let $counter = $(counter);

			$counter.html(oInfo['total'] ? oInfo['total'] : '');
		});
	}

	removeItemsFromPage (productID) {
		productID.forEach((id) => {
			let $cardToRemove = this.getComparelistCardById(id);
			let $rootCell = $cardToRemove.closest('.gcell, .compare-table__cell');

			$cardToRemove.slideUp(this.params.delay, () => {
				switch ($rootCell.parent().children().length) {
					case 2:
						$rootCell.closest('[data-comparelist-group]').find('[data-comparelist-link]').remove();
						break;
					case 1:
						$rootCell.closest('[data-comparelist-group]').remove();
						break;
				}

				$rootCell.remove();
			});
		});
	}

	getComparelistCardById (id) {
		return this.$comparelistCards.filter(function () {
			return $(this).data('product-id') === id;
		});
	}

	getComparelistTogglerById (id) {
		return this.$comparelistTogglers.filter(function () {
			return $(this).data('comparelist-toggle') === id;
		});
	}

	setUnLink (bool) {
		if (bool) {
			this.$link.attr('href', this.$link.data('href'));
		} else {
			this.$link.removeAttr('href');
		}
	}
}

;(function (window) {
	window.siteComparelist = new Comparelist();
})(window);
