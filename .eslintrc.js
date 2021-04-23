module.exports = {
	extends: [
		'wezom-relax'
	],
	globals: {
		'IS_DEVELOPMENT': true,
		'IS_PRODUCTION': true,
		'IS_BUILD': true,
		'$': true,
		'GSAP': true,
		'GreenSockGlobals': true
	}
};
