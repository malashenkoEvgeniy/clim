'use strict';

/**
 * @module
 * @author Oleg Dutchenko <dutchenko.o.dev@gmail.com>
 * @version 2.0.0
 */

// ----------------------------------------
// Definitions
// ----------------------------------------

/**
 * @namespace process
 * @global
 */

/**
 * @method require
 * @global
 */

// ----------------------------------------
// Imports
// ----------------------------------------

const notifier = require('node-notifier');
const fromCWD = require('from-cwd');

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * Обработка критической ошибка процесса
 * Позволяет вывести push уведомление разработчику
 * для осведомления о падении процесса )))
 */
function uncaughtException () {
	process.on('uncaughtException', err => {
		console.log('-----------');
		console.log(err.message);
		console.log('-----------');
		notifier.notify({
			type: 'Process shutdown',
			message: err.message,
			icon: fromCWD('../icons/error.png')
		}, () => {
			process.exit();
		});
	});
}

// ----------------------------------------
// Exports
// ----------------------------------------

module.exports = uncaughtException;
