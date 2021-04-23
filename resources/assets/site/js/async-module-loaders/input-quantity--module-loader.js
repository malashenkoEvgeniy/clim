import InputQuantity from 'assetsSite#/js/modules/input-quantity';

function loaderInit ($elements, moduleLoader) {
	$.each($elements, (i, root) => {
		let $root = $(root);

		if ($root.data('InputQuantity') instanceof InputQuantity === false) {
			const instance = new InputQuantity($root, moduleLoader);
			$root.data('InputQuantity', instance);
			$root.addClass('is-initialized');
		}
	});
}

export { loaderInit };
