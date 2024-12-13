import domReady from '@wordpress/dom-ready';
import { loadTemplateAjax } from '../../dynamic-partials-plugin/loadTemplateAjax';

domReady( () => {
	/**
	 * adding or modifying a contribution for a ticker and a year, using the form
	 */
	const form = document.querySelector( '#ticker-contribution-form' );
	form.addEventListener( 'submit', ( event ) => {
		event.preventDefault();
		const ticker = event.currentTarget.dataset.ticker;
		const year = event.currentTarget.querySelector( 'input[name="year"]' ).value;
		const formdata = new FormData();
		formdata.append( 'action', 'add_contribution_year' );
		formdata.append( 'nonce', window.myJS.nonce );

		formdata.append( 'ticker', ticker );
		formdata.append( 'year', year );
		formdata.append(
			'amount',
			event.currentTarget.querySelector( 'input[name="amount"]' ).value
		);

		console.log( 'TODELETE form DAta', formdata );
		fetch( window.myJS.ajaxurl, {
			method: 'POST',
			body: formdata,
		} )
			.then( ( response ) => response.json() )
			.then( ( data ) => {
				console.log( 'TODELETE data response ajax part edit ticker', data );
				if ( data.success ) {
					console.log( 'Ticker contribution added:', data.data );

					loadTemplateAjax(
						'stock-templates/blocks/part-edit-contribution-list',
						'[data-dynamic-partial="part-edit-contribution-list"]',
						{ ticker }
					);
				}
			} )
			.catch( ( error ) => {
				console.error(
					'Error in fetching ticker contribution for "add_ticker_contribution":',
					error,
					formdata
				);
			} );
	} );
} ); // end dom ready

/**
 * removing
 * @param event
 */
window.handleRemoveContribution = function ( event ) {
	event.preventDefault();
	const ticker = event.currentTarget.dataset.ticker;
	const year = event.currentTarget.dataset.year;
	const formdata = new FormData();
	formdata.append( 'action', 'remove_contribution_year' );
	formdata.append( 'nonce', window.myJS.nonce );
	formdata.append( 'ticker', ticker );
	formdata.append( 'year', year );
	console.log( 'TODELETE form DAta', formdata );
	fetch( window.myJS.ajaxurl, {
		method: 'POST',
		body: formdata,
	} )
		.then( ( response ) => response.json() )
		.then( ( data ) => {
			console.log( 'TODELETE data response ajax removing year contrib', data );
			if ( data.success ) {
				loadTemplateAjax(
					'stock-templates/blocks/part-edit-contribution-list',
					'[data-dynamic-partial="part-edit-contribution-list"]',
					{ ticker }
				);
			}
		} );
};
