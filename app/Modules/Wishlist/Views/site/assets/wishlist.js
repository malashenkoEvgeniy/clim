import moduleLoader from 'assetsSite#/js/async-module-loader';

import { ucFirst, plural } from 'assetsSite#/js/utils';

const $document = $(document);

class Wishlist {
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
		this.$wishlistCards = null;
		this.$wishlistTogglers = null;
		this.$counters = $document.find('[data-wishlist-counter]');
		this.$link = $document.find('[data-wishlist-link]');
		this.$blockBuy = $document.find('[data-wishlist-block-buy]');
		this.$massControls = $document.find('[data-wishlist-massive-control]');
		this.$checkedManagerItems = null;
		this.selectedProducts = null;

		this.init();
	}

	init () {
		$document.on('click', '[data-wishlist-toggle]', (e) => {
			this.killPrevRequest();
			let $currentTarget = $(e.currentTarget);
			this.currentRequest = this.request($currentTarget.data('wishlist-toggle'));
		});

		$document.on('change', '[data-wishlist-manager-item]', (e) => {
			let $currentTarget = $(e.currentTarget);
			$currentTarget.closest('[data-wishlist-card]').toggleClass(this.params.css.active, e.currentTarget.checked);
			this.updateState();
		});

		$document.on('click', '[data-wishlist-massive]', (e) => {
			let $currentTarget = $(e.currentTarget);
			let action = $currentTarget.data('wishlist-massive');
			this[`mass${ucFirst(action)}`]();
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
			method: 'POST',
			url: '/wishlist',
			data: data
		})
			.done((response) => {
				if (response.success) {
					if (this.$wishlistCards.length && /wishlist/.test(window.location.pathname)) {
						this.removeItemsFromPage(productID);

						// setTimeout потому, что при slideUp в методе removeItemsFromPage если задержка в this.params.delay мс
						// т.к. это операция асинхронная, без таймаута updateState отрабатывае до того, как DOM дерево обновилось
						// соответственно берет не верные значения
						window.setTimeout(() => {
							this.updateState(productID, response);
						}, this.params.delay);
					} else {
						this.updateState(productID, response);
					}
				}
			})
			.fail((err) => {
				console.error(err);
			})
			.always((response) => {
				this.pending(false, productID);
				this.currentRequest = null;
			});
	}

	pending (status = null, productID) {
		if (typeof status !== 'boolean') {
			return;
		}

		$document.find('[data-wishlist-toggle]').toggleClass(this.params.css.pending, status);

		if (this.$wishlistCards.length) {
			productID.forEach((id) => {
				this.getWishlistCardById(id).toggleClass(this.params.css.pending, status);
			});
		}
	}

	massBuy () {
		if (this.selectedProducts.length) {
			$document.trigger('cart.mass.add', [this.selectedProducts]);
		}
	}

	massDelete () {
		this.confirm('show')
			.then((choice) => {
				if (/^remove$/i.test(choice)) {
					this.confirm('hide');
					this.killPrevRequest();
					this.currentRequest = this.request(this.selectedProducts);
				} else if (/^cancel$/i.test(choice)) {
					this.confirm('hide');
					// perhaps some kind of logic, if the removal from the wishlist was canceled
				}
			})
			.catch((err) => {
				console.error(err);
				this.confirm('hide');
			});
	}

	updateState (productID = null, response = null) {
		this.$wishlistCards = $document.find('[data-wishlist-card]');
		this.$wishlistTogglers = $document.find('[data-wishlist-toggle]');

		this.$checkedManagerItems = $document.find('[data-wishlist-manager-item]').filter(function () {
			return this.checked;
		});

		let $managerItems = this.$checkedManagerItems.length ? this.$checkedManagerItems : $document.find('[data-wishlist-manager-item]:not(:disabled)');
		this.selectedProducts = Array.from($managerItems, (item) => +item.value);

		this.$massControls.toggleClass('_hide', !this.$checkedManagerItems.length);

		if (this.$blockBuy.length) {
			let totalAmount = Array.from($managerItems).reduce((sum, input) => {
				let productPrice = parseFloat($(input).closest('[data-product]').data('product-price'));
				return sum + productPrice;
			}, 0).toFixed(2);

			let count = this.selectedProducts.length;
			let totalHTML = this.$blockBuy.html();

			totalHTML = totalHTML.replace(/(.*?)<b(.*?)/gm, `${count} ${plural(this.$blockBuy.data('wishlist-block-buy'), count)} <b$2`);
			totalHTML = totalHTML.replace(/>(.*?) /gm, `>${totalAmount} `);

			this.$blockBuy.html(totalHTML);

			if (response && typeof response.widget !== 'undefined') {
				this.$blockBuy.html(response.widget);
			}
		}

		if (response) {
			this.updateCounters({
				'total': response.total
			});

			$document.find('[data-wishlist-popover]').toggleClass('_hide', response.total > 0);

			this.setUnLink(response.total > 0);
		}

		if (productID) {
			productID.forEach((id) => {
				this.getWishlistTogglerById(id).toggleClass(this.params.css.active);
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
			let $cardToRemove = this.getWishlistCardById(id);
			let $rootCell = $cardToRemove.closest('.gcell');
			let reload = $rootCell.siblings('.gcell').length === 0;
			$cardToRemove.slideUp(this.params.delay, () => {
				$rootCell.remove();
				if (reload) {
					window.location.reload();
				}
			});
		});
	}

	confirm (action = null) {
		switch (action) {
			case 'show':
				return new Promise((resolve, reject) => {
					$.magnificPopup.open({
						items: {
							src: '#popup-wishlist-confirm-mass-delete'
						},
						type: 'inline',
						removalDelay: 300,
						mainClass: 'mfp-animate-zoom-in',
						autoFocusLast: false,
						closeBtnInside: true,
						callbacks: {
							open () {
								this.content.one('click.confirm', '[data-confirm-action]', (e) => {
									let choice = $(e.currentTarget).data('confirm-action').toLocaleLowerCase();
									if (!/^remove$|^cancel$/i.test(choice)) {
										reject(new Error([
											'Something went wrong.',
											'Choice [remove] or [cancel] expected.',
											`But choice [${choice}] was received`,
											'----------------------'
										].join('\n')));
									}
									resolve(choice);
								});
							}
						}
					});
				});
			case 'hide':
				$.magnificPopup.close();
				break;
			default:
				break;
		}
	}

	getWishlistCardById (id) {
		return this.$wishlistCards.filter(function () {
			return $(this).data('product-id') === id;
		});
	}

	getWishlistTogglerById (id) {
		return this.$wishlistTogglers.filter(function () {
			return $(this).data('wishlist-toggle') === id;
		});
	}

	setUnLink (bool) {
		if (bool) {
			this.$link.attr('href', this.$link.data('href'));
		} else {
			this.$link.removeAttr('href');
		}
	}

	plural (str, number) {

	}
}

;(function (window) {
	window.siteWishlist = new Wishlist();
})(window);
