'use strict';

/**
 * Экспорт _"интерфейса"_ Type
 * @module
 * @author Oleg Dutchenko <dutchenko.o.dev@gmail.com>
 * @version 1.0.0
 */

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @interface
 * @property {jQuery} $rootElement
 */
class Type {
	/**
	 * @param {jQuery} $rootElement
	 */
	constructor ($rootElement) {
		this.$rootElement = $rootElement;
	}

	/**
	 * @returns {Object[]}
	 */
	_setupUserTypeOptions () {
		const {
			'user-type-options': options = {}
		} = this.$rootElement.data(this._dataAttrKey) || {};
		return Array.isArray(options) ? options : [options];
	}

	/**
	 * @param {Object[]} [userOptions]
	 * @return {Object}
	 */
	_setupOptions (userOptions) {
		return $.extend(true, {}, this._typeDefaultOptions, ...userOptions);
	}

	/**
	 * @returns {Object}
	 */
	get _typeDefaultOptions () {
		return {};
	}

	/**
	 * @returns {string}
	 */
	get _dataAttrKey () {
		return 'change-me-in-extended';
	}
}

// ----------------------------------------
// Exports
// ----------------------------------------

export default Type;
