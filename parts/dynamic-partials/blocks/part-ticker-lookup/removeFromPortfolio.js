import { loadTemplateAjax } from "../../loadTemplateAjax";

export const setupRemoveFromPortfolio = ( removeFromPortfolioButtonParent, buttonSelector ) => {
	document.querySelector(removeFromPortfolioButtonParent).addEventListener('click', async function(event) {
		if (event.target.matches( buttonSelector )) {
			console.log('TODELTEL removing from portfoi');
			const buttonElement = event.target;
			// WIP - with ajax, add the ticker to the current user.
			const ticker = buttonElement.getAttribute('data-ticker');
			const formdata = new FormData();
			formdata.append('action', 'remove_from_current_user_portfolio');
			formdata.append('nonce', window.myJS.nonce);
			formdata.append('ticker', ticker);
			try {
				const response = await fetch(window.myJS.ajaxurl, { method: 'POST', body: formdata });
				const result = await response.json();

				if (result.success) {
					console.log('Ticker added to portfolio:', result.data);
				} else {
					console.error('Error en la respuesta setupAddToPortfolio:', result.data);
				}
			} catch (error) {
					console.error('Error en la solicitud AJAX setupAddToPortfolio:', error);
			} // end try/catch

			// reload the template part.
			console.log('TODEL reloading tempalte part.', ticker);
			loadTemplateAjax('parts/dynamic-partials/programmatic-partials/partial-add-to-portfolio-button',
				'.add-remove-button-wrapper', { "symbol": ticker } );
		}
	});
}
