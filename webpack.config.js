const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );
const glob = require( 'glob' );

const entryPoints = defaultConfig.entry();

const configFile = path.resolve( __dirname, 'dynamic-partials-plugin/config.json' );
const config = require( configFile );

// Escanear todos los directorios en /src y buscar index.js
glob.sync( '.' + config[ 'js-source-path' ] + '/*.js' ).forEach( ( file ) => {
	const entry = path.basename( file, '.js' );
	entryPoints[ entry ] = path.resolve( __dirname, file );
} );

entryPoints[ 'dynamic-partials-public-helpers' ] = './dynamic-partials-plugin/public-helpers.js';

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
