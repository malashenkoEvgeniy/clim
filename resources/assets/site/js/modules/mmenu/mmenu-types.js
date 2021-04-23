'use strict';

/**
 * @module
 * @author Oleg Dutchenko <dutchenko.o.dev@gmail.com>
 * @version 1.0.0
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'custom-jquery-methods/fn/get-my-elements';
import Type from 'assetsSite#/js/type';

// ----------------------------------------
// Private
// ----------------------------------------

/**
 * @implements Type
 * @property {jQuery} $rootElement
 * @property {Object} typeOptions
 * @property {Object} api
 * @property {string} idSelector
 */
export class MobileMenuType extends Type {
	constructor ($rootElement) {
		super($rootElement);
		this._setupUserTypeOptions();
		this._setupOptions();
		this.api = {};
		this.idSelector = this.$rootElement.prop('id');
	}

	/**
	 * @private
	 */
	_setupUserTypeOptions () {
		/**
		 * @type {Object[]}
		 * @private
		 */
		this._userTypeOptions = super._setupUserTypeOptions();
		return this._userTypeOptions;
	}

	/**
	 * @param {Object[]} [userOptions=this._userTypeOptions]
	 * @private
	 */
	_setupOptions (userOptions = this._userTypeOptions) {
		this.typeOptions = super._setupOptions(userOptions);
	}

	/**
	 * @return {Object}
	 * @private
	 */
	get _typeDefaultOptions () {
		return {
			options: {
				fix: true,
				extensions: [
					'shadow-page',
					'position-right',
					'fx-menu-slide',
					'theme-custom'
				]
			},
			configuration: {
				offCanvas: {
					page: {
						selector: '#layout'
					}
				},
				scrollBugFix: {
					fix: true
				}
			}
		};
	}

	/**
	 * @return {string}
	 * @private
	 */
	get _dataAttrKey () {
		return MobileMenuType.dataAttrKey;
	}

	/**
	 * @return {string}
	 */
	static get dataAttrKey () {
		return 'mmenu-module';
	}

	/**
	 * @return {jQuery}
	 * @private
	 */
	get $opener () {
		return this.$rootElement.getMyElements('$mmenuOpener', `[data-mmenu-opener="${this.idSelector}"]`);
	}

	/**
	 * @public
	 */
	initialize () {
		const {
			options = {},
			configuration = {}
		} = this.typeOptions;

		this.$rootElement.mmenu(options, configuration);
		let $api = this.$rootElement.data('mmenu');
		this.$opener.on('click', () => $api.open());
		this.$rootElement.data('moduleLoader').init(this.$rootElement);

		$(document).on('click', '.js-mmenu-openPanel', (e) => {
			e.preventDefault();
			$api.open();
			$api.openPanel($('#' + $(e.currentTarget).data('mmenu-panel')));
		});
	}
}

/**
 * @property {jQuery} $rootElement
 * @property {Object} typeOptions
 * @property {Object} api
 */
export class MenuNav extends MobileMenuType {}
