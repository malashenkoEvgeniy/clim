'use strict';

/**
 *
 * @module
 */

// ----------------------------------------
// Imports
// ----------------------------------------

import 'custom-jquery-methods/fn/has-inited-key';
import 'custom-jquery-methods/fn/get-my-elements';

// ----------------------------------------
// Private
// ----------------------------------------

/**
 * @param {JQuery} $map
 * @private
 */

function createMap ($map) {
	const $container = $map.getMyElements('$mapContainer', '[data-google-map-container]', 'find');
	const $points = $('.tabs-nav').getMyElements('$mapPoints', '[data-google-map-point]', 'find');
	const $select = $('.js-branch-select');
	const $markers = $('[data-position]');
	const centerConfig = $points.filter('.is-active').data('google-map-point');

	// выгружаем ссылки
	const { Map, Marker } = window.google.maps;

	// карта
	const mapConfig = $.extend({
		zoom: 16
	}, centerConfig);
	mapConfig.center = mapConfig.position;

	/**
	 * @type {Object}
	 * @prop {Function} setCenter
	 * @prop {Function} setZoom
	 */
	const map = new Map($container[0], mapConfig);

	$markers.each((i, el) => {
		return new Marker({
			position: $(el).data('position'),
			map: map
		});
	});

	$points.each((i, el) => {
		const $point = $(el);
		const pointConfig = $.extend({
			// defaults
		}, $point.data('google-map-point'), {
			map
		});

		$point.data('pointConfig', pointConfig);
	});

	$points.on('click', function () {
		const $this = $(this);
		showArea($this);
		$('.js-branch-select').prop('selectedIndex', 0);
		$('.branch__item').removeClass('is-active');
	});

	$select.on('change', function () {
		const $this = $(this);
		if ($this.get(0).selectedIndex > 0) {
			showBranch($this);
		}
	});

	function showArea ($point) {
		const {
			pointConfig: config
		} = $point.data();

		const {
			position: center = {},
			zoom = null
		} = config;

		map.setCenter(center);
		if (zoom) {
			map.setZoom(zoom);
		}
	}

	function showBranch ($el) {
		const id = $el.val();
		const position = $el.children('option:selected').data('position');
		const parent = $el.closest('.tabs-blocks__block');

		parent.find(`[data-brach-item="${id}"]`).addClass('is-active').siblings().removeClass('is-active');
		map.setCenter(position);
		map.setZoom(14);
	}
}

/**
 * @type {Object}
 * @private
 */
const ggl = {
	src: 'https://maps.googleapis.com/maps/api/js',
	loaded: false
};

// ----------------------------------------
// Public
// ----------------------------------------

/**
 * @param {JQuery} $elements
 * @param {ModuleLoader} moduleLoader
 * @sourceCode
 */
function googleMapInit ($elements, moduleLoader) {
	if (ggl.loaded) {
		console.warn('Google map is already loaded!');
		return false;
	}

	const { googleMapQueries } = window.locoConfig;
	const queries = Object.keys(googleMapQueries).map(q => {
		return q + '=' + googleMapQueries[q];
	}).join('&');
	const jsMapSrc = ggl.src + '?' + queries;
	window.jQuery.getScript(jsMapSrc, function () {
		$elements.each((i, el) => {
			const $map = $(el);
			if ($map.hasInitedKey('googleMapInited')) {
				return true;
			}
			createMap($map);
		});
	});
};

// ----------------------------------------
// Exports
// ----------------------------------------

export default googleMapInit;
