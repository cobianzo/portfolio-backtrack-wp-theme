module.exports = {
	content: [
		'./src/**/*.{php,html,js,jsx,ts,tsx}',
		'./template-parts/**/*.php',
		'./templates/**/*.php',
		'./patterns/**/*.php',
		'./parts/**/*.html',
		'./*.php',
	],
	theme: {
		extend: {},
	},
	plugins: [],
	corePlugins: {
		preflight: false, // Disable base styles that might conflict with WordPress
	},
};
