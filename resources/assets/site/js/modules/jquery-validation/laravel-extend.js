function strlen (string) {
	//  discuss at: http://phpjs.org/functions/strlen/
	// original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// improved by: Sakimori
	// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	//    input by: Kirk Strobeck
	// bugfixed by: Onno Marsman
	//  revised by: Brett Zamir (http://brett-zamir.me)
	//        note: May look like overkill, but in order to be truly faithful to handling all Unicode
	//        note: characters and to this function in PHP which does not count the number of bytes
	//        note: but counts the number of characters, something like this is really necessary.
	//   example 1: strlen('Kevin van Zonneveld');
	//   returns 1: 19
	//   example 2: ini_set('unicode.semantics', 'on');
	//   example 2: strlen('A\ud87e\udc04Z');
	//   returns 2: 3

	var str = string + '';
	var i = 0;

	var chr = '';

	var lgth = 0;

	var that = this || window; // fix ES3

	if (!that.php_js || !that.php_js.ini || !that.php_js.ini['unicode.semantics'] || that.php_js.ini[
		'unicode.semantics'].local_value.toLowerCase() !== 'on') {
		return string.length;
	}

	var getWholeChar = function (str, i) {
		var code = str.charCodeAt(i);
		var next = '';

		var prev = '';
		if (code >= 0xD800 && code <= 0xDBFF) {
			// High surrogate (could change last hex to 0xDB7F to treat high private surrogates as single characters)
			if (str.length <= (i + 1)) {
				throw 'High surrogate without following low surrogate';
			}
			next = str.charCodeAt(i + 1);
			if (next < 0xDC00 || next > 0xDFFF) {
				throw 'High surrogate without following low surrogate';
			}
			return str.charAt(i) + str.charAt(i + 1);
		} else if (code >= 0xDC00 && code <= 0xDFFF) {
			// Low surrogate
			if (i === 0) {
				throw 'Low surrogate without preceding high surrogate';
			}
			prev = str.charCodeAt(i - 1);
			if (prev < 0xD800 || prev > 0xDBFF) {
				// (could change last hex to 0xDB7F to treat high private surrogates as single characters)
				throw 'Low surrogate without preceding high surrogate';
			}
			// We can pass over low surrogates now as the second component in a pair which we have already processed
			return false;
		}
		return str.charAt(i);
	};

	for (i = 0, lgth = 0; i < str.length; i++) {
		if ((chr = getWholeChar(str, i)) === false) {
			continue;
		} // Adapt this line at the top of any loop, passing in the whole string and the current iteration and returning a variable to represent the individual character; purpose is to treat the first part of a surrogate pair as the whole character and then ignore the second part
		lgth++;
	}
	return lgth;
}

function array_diff (arr1) {
	//  discuss at: http://phpjs.org/functions/array_diff/
	// original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// improved by: Sanjoy Roy
	//  revised by: Brett Zamir (http://brett-zamir.me)
	//   example 1: array_diff(['Kevin', 'van', 'Zonneveld'], ['van', 'Zonneveld']);
	//   returns 1: {0:'Kevin'}

	var retArr = {};

	var argl = arguments.length;

	var k1 = '';

	var i = 1;

	var k = '';

	var arr = {};

	arr1keys: for (k1 in arr1) {
		for (i = 1; i < argl; i++) {
			arr = arguments[i];
			for (k in arr) {
				if (arr[k] === arr1[k1]) {
					// If it reaches here, it was found in at least one array, so try next value
					continue arr1keys;
				}
			}
			retArr[k1] = arr1[k1];
		}
	}

	return retArr;
}

