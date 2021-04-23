import LocationSuggest from 'assetsSite#/js/modules/location-suggest';

function loaderInit ($elements, moduleLoader) {
	$.each($elements, (i, root) => {
		let $root = $(root);

		if ($root.data('LocationSuggest') instanceof LocationSuggest === false) {
			const instance = new LocationSuggest($root, moduleLoader);
			$root.data('LocationSuggest', instance);
			$root.addClass('is-initialized');
		}
	});
}

export { loaderInit };
