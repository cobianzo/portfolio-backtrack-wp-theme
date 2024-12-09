import apiFetch from '@wordpress/api-fetch';
export const searchYahooFinanceTickers = async ( searchTerm ) => {
	try {
		const response = await apiFetch( {
			path: '/stock-api/search?ticker=' + searchTerm,
		} );
		console.log( 'TODELETE: API Response:', response );
		return response; // returns array of objects, each one a stock..
	} catch ( error ) {
		console.error( 'Internal WP API Error on custom endpoint:', error );
		throw error;
	}
};

// Función de debounce (Helper)
export const debounce = ( func, delay ) => {
	let timeoutId;
	return ( ...args ) => {
		clearTimeout( timeoutId );
		timeoutId = setTimeout( () => func.apply( null, args ), delay );
	};
};
