import moduleLoader from 'assetsSite#/js/async-module-loader';
import debounce from 'lodash.debounce';

import { getLocale } from 'assetsSite#/js/utils';

const $document = $(document);

class Cart {
	constructor () {
		this.params = {
			dictionary: {
				ru: {
					'buy': 'Купить',
					'in-cart': 'В корзине'
				},
				uk: {
					'buy': 'Купити',
					'in-cart': 'В кошику'
				},
				en: {
					'buy': 'To order',
					'in-cart': 'In cart'
				}
			},
			css: {
				pending: 'is-pending',
				inCart: 'in-cart'
			}
		};
		this.eventsMap = {
			'change.quantity': '[data-product-quantity]',
			'change.dictionary': '[data-product-dictionary]'
		};
		this.popupTemplate = $('#popup-cart--template').get(0).innerHTML;
		this.cart = {};
		this.currentRequest = null;
		this.moduleLoader = moduleLoader;
		this.cartContainersOnPage = Array.from($document.find('[data-cart-container]'), (node) => {
			return $(node).data('cart-container');
		});
		this.$counters = $document.find('[data-cart-counter]');

		this.init();
	}

	init () {
		$document.on('click', '[data-cart-action]', (e) => {
			this.processAction(this.getCartAction(e), e);
		});

		$document.on('click', '[data-cart-trigger]', (e) => {
			let triggerType = $(e.currentTarget).data('cart-trigger');
			this[triggerType]();
		});

		Object.keys(this.eventsMap).forEach((event) => {
			$document.on(event, this.eventsMap[event], debounce((e) => {
				if (event === 'change.dictionary') {
					this.processAction('dictionary', e);
				} else {
					this.processAction('update', e);
				}
			}, 500));
		});

		$document.on('cart.mass.add', (e, productsToBuy) => {
			this.massAdd(productsToBuy);
		});

		this.request('get', {});
	}

	processAction (action = null, event = null) {
		if (!action || !event) {
			return;
		}

		this.currentRequest && this.currentRequest.abort();
		let $product = this.getProduct(event);
		let productID = /update/.test(action) ? $product.data('product-id') : this.getProductID(event);
		this.collectData(action, productID, $product).then((data) => {
			this.currentRequest = this.request(action, data);
		});
	}

	massAdd (productsToBuy = null) {
		if (!productsToBuy) {
			return;
		}

		productsToBuy = Array.isArray(productsToBuy) ? productsToBuy : [productsToBuy];

		productsToBuy = productsToBuy.filter((productID) => {
			return !this.productIsInCart(productID);
		});

		if (productsToBuy.length) {
			this.request('add', {
				product_id: productsToBuy
			});
		} else {
			this.open();
		}
	}

	massDelete (productsToDelete = null) {
		if (!window.confirm('Please, confirm the removal of goods from the cart!')) {
			return;
		}

		if (/^clear-cart$/.test(productsToDelete) && this.cart.detailed) {
			let $cart = this.makeCart(this.cart.detailed);
			productsToDelete = Array.from($cart.find('[data-product]'), item => $(item).data('product-id'));
		}

		if (!productsToDelete || typeof productsToDelete === 'string' || !productsToDelete.length) {
			return;
		}

		productsToDelete = Array.isArray(productsToDelete) ? productsToDelete : [productsToDelete];

		this.request('delete', {
			_method: 'delete',
			product_id: productsToDelete
		});
	}

	request (action = null, data = null) {
		if (!action || !data) {
			return;
		}

		this.pending(true);

		data.cart_containers = this.cartContainersOnPage;

		return $.ajax({
			method: /get/.test(action) ? 'GET' : 'POST',
			url: window.LOCO_DATA.cart.local,
			data: data
		})
			.done((response) => {
				if (response.success) {
					this.storeCarts(response.html);
					this.insertCarts(response);
					this.updateCounters({
						'total-amount': response.total_amount,
						'total-quantity': response.total_quantity
					});
					this.syncState(response);
					if (/add/.test(action)) {
						this.open();
					}
				}
			})
			.fail((err) => {
				console.error(err);
			})
			.always((response) => {
				this.pending(false);
				this.currentRequest = null;
			});
	}

	pending (status = null) {
		if (typeof status !== 'boolean') {
			return;
		}

		$document.find('[data-cart-container]').toggleClass(this.params.css.pending, status);
		$document.find('button[data-product-id]').toggleClass(this.params.css.pending, status);
	}

	storeCarts (oMarkup = null) {
		if (!oMarkup) {
			return;
		}

		this.cart = oMarkup;
	}

