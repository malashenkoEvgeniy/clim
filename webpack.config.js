'use strict';

/**
 * @module
 * @description Фейковый конфиг для фонового сканирования вашей IDE
 * Конфигурация webpack'a здесь - webpack.export.js
 */

// ----------------------------------------
// Imports
// ----------------------------------------

// модули
const fromCWD = require('from-cwd');

// ----------------------------------------
// Configuration
// ----------------------------------------

/** @type {WebpackOptions} */
const config = {
	mode: 'development',
	resolve: {
		alias: {
			'assetsSite#': fromCWD('./resources/assets/site'),
			'assetsAdmin#': fromCWD('./resources/assets/admin'),
			'GSAP#': fromCWD('./resources/assets/gsap'),
			'modernizr$': fromCWD('.modernizrrc')
		},
		modules: [
			fromCWD('./node_modules/'),
			fromCWD('./resources/'),
			fromCWD('./resources/assets/gsap/'),
			fromCWD('./resources/assets/gsap/easing/'),
			fromCWD('./resources/assets/gsap/plugins/'),
			fromCWD('./resources/assets/gsap/utils/')
		]
	}
};

// ----------------------------------------
// Exports
// ----------------------------------------

module.exports = config;
