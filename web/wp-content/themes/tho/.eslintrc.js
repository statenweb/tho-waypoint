module.exports = {
	root: true,
	env: {
		browser: true,
		es6: true,
		node: true,
	},
	extends: ['wordpress', 'eslint:recommended', 'plugin:prettier/recommended'],
	rules: {
		'prettier/prettier': ['error'], // Mark Prettier issues as errors
	},
	globals: {
		wp: 'readonly',
		sw: 'readonly',
	},
};
