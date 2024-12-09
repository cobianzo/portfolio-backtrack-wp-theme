module.exports = {
	...require( '@wordpress/prettier-config' ),
	printWidth: 200, // Don't format line length
	overrides: [
		{
			files: '*.md', // Target only markdown files
			options: {
				proseWrap: 'preserve', // Preserve wrapping in markdown files
			},
		},
	],
};
