import LiveSearch from 'assetsSite#/js/modules/livesearch';

function loaderInit ($elements, moduleLoader) {
	$.each($elements, (i, root) => {
		let $root = $(root);

		if ($root.data('LiveSearch') instanceof LiveSearch === false) {
			const instance = new LiveSearch($root, moduleLoader);
			$root.data('LiveSearch', instance);
			$root.addClass('is-initialized');
		}
	});
}

export { loaderInit };
