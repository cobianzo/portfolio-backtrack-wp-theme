const { domReady } = wp;
( function () {
	// Función de debounce (Helper)
	const debounce = ( func, delay ) => {
		let timeoutId;
		return ( ...args ) => {
			clearTimeout( timeoutId );
			timeoutId = setTimeout( () => func.apply( null, args ), delay );
		};
	};

	// INPUT LOOKUP - Helper Función de búsqueda de tickers
	// =============================================
	const searchYahooFinanceTickers = async ( searchTerm ) => {
		const { apiFetch } = wp;

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

	// Setup input: Función para configurar búsqueda
	const setupTickerSearch = ( inputSelector, resultsSelector ) => {
		const searchInput = document.querySelector( inputSelector );
		const resultsContainer = document.querySelector( resultsSelector );

		// The handler debounded for the input typing
		const handleSearch = debounce( async ( event ) => {
			const searchTerm = event.target.value.trim();

			resultsContainer.innerHTML = '';

			if ( searchTerm.length < 2 ) return;

			resultsContainer.innerHTML = '<div>Buscando ' + searchTerm + '...</div>';

			try {
				const tickers = await searchYahooFinanceTickers( searchTerm );
				const datalist = document.getElementById( 'ticker-options' );
				datalist.innerHTML = '';
				console.log( '@TODELETE, handle search found: ', tickers );
				tickers.forEach( ( ticker ) => {
					const option = document.createElement( 'option' );
					option.value = ticker.symbol;
					datalist.appendChild( option );
				} );
			} catch ( error ) {
				console.error( error );
			}
		}, 300 );

		// bind the event when typing
		searchInput.addEventListener( 'input', handleSearch );
		searchInput.addEventListener( 'change', function ( event ) {
			console.log( 'TODELETE Selected value from datalist: ', event.target.value );
		} );
		// bind the event when selecting:
		searchInput.addEventListener( 'blur', async function ( event ) {
			try {
				const tickers = await searchYahooFinanceTickers( event.target.value );
				if ( ! tickers.length ) event.target.value = '';
			} catch ( error ) {
				event.target.value = '';
			}
		} );
	};

	// SHOW RESULTS button
	// ==================================
	const setupShowResultsButton = ( btnWraperSelector, resultsSelector ) => {
		const btnWraper = document.querySelector( btnWraperSelector );
		const resultsContainer = document.querySelector( resultsSelector );

		// WIP - on show returns, call the API of yahoo to retrieve the historical data of the selected stock
	};
	// ==================================
	// ==================================
	// ==================================
	// ==================================
	// ==================================
	// Inicializar cuando el DOM esté cargado
	domReady( () => {
		setupTickerSearch( '#ticker-lookup', '#ticker-search-results' );
		setupShowResultsButton( '#show-results-button', '#ticker-search-results' );
	} );
} )();
