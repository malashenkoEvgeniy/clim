'use strict';

/**
 * @module
 * @author OlegDutchenko <dutchenko.o.dev@gmail.com>
 * @version 0.0.1
 */

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {BundleJsFile} js
 * @returns {Object}
 */
function output (js) {
	return {
		filename (file) {
			if (/\.(s)?css$/.test(file.chunk.entryModule.resource)) {
				return '.trash/[name].js';
			}
			return '[name].js';
		},
		path: js.path,
		publicPath: js.publicPath,
		chunkFilename: js.chunkFilename
	};
}

// ----------------------------------------
// Exports
// ----------------------------------------

module.exports = output;
