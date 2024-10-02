// Set the Preflight flag based on the build target.
const includePreflight = 'editor' === process.env._TW_TARGET ? false : true;
const plugin = require('tailwindcss/plugin');
const flattenColorPalette =
	require('tailwindcss/lib/util/flattenColorPalette').default;
const { parseColor } = require('tailwindcss/lib/util/color');
module.exports = {
	options: {
		safelist: [/^flaticon-/],
	},
	presets: [
		// Manage Tailwind Typography's configuration in a separate file.
		require('./tailwind-typography.config.js'),
	],
	content: [
		// Ensure changes to PHP files and `theme.json` trigger a rebuild.
		'./theme/**/*.php',
	],
	theme: {
		container: {
			center: true,
		},
		extend: {
			backgroundImage: {
				'primary-gradient':
					'linear-gradient(to right, #005993, #b31217)',
			},
		},
		otherSizes: {
			mobileBreak: '1070px',
			mobileBreakPlus1: '1071px',
			largerBreak: '1200px',
			largestBreakpoint: '1540px',
		},
	},
	corePlugins: {
		// Disable Preflight base styles in builds targeting the editor.
		preflight: includePreflight,
	},
	plugins: [
		// Add Tailwind Typography (via _tw fork).
		require('@_tw/typography'),

		// Extract colors and widths from `theme.json`.
		require('@_tw/themejson'),

		// Uncomment below to add additional first-party Tailwind plugins.
		// require('@tailwindcss/forms'),
		// require('@tailwindcss/aspect-ratio'),
		// require('@tailwindcss/container-queries'),

		// New mobile-only variant
		function ({ addVariant }) {
			addVariant(
				'mobile-only',
				"@media screen and (max-width: theme('otherSizes.mobileBreak'))"
			);
			addVariant(
				'hamburger',
				"@media screen and (max-width: theme('otherSizes.mobileBreak'))"
			);
			addVariant(
				'non-hamburger',
				"@media screen and (max-width: theme('otherSizes.mobileBreakPlus1'))"
			);
			plugin(({ matchUtilities, theme }) => {
				matchUtilities(
					{
						l: (value) => {
							const { color } = parseColor(value);

							return {
								backgroundImage: `linear-gradient(315deg, transparent 10px, rgba(${color[0]} ${color[1]} ${color[2]} / 0.9) 10px`,
							};
						},
					},
					{
						values: flattenColorPalette(theme('colors')),
						type: 'color',
					}
				);
			});
		},
	],
};
