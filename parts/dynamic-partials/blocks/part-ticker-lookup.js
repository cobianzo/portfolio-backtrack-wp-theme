import domReady from '@wordpress/dom-ready';
import { debounce } from './part-ticker-lookup/helpers';
import { searchYahooFinanceTickers, tickerExists } from './part-ticker-lookup/stocksInfoAPI';

// @TODO: aboid using global vars
window.selectedTicker = null;

const setSelectedTicker = ( symbol ) => {
	window.selectedTicker = symbol;
};
const clearSelectedTicker = ( ) => {
	window.selectedTicker = null;
}

// INPUT LOOKUP - Helper Función de búsqueda de tickers
// =============================================

// Setup lookup input actions to search tickers
const setupTickerSearch = ( inputSelector, resultsSelector ) => {
	const searchInput = document.querySelector( inputSelector );
	const resultsContainer = document.querySelector( resultsSelector );

	// The handler debounded for the input typing
	const handleSearch = debounce( async ( event ) => {
		const searchTerm = event.target.value.trim();

		clearSelectedTicker();
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
		if ( ! currentTicker ) resultsContainer.innerHTML = `Ticker <b>${ searchInput.value }</b> invalid`;
		else resultsContainer.innerHTML = `Evaluating <b>${ searchInput.value }, ${ currentTicker.shortname }</b>`;
	} );
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