	insertCarts (response) {
		$document.find('[data-cart-container]').each((i, container) => {
			let $container = $(container);
			let cartType = $container.data('cart-container');

			$container.html(this.makeCart(this.cart[cartType]));
		});

		if (typeof window.LOCO_DATA.checkout !== 'undefined' && response.total_quantity === 0) {
			setTimeout(() => {
				window.location.href = window.LOCO_DATA.checkout;
			}, 500);
		}
	}

	updateCounters (oInfo = null) {
		if (!oInfo) {
			return;
		}

		this.$counters.each((i, counter) => {
			let $counter = $(counter);
			let counterType = $counter.data('cart-counter');

			$counter.html(oInfo[counterType] ? oInfo[counterType] : '');
		});
	}

	syncState (response, buttonState = false) {
		if (buttonState) {
			let $addButtons = $('button[data-product-id]');

			if ($addButtons.length) {
				let locale = getLocale();

				$.each($addButtons, (i, button) => {
					let $button = $(button);
					let dictionary = $button.data('dictionary') || this.params.dictionary;
					let productID = $button.data('product-id');

					if (this.productIsInCart(productID)) {
						$button
							.addClass(this.params.css.inCart)
							.removeAttr('data-cart-action')
							.attr('data-cart-trigger', 'open')
							.find('.button__text')
							.text(dictionary[locale]['in-cart']);
					} else {
						$button
							.removeClass(this.params.css.inCart)
							.removeAttr('data-cart-trigger')
							.attr('data-cart-action', 'add')
							.find('.button__text')
							.text(dictionary[locale]['buy']);
					}
				});
			}
		}

		$document.find('[data-cart-splash]').toggleClass('has-content', response.total_quantity > 0);
		$document.find('[data-order-confirm]').toggleClass('is-disabled', !response.can_make_order);
		$document.find('[data-minimum-order-amount-msg]').toggleClass('_hide', response.can_make_order);
	}

	makeCart (cart = null) {
		if (!cart) {
			return;
		}

		let $cart = $(cart);
		$.each($cart.find('form'), (i, form) => {
			form.autocomplete = 'off';
		});
		this.moduleLoader.init($cart);
		return $cart;
	}

	collectData (action = null, productID = null, $product = null) {
		if (!action || !productID || !$product) {
			return;
		}

		productID = Array.isArray(productID) ? productID : [productID];

		return new window.Promise((resolve, reject) => {
			let data = {};

			switch (action) {
				case 'add':
					data.product_id = productID;
					data.product_data = $product.find('form')
						.serializeArray().reduce(function (obj, item) {
							obj[item.name] = item.value;
							return obj;
						}, {});
					break;
				case 'delete':
					data._method = 'delete';
					data.product_id = productID;
					break;
				case 'move-to-wishlist':
					data._method = 'delete';
					data.product_id = productID;

					if (typeof window.siteWishlist !== 'undefined') {
						window.siteWishlist.request(productID[0]);
					}
					break;
				case 'update':
					data._method = 'put';
					data.product_id = productID[0];
					data.product_data = $product.find('form')
						.serializeArray().reduce(function (obj, item) {
							obj[item.name] = item.value;
							return obj;
						}, {});
					break;
				case 'dictionary':
					data._method = 'patch';
					data.product_id = productID[0];
					data.product_data = $product.find('form')
						.serializeArray().reduce(function (obj, item) {
							obj[item.name] = item.value;
							return obj;
						}, {});
					break;
				default:
					break;
			}

			resolve(data);
		});
	}

	productIsInCart (productID) {
		let regExp = new window.RegExp(`data-product-id=("|')${productID}("|')`, 'gi');
		return regExp.test(this.cart.detailed);
	}

	open () {
		if (this.cart.detailed) {
			let cartPopup = this.popupTemplate.replace('__cart__', this.cart.detailed);
			this.showMagnific(this.makeCart(cartPopup));
		}
	}

	close () {
		$.magnificPopup.close();
	}

	showMagnific ($content) {
		$.magnificPopup.open({
			items: {
				src: $content
			},
			type: 'inline',
			removalDelay: 300,
			mainClass: 'mfp-animate-zoom-in',
			autoFocusLast: false,
			closeBtnInside: true
		});
	}

	getProduct (event) {
		return $(event.currentTarget).closest('[data-product]');
	}

	getProductID (event) {
		return $(event.currentTarget).data('product-id');
	}

	getCartAction (event) {
		return $(event.currentTarget).data('cart-action');
	}
}

;(function (window) {
	window.siteCart = new Cart();
})(window);
