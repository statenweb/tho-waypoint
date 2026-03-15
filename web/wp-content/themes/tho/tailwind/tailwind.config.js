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
			screens: {
				DEFAULT: '980px',
			},
		},
		extend: {
			colors: {
				// THO Brand Colors
				'tho-black': '#000000',
				'tho-white': '#FFFFFF',
				'tho-dark-green': '#007129',
				'tho-medium-green': '#00FF01',
				'tho-light-green': '#AAFFAA',
				// THO Grays
				'tho-near-black': '#333333',
				'tho-dark-gray': '#605E5E',
				'tho-medium-gray': '#727272',
				'tho-gray': '#999999',
				'tho-warm-gray': '#A0A09F',
				'tho-light-gray': '#B0B0B0',
				'tho-lighter-gray': '#CCCCCC',
				// THO Teals (secondary palette)
				'tho-teal': '#00CEA8',
				'tho-cyan': '#9FEFE0',
				'tho-deep-teal': '#008970',
				'tho-dark-teal': '#004538',
				// System / Brand
				'tho-red': '#ED1C24',
				'tho-blue': '#0088CB',
				'tho-gold': '#FFCB05',
			},
			fontFamily: {
				// Display / Hero / Nav
				display: ['Aero', 'Monument Extended', 'Impact', 'sans-serif'],
				// Headings
				heading: ['Aeonik', 'Inter', 'system-ui', 'sans-serif'],
				// Body copy
				body: ['Aeonik', 'Inter', 'system-ui', 'sans-serif'],
				// Navigation / Caption
				nav: ['DIN Next W01 Light', 'system-ui', 'sans-serif'],
			},
			fontSize: {
				'display': ['110px', { lineHeight: '1', letterSpacing: '0.02em', textTransform: 'uppercase' }],
				'heading-xl': ['42px', { lineHeight: '1.2' }],
				'heading-lg': ['35px', { lineHeight: '1.25', fontStyle: 'italic' }],
				'heading-md': ['23px', { lineHeight: '1.3' }],
				'heading-sm': ['20px', { lineHeight: '1.4' }],
				'body-lg': ['17px', { lineHeight: '1.6' }],
				'body-md': ['15px', { lineHeight: '1.6' }],
				'body-sm': ['14px', { lineHeight: '1.5' }],
				'nav': ['16px', { lineHeight: '1.5', textTransform: 'uppercase' }],
				'caption': ['12px', { lineHeight: '1.4' }],
			},
			spacing: {
				'header': '85px',
				'section': '80px',
				'section-sm': '40px',
			},
			transitionDuration: {
				'tho': '400ms',
			},
			transitionTimingFunction: {
				'tho': 'ease',
			},
			borderRadius: {
				'tho': '0px',
			},
			maxWidth: {
				'tho': '980px',
			},
			backgroundImage: {
				'black-menu-arrow': "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.com/svgjs' width='512' height='512' x='0' y='0' viewBox='0 0 24 24' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''%3E%3Cg%3E%3Cpath d='M12 16a1 1 0 0 1-.71-.29l-6-6a1 1 0 0 1 1.42-1.42l5.29 5.3 5.29-5.29a1 1 0 0 1 1.41 1.41l-6 6a1 1 0 0 1-.7.29z' data-name='16' fill='%23000000' data-original='%23000000' class=''%3E%3C/path%3E%3C/g%3E%3C/svg%3E\")",
				'white-menu-arrow': "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.com/svgjs' width='512' height='512' x='0' y='0' viewBox='0 0 24 24' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''%3E%3Cg%3E%3Cpath d='M12 16a1 1 0 0 1-.71-.29l-6-6a1 1 0 0 1 1.42-1.42l5.29 5.3 5.29-5.29a1 1 0 0 1 1.41 1.41l-6 6a1 1 0 0 1-.7.29z' data-name='16' fill='%23ffffff' data-original='%23000000' class=''%3E%3C/path%3E%3C/g%3E%3C/svg%3E\")",
			},
		},
		otherSizes: {
			mobileBreak: '550px',
			mobileBreakPlus1: '551px',
			largerBreak: '768px',
			largestBreakpoint: '980px',
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
