const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );
const glob = require( 'glob' );

const entryPoints = defaultConfig.entry();

// Escanear todos los directorios en /src y buscar index.js
glob.sync( './parts/dynamic-partials/blocks/**/*.js' ).forEach( ( file ) => {
	const entry = path.basename( file, '.js' );
	entryPoints[ entry ] = path.resolve( __dirname, file );
} );

entryPoints[ 'load-template-ajax' ] = './parts/dynamic-partials/load-template-ajax.js';

module.exports = {
	...defaultConfig,
	entry: {
		...defaultConfig.entry,
		...entryPoints,
	},
	output: {
		...defaultConfig.output,
		path: path.resolve( __dirname, 'build' ),
		filename: '[name].js',
	},
};
