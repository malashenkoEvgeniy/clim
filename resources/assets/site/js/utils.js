export const getLocale = () => {
	return document.documentElement.lang.split('-').pop().toLocaleLowerCase();
};

export const prepareIncomingData = (data) => {
	try {
		let temp;

		if (typeof data === 'string') {
			temp = JSON.parse(data);
		} else {
			temp = JSON.parse(JSON.stringify(data));
		}

		return temp;
	} catch (err) {
		return null;
	}
};

export const onlyNumbers = ($input) => {
	$input.on('keydown', (e) => {
		// Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
			// Allow: Ctrl+A
			(e.keyCode === 65 && e.ctrlKey === true) ||
			// Allow: Ctrl+C
			(e.keyCode === 67 && e.ctrlKey === true) ||
			// Allow: Ctrl+X
			(e.keyCode === 88 && e.ctrlKey === true) ||
			// Allow: home, end, left, right
			(e.keyCode >= 35 && e.keyCode <= 39)) {
			// let it happen, don't do anything
			return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			e.preventDefault();
		}
	});
};

export const isNumeric = (number) => {
	return !isNaN(parseFloat(number)) && isFinite(number);
};

export const ucFirst = (str) => {
	return str.charAt(0).toUpperCase() + str.slice(1);
};

export const plural = (string, number) => {
	const words = string.split('|').map((item) => item.split(':count ')[1]);
	const arr = [2, 0, 1, 1, 1, 2];
	return words[ (number % 100 > 4 && number % 100 < 20) ? 2 : arr[Math.min(number % 10, 5)] ];
};
