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
			fontFamily: {
				display: ['Outfit', 'sans-serif'],
				heading: ['Inter', 'sans-serif'],
				nav: ['Inter', 'sans-serif'],
				body: ['Inter', 'sans-serif'],
			},
			fontSize: {
				display: ['6.875rem', { lineHeight: '1.1', letterSpacing: '0.02em' }],
				'h1': ['2.625rem', { lineHeight: '1.2' }],
				'h2': ['2.1875rem', { lineHeight: '1.25' }],
				'h3': ['1.4375rem', { lineHeight: '1.3' }],
				'h4': ['1.25rem', { lineHeight: '1.35' }],
				'body-lg': ['1.0625rem', { lineHeight: '1.6' }],
				'body': ['0.9375rem', { lineHeight: '1.6' }],
				'body-sm': ['0.875rem', { lineHeight: '1.5' }],
				'nav': ['1rem', { lineHeight: '1.4' }],
				'caption': ['0.75rem', { lineHeight: '1.4' }],
			},
			spacing: {
				'header': '5.3125rem',
				'section-min': '2.5rem',
				'section-max': '5rem',
				'content-max': '61.25rem',
				'footer-logo': '6.125rem',
				'social-icon': '2.9375rem',
			},
			maxWidth: {
				'content': '61.25rem',
			},
			backgroundImage: {
				'black-menu-arrow': "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.com/svgjs' width='512' height='512' x='0' y='0' viewBox='0 0 24 24' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''%3E%3Cg%3E%3Cpath d='M12 16a1 1 0 0 1-.71-.29l-6-6a1 1 0 0 1 1.42-1.42l5.29 5.3 5.29-5.29a1 1 0 0 1 1.41 1.41l-6 6a1 1 0 0 1-.7.29z' data-name='16' fill='%23000000' data-original='%23000000' class=''%3E%3C/path%3E%3C/g%3E%3C/svg%3E\")",
				'white-menu-arrow': "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.com/svgjs' width='512' height='512' x='0' y='0' viewBox='0 0 24 24' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''%3E%3Cg%3E%3Cpath d='M12 16a1 1 0 0 1-.71-.29l-6-6a1 1 0 0 1 1.42-1.42l5.29 5.3 5.29-5.29a1 1 0 0 1 1.41 1.41l-6 6a1 1 0 0 1-.7.29z' data-name='16' fill='%23ffffff' data-original='%23000000' class=''%3E%3C/path%3E%3C/g%3E%3C/svg%3E\")",
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
