'use strict';

/**
 * @module
 * @author OlegDutchenko <dutchenko.o.dev@gmail.com>
 * @version 0.0.1
 */

// ----------------------------------------
// Private
// ----------------------------------------

/**
 * @param {Object} module
 * @return {string|boolean}
 */
function _miniCssRecursiveIssuer (module) {
	if (module.issuer) {
		return _miniCssRecursiveIssuer(module.issuer);
	} else if (module.name) {
		return module.name;
	} else {
		return false;
	}
}

/**
 * @param {string} groupName
 * @param {string} [chunks="all"]
 * @return {Object}
 */
function _miniCssSplitGroup (groupName, chunks = 'all') {
	return {
		name: groupName,
		test: (m, c, entry = groupName) => {
			return m.constructor.name === 'CssModule' && _miniCssRecursiveIssuer(m) === entry;
		},
		chunks: chunks,
		enforce: true
	};
}

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {BundleSassFile[]} sass
 * @returns {Object}
 */
function optimiziation (sass) {
	return {
		noEmitOnErrors: true,
		splitChunks: {
			chunks: 'async',
			minSize: 300.001,
			minChunks: 1,
			maxAsyncRequests: 5,
			maxInitialRequests: 3,
			automaticNameDelimiter: '~',
			name: true,
			get cacheGroups () {
				const groups = {
					vendors: {
						test: /[\\/](node_modules|_vendors)[\\/]/,
						priority: -10
					},
					default: {
						minChunks: 2,
						priority: -20,
						reuseExistingChunk: true
					}
				};

				sass.forEach(file => {
					groups[file.key] = _miniCssSplitGroup(file.bundleName);
				});

				return groups;
			}
		}
	};
}

// ----------------------------------------
// Export
// ----------------------------------------

module.exports = optimiziation;
