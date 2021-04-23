'use strict';

/**
 * @module
 * @description Модуль сканнирования файлов
 * @author Oleg Dutchenko <dutchenko.o.dev@gmail.com>
 * @version 2.0.0
 */

// ----------------------------------------
// Definitions
// ----------------------------------------

/**
 * @method require
 * @global
 */

// ----------------------------------------
// Imports
// ----------------------------------------

const fs = require('fs');
const path = require('path');
const glob = require('glob');
const mkdirp = require('mkdirp');
const normalizePath = require('normalize-path');
const notifier = require('node-notifier');
const logger = require('./logger');
const fromCWD = require('from-cwd');

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @prop {string[]} src
 * @prop {string} dist
 * @prop {string} resolve
 */
class AssetsScanner {
	/**
	 * @param {Object} options
	 * @param {string[]} options.sources
	 * @param {string} options.resultFile
	 * @param {string} options.includeFile
	 */
	constructor (options) {
		this.sources = options.sources;
		this.resultFile = options.resultFile;
		this.includeFile = options.includeFile;
		this.header = '';
		this.footer = '';
	}

	/**
	 * @param {boolean} [forceRun]
	 * @public
	 */
	scan (forceRun) {
		this.forceRun = !!forceRun;
		this.files = [];
		this.sources.forEach(src => {
			this.files = this.files.concat(glob.sync(src));
		});

		this.paths = this.files.filter(file => !/^_/.test(path.basename(file)));
		this.paths = this.paths.map(file => normalizePath(path.relative(this.includeFile, file)));

		this._duplicatedFiles();
		this.paths = this._transformPaths(this.paths);
		this._createContent(this.paths);
		this._write();
	}

	/**
	 * @private
	 */
	_duplicatedFiles () {
		const files = {};
		this.paths.forEach(src => {
			const filename = path.basename(src);
			if (files.hasOwnProperty(filename)) {
				files[filename].sources.push(src);
			} else {
				files[filename] = {
					hasDouble: false,
					sources: [src]
				};
			}
		});

		let duplicated = [];
		for (let filename in files) {
			let sources = files[filename].sources;
			if (sources.length < 2) {
				delete files[filename];
			}

			sources.forEach((src, i) => {
				if (!i) {
					return;
				}
				duplicated.push(src);
			});
		}

		if (duplicated.length) {
			// this.paths = this.paths.filter(src => !~duplicated.indexOf(src));
			notifier.notify({
				type: 'warn',
				title: 'Double Assets!',
				message: 'You have duplicates!\n' + duplicated.join('\n'),
				icon: fromCWD('./resources/webpack/icons/attention.png')
			});
			logger.instance.blank();
			logger.instance.print('yellow', 'Attention!', 'You have duplicates! They may have the same content and may be redundant:');
			logger.instance.print('cyan', ...duplicated);
			logger.instance.print('yellow', 'Please check result file');
			logger.instance.print('cyan', this.resultFile);
			logger.instance.blank();
		}
	}

	/**
	 * @private
	 */
	_transformPaths () {}

	/**
	 * @private
	 */
	_createContent (paths = this.paths) {
		this.content = [
			this.header,
			paths.join('\n'),
			this.footer
		].join('\n');
	}

	/**
	 * @private
	 */
	_write () {
		const distExists = fs.existsSync(this.resultFile);
		const content = distExists && fs.readFileSync(this.resultFile, 'utf8');
		if (!this.forceRun && content === this.content) {
			return false;
		}

		if (!distExists) {
			const dirname = path.dirname(this.resultFile);
			if (!fs.existsSync(dirname)) {
				mkdirp.sync(dirname);
			}
		}

		fs.writeFileSync(this.resultFile, this.content, 'utf8');
		this._log();
	}

	/**
	 * @private
	 */
	_log () {}
}

class SassScanner extends AssetsScanner {
	constructor (options) {
		super(options);
		this.includeFile = path.dirname(this.includeFile);
		this.header = [
			'// THIS FILE WAS GENERATED AUTOMATICALLY',
			'// DO NOT EDIT IT MANUALLY !!!!!!!!!!!!!',
			'',
			'// sass-lint:disable clean-import-paths final-newline',
			''
		].join('\n');
	}

	/**
	 * @param {string[]} paths
	 * @returns {string[]} paths
	 * @override
	 * @private
	 */
	_transformPaths (paths) {
		return paths.map(src => {
			return `@import "${src}";`;
		});
	}

	/**
	 * @override
	 * @private
	 */
	_log () {
		logger.instance.print('white', `sassScanner ${logger.color('yellow', 're-write imports!')}`);
		logger.instance.line();
	}
}

class JSScanner extends AssetsScanner {
	constructor (options) {
		super(options);
		this.header = [
			'// THIS FILE WAS GENERATED AUTOMATICALLY',
			'// DO NOT EDIT IT MANUALLY !!!!!!!!!!!!!',
			''
		].join('\n');
	}

	/**
	 * @param {string[]} paths
	 * @returns {string[]} paths
	 * @override
	 * @private
	 */
	_transformPaths (paths) {
		return paths.map(src => {
			return `import '${src}';`;
		});
	}

	/**
	 * @override
	 * @private
	 */
	_log () {
		logger.instance.print('white', `jsScanner ${logger.color('yellow', 're-write imports!')}`);
		logger.instance.line();
	}
}

// ----------------------------------------
// Exports
// ----------------------------------------

module.exports = { SassScanner, JSScanner };
