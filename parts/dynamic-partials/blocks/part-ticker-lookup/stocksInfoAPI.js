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

export const getTickerInfoBySymbol = async ( symbol ) => {
	try {
		const response = await apiFetch( {
			path: `/stock-api/search?ticker=${symbol}&unique=true`,
		} );
		console.log( 'TODELETE: API Response getTickerInfoBySymbol:', response );
		return response; // returns object with the info or false (null if error)
	} catch ( error ) {
		console.error( 'Internal WP API Error on custom endpoint getTickerInfoBySymbol:', error );
		return null;
	}
}

export async function tickerExists( symbol ) {
	try {
		const ticker = await getTickerInfoBySymbol( symbol );
		if ( ! ticker ) return false;
		return ticker;
	} catch ( error ) {
		return false;
	}
}
