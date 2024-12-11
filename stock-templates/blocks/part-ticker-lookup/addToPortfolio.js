import { loadTemplateAjax } from '../../../dynamic-partials-plugin/loadTemplateAjax';

// @TODO: The function to add/remove from to portfolio must be in a separated lib

const handleAddRemoveFromPortfolio = async ( event ) => {
	// conditions - the partial must be wrapped in a container with id
	//	and the attrs in the button with the handler data-ticker and data-action are mandatory
	const buttonElement = event.currentTarget;
	const ticker = buttonElement.getAttribute( 'data-ticker' );
	const parentContainerSelector = `[data-template-container="add-remove-button-wrapper-${ ticker }"]`;
	const action = buttonElement.getAttribute( 'data-action' );

	const ajaxAction =
		action === 'add' ? 'add_to_current_user_portfolio' : 'remove_from_current_user_portfolio';
	const formdata = new FormData();
	formdata.append( 'action', ajaxAction );
	formdata.append( 'nonce', window.myJS.nonce );
	formdata.append( 'ticker', ticker );
	try {
		const response = await fetch( window.myJS.ajaxurl, { method: 'POST', body: formdata } );
		const result = await response.json();

		if ( result.success ) {
			console.log( 'Ticker added or removed to portfolio:', result.data );
		} else {
			console.error( 'Error en la respuesta setupAddToPortfolio:', result.data );
		}
	} catch ( error ) {
		console.error( 'Error en la solicitud AJAX setupAddToPortfolio:', error );
	} // end try/catch

	// reload the template part.
	console.log( 'TODEL reloading tempalte part.', ticker );
	loadTemplateAjax(
		'stock-templates/sub-templates/partial-add-to-portfolio-button',
		parentContainerSelector,
		{ symbol: ticker }
	);
};

export const setupAddToPortfolio = () => {
	// expose the handle to the DOM so we can call it on onclick of the buttons, which is cleaner.
	// see the php view 'partial-add-to-portfolio-button.php'. The data attributes tot he button must be there
	window.handleAddRemoveFromPortfolio = handleAddRemoveFromPortfolio;
};
