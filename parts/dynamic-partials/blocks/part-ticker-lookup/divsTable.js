import { tickerExists, getTickerHistorical } from "./stocksInfoAPI";
import { loadTemplateAjax } from "../../load-template-ajax";

// Load the dividends by submitting the input with the ticker selected
// ==================================
export const setupShowResultsButton = ( formSelector, resultsSelector ) => {
	const form = document.querySelector( formSelector );

	form.addEventListener( 'submit', async (e) => {

		// dont do the default action
		e.preventDefault();

		// prepare data for the ajax
		const formData = new FormData(form);
		const tickerValue = formData.get('ticker-lookup').trim();;

		// validation, check that the input has a symbol that exists
		const currentTicker = await tickerExists( tickerValue.trim() );
		if ( currentTicker ) {
			window.setSelectedTicker( currentTicker );
		} else window.clearSelectedTicker();

		// retrieve the data for the years, using our internal endpoint
		const historicalData = await getTickerHistorical( currentTicker.symbol );
		console.log( `%cTODELETE: historical data `, 'font-size:2rem;', historicalData );

		// Load the table of dividends
		loadTemplateAjax(
			'parts/dynamic-partials/programmatic-partials/partial-dividends-results',
			resultsSelector,
			{ "data": historicalData }
		);

	} );
};