function strtotime (text, now) {
	//  discuss at: http://phpjs.org/functions/strtotime/
	//     version: 1109.2016
	// original by: Caio Ariede (http://caioariede.com)
	// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// improved by: Caio Ariede (http://caioariede.com)
	// improved by: A. Matías Quezada (http://amatiasq.com)
	// improved by: preuter
	// improved by: Brett Zamir (http://brett-zamir.me)
	// improved by: Mirko Faber
	//    input by: David
	// bugfixed by: Wagner B. Soares
	// bugfixed by: Artur Tchernychev
	// bugfixed by: Stephan Bösch-Plepelits (http://github.com/plepe)
	//        note: Examples all have a fixed timestamp to prevent tests to fail because of variable time(zones)
	//   example 1: strtotime('+1 day', 1129633200);
	//   returns 1: 1129719600
	//   example 2: strtotime('+1 week 2 days 4 hours 2 seconds', 1129633200);
	//   returns 2: 1130425202
	//   example 3: strtotime('last month', 1129633200);
	//   returns 3: 1127041200
	//   example 4: strtotime('2009-05-04 08:30:00 GMT');
	//   returns 4: 1241425800
	//   example 5: strtotime('2009-05-04 08:30:00+00');
	//   returns 5: 1241425800
	//   example 6: strtotime('2009-05-04 08:30:00+02:00');
	//   returns 6: 1241418600
	//   example 7: strtotime('2009-05-04T08:30:00Z');
	//   returns 7: 1241425800

	var parsed; var match; var today; var year; var date; var days; var ranges; var len; var times; var regex; var i; var fail = false;

	if (!text) {
		return fail;
	}

	// Unecessary spaces
	text = text.replace(/^\s+|\s+$/g, '')
		.replace(/\s{2,}/g, ' ')
		.replace(/[\t\r\n]/g, '')
		.toLowerCase();

	// in contrast to php, js Date.parse function interprets:
	// dates given as yyyy-mm-dd as in timezone: UTC,
	// dates with "." or "-" as MDY instead of DMY
	// dates with two-digit years differently
	// etc...etc...
	// ...therefore we manually parse lots of common date formats
	match = text.match(
		/^(\d{1,4})([\-\.\/\:])(\d{1,2})([\-\.\/\:])(\d{1,4})(?:\s(\d{1,2}):(\d{2})?:?(\d{2})?)?(?:\s([A-Z]+)?)?$/);

	if (match && match[2] === match[4]) {
		if (match[1] > 1901) {
			switch (match[2]) {
				case '-': {
					// YYYY-M-D
					if (match[3] > 12 || match[5] > 31) {
						return fail;
					}

					return new Date(match[1], parseInt(match[3], 10) - 1, match[5],
						match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
				}
				case '.': {
					// YYYY.M.D is not parsed by strtotime()
					return fail;
				}
				case '/': {
					// YYYY/M/D
					if (match[3] > 12 || match[5] > 31) {
						return fail;
					}

					return new Date(match[1], parseInt(match[3], 10) - 1, match[5],
						match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
				}
			}
		} else if (match[5] > 1901) {
			switch (match[2]) {
				case '-': {
					// D-M-YYYY
					if (match[3] > 12 || match[1] > 31) {
						return fail;
					}

					return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
						match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
				}
				case '.': {
					// D.M.YYYY
					if (match[3] > 12 || match[1] > 31) {
						return fail;
					}

					return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
						match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
				}
				case '/': {
					// M/D/YYYY
					if (match[1] > 12 || match[3] > 31) {
						return fail;
					}

					return new Date(match[5], parseInt(match[1], 10) - 1, match[3],
						match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
				}
			}
		} else {
			switch (match[2]) {
				case '-': {
					// YY-M-D
					if (match[3] > 12 || match[5] > 31 || (match[1] < 70 && match[1] > 38)) {
						return fail;
					}

					year = match[1] >= 0 && match[1] <= 38 ? +match[1] + 2000 : match[1];
					return new Date(year, parseInt(match[3], 10) - 1, match[5],
						match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
				}
				case '.': {
					// D.M.YY or H.MM.SS
					if (match[5] >= 70) {
						// D.M.YY
						if (match[3] > 12 || match[1] > 31) {
							return fail;
						}

						return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
							match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
					}
					if (match[5] < 60 && !match[6]) {
						// H.MM.SS
						if (match[1] > 23 || match[3] > 59) {
							return fail;
						}

						today = new Date();
						return new Date(today.getFullYear(), today.getMonth(), today.getDate(),
							match[1] || 0, match[3] || 0, match[5] || 0, match[9] || 0) / 1000;
					}

					// invalid format, cannot be parsed
					return fail;
				}
				case '/': {
					// M/D/YY
					if (match[1] > 12 || match[3] > 31 || (match[5] < 70 && match[5] > 38)) {
						return fail;
					}

					year = match[5] >= 0 && match[5] <= 38 ? +match[5] + 2000 : match[5];
					return new Date(year, parseInt(match[1], 10) - 1, match[3],
						match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
				}
				case ':': {
					// HH:MM:SS
					if (match[1] > 23 || match[3] > 59 || match[5] > 59) {
						return fail;
					}

					today = new Date();
					return new Date(today.getFullYear(), today.getMonth(), today.getDate(),
						match[1] || 0, match[3] || 0, match[5] || 0) / 1000;
				}
			}
		}
	}

	// other formats and "now" should be parsed by Date.parse()
	if (text === 'now') {
		return now === null || isNaN(now) ? new Date()
			.getTime() / 1000 | 0 : now | 0;
	}
	if (!isNaN(parsed = Date.parse(text))) {
		return parsed / 1000 | 0;
	}
	// Browsers != Chrome have problems parsing ISO 8601 date strings, as they do
	// not accept lower case characters, space, or shortened time zones.
	// Therefore, fix these problems and try again.
	// Examples:
	//   2015-04-15 20:33:59+02
	//   2015-04-15 20:33:59z
	//   2015-04-15t20:33:59+02:00
	if (match = text.match(
		/^([0-9]{4}-[0-9]{2}-[0-9]{2})[ t]([0-9]{2}:[0-9]{2}:[0-9]{2}(\.[0-9]+)?)([\+-][0-9]{2}(:[0-9]{2})?|z)/)) {
		// fix time zone information
		if (match[4] == 'z') {
			match[4] = 'Z';
		} else if (match[4].match(/^([\+-][0-9]{2})$/)) {
			match[4] = match[4] + ':00';
		}

		if (!isNaN(parsed = Date.parse(match[1] + 'T' + match[2] + match[4]))) {
			return parsed / 1000 | 0;
		}
	}

	date = now ? new Date(now * 1000) : new Date();
	days = {
		'sun': 0,
		'mon': 1,
		'tue': 2,
		'wed': 3,
		'thu': 4,
		'fri': 5,
		'sat': 6
	};
	ranges = {
		'yea': 'FullYear',
		'mon': 'Month',
		'day': 'Date',
		'hou': 'Hours',
		'min': 'Minutes',
		'sec': 'Seconds'
	};

	function lastNext (type, range, modifier) {
		var diff; var day = days[range];

		if (typeof day !== 'undefined') {
			diff = day - date.getDay();

			if (diff === 0) {
				diff = 7 * modifier;
			} else if (diff > 0 && type === 'last') {
				diff -= 7;
			} else if (diff < 0 && type === 'next') {
				diff += 7;
			}

			date.setDate(date.getDate() + diff);
		}
	}

	function process (val) {
		var splt = val.split(' ');
		// Todo: Reconcile this with regex using \s, taking into account browser issues with split and regexes

		var type = splt[0];

		var range = splt[1].substring(0, 3);

		var typeIsNumber = /\d+/.test(type);

		var ago = splt[2] === 'ago';

		var num = (type === 'last' ? -1 : 1) * (ago ? -1 : 1);

		if (typeIsNumber) {
			num *= parseInt(type, 10);
		}

		if (ranges.hasOwnProperty(range) && !splt[1].match(/^mon(day|\.)?$/i)) {
			return date['set' + ranges[range]](date['get' + ranges[range]]() + num);
		}

		if (range === 'wee') {
			return date.setDate(date.getDate() + (num * 7));
		}

		if (type === 'next' || type === 'last') {
			lastNext(type, range, num);
		} else if (!typeIsNumber) {
			return false;
		}

		return true;
	}

	times = '(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec' +
		'|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?' +
		'|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)';
	regex = '([+-]?\\d+\\s' + times + '|' + '(last|next)\\s' + times + ')(\\sago)?';

	match = text.match(new RegExp(regex, 'gi'));
	if (!match) {
		return fail;
	}

	for (i = 0, len = match.length; i < len; i++) {
		if (!process(match[i])) {
			return fail;
		}
	}

	// ECMAScript 5 only
	// if (!match.every(process))
	//    return false;

	return (date.getTime() / 1000);
}

function is_numeric (mixed_var) {
	//  discuss at: http://phpjs.org/functions/is_numeric/
	// original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// improved by: David
	// improved by: taith
	// bugfixed by: Tim de Koning
	// bugfixed by: WebDevHobo (http://webdevhobo.blogspot.com/)
	// bugfixed by: Brett Zamir (http://brett-zamir.me)
	// bugfixed by: Denis Chenu (http://shnoulle.net)
	//   example 1: is_numeric(186.31);
	//   returns 1: true
	//   example 2: is_numeric('Kevin van Zonneveld');
	//   returns 2: false
	//   example 3: is_numeric(' +186.31e2');
	//   returns 3: true
	//   example 4: is_numeric('');
	//   returns 4: false
	//   example 5: is_numeric([]);
	//   returns 5: false
	//   example 6: is_numeric('1 ');
	//   returns 6: false

	var whitespace =
		' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
	return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) ===
		-1)) && mixed_var !== '' && !isNaN(mixed_var);
}

/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2017
 * @version 1.3.4
 *
 * Date formatter utility library that allows formatting date/time variables or Date objects using PHP DateTime format.
 * This library is a standalone javascript library and does not depend on other libraries or plugins like jQuery.
 *
 * @see http://php.net/manual/en/function.date.php
 *
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */
var DateFormatter;
(function () {
	'use strict';

	var _compare, _lpad, _extend, _indexOf, defaultSettings, DAY, HOUR;
	DAY = 1000 * 60 * 60 * 24;
	HOUR = 3600;

	_compare = function (str1, str2) {
		return typeof (str1) === 'string' && typeof (str2) === 'string' && str1.toLowerCase() === str2.toLowerCase();
	};
	_lpad = function (value, length, chr) {
		var val = value.toString();
		chr = chr || '0';
		return val.length < length ? _lpad(chr + val, length) : val;
	};
	_extend = function (out) {
		var i, obj;
		out = out || {};
		for (i = 1; i < arguments.length; i++) {
			obj = arguments[i];
			if (!obj) {
				continue;
			}
			for (var key in obj) {
				if (obj.hasOwnProperty(key)) {
					if (typeof obj[key] === 'object') {
						_extend(out[key], obj[key]);
					} else {
						out[key] = obj[key];
					}
				}
			}
		}
		return out;
	};
	_indexOf = function (val, arr) {
		for (var i = 0; i < arr.length; i++) {
			if (arr[i].toLowerCase() === val.toLowerCase()) {
				return i;
			}
		}
		return -1;
	};
	defaultSettings = {
		dateSettings: {
			days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
			daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			months: [
				'January', 'February', 'March', 'April', 'May', 'June', 'July',
				'August', 'September', 'October', 'November', 'December'
			],
			monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			meridiem: ['AM', 'PM'],
			ordinal: function (number) {
				var n = number % 10; var suffixes = { 1: 'st', 2: 'nd', 3: 'rd' };
				return Math.floor(number % 100 / 10) === 1 || !suffixes[n] ? 'th' : suffixes[n];
			}
		},
		separators: /[ \-+\/\.T:@]/g,
		validParts: /[dDjlNSwzWFmMntLoYyaABgGhHisueTIOPZcrU]/g,
		intParts: /[djwNzmnyYhHgGis]/g,
		tzParts: /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
		tzClip: /[^-+\dA-Z]/g
	};

	DateFormatter = function (options) {
		var self = this; var config = _extend(defaultSettings, options);
		self.dateSettings = config.dateSettings;
		self.separators = config.separators;
		self.validParts = config.validParts;
		self.intParts = config.intParts;
		self.tzParts = config.tzParts;
		self.tzClip = config.tzClip;
	};

	DateFormatter.prototype = {
		constructor: DateFormatter,
		getMonth: function (val) {
			var self = this; var i;
			i = _indexOf(val, self.dateSettings.monthsShort) + 1;
			if (i === 0) {
				i = _indexOf(val, self.dateSettings.months) + 1;
			}
			return i;
		},
		parseDate: function (vDate, vFormat) {
			var self = this; var vFormatParts; var vDateParts; var i; var vDateFlag = false; var vTimeFlag = false; var vDatePart; var iDatePart;

			var vSettings = self.dateSettings; var vMonth; var vMeriIndex; var vMeriOffset; var len; var mer;

			var out = { date: null, year: null, month: null, day: null, hour: 0, min: 0, sec: 0 };
			if (!vDate) {
				return null;
			}
			if (vDate instanceof Date) {
				return vDate;
			}
			if (vFormat === 'U') {
				i = parseInt(vDate);
				return i ? new Date(i * 1000) : vDate;
			}
			switch (typeof vDate) {
				case 'number':
					return new Date(vDate);
				case 'string':
					break;
				default:
					return null;
			}
			vFormatParts = vFormat.match(self.validParts);
			if (!vFormatParts || vFormatParts.length === 0) {
				throw new Error('Invalid date format definition.');
			}
			vDateParts = vDate.replace(self.separators, '\0').split('\0');
			for (i = 0; i < vDateParts.length; i++) {
				vDatePart = vDateParts[i];
				iDatePart = parseInt(vDatePart);
				switch (vFormatParts[i]) {
					case 'y':
					case 'Y':
						if (iDatePart) {
							len = vDatePart.length;
							out.year = len === 2 ? parseInt((iDatePart < 70 ? '20' : '19') + vDatePart) : iDatePart;
						} else {
							return null;
						}
						vDateFlag = true;
						break;
					case 'm':
					case 'n':
					case 'M':
					case 'F':
						if (isNaN(iDatePart)) {
							vMonth = self.getMonth(vDatePart);
							if (vMonth > 0) {
								out.month = vMonth;
							} else {
								return null;
							}
						} else {
							if (iDatePart >= 1 && iDatePart <= 12) {
								out.month = iDatePart;
							} else {
								return null;
							}
						}
						vDateFlag = true;
						break;
					case 'd':
					case 'j':
						if (iDatePart >= 1 && iDatePart <= 31) {
							out.day = iDatePart;
						} else {
							return null;
						}
						vDateFlag = true;
						break;
					case 'g':
					case 'h':
						vMeriIndex = (vFormatParts.indexOf('a') > -1) ? vFormatParts.indexOf('a')
							: (vFormatParts.indexOf('A') > -1) ? vFormatParts.indexOf('A') : -1;
						mer = vDateParts[vMeriIndex];
						if (vMeriIndex !== -1) {
							vMeriOffset = _compare(mer, vSettings.meridiem[0]) ? 0
								: (_compare(mer, vSettings.meridiem[1]) ? 12 : -1);
							if (iDatePart >= 1 && iDatePart <= 12 && vMeriOffset !== -1) {
								out.hour = iDatePart % 12 === 0 ? vMeriOffset : iDatePart + vMeriOffset;
							} else {
								if (iDatePart >= 0 && iDatePart <= 23) {
									out.hour = iDatePart;
								}
							}
						} else {
							if (iDatePart >= 0 && iDatePart <= 23) {
								out.hour = iDatePart;
							} else {
								return null;
							}
						}
						vTimeFlag = true;
						break;
					case 'G':
					case 'H':
						if (iDatePart >= 0 && iDatePart <= 23) {
							out.hour = iDatePart;
						} else {
							return null;
						}
						vTimeFlag = true;
						break;
					case 'i':
						if (iDatePart >= 0 && iDatePart <= 59) {
							out.min = iDatePart;
						} else {
							return null;
						}
						vTimeFlag = true;
						break;
					case 's':
						if (iDatePart >= 0 && iDatePart <= 59) {
							out.sec = iDatePart;
						} else {
							return null;
						}
						vTimeFlag = true;
						break;
				}
			}
			if (vDateFlag === true && out.year && out.month && out.day) {
				out.date = new Date(out.year, out.month - 1, out.day, out.hour, out.min, out.sec, 0);
			} else {
				if (vTimeFlag !== true) {
					return null;
				}
				out.date = new Date(0, 0, 0, out.hour, out.min, out.sec, 0);
			}
			return out.date;
		},
		guessDate: function (vDateStr, vFormat) {
			if (typeof vDateStr !== 'string') {
				return vDateStr;
			}
			var self = this; var vParts = vDateStr.replace(self.separators, '\0').split('\0'); var vPattern = /^[djmn]/g; var len;

			var vFormatParts = vFormat.match(self.validParts); var vDate = new Date(); var vDigit = 0; var vYear; var i; var n; var iPart; var iSec;

			if (!vPattern.test(vFormatParts[0])) {
				return vDateStr;
			}

			for (i = 0; i < vParts.length; i++) {
				vDigit = 2;
				iPart = vParts[i];
				iSec = parseInt(iPart.substr(0, 2));
				if (isNaN(iSec)) {
					return null;
				}
				switch (i) {
					case 0:
						if (vFormatParts[0] === 'm' || vFormatParts[0] === 'n') {
							vDate.setMonth(iSec - 1);
						} else {
							vDate.setDate(iSec);
						}
						break;
					case 1:
						if (vFormatParts[0] === 'm' || vFormatParts[0] === 'n') {
							vDate.setDate(iSec);
						} else {
							vDate.setMonth(iSec - 1);
						}
						break;
					case 2:
						vYear = vDate.getFullYear();
						len = iPart.length;
						vDigit = len < 4 ? len : 4;
						vYear = parseInt(len < 4 ? vYear.toString().substr(0, 4 - len) + iPart : iPart.substr(0, 4));
						if (!vYear) {
							return null;
						}
						vDate.setFullYear(vYear);
						break;
					case 3:
						vDate.setHours(iSec);
						break;
					case 4:
						vDate.setMinutes(iSec);
						break;
					case 5:
						vDate.setSeconds(iSec);
						break;
				}
				n = iPart.substr(vDigit);
				if (n.length > 0) {
					vParts.splice(i + 1, 0, n);
				}
			}
			return vDate;
		},
		parseFormat: function (vChar, vDate) {
			var self = this; var vSettings = self.dateSettings; var fmt; var backslash = /\\?(.?)/gi; var doFormat = function (t, s) {
				return fmt[t] ? fmt[t]() : s;
			};
			fmt = {
				/// //////
				// DAY //
				/// //////
				/**
				 * Day of month with leading 0: `01..31`
				 * @return {string}
				 */
				d: function () {
					return _lpad(fmt.j(), 2);
				},
				/**
				 * Shorthand day name: `Mon...Sun`
				 * @return {string}
				 */
				D: function () {
					return vSettings.daysShort[fmt.w()];
				},
				/**
				 * Day of month: `1..31`
				 * @return {number}
				 */
				j: function () {
					return vDate.getDate();
				},
				/**
				 * Full day name: `Monday...Sunday`
				 * @return {number}
				 */
				l: function () {
					return vSettings.days[fmt.w()];
				},
				/**
				 * ISO-8601 day of week: `1[Mon]..7[Sun]`
				 * @return {number}
				 */
				N: function () {
					return fmt.w() || 7;
				},
				/**
				 * Day of week: `0[Sun]..6[Sat]`
				 * @return {number}
				 */
				w: function () {
					return vDate.getDay();
				},
				/**
				 * Day of year: `0..365`
				 * @return {number}
				 */
				z: function () {
					var a = new Date(fmt.Y(), fmt.n() - 1, fmt.j()); var b = new Date(fmt.Y(), 0, 1);
					return Math.round((a - b) / DAY);
				},

				/// ///////
				// WEEK //
				/// ///////
				/**
				 * ISO-8601 week number
				 * @return {number}
				 */
				W: function () {
					var a = new Date(fmt.Y(), fmt.n() - 1, fmt.j() - fmt.N() + 3); var b = new Date(a.getFullYear(), 0, 4);
					return _lpad(1 + Math.round((a - b) / DAY / 7), 2);
				},

				/// ////////
				// MONTH //
				/// ////////
				/**
				 * Full month name: `January...December`
				 * @return {string}
				 */
				F: function () {
					return vSettings.months[vDate.getMonth()];
				},
				/**
				 * Month w/leading 0: `01..12`
				 * @return {string}
				 */
				m: function () {
					return _lpad(fmt.n(), 2);
				},
				/**
				 * Shorthand month name; `Jan...Dec`
				 * @return {string}
				 */
				M: function () {
					return vSettings.monthsShort[vDate.getMonth()];
				},
				/**
				 * Month: `1...12`
				 * @return {number}
				 */
				n: function () {
					return vDate.getMonth() + 1;
				},
				/**
				 * Days in month: `28...31`
				 * @return {number}
				 */
				t: function () {
					return (new Date(fmt.Y(), fmt.n(), 0)).getDate();
				},

				/// ///////
				// YEAR //
				/// ///////
				/**
				 * Is leap year? `0 or 1`
				 * @return {number}
				 */
				L: function () {
					var Y = fmt.Y();
					return (Y % 4 === 0 && Y % 100 !== 0 || Y % 400 === 0) ? 1 : 0;
				},
				/**
				 * ISO-8601 year
				 * @return {number}
				 */
				o: function () {
					var n = fmt.n(); var W = fmt.W(); var Y = fmt.Y();
					return Y + (n === 12 && W < 9 ? 1 : n === 1 && W > 9 ? -1 : 0);
				},
				/**
				 * Full year: `e.g. 1980...2010`
				 * @return {number}
				 */
				Y: function () {
					return vDate.getFullYear();
				},
				/**
				 * Last two digits of year: `00...99`
				 * @return {string}
				 */
				y: function () {
					return fmt.Y().toString().slice(-2);
				},

				/// ///////
				// TIME //
				/// ///////
				/**
				 * Meridian lower: `am or pm`
				 * @return {string}
				 */
				a: function () {
					return fmt.A().toLowerCase();
				},
				/**
				 * Meridian upper: `AM or PM`
				 * @return {string}
				 */
				A: function () {
					var n = fmt.G() < 12 ? 0 : 1;
					return vSettings.meridiem[n];
				},
				/**
				 * Swatch Internet time: `000..999`
				 * @return {string}
				 */
				B: function () {
					var H = vDate.getUTCHours() * HOUR; var i = vDate.getUTCMinutes() * 60; var s = vDate.getUTCSeconds();
					return _lpad(Math.floor((H + i + s + HOUR) / 86.4) % 1000, 3);
				},
				/**
				 * 12-Hours: `1..12`
				 * @return {number}
				 */
				g: function () {
					return fmt.G() % 12 || 12;
				},
				/**
				 * 24-Hours: `0..23`
				 * @return {number}
				 */
				G: function () {
					return vDate.getHours();
				},
				/**
				 * 12-Hours with leading 0: `01..12`
				 * @return {string}
				 */
				h: function () {
					return _lpad(fmt.g(), 2);
				},
				/**
				 * 24-Hours w/leading 0: `00..23`
				 * @return {string}
				 */
				H: function () {
					return _lpad(fmt.G(), 2);
				},
				/**
				 * Minutes w/leading 0: `00..59`
				 * @return {string}
				 */
				i: function () {
					return _lpad(vDate.getMinutes(), 2);
				},
				/**
				 * Seconds w/leading 0: `00..59`
				 * @return {string}
				 */
				s: function () {
					return _lpad(vDate.getSeconds(), 2);
				},
				/**
				 * Microseconds: `000000-999000`
				 * @return {string}
				 */
				u: function () {
					return _lpad(vDate.getMilliseconds() * 1000, 6);
				},

				/// ///////////
				// TIMEZONE //
				/// ///////////
				/**
				 * Timezone identifier: `e.g. Atlantic/Azores, ...`
				 * @return {string}
				 */
				e: function () {
					var str = /\((.*)\)/.exec(String(vDate))[1];
					return str || 'Coordinated Universal Time';
				},
				/**
				 * DST observed? `0 or 1`
				 * @return {number}
				 */
				I: function () {
					var a = new Date(fmt.Y(), 0); var c = Date.UTC(fmt.Y(), 0);

					var b = new Date(fmt.Y(), 6); var d = Date.UTC(fmt.Y(), 6);
					return ((a - c) !== (b - d)) ? 1 : 0;
				},
				/**
				 * Difference to GMT in hour format: `e.g. +0200`
				 * @return {string}
				 */
				O: function () {
					var tzo = vDate.getTimezoneOffset(); var a = Math.abs(tzo);
					return (tzo > 0 ? '-' : '+') + _lpad(Math.floor(a / 60) * 100 + a % 60, 4);
				},
				/**
				 * Difference to GMT with colon: `e.g. +02:00`
				 * @return {string}
				 */
				P: function () {
					var O = fmt.O();
					return (O.substr(0, 3) + ':' + O.substr(3, 2));
				},
				/**
				 * Timezone abbreviation: `e.g. EST, MDT, ...`
				 * @return {string}
				 */
				T: function () {
					var str = (String(vDate).match(self.tzParts) || ['']).pop().replace(self.tzClip, '');
					return str || 'UTC';
				},
				/**
				 * Timezone offset in seconds: `-43200...50400`
				 * @return {number}
				 */
				Z: function () {
					return -vDate.getTimezoneOffset() * 60;
				},

				/// /////////////////
				// FULL DATE TIME //
				/// /////////////////
				/**
				 * ISO-8601 date
				 * @return {string}
				 */
				c: function () {
					return 'Y-m-d\\TH:i:sP'.replace(backslash, doFormat);
				},
				/**
				 * RFC 2822 date
				 * @return {string}
				 */
				r: function () {
					return 'D, d M Y H:i:s O'.replace(backslash, doFormat);
				},
				/**
				 * Seconds since UNIX epoch
				 * @return {number}
				 */
				U: function () {
					return vDate.getTime() / 1000 || 0;
				}
			};
			return doFormat(vChar, vChar);
		},
		formatDate: function (vDate, vFormat) {
			var self = this; var i; var n; var len; var str; var vChar; var vDateStr = ''; var BACKSLASH = '\\';
			if (typeof vDate === 'string') {
				vDate = self.parseDate(vDate, vFormat);
				if (!vDate) {
					return null;
				}
			}
			if (vDate instanceof Date) {
				len = vFormat.length;
				for (i = 0; i < len; i++) {
					vChar = vFormat.charAt(i);
					if (vChar === 'S' || vChar === BACKSLASH) {
						continue;
					}
					if (i > 0 && vFormat.charAt(i - 1) === BACKSLASH) {
						vDateStr += vChar;
						continue;
					}
					str = self.parseFormat(vChar, vDate);
					if (i !== (len - 1) && self.intParts.test(vChar) && vFormat.charAt(i + 1) === 'S') {
						n = parseInt(str) || 0;
						str += self.dateSettings.ordinal(n);
					}
					vDateStr += str;
				}
				return vDateStr;
			}
			return '';
		}
	};
})();
/*!
 * Laravel Javascript Validation
 *
 * https://github.com/proengsoft/laravel-jsvalidation
 *
 * Copyright (c) 2017 Proengsoft
 * Released under the MIT license
 */

var laravelValidation;
laravelValidation = {

	implicitRules: ['Required', 'Confirmed'],

	/**
	 * Initialize laravel validations.
	 */
	init: function () {
		// Disable class rules and attribute rules
		$.validator.classRuleSettings = {};
		$.validator.attributeRules = function () {
			this.rules = {};
		};

		$.validator.dataRules = this.arrayRules;
		$.validator.prototype.arrayRulesCache = {};
		// Register validations methods
		this.setupValidations();
	},

	arrayRules: function (element) {
		var rules = {};

		var validator = $.data(element.form, 'validator');

		var cache = validator.arrayRulesCache;

		// Is not an Array
		if (element.name.indexOf('[') === -1) {
			return rules;
		}

		if (!(element.name in cache)) {
			cache[element.name] = {};
		}

		$.each(validator.settings.rules, function (name, tmpRules) {
			if (name in cache[element.name]) {
				$.extend(rules, cache[element.name][name]);
			} else {
				cache[element.name][name] = {};
				var nameRegExp = laravelValidation.helpers.regexFromWildcard(name);
				if (element.name.match(nameRegExp)) {
					var newRules = $.validator.normalizeRule(tmpRules) || {};
					cache[element.name][name] = newRules;
					$.extend(rules, newRules);
				}
			}
		});

		return rules;
	},

	setupValidations: function () {
		/**
		 * Create JQueryValidation check to validate Laravel rules.
		 */

		$.validator.addMethod('laravelValidation', function (value, element, params) {
			var validator = this;
			var validated = true;
			var previous = this.previousValue(element);

			// put Implicit rules in front
			var rules = [];
			$.each(params, function (i, param) {
				if (param[3] || laravelValidation.implicitRules.indexOf(param[0]) !== -1) {
					rules.unshift(param);
				} else {
					rules.push(param);
				}
			});

			$.each(rules, function (i, param) {
				var implicit = param[3] || laravelValidation.implicitRules.indexOf(param[0]) !== -1;
				var rule = param[0];
				var message = param[2];

				if (!implicit && validator.optional(element)) {
					validated = 'dependency-mismatch';
					return false;
				}

				if (laravelValidation.methods[rule] !== undefined) {
					validated = laravelValidation.methods[rule].call(validator, value, element, param[1], function (valid) {
						validator.settings.messages[element.name].laravelValidationRemote = previous.originalMessage;
						if (valid) {
							var submitted = validator.formSubmitted;
							validator.prepareElement(element);
							validator.formSubmitted = submitted;
							validator.successList.push(element);
							delete validator.invalid[element.name];
							validator.showErrors();
						} else {
							var errors = {};
							errors[element.name] = previous.message = $.isFunction(message) ? message(value) : message;
							validator.invalid[element.name] = true;
							validator.showErrors(errors);
						}
						validator.showErrors(validator.errorMap);
						previous.valid = valid;
					});
				} else {
					validated = false;
				}

				if (validated !== true) {
					if (!validator.settings.messages[element.name]) {
						validator.settings.messages[element.name] = {};
					}
					validator.settings.messages[element.name].laravelValidation = message;
					return false;
				}
			});
			return validated;
		}, '');

		/**
		 * Create JQueryValidation check to validate Remote Laravel rules.
		 */
		$.validator.addMethod('laravelValidationRemote', function (value, element, params) {
			var implicit = false;

			var check = params[0][1];

			var attribute = element.name;

			var token = check[1];

			var validateAll = check[2];

			$.each(params, function (i, parameters) {
				implicit = implicit || parameters[3];
			});

			if (!implicit && this.optional(element)) {
				return 'dependency-mismatch';
			}

			var previous = this.previousValue(element);

			var validator; var data;

			if (!this.settings.messages[element.name]) {
				this.settings.messages[element.name] = {};
			}
			previous.originalMessage = this.settings.messages[element.name].laravelValidationRemote;
			this.settings.messages[element.name].laravelValidationRemote = previous.message;

			var param = typeof param === 'string' && { url: param } || param;

			if (previous.old === value) {
				return previous.valid;
			}

			previous.old = value;
			validator = this;
			this.startRequest(element);

			data = $(validator.currentForm).serializeArray();

			data.push({
				'name': '_jsvalidation',
				'value': attribute
			});

			data.push({
				'name': '_jsvalidation_validate_all',
				'value': validateAll
			});

			var formMethod = $(validator.currentForm).attr('method');
			if ($(validator.currentForm).find('input[name="_method"]').length) {
				formMethod = $(validator.currentForm).find('input[name="_method"]').val();
			}

			$.ajax($.extend(true, {
				mode: 'abort',
				port: 'validate' + element.name,
				dataType: 'json',
				data: data,
				context: validator.currentForm,
				url: $(validator.currentForm).attr('action'),
				type: formMethod,

				beforeSend: function (xhr) {
					if ($(validator.currentForm).attr('method').toLowerCase() !== 'get' && token) {
						return xhr.setRequestHeader('X-XSRF-TOKEN', token);
					}
				}
			}, param)
			).always(function (response, textStatus) {
				var errors, message, submitted, valid;

				if (textStatus === 'error') {
					valid = false;
					response = laravelValidation.helpers.parseErrorResponse(response);
				} else if (textStatus === 'success') {
					valid = response === true || response === 'true';
				} else {
					return;
				}

				validator.settings.messages[element.name].laravelValidationRemote = previous.originalMessage;

				if (valid) {
					submitted = validator.formSubmitted;
					validator.prepareElement(element);
					validator.formSubmitted = submitted;
					validator.successList.push(element);
					delete validator.invalid[element.name];
					validator.showErrors();
				} else {
					errors = {};
					message = response || validator.defaultMessage(element, 'remote');
					errors[element.name] = previous.message = $.isFunction(message) ? message(value) : message[0];
					validator.invalid[element.name] = true;
					validator.showErrors(errors);
				}
				validator.showErrors(validator.errorMap);
				previous.valid = valid;
				validator.stopRequest(element, valid);
			}
			);
			return 'pending';
		}, '');
	}
};

$(function () {
	laravelValidation.init();
});

/*!
 * Laravel Javascript Validation
 *
 * https://github.com/proengsoft/laravel-jsvalidation
 *
 * Helper functions used by validators
 *
 * Copyright (c) 2017 Proengsoft
 * Released under the MIT license
 */

$.extend(true, laravelValidation, {

	helpers: {

		/**
		 * Numeric rules
		 */
		numericRules: ['Integer', 'Numeric'],

		/**
		 * Gets the file information from file input.
		 *
		 * @param fieldObj
		 * @param index
		 * @returns {{file: *, extension: string, size: number}}
		 */
		fileinfo: function (fieldObj, index) {
			var FileName = fieldObj.value;
			index = typeof index !== 'undefined' ? index : 0;
			if (fieldObj.files !== null) {
				if (typeof fieldObj.files[index] !== 'undefined') {
					return {
						file: FileName,
						extension: FileName.substr(FileName.lastIndexOf('.') + 1),
						size: fieldObj.files[index].size / 1024,
						type: fieldObj.files[index].type
					};
				}
			}
			return false;
		},

		/**
		 * Gets the selectors for th specified field names.
		 *
		 * @param names
		 * @returns {string}
		 */
		selector: function (names) {
			var selector = [];
			if (!$.isArray(names)) {
				names = [names];
			}
			for (var i = 0; i < names.length; i++) {
				selector.push('[name=\'' + names[i] + '\']');
			}
			return selector.join();
		},

		/**
		 * Check if element has numeric rules.
		 *
		 * @param element
		 * @returns {boolean}
		 */
		hasNumericRules: function (element) {
			return this.hasRules(element, this.numericRules);
		},

		/**
		 * Check if element has passed rules.
		 *
		 * @param element
		 * @param rules
		 * @returns {boolean}
		 */
		hasRules: function (element, rules) {
			var found = false;
			if (typeof rules === 'string') {
				rules = [rules];
			}

			var validator = $.data(element.form, 'validator');
			var listRules = [];
			var cache = validator.arrayRulesCache;
			if (element.name in cache) {
				$.each(cache[element.name], function (index, arrayRule) {
					listRules.push(arrayRule);
				});
			}
			if (element.name in validator.settings.rules) {
				listRules.push(validator.settings.rules[element.name]);
			}
			$.each(listRules, function (index, objRules) {
				if ('laravelValidation' in objRules) {
					var _rules = objRules.laravelValidation;
					for (var i = 0; i < _rules.length; i++) {
						if ($.inArray(_rules[i][0], rules) !== -1) {
							found = true;
							return false;
						}
					}
				}
			});

			return found;
		},

		/**
		 * Return the string length using PHP function.
		 * http://php.net/manual/en/function.strlen.php
		 * http://phpjs.org/functions/strlen/
		 *
		 * @param string
		 */
		strlen: function (string) {
			return strlen(string);
		},

		/**
		 * Get the size of the object depending of his type.
		 *
		 * @param obj
		 * @param element
		 * @param value
		 * @returns int
		 */
		getSize: function getSize (obj, element, value) {
			if (this.hasNumericRules(element) && this.is_numeric(value)) {
				return parseFloat(value);
			} else if ($.isArray(value)) {
				return parseFloat(value.length);
			} else if (element.type === 'file') {
				return parseFloat(Math.floor(this.fileinfo(element).size));
			}

			return parseFloat(this.strlen(value));
		},

		/**
		 * Return specified rule from element.
		 *
		 * @param rule
		 * @param element
		 * @returns object
		 */
		getLaravelValidation: function (rule, element) {
			var found = undefined;
			$.each($.validator.staticRules(element), function (key, rules) {
				if (key === 'laravelValidation') {
					$.each(rules, function (i, value) {
						if (value[0] === rule) {
							found = value;
						}
					});
				}
			});

			return found;
		},

		/**
		 * Return he timestamp of value passed using format or default format in element.
		 *
		 * @param value
		 * @param format
		 * @returns {boolean|int}
		 */
		parseTime: function (value, format) {
			var timeValue = false;
			var fmt = new DateFormatter();

			if ($.type(format) === 'object') {
				var dateRule = this.getLaravelValidation('DateFormat', format);
				if (dateRule !== undefined) {
					format = dateRule[1][0];
				} else {
					format = null;
				}
			}

			if (format == null) {
				timeValue = this.strtotime(value);
			} else {
				timeValue = fmt.parseDate(value, format);
				if (timeValue) {
					timeValue = Math.round((timeValue.getTime() / 1000));
				}
			}

			return timeValue;
		},

		/**
		 * This method allows you to intelligently guess the date by closely matching the specific format.
		 *
		 * @param value
		 * @param format
		 * @returns {Date}
		 */
		guessDate: function (value, format) {
			var fmt = new DateFormatter();
			return fmt.guessDate(value, format);
		},

		/**
		 * Returns Unix timestamp based on PHP function strototime.
		 * http://php.net/manual/es/function.strtotime.php
		 * http://phpjs.org/functions/strtotime/
		 *
		 * @param text
		 * @param now
		 * @returns {*}
		 */
		strtotime: function (text, now) {
			return strtotime(text, now);
		},

		/**
		 * Returns if value is numeric.
		 * http://php.net/manual/es/var.is_numeric.php
		 * http://phpjs.org/functions/is_numeric/
		 *
		 * @param mixed_var
		 * @returns {*}
		 */
		is_numeric: function (mixed_var) {
			return is_numeric(mixed_var);
		},

		/**
		 * Returns Array diff based on PHP function array_diff.
		 * http://php.net/manual/es/function.array_diff.php
		 * http://phpjs.org/functions/array_diff/
		 *
		 * @param arr1
		 * @param arr2
		 * @returns {*}
		 */
		arrayDiff: function (arr1, arr2) {
			return array_diff(arr1, arr2);
		},

		/**
		 * Makes element dependant from other.
		 *
		 * @param validator
		 * @param element
		 * @param name
		 * @returns {*}
		 */
		dependentElement: function (validator, element, name) {
			var el = validator.findByName(name);

			if (el[0] !== undefined && validator.settings.onfocusout) {
				var event = 'blur';
				if (el[0].tagName === 'SELECT' ||
					el[0].tagName === 'OPTION' ||
					el[0].type === 'checkbox' ||
					el[0].type === 'radio'
				) {
					event = 'click';
				}

				var ruleName = '.validate-laravelValidation';
				el.off(ruleName)
					.off(event + ruleName + '-' + element.name)
					.on(event + ruleName + '-' + element.name, function () {
						$(element).valid();
					});
			}

			return el[0];
		},

		/**
		 * Parses error Ajax response and gets the message.
		 *
		 * @param response
		 * @returns {string[]}
		 */
		parseErrorResponse: function (response) {
			var newResponse = ['Whoops, looks like something went wrong.'];
			if ('responseText' in response) {
				var errorMsg = response.responseText.match(/<h1\s*>(.*)<\/h1\s*>/i);
				if ($.isArray(errorMsg)) {
					newResponse = [errorMsg[1]];
				}
			}
			return newResponse;
		},

		/**
		 * Escape string to use as Regular Expression.
		 *
		 * @param str
		 * @returns string
		 */
		escapeRegExp: function (str) {
			return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, '\\$&');
		},

		/**
		 * Generate RegExp from wildcard attributes.
		 *
		 * @param name
		 * @returns {RegExp}
		 */
		regexFromWildcard: function (name) {
			var nameParts = name.split('[*]');
			if (nameParts.length === 1) {
				nameParts.push('');
			}
			var regexpParts = nameParts.map(function (currentValue, index) {
				if (index % 2 === 0) {
					currentValue = currentValue + '[';
				} else {
					currentValue = ']' + currentValue;
				}

				return laravelValidation.helpers.escapeRegExp(currentValue);
			});

			return new RegExp('^' + regexpParts.join('.*') + '$');
		}
	}
});

/*!
 * Laravel Javascript Validation
 *
 * https://github.com/proengsoft/laravel-jsvalidation
 *
 * Timezone Helper functions used by validators
 *
 * Copyright (c) 2017 Proengsoft
 * Released under the MIT license
 */

$.extend(true, laravelValidation, {

	helpers: {

		/**
		 * Check if the specified timezone is valid.
		 *
		 * @param value
		 * @returns {boolean}
		 */
		isTimezone: function (value) {
			var timezones = {
				'africa': [
					'abidjan',
					'accra',
					'addis_ababa',
					'algiers',
					'asmara',
					'bamako',
					'bangui',
					'banjul',
					'bissau',
					'blantyre',
					'brazzaville',
					'bujumbura',
					'cairo',
					'casablanca',
					'ceuta',
					'conakry',
					'dakar',
					'dar_es_salaam',
					'djibouti',
					'douala',
					'el_aaiun',
					'freetown',
					'gaborone',
					'harare',
					'johannesburg',
					'juba',
					'kampala',
					'khartoum',
					'kigali',
					'kinshasa',
					'lagos',
					'libreville',
					'lome',
					'luanda',
					'lubumbashi',
					'lusaka',
					'malabo',
					'maputo',
					'maseru',
					'mbabane',
					'mogadishu',
					'monrovia',
					'nairobi',
					'ndjamena',
					'niamey',
					'nouakchott',
					'ouagadougou',
					'porto-novo',
					'sao_tome',
					'tripoli',
					'tunis',
					'windhoek'
				],
				'america': [
					'adak',
					'anchorage',
					'anguilla',
					'antigua',
					'araguaina',
					'argentina\/buenos_aires',
					'argentina\/catamarca',
					'argentina\/cordoba',
					'argentina\/jujuy',
					'argentina\/la_rioja',
					'argentina\/mendoza',
					'argentina\/rio_gallegos',
					'argentina\/salta',
					'argentina\/san_juan',
					'argentina\/san_luis',
					'argentina\/tucuman',
					'argentina\/ushuaia',
					'aruba',
					'asuncion',
					'atikokan',
					'bahia',
					'bahia_banderas',
					'barbados',
					'belem',
					'belize',
					'blanc-sablon',
					'boa_vista',
					'bogota',
					'boise',
					'cambridge_bay',
					'campo_grande',
					'cancun',
					'caracas',
					'cayenne',
					'cayman',
					'chicago',
					'chihuahua',
					'costa_rica',
					'creston',
					'cuiaba',
					'curacao',
					'danmarkshavn',
					'dawson',
					'dawson_creek',
					'denver',
					'detroit',
					'dominica',
					'edmonton',
					'eirunepe',
					'el_salvador',
					'fortaleza',
					'glace_bay',
					'godthab',
					'goose_bay',
					'grand_turk',
					'grenada',
					'guadeloupe',
					'guatemala',
					'guayaquil',
					'guyana',
					'halifax',
					'havana',
					'hermosillo',
					'indiana\/indianapolis',
					'indiana\/knox',
					'indiana\/marengo',
					'indiana\/petersburg',
					'indiana\/tell_city',
					'indiana\/vevay',
					'indiana\/vincennes',
					'indiana\/winamac',
					'inuvik',
					'iqaluit',
					'jamaica',
					'juneau',
					'kentucky\/louisville',
					'kentucky\/monticello',
					'kralendijk',
					'la_paz',
					'lima',
					'los_angeles',
					'lower_princes',
					'maceio',
					'managua',
					'manaus',
					'marigot',
					'martinique',
					'matamoros',
					'mazatlan',
					'menominee',
					'merida',
					'metlakatla',
					'mexico_city',
					'miquelon',
					'moncton',
					'monterrey',
					'montevideo',
					'montreal',
					'montserrat',
					'nassau',
					'new_york',
					'nipigon',
					'nome',
					'noronha',
					'north_dakota\/beulah',
					'north_dakota\/center',
					'north_dakota\/new_salem',
					'ojinaga',
					'panama',
					'pangnirtung',
					'paramaribo',
					'phoenix',
					'port-au-prince',
					'port_of_spain',
					'porto_velho',
					'puerto_rico',
					'rainy_river',
					'rankin_inlet',
					'recife',
					'regina',
					'resolute',
					'rio_branco',
					'santa_isabel',
					'santarem',
					'santiago',
					'santo_domingo',
					'sao_paulo',
					'scoresbysund',
					'shiprock',
					'sitka',
					'st_barthelemy',
					'st_johns',
					'st_kitts',
					'st_lucia',
					'st_thomas',
					'st_vincent',
					'swift_current',
					'tegucigalpa',
					'thule',
					'thunder_bay',
					'tijuana',
					'toronto',
					'tortola',
					'vancouver',
					'whitehorse',
					'winnipeg',
					'yakutat',
					'yellowknife'
				],
				'antarctica': [
					'casey',
					'davis',
					'dumontdurville',
					'macquarie',
					'mawson',
					'mcmurdo',
					'palmer',
					'rothera',
					'south_pole',
					'syowa',
					'vostok'
				],
				'arctic': [
					'longyearbyen'
				],
				'asia': [
					'aden',
					'almaty',
					'amman',
					'anadyr',
					'aqtau',
					'aqtobe',
					'ashgabat',
					'baghdad',
					'bahrain',
					'baku',
					'bangkok',
					'beirut',
					'bishkek',
					'brunei',
					'choibalsan',
					'chongqing',
					'colombo',
					'damascus',
					'dhaka',
					'dili',
					'dubai',
					'dushanbe',
					'gaza',
					'harbin',
					'hebron',
					'ho_chi_minh',
					'hong_kong',
					'hovd',
					'irkutsk',
					'jakarta',
					'jayapura',
					'jerusalem',
					'kabul',
					'kamchatka',
					'karachi',
					'kashgar',
					'kathmandu',
					'khandyga',
					'kolkata',
					'krasnoyarsk',
					'kuala_lumpur',
					'kuching',
					'kuwait',
					'macau',
					'magadan',
					'makassar',
					'manila',
					'muscat',
					'nicosia',
					'novokuznetsk',
					'novosibirsk',
					'omsk',
					'oral',
					'phnom_penh',
					'pontianak',
					'pyongyang',
					'qatar',
					'qyzylorda',
					'rangoon',
					'riyadh',
					'sakhalin',
					'samarkand',
					'seoul',
					'shanghai',
					'singapore',
					'taipei',
					'tashkent',
					'tbilisi',
					'tehran',
					'thimphu',
					'tokyo',
					'ulaanbaatar',
					'urumqi',
					'ust-nera',
					'vientiane',
					'vladivostok',
					'yakutsk',
					'yekaterinburg',
					'yerevan'
				],
				'atlantic': [
					'azores',
					'bermuda',
					'canary',
					'cape_verde',
					'faroe',
					'madeira',
					'reykjavik',
					'south_georgia',
					'st_helena',
					'stanley'
				],
				'australia': [
					'adelaide',
					'brisbane',
					'broken_hill',
					'currie',
					'darwin',
					'eucla',
					'hobart',
					'lindeman',
					'lord_howe',
					'melbourne',
					'perth',
					'sydney'
				],
				'europe': [
					'amsterdam',
					'andorra',
					'athens',
					'belgrade',
					'berlin',
					'bratislava',
					'brussels',
					'bucharest',
					'budapest',
					'busingen',
					'chisinau',
					'copenhagen',
					'dublin',
					'gibraltar',
					'guernsey',
					'helsinki',
					'isle_of_man',
					'istanbul',
					'jersey',
					'kaliningrad',
					'kiev',
					'lisbon',
					'ljubljana',
					'london',
					'luxembourg',
					'madrid',
					'malta',
					'mariehamn',
					'minsk',
					'monaco',
					'moscow',
					'oslo',
					'paris',
					'podgorica',
					'prague',
					'riga',
					'rome',
					'samara',
					'san_marino',
					'sarajevo',
					'simferopol',
					'skopje',
					'sofia',
					'stockholm',
					'tallinn',
					'tirane',
					'uzhgorod',
					'vaduz',
					'vatican',
					'vienna',
					'vilnius',
					'volgograd',
					'warsaw',
					'zagreb',
					'zaporozhye',
					'zurich'
				],
				'indian': [
					'antananarivo',
					'chagos',
					'christmas',
					'cocos',
					'comoro',
					'kerguelen',
					'mahe',
					'maldives',
					'mauritius',
					'mayotte',
					'reunion'
				],
				'pacific': [
					'apia',
					'auckland',
					'chatham',
					'chuuk',
					'easter',
					'efate',
					'enderbury',
					'fakaofo',
					'fiji',
					'funafuti',
					'galapagos',
					'gambier',
					'guadalcanal',
					'guam',
					'honolulu',
					'johnston',
					'kiritimati',
					'kosrae',
					'kwajalein',
					'majuro',
					'marquesas',
					'midway',
					'nauru',
					'niue',
					'norfolk',
					'noumea',
					'pago_pago',
					'palau',
					'pitcairn',
					'pohnpei',
					'port_moresby',
					'rarotonga',
					'saipan',
					'tahiti',
					'tarawa',
					'tongatapu',
					'wake',
					'wallis'
				],
				'utc': [
					''
				]
			};

			var tzparts = value.split('/', 2);
			var continent = tzparts[0].toLowerCase();
			var city = '';
			if (tzparts[1]) {
				city = tzparts[1].toLowerCase();
			}

			return (continent in timezones && (timezones[continent].length === 0 || timezones[continent].indexOf(city) !== -1));
		}
	}
});

/*!
 * Laravel Javascript Validation
 *
 * https://github.com/proengsoft/laravel-jsvalidation
 *
 * Methods that implement Laravel Validations
 *
 * Copyright (c) 2017 Proengsoft
 * Released under the MIT license
 */

$.extend(true, laravelValidation, {

	methods: {

		helpers: laravelValidation.helpers,

		jsRemoteTimer: 0,

		/**
		 * "Validate" optional attributes.
		 * Always returns true, just lets us put sometimes in rules.
		 *
		 * @return {boolean}
		 */
		Sometimes: function () {
			return true;
		},

		/**
		 * Bail This is the default behaivour os JSValidation.
		 * Always returns true, just lets us put sometimes in rules.
		 *
		 * @return {boolean}
		 */
		Bail: function () {
			return true;
		},

		/**
		 * "Indicate" validation should pass if value is null.
		 * Always returns true, just lets us put "nullable" in rules.
		 *
		 * @return {boolean}
		 */
		Nullable: function () {
			return true;
		},

		/**
		 * Validate the given attribute is filled if it is present.
		 */
		Filled: function (value, element) {
			return $.validator.methods.required.call(this, value, element, true);
		},

		/**
		 * Validate that a required attribute exists.
		 */
		Required: function (value, element) {
			return $.validator.methods.required.call(this, value, element);
		},

		/**
		 * Validate that an attribute exists when any other attribute exists.
		 *
		 * @return {boolean}
		 */
		RequiredWith: function (value, element, params) {
			var validator = this;

			var required = false;
			var currentObject = this;

			$.each(params, function (i, param) {
				var target = laravelValidation.helpers.dependentElement(
					currentObject, element, param
				);
				required = required || (
					target !== undefined &&
					$.validator.methods.required.call(
						validator,
						currentObject.elementValue(target),
						target, true
					));
			});

			if (required) {
				return $.validator.methods.required.call(this, value, element, true);
			}
			return true;
		},

		/**
		 * Validate that an attribute exists when all other attribute exists.
		 *
		 * @return {boolean}
		 */
		RequiredWithAll: function (value, element, params) {
			var validator = this;

			var required = true;
			var currentObject = this;

			$.each(params, function (i, param) {
				var target = laravelValidation.helpers.dependentElement(
					currentObject, element, param
				);
				required = required && (
					target !== undefined &&
					$.validator.methods.required.call(
						validator,
						currentObject.elementValue(target),
						target, true
					));
			});

			if (required) {
				return $.validator.methods.required.call(this, value, element, true);
			}
			return true;
		},

		/**
		 * Validate that an attribute exists when any other attribute does not exists.
		 *
		 * @return {boolean}
		 */
		RequiredWithout: function (value, element, params) {
			var validator = this;

			var required = false;
			var currentObject = this;

			$.each(params, function (i, param) {
				var target = laravelValidation.helpers.dependentElement(
					currentObject, element, param
				);
				required = required ||
					target === undefined ||
					!$.validator.methods.required.call(
						validator,
						currentObject.elementValue(target),
						target, true
					);
			});

			if (required) {
				return $.validator.methods.required.call(this, value, element, true);
			}
			return true;
		},

		/**
		 * Validate that an attribute exists when all other attribute does not exists.
		 *
		 * @return {boolean}
		 */
		RequiredWithoutAll: function (value, element, params) {
			var validator = this;

			var required = true;

			var currentObject = this;

			$.each(params, function (i, param) {
				var target = laravelValidation.helpers.dependentElement(
					currentObject, element, param
				);
				required = required && (
					target === undefined ||
					!$.validator.methods.required.call(
						validator,
						currentObject.elementValue(target),
						target, true
					));
			});

			if (required) {
				return $.validator.methods.required.call(this, value, element, true);
			}
			return true;
		},

		/**
		 * Validate that an attribute exists when another attribute has a given value.
		 *
		 * @return {boolean}
		 */
		RequiredIf: function (value, element, params) {
			var target = laravelValidation.helpers.dependentElement(
				this, element, params[0]
			);

			if (target !== undefined) {
				var val = String(this.elementValue(target));
				if (typeof val !== 'undefined') {
					var data = params.slice(1);
					if ($.inArray(val, data) !== -1) {
						return $.validator.methods.required.call(
							this, value, element, true
						);
					}
				}
			}

			return true;
		},

		/**
		 * Validate that an attribute exists when another
		 * attribute does not have a given value.
		 *
		 * @return {boolean}
		 */
		RequiredUnless: function (value, element, params) {
			var target = laravelValidation.helpers.dependentElement(
				this, element, params[0]
			);

			if (target !== undefined) {
				var val = String(this.elementValue(target));
				if (typeof val !== 'undefined') {
					var data = params.slice(1);
					if ($.inArray(val, data) !== -1) {
						return true;
					}
				}
			}

			return $.validator.methods.required.call(
				this, value, element, true
			);
		},

		/**
		 * Validate that an attribute has a matching confirmation.
		 *
		 * @return {boolean}
		 */
		Confirmed: function (value, element, params) {
			return laravelValidation.methods.Same.call(this, value, element, params);
		},

		/**
		 * Validate that two attributes match.
		 *
		 * @return {boolean}
		 */
		Same: function (value, element, params) {
			var target = laravelValidation.helpers.dependentElement(
				this, element, params[0]
			);

			if (target !== undefined) {
				return String(value) === String(this.elementValue(target));
			}
			return false;
		},

		/**
		 * Validate that the values of an attribute is in another attribute.
		 *
		 * @param value
		 * @param element
		 * @param params
		 * @returns {boolean}
		 * @constructor
		 */
		InArray: function (value, element, params) {
			if (typeof params[0] === 'undefined') {
				return false;
			}
			var elements = this.elements();
			var found = false;
			var nameRegExp = laravelValidation.helpers.regexFromWildcard(params[0]);

			for (var i = 0; i < elements.length; i++) {
				var targetName = elements[i].name;
				if (targetName.match(nameRegExp)) {
					var equals = laravelValidation.methods.Same.call(this, value, element, [targetName]);
					found = found || equals;
				}
			}

			return found;
		},

		/**
		 * Validate an attribute is unique among other values.
		 *
		 * @param value
		 * @param element
		 * @param params
		 * @returns {boolean}
		 */
		Distinct: function (value, element, params) {
			if (typeof params[0] === 'undefined') {
				return false;
			}

			var elements = this.elements();
			var found = false;
			var nameRegExp = laravelValidation.helpers.regexFromWildcard(params[0]);

			for (var i = 0; i < elements.length; i++) {
				var targetName = elements[i].name;
				if (targetName !== element.name && targetName.match(nameRegExp)) {
					var equals = laravelValidation.methods.Same.call(this, value, element, [targetName]);
					found = found || equals;
				}
			}

			return !found;
		},

		/**
		 * Validate that an attribute is different from another attribute.
		 *
		 * @return {boolean}
		 */
		Different: function (value, element, params) {
			return !laravelValidation.methods.Same.call(this, value, element, params);
		},

		/**
		 * Validate that an attribute was "accepted".
		 * This validation rule implies the attribute is "required".
		 *
		 * @return {boolean}
		 */
		Accepted: function (value) {
			var regex = new RegExp('^(?:(yes|on|1|true))$', 'i');
			return regex.test(value);
		},

		/**
		 * Validate that an attribute is an array.
		 */
		Array: function (value) {
			return $.isArray(value);
		},

		/**
		 * Validate that an attribute is a boolean.
		 *
		 * @return {boolean}
		 */
		Boolean: function (value) {
			var regex = new RegExp('^(?:(true|false|1|0))$', 'i');
			return regex.test(value);
		},

		/**
		 * Validate that an attribute is an integer.
		 *
		 * @return {boolean}
		 */
		Integer: function (value) {
			var regex = new RegExp('^(?:-?\\d+)$', 'i');
			return regex.test(value);
		},

		/**
		 * Validate that an attribute is numeric.
		 */
		Numeric: function (value, element) {
			return $.validator.methods.number.call(this, value, element, true);
		},

		/**
		 * Validate that an attribute is a string.
		 *
		 * @return {boolean}
		 */
		String: function (value) {
			return typeof value === 'string';
		},

		/**
		 * The field under validation must be numeric and must have an exact length of value.
		 */
		Digits: function (value, element, params) {
			return (
				$.validator.methods.number.call(this, value, element, true) &&
				value.length === parseInt(params, 10)
			);
		},

		/**
		 * The field under validation must have a length between the given min and max.
		 */
		DigitsBetween: function (value, element, params) {
			return ($.validator.methods.number.call(this, value, element, true) &&
				value.length >= parseFloat(params[0]) && value.length <= parseFloat(params[1]));
		},

		/**
		 * Validate the size of an attribute.
		 *
		 * @return {boolean}
		 */
		Size: function (value, element, params) {
			return laravelValidation.helpers.getSize(this, element, value) === parseFloat(params[0]);
		},

		/**
		 * Validate the size of an attribute is between a set of values.
		 *
		 * @return {boolean}
		 */
		Between: function (value, element, params) {
			return (laravelValidation.helpers.getSize(this, element, value) >= parseFloat(params[0]) &&
				laravelValidation.helpers.getSize(this, element, value) <= parseFloat(params[1]));
		},

		/**
		 * Validate the size of an attribute is greater than a minimum value.
		 *
		 * @return {boolean}
		 */
		Min: function (value, element, params) {
			return laravelValidation.helpers.getSize(this, element, value.trim()) >= parseFloat(params[0]);
		},

		/**
		 * Validate the size of an attribute is less than a maximum value.
		 *
		 * @return {boolean}
		 */
		Max: function (value, element, params) {
			return laravelValidation.helpers.getSize(this, element, value.trim()) <= parseFloat(params[0]);
		},

		/**
		 * Validate an attribute is contained within a list of values.
		 *
		 * @return {boolean}
		 */
		In: function (value, element, params) {
			if ($.isArray(value) && laravelValidation.helpers.hasRules(element, 'Array')) {
				var diff = laravelValidation.helpers.arrayDiff(value, params);
				return Object.keys(diff).length === 0;
			}
			return params.indexOf(value.toString()) !== -1;
		},

		/**
		 * Validate an attribute is not contained within a list of values.
		 *
		 * @return {boolean}
		 */
		NotIn: function (value, element, params) {
			return params.indexOf(value.toString()) === -1;
		},

		/**
		 * Validate that an attribute is a valid IP.
		 *
		 * @return {boolean}
		 */
		Ip: function (value) {
			return /^(25[0-5]|2[0-4]\d|[01]?\d\d?)\.(25[0-5]|2[0-4]\d|[01]?\d\d?)\.(25[0-5]|2[0-4]\d|[01]?\d\d?)\.(25[0-5]|2[0-4]\d|[01]?\d\d?)$/i.test(value) ||
				/^((([0-9A-Fa-f]{1,4}:){7}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}:[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){5}:([0-9A-Fa-f]{1,4}:)?[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){4}:([0-9A-Fa-f]{1,4}:){0,2}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){3}:([0-9A-Fa-f]{1,4}:){0,3}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){2}:([0-9A-Fa-f]{1,4}:){0,4}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(([0-9A-Fa-f]{1,4}:){0,5}:((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(::([0-9A-Fa-f]{1,4}:){0,5}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|([0-9A-Fa-f]{1,4}::([0-9A-Fa-f]{1,4}:){0,5}[0-9A-Fa-f]{1,4})|(::([0-9A-Fa-f]{1,4}:){0,6}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){1,7}:))$/i.test(value);
		},

		/**
		 * Validate that an attribute is a valid e-mail address.
		 */
		Email: function (value, element) {
			return $.validator.methods.email.call(this, value, element, true);
		},

		/**
		 * Validate that an attribute is a valid URL.
		 */
		Url: function (value, element) {
			return $.validator.methods.url.call(this, value, element, true);
		},

		/**
		 * The field under validation must be a successfully uploaded file.
		 *
		 * @return {boolean}
		 */
		File: function (value, element) {
			if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
				return true;
			}
			if ('files' in element) {
				return (element.files.length > 0);
			}
			return false;
		},

		/**
		 * Validate the MIME type of a file upload attribute is in a set of MIME types.
		 *
		 * @return {boolean}
		 */
		Mimes: function (value, element, params) {
			if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
				return true;
			}
			var lowerParams = $.map(params, function (item) {
				return item.toLowerCase();
			});

			var fileinfo = laravelValidation.helpers.fileinfo(element);
			return (fileinfo !== false && lowerParams.indexOf(fileinfo.extension.toLowerCase()) !== -1);
		},

		/**
		 * The file under validation must match one of the given MIME types.
		 *
		 * @return {boolean}
		 */
		Mimetypes: function (value, element, params) {
			if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
				return true;
			}
			var lowerParams = $.map(params, function (item) {
				return item.toLowerCase();
			});

			var fileinfo = laravelValidation.helpers.fileinfo(element);

			if (fileinfo === false) {
				return false;
			}
			return (lowerParams.indexOf(fileinfo.type.toLowerCase()) !== -1);
		},

		/**
		 * Validate the MIME type of a file upload attribute is in a set of MIME types.
		 */
		Image: function (value, element) {
			return laravelValidation.methods.Mimes.call(this, value, element, [
				'jpg', 'png', 'gif', 'bmp', 'svg', 'jpeg'
			]);
		},

		/**
		 * Validate dimensions of Image.
		 *
		 * @return {boolean|string}
		 */
		Dimensions: function (value, element, params, callback) {
			if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
				return true;
			}
			if (element.files === null || typeof element.files[0] === 'undefined') {
				return false;
			}

			var fr = new FileReader();
			fr.onload = function () {
				var img = new Image();
				img.onload = function () {
					var height = parseFloat(img.naturalHeight);
					var width = parseFloat(img.naturalWidth);
					var ratio = width / height;
					var notValid = ((params['width']) && parseFloat(params['width'] !== width)) ||
						((params['min_width']) && parseFloat(params['min_width']) > width) ||
						((params['max_width']) && parseFloat(params['max_width']) < width) ||
						((params['height']) && parseFloat(params['height']) !== height) ||
						((params['min_height']) && parseFloat(params['min_height']) > height) ||
						((params['max_height']) && parseFloat(params['max_height']) < height) ||
						((params['ratio']) && ratio !== parseFloat(eval(params['ratio']))
						);
					callback(!notValid);
				};
				img.onerror = function () {
					callback(false);
				};
				img.src = fr.result;
			};
			fr.readAsDataURL(element.files[0]);

			return 'pending';
		},

		/**
		 * Validate that an attribute contains only alphabetic characters.
		 *
		 * @return {boolean}
		 */
		Alpha: function (value) {
			if (typeof value !== 'string') {
				return false;
			}

			var regex = new RegExp('^(?:^[a-z\u00E0-\u00FC]+$)$', 'i');
			return regex.test(value);
		},

		/**
		 * Validate that an attribute contains only alpha-numeric characters.
		 *
		 * @return {boolean}
		 */
		AlphaNum: function (value) {
			if (typeof value !== 'string') {
				return false;
			}
			var regex = new RegExp('^(?:^[a-z0-9\u00E0-\u00FC]+$)$', 'i');
			return regex.test(value);
		},

		/**
		 * Validate that an attribute contains only alphabetic characters.
		 *
		 * @return {boolean}
		 */
		AlphaDash: function (value) {
			if (typeof value !== 'string') {
				return false;
			}
			var regex = new RegExp('^(?:^[a-z0-9\u00E0-\u00FC_-]+$)$', 'i');
			return regex.test(value);
		},

		/**
		 * Validate that an attribute passes a regular expression check.
		 *
		 * @return {boolean}
		 */
		Regex: function (value, element, params) {
			var invalidModifiers = ['x', 's', 'u', 'X', 'U', 'A'];
			// Converting php regular expression
			var phpReg = new RegExp('^(?:\/)(.*\\\/?[^\/]*|[^\/]*)(?:\/)([gmixXsuUAJ]*)?$');
			var matches = params[0].match(phpReg);
			if (matches === null) {
				return false;
			}
			// checking modifiers
			var php_modifiers = [];
			if (matches[2] !== undefined) {
				php_modifiers = matches[2].split('');
				for (var i = 0; i < php_modifiers.length < i; i++) {
					if (invalidModifiers.indexOf(php_modifiers[i]) !== -1) {
						return true;
					}
				}
			}
			var regex = new RegExp('^(?:' + matches[1] + ')$', php_modifiers.join());
			return regex.test(value);
		},

		/**
		 * Validate that an attribute is a valid date.
		 *
		 * @return {boolean}
		 */
		Date: function (value) {
			return (laravelValidation.helpers.strtotime(value) !== false);
		},

		/**
		 * Validate that an attribute matches a date format.
		 *
		 * @return {boolean}
		 */
		DateFormat: function (value, element, params) {
			return laravelValidation.helpers.parseTime(value, params[0]) !== false;
		},

		/**
		 * Validate the date is before a given date.
		 *
		 * @return {boolean}
		 */
		Before: function (value, element, params) {
			var timeCompare = parseFloat(params);
			if (isNaN(timeCompare)) {
				var target = laravelValidation.helpers.dependentElement(this, element, params);
				if (target === undefined) {
					return false;
				}
				timeCompare = laravelValidation.helpers.parseTime(this.elementValue(target), target);
			}

			var timeValue = laravelValidation.helpers.parseTime(value, element);
			return (timeValue !== false && timeValue < timeCompare);
		},

		/**
		 * Validate the date is after a given date.
		 *
		 * @return {boolean}
		 */
		After: function (value, element, params) {
			var timeCompare = parseFloat(params);
			if (isNaN(timeCompare)) {
				var target = laravelValidation.helpers.dependentElement(this, element, params);
				if (target === undefined) {
					return false;
				}
				timeCompare = laravelValidation.helpers.parseTime(this.elementValue(target), target);
			}

			var timeValue = laravelValidation.helpers.parseTime(value, element);
			return (timeValue !== false && timeValue > timeCompare);
		},

		/**
		 * Validate that an attribute is a valid date.
		 */
		Timezone: function (value) {
			return laravelValidation.helpers.isTimezone(value);
		},

		/**
		 * Validate the attribute is a valid JSON string.
		 *
		 * @param  value
		 * @return bool
		 */
		Json: function (value) {
			var result = true;
			try {
				JSON.parse(value);
			} catch (e) {
				result = false;
			}
			return result;
		}
	}
});
