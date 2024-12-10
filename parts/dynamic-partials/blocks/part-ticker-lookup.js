import domReady from '@wordpress/dom-ready';
import { debounce } from './part-ticker-lookup/helpers';
import { searchYahooFinanceTickers, tickerExists, getTickerHistorical } from './part-ticker-lookup/stocksInfoAPI';

// @TODO: aboid using global vars
window.selectedTicker = null;

const setSelectedTicker = ( tickerInfo ) => {
	window.selectedTicker = tickerInfo ?? null;

	// effects to update when it changes
	const resultsContainer = document.querySelector( '#ticker-search-results' );
	if ( ! window.selectedTicker ) {
		resultsContainer.innerHTML = `<div>Use the input to lookup for a ticker</div>`;
	} else {
		resultsContainer.innerHTML = `<div>Selected ${ tickerInfo.shortname }...</div>`;
	}
};
const clearSelectedTicker = () => setSelectedTicker( null );

// INPUT LOOKUP - Helper Función de búsqueda de tickers
// =============================================

// Setup lookup input actions to search tickers
const setupTickerSearch = ( inputSelector ) => {
	const searchInput = document.querySelector( inputSelector );

	// The handler debounded for the input typing
	const handleSearch = debounce( async ( event ) => {
		const searchTerm = event.target.value.trim();

		clearSelectedTicker();

		if ( searchTerm.length < 2 ) return;

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
	searchInput.addEventListener( 'change', async function ( event ) {
		const tickerInInput = await tickerExists( event.target.value );
		setSelectedTicker( tickerInInput );
		console.log( 'TODELETE Selected value from datalist: ', event.target.value );
	} );
	// bind the event when selecting:
	searchInput.addEventListener( 'blur', async function ( event ) {
		const tickerInInput = await tickerExists( event.target.value );
		if ( tickerInInput ) {
			setSelectedTicker( tickerInInput );
			console.log( 'TODELETE: set selected ticker to ' + tickerInInput.symbol, tickerInInput );
		} else {
			event.target.value = '';
		}
	} );
};

// SHOW RESULTS button
// ==================================
const setupShowResultsButton = ( btnWraperSelector, resultsSelector ) => {
	const btn = document.querySelector( btnWraperSelector ).querySelector( 'button' );
	const resultsContainer = document.querySelector( resultsSelector );
	const searchInput = document.querySelector( '#ticker-lookup' );
	// WIP - on show returns, call the API of yahoo to retrieve the historical data of the selected stock

	btn.addEventListener( 'click', async () => {
		const currentTicker = await tickerExists( searchInput.value.trim() );
		if ( currentTicker ) {
			setSelectedTicker( currentTicker );
		} else clearSelectedTicker();
		console.log( `TODELETE: look for historical data for ${ searchInput.value.trim() }`, currentTicker );
		if ( ! currentTicker ) resultsContainer.innerHTML = `Ticker <b>${ searchInput.value }</b> invalid`;
		else resultsContainer.innerHTML = `Evaluating <b>${ searchInput.value }, ${ currentTicker.shortname }</b>`;

		// retrieve the data for the years
		const historicalData = await getTickerHistorical( currentTicker.symbol );
		console.log( `%cTODELETE: historical data `, 'font-size:2rem;', historicalData );
	} );
};
// ==================================
// ==================================
// ==================================
// ==================================
// ==================================
// Inicializar cuando el DOM esté cargado
domReady( () => {
	setupTickerSearch( '#ticker-lookup' );
	setupShowResultsButton( '#show-results-button', '#ticker-search-results' );
} );
