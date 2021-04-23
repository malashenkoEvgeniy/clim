'use strict';

/**
 * @module
 * @author OlegDutchenko <dutchenko.o.dev@gmail.com>
 * @version 0.0.1
 */

// ----------------------------------------
// Imports
// ----------------------------------------

const argv = require('../utils/argv');
const merge = require('lodash.merge');

// ----------------------------------------
// Private
// ----------------------------------------

const isProduction = argv('production');
const isDevelopment = !isProduction;
const isHot = argv('hot');

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * Конфиги используемых лоадеров.
 * Вынесены в отдельный объект для повторяющихся использованиий
 * при составлении webpackConfig'a
 * @param {Object} data
 * @param {string[]} data.includePaths
 * @returns {Object}
 */
function styleLoaders (data) {
	const loaders = {
		style: {
			loader: 'style-loader',
			options: {
				hmr: isHot,
				sourceMap: isDevelopment
			}
		},
		get asyncStyle () {
			return merge({}, this.style, {
				options: {
					sourceMap: false
				}
			});
		},
		css: {
			loader: 'css-loader',
			options: {
				sourceMap: isDevelopment,
				importLoaders: 1
			}
		},
		get asyncCss () {
			return merge({}, this.css, {
				options: {
					sourceMap: false
				}
			});
		},
		postcss: {
			loader: 'postcss-loader',
			options: {
				sourceMap: isDevelopment,
				plugins: [
					require('autoprefixer')({
						browsers: ['> 1%', 'ie 11'],
						cascade: false
					}),
					require('css-mqpacker')({
						sort: require('sort-css-media-queries')
					})
				]
			}
		},
		get asyncPostcss () {
			return merge({}, this.postcss, {
				options: {
					sourceMap: isHot
				}
			});
		},
		sass: {
			loader: 'sass-loader',
			options: {
				sourceMap: isDevelopment,
				includePaths: data.includePaths
			}
		},
		get asyncSass () {
			return merge({}, this.sass, {
				options: {
					sourceMap: isHot
				}
			});
		}
	};

	if (isProduction) {
		loaders.postcss.options.plugins.push(
			require('cssnano')({
				preset: ['default', {
					zindex: false,
					autoprefixer: false,
					reduceIdents: false,
					discardUnused: false,
					cssDeclarationSorter: false, // disable plugin
					postcssCalc: false, // disable plugin
					discardComments: { // custom plugin config
						removeAll: true
					}
				}]
			})
		);
	}

	return loaders;
}

// ----------------------------------------
// Exports
// ----------------------------------------

module.exports = styleLoaders;
