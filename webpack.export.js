'use strict';

/**
 * @module
 * @description составление и экспорт webpack конфигурации
 */

/** @type {WebpackOptions} */
const webpackConfig = require('./webpack.config');

const fs = require('fs');
const path = require('path');
const fromCWD = require('from-cwd');
const argv = require('./resources/webpack/utils/argv');
const copy = require('./resources/webpack/utils/copy');
const clear = require('./resources/webpack/utils/clear');
const logger = require('./resources/webpack/utils/logger');
const localFolderName = require('./resources/webpack/utils/local-folder-name');
const uncaughtException = require('./resources/webpack/utils/uncaught-exception');
const styleLoaderExcludePaths = require('./resources/webpack/utils/style-loader-exclude-paths');

const setupStats = require('./resources/webpack/setups/stats');
const setupEntry = require('./resources/webpack/setups/entry');
const setupOutput = require('./resources/webpack/setups/output');
const setupOptimization = require('./resources/webpack/setups/optimization');
const setupStyleLoaders = require('./resources/webpack/setups/style-loaders');

const webpack = require('webpack');
const blenme = require('babel-loader-exclude-node-modules-except');
const SvgSpritemapPlugin = require('svg-spritemap-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const WebpackBuildNotifierPlugin = require('mini-css-extract-plugin');

const {
	// BundleFile,
	BundleJsFile,
	BundleSassFile,
	BundleSvgSpriteFile
} = require('./resources/webpack/utils/BundleFile');

// ----------------------------------------
// Private
// ----------------------------------------

const isAdmin = argv('app') === 'admin';
const isProduction = argv('production');
const isWatching = argv('watch');
const isHot = argv('hot');

const _sourceSite = path => `./resources/assets/site/${path}`;
const _sourceAdmin = path => `./resources/assets/admin/${path}`;
const _distSite = path => `./public/site/assets/${path}`;
const _distAdmin = path => `./public/admin/assets/${path}`;
const _publicSite = path => `/assets/${path}`;
const _publicAdmin = path => `/admin/assets/${path}`;

// ----------------------------------------
// CONFIG
// ----------------------------------------

const CONFIG = {
	/** Пути к файлам или директориям, которые следует удалить переде стартом сборки
	 * Удаление будет выполнено при использовании флан */
	clear: (() => {
		if (isAdmin) {
			return [
				_distAdmin('') // удаление корневой папки итогового кода public/admin/assets/
			];
		}
		return [
			_distSite('') // удаление корневой папки итогового кода public/site/assets/
		];
	})(),

	/** Копирование файлов
	 * @type {BundleFile[]} */
	copy: (() => {
		if (isAdmin) {
			return [];
		}
		return [
			// new BundleFile(
			// 	'./node_modules/jquery/dist/jquery.min.js',
			// 	_distSite('js/vendors/jquery.min.js')
			// )
		];
	})(),

	/** Исходный JS файл. Корневой файл - один!
	 * @type {BundleJsFile} */
	js: (() => {
		if (isAdmin) {
			return new BundleJsFile(
				_sourceAdmin('js/admin-app.js'),
				_distAdmin('js/bundle-admin-app.js'),
				_publicAdmin('js/'),
				'_async-modules/[name].js?=[chunkhash]'
			);
		}
		return new BundleJsFile(
			_sourceSite('js/app.js'),
			_distSite('js/bundle-app.js'),
			_publicSite('js/'),
			'_async-modules/[name].js?=[chunkhash]'
		);
	})(),

	/** Экстракт стилей относительно итогового bundle-app.js */
	extractCSS: '../css/[name].css',

	/** Исходные SASS файлы
	 * @type {BundleSassFile[]} */
	sass: (() => {
		if (isAdmin) {
			return [
				new BundleSassFile(
					_sourceAdmin('/sass/admin-style.scss'),
					_distAdmin('css/bundle-admin-style.css')
				)
			];
		}
		return [
			new BundleSassFile(
				_sourceSite('/sass/vendor.scss'),
				_distSite('css/bundle-vendor.css')
			),
			new BundleSassFile(
				_sourceSite('/sass/common.scss'),
				_distSite('css/bundle-common.css')
			),
			new BundleSassFile(
				_sourceSite('/sass/site.scss'),
				_distSite('css/bundle-site.css')
			),
			new BundleSassFile(
				_sourceSite('/sass/noscript.scss'),
				_distSite('css/bundle-noscript.css')
			),
			new BundleSassFile(
				_sourceSite('/sass/sitemap.scss'),
				_distSite('css/bundle-sitemap.css')
			),
			new BundleSassFile(
				_sourceSite('/sass/wysiwyg.scss'),
				_distSite('css/bundle-wysiwyg.css')
			)
		];
	})(),

	/** SVG спрайты
	 * @type {BundleSvgSpriteFile[]} */
	svg: (() => {
		if (isAdmin) {
			return [
				new BundleSvgSpriteFile(
					_sourceAdmin('/svg/*.svg'),
					'../svg/spritemap.svg'
				)
			];
		}
		return [
			new BundleSvgSpriteFile(
				_sourceSite('/svg/*.svg'),
				'../svg/spritemap.svg'
			)
		];
	})(),

	/** Путь к итоговым файлам, внутри директории CSS
	 * @type {string} */
	assetsGlobCSS: fromCWD(isAdmin ? _distAdmin('css/**/**') : _distSite('css/**/**')),

	/** Путь к итоговым файлам, внутри директории SVG
	 * @type {string} */
	assetsGlobSVG: fromCWD(isAdmin ? _distAdmin('svg/**/**') : _distSite('svg/**/**')),

	sassScanner: (() => {
		if (isAdmin) {
			return null;
		}
		return {
			sources: [
				fromCWD('./app/Modules/**/Views/site/**/*.scss'),
				fromCWD('./resources/views/site/**/*.scss'),
				fromCWD('./resources/views/site-custom/**/*.scss')
			],
			resultFile: fromCWD('./resources/assets/site/sass/_site-modules/all.scss'),
			includeFile: fromCWD('./resources/assets/site/sass/site.scss')
		};
	})(),

	jsScanner:  (() => {
		if (isAdmin) {
			return null;
		}
		return {
			sources: [
				fromCWD('./app/Modules/**/Views/site/**/*.js'),
				fromCWD('./resources/views/site/**/*.js'),
				fromCWD('./resources/views/site-custom/**/*.js')
			],
			resultFile: fromCWD('./resources/assets/site/js/_site-modules/all.js'),
			includeFile: fromCWD('./resources/assets/site/js/app.js')
		};
	})()
};

/** Настройки для сканеров
 * @type {Object} */
let scan = null;
if (argv('scan')) {
	const { SassScanner, JSScanner } = require('./resources/webpack/utils/AssetsScanner');
	scan = {
		sass: CONFIG.sassScanner === null ? null : new SassScanner(CONFIG.sassScanner),
		js: CONFIG.jsScanner === null ? null : new JSScanner(CONFIG.jsScanner)
	};
}

/** Настройки browser-sync
 * @type {Object} */
CONFIG.bsOptions = (function () {
	if (!isWatching) {
		return {};
	}
	const host = localFolderName();
	return {
		open: argv('open') ? 'external' : false,
		host: host,
		port: 4000,
		proxy: `http://${host}`,
		files: (isHot ? [] : [
			CONFIG.js.distFile,
			_distSite('js/_async-modules/**'),
			_distAdmin('js/_async-modules/**')
		]).concat([
			fromCWD('./app/**/*.php'),
			fromCWD('./config/**/*.php'),
			fromCWD('./resources/lang/**/*.php'),
			fromCWD('./resources/views/**/*.blade.php'),
			fromCWD('./public/admin/static/**/**'),
			fromCWD('./public/site/static/**/**'),
			{
				match: CONFIG.assetsGlobSVG,
				fn (event, file) {
					if (isHot) {
						this.reload();
						return;
					}

					if (!this.hasOwnProperty('__svgFiles')) {
						this.__svgFiles = {};
					}

					const svgPath = fromCWD(file);
					if (fs.existsSync(svgPath)) {
						const svgFile = String(fs.readFileSync(svgPath));
						if (this.__svgFiles[file] === svgFile) {
							return;
						}
						this.__svgFiles[file] = svgFile;
					}
					this.reload();
				}
			}, {
				match: CONFIG.assetsGlobCSS,
				fn (event, file) {
					let filename = file.split(path.sep).pop();
					this.notify(`Inject ${path.basename(filename)}`);
					this.reload(file);
				}
			}
		], scan !== null && CONFIG.sassScanner !== null ? [
			{
				match: CONFIG.sassScanner.sources,
				fn (event) {
					switch (event) {
						case 'add':
						case 'unlink':
							scan.sass.scan();
							break;
					}
				}
			}
		] : [], scan !== null && CONFIG.sassScanner !== null ? [
			{
				match: CONFIG.jsScanner.sources,
				fn (event) {
					switch (event) {
						case 'add':
						case 'unlink':
							scan.js.scan();
							break;
					}
				}
			}
		] : [])
	};
})();

// ----------------------------------------
// Clear & Copy
// ----------------------------------------

logger.instance.blank();
logger.instance.line();
logger.instance.print('white', `app: ${logger.color('yellow', isAdmin ? 'ADMIN!' : 'SITE!')}`);
logger.instance.line();
logger.instance.print('white', `mode: ${logger.color('yellow', isProduction ? 'PRODUCTION!' : 'DEVELOPMENT!')}`);
logger.instance.line();

if (argv('clear')) {
	clear(CONFIG.clear);
}
CONFIG.copy.forEach(file => copy(file.sourceFile, file.distFile, true));

// ----------------------------------------
// Scans
// ----------------------------------------

if (scan !== null) {
	if (scan.sass) {
		scan.sass.scan(true);
	}
	if (scan.js) {
		scan.js.scan(true);
	}
}

// ----------------------------------------
// Setup
// ----------------------------------------

webpackConfig.mode = isProduction ? 'production' : 'development';
webpackConfig.devtool = isWatching ? 'inline-source-map' : false;
webpackConfig.stats = setupStats;
webpackConfig.entry = setupEntry(CONFIG.js, CONFIG.sass, CONFIG.bsOptions);
webpackConfig.output = setupOutput(CONFIG.js);
webpackConfig.optimization = setupOptimization(CONFIG.sass);
webpackConfig.externals = {
	jquery: 'jQuery'
};

const styleLoaders = setupStyleLoaders([
	'./node_modules/',
	_sourceSite('/sass/')
]);

webpackConfig.module = {
	rules: [{
		test: /\.modernizrrc$/,
		loader: 'modernizr-loader!json5-loader'
	}, {
		test: /\.js$/,
		exclude: blenme([
			'custom-jquery-methods',
			'module-dynamic-import',
			'wezom-module-loader',
			'swiper',
			'dom7'
		]),
		use: {
			loader: 'babel-loader'
		}
	}, {
		test: /\.css$/,
		use: [
			styleLoaders.asyncStyle,
			styleLoaders.asyncCss,
			styleLoaders.asyncPostcss
		]
	}, {
		test: /\.scss$/,
		exclude: styleLoaderExcludePaths(CONFIG.sass.map(file =>file.sourceFile)),
		use: [
			styleLoaders.asyncStyle,
			styleLoaders.asyncCss,
			styleLoaders.asyncPostcss,
			styleLoaders.asyncSass
		]
	}].concat(CONFIG.sass.map(file => {
		return {
			test: file.sourceFile,
			use: [
				MiniCssExtractPlugin.loader,
				styleLoaders.css,
				styleLoaders.postcss,
				styleLoaders.sass
			]
		};
	}))
};

webpackConfig.plugins = [
	// new webpack.PrefetchPlugin(fromCWD(_sourceSite('/js/modules/mmenu/index.js'))),
	new webpack.DefinePlugin({
		IS_PRODUCTION: JSON.stringify(isProduction),
		IS_DEVELOPMENT: JSON.stringify(!isProduction),
		IS_BUILD: JSON.stringify(!!argv('build'))
	}),
	new WebpackBuildNotifierPlugin({
		suppressSuccess: isWatching ? 'initial' : false
	})
];

CONFIG.svg.forEach(file => {
	webpackConfig.plugins.push(new SvgSpritemapPlugin(file.src, file.options));
});

if (CONFIG.sass.length) {
	webpackConfig.plugins.push(new MiniCssExtractPlugin({ filename: CONFIG.extractCSS }));
}

if (isWatching) {
	uncaughtException();
	if (isHot) {
		const WriteFilePlugin = require('write-file-webpack-plugin');
		const BrowserSyncDevHotPlugin = require('browser-sync-dev-hot-webpack-plugin');
		webpackConfig.plugins.push(new WriteFilePlugin({
			force: true,
			test: /\.(css|svg)$/,
			useHashIndex: true
		}), new BrowserSyncDevHotPlugin({
			browserSync: CONFIG.bsOptions,
			devMiddleware: {
				publicPath: _publicSite('js/'),
				noInfo: false,
				quiet: false,
				stats: {
					colors: true,
					cached: false,
					cachedAssets: false
				}
			},
			hotMiddleware: {},
			callback () {
				const updTime = new Date();
				fs.utimes(CONFIG.js.sourceFile, updTime, updTime);
			}
		}));
	} else {
		const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
		webpackConfig.plugins.push(new BrowserSyncPlugin(CONFIG.bsOptions, {
			reload: false
		}));
	}
}

logger.instance.print('yellow', 'IT HAS BEGUN! LET\'S PLAY ROCK\'n\'ROLL!');
logger.instance.line();
logger.instance.blank();

// ----------------------------------------
// Exports
// ----------------------------------------

module.exports = webpackConfig;
