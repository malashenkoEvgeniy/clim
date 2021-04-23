import Toggle from 'assetsSite#/js/modules/toggle';

function loaderInit ($elements, moduleLoader) {
	$.each($elements, (i, root) => {
		let $root = $(root);

		if ($root.data('Toggle') instanceof Toggle === false) {
			const instance = new Toggle($root, moduleLoader);
			$root.data('Toggle', instance);
			$root.addClass('is-initialized');
		}
	});
}

export { loaderInit };
