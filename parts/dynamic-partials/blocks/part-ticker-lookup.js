import domReady from '@wordpress/dom-ready';
import { setupShowResultsButton } from './part-ticker-lookup/divsTable';
import { setupTickerSearch } from './part-ticker-lookup/lookupticker';
import { loadTemplateAjax } from '../loadTemplateAjax';
import { setupAddToPortfolio } from './part-ticker-lookup/addToPortfolio';
import { setupRemoveFromPortfolio } from './part-ticker-lookup/removeFromPortfolio';
// GENERIC VARIABLES AND FUNCTIONS, MEANT TO BE USED BY OTHER COMPONENTS IN THE PAGE.
// ==================================
// ==================================

// @TODO: avoid using global vars
window.selectedTicker = null;

window.setSelectedTicker = ( tickerInfo ) => {
	window.selectedTicker = tickerInfo ?? null;

	// effects to update when it changes
	const resultsContainer = document.querySelector( '#ticker-search-results' );
	if ( ! window.selectedTicker ) {
		resultsContainer.innerHTML = `<div>Use the input to lookup for a ticker</div>`;
	} else {
		resultsContainer.innerHTML = `<div>Selected ${ tickerInfo.shortname }...</div>`;
	}
};
window.clearSelectedTicker = () => window.setSelectedTicker( null );


// ==================================
// ==================================
// ==================================
// ==================================
// ==================================
// Inicializar cuando el DOM esté cargado
domReady( () => {
	setupTickerSearch( '#ticker-lookup' );
	setupShowResultsButton( '#ticker-lookup-form', '#ticker-search-results' );
	setupAddToPortfolio( '.coco-dynamic-block-wrapper', '#add-to-portfolio-button button' );
	setupRemoveFromPortfolio( '.coco-dynamic-block-wrapper', '#remove-from-portfolio-button button' );

	// Test  @TODELETE
	const testButton = document.querySelector( '#my-test' );
	const containerTest = document.querySelector( '#container-test' );
	testButton.addEventListener( 'click', () => {
		console.log( 'testing:' );

		loadTemplateAjax(
			'parts/dynamic-partials/programmatic-partials/partial-dividends-results',
			'#container-test',
			{ "data": { "2001": { "title" : "a"}, "2003": { "title" : "b"} },
				"options": { "append": { "title" : "titlereforbs" } } }
		);
	} );
} );
