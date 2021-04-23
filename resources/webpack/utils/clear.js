'use strict';

/**
 * @module
 * @author Oleg Dutchenko <dutchenko.o.dev@gmail.com>
 * @licence MIT
 */

// ----------------------------------------
// Imports
// ----------------------------------------

const del = require('del');
const logger = require('./logger');

// ----------------------------------------
// Publics
// ----------------------------------------

/**
 * Clear some folders or files,
 * before webpack starts to bundle your project
 * @param {string|string[]} paths
 */
function clear (paths) {
	if (!Array.isArray(paths)) {
		paths = [paths];
	}

	logger.instance.print('white', 'Clear path:');

	paths.forEach(path => {
		logger.instance.print('blue', path);
		del.sync(path);
	});

	logger.instance.print('yellow', 'DONE!');
	logger.instance.line();
}

// ----------------------------------------
// Exports
// ----------------------------------------

module.exports = clear;
