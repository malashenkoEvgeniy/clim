'use strict';

/**
 * @module
 * @author OlegDutchenko <dutchenko.o.dev@gmail.com>
 * @version 0.0.1
 */

// ----------------------------------------
// Imports
// ----------------------------------------

const path = require('path');
const fromCWD = require('from-cwd');

// ----------------------------------------
// Private
// ----------------------------------------

class BundleFile {
	/**
	 * @param {string} sourceFile
	 * @param {string} distFile
	 */
	constructor (sourceFile, distFile) {
		this.bundleName = path.basename(distFile, this.ext);
		this.sourceFile = fromCWD(sourceFile);
		this.distFile = fromCWD(distFile);
		this.key = `key${this.ext}-${this.bundleName}`;
	}

	/**
	 * @returns {string}
	 */
	get ext () {
		return '';
	}
}

/**
 * @property {string} bundleName
 * @property {string} sourceFile
 * @property {string} distFile
 * @property {string} key
 * @property {string} path
 * @property {string} publicPath
 * @property {string} chunkFilename
 */
class BundleJsFile extends BundleFile {
	/**
	 * @param {string} sourceFile
	 * @param {string} distFile
	 * @param {string} publicPath
	 * @param {string} chunkFilename
	 */
	constructor (sourceFile, distFile, publicPath, chunkFilename) {
		super(sourceFile, distFile);
		this.path = fromCWD(path.dirname(distFile));
		this.publicPath = publicPath;
		this.chunkFilename = chunkFilename;
	}

	get ext () {
		return '.js';
	}
}

/**
 * @property {string} bundleName
 * @property {string} sourceFile
 * @property {string} distFile
 * @property {string} key
 * @property {string} extractFilename
 */
class BundleSassFile extends BundleFile {
	get ext () {
		return '.css';
	}
}

/**
 * @property {string} src
 * @property {Object} options
 */
class BundleSvgSpriteFile {
	/**
	 * @param sourceGlob
	 * @param extractFilename
	 */
	constructor (sourceGlob, extractFilename) {
		this.src = sourceGlob;
		this.options = {
			output: {
				filename: extractFilename,
				chunk: {
					name: 'svg-sprite-map-' + path.basename(extractFilename, '.svg')
				}
			},
			sprite: {
				prefix: false,
				gutter: 5,
				generate: {
					title: false
				}
			}
		};
	}
}

// ----------------------------------------
// Public
// ----------------------------------------

module.exports = { BundleFile, BundleJsFile, BundleSassFile, BundleSvgSpriteFile };
