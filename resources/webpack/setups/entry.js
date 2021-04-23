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

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {BundleJsFile} js
 * @param {BundleSassFile[]} sass
 * @param {Object} sass
 * @returns {Object}
 */
function entry (js, sass, bs) {
	const data = {
		[js.bundleName]: [js.sourceFile]
	};

	if (argv('hot')) {
		data[js.bundleName].push(
			`webpack-hot-middleware/client?path=${bs.proxy}:${bs.port}/__webpack_hmr&timeout=20000&reload=true`
		);
	}

	sass.forEach(file => {
		data[file.bundleName] = file.sourceFile;
	});
	return data;
}

// ----------------------------------------
// Exports
// ----------------------------------------

module.exports = entry;
