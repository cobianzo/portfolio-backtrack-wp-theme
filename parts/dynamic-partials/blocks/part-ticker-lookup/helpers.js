import apiFetch from '@wordpress/api-fetch';

// Función de debounce (Helper)
export const debounce = ( func, delay ) => {
	let timeoutId;
	return ( ...args ) => {
		clearTimeout( timeoutId );
		timeoutId = setTimeout( () => func.apply( null, args ), delay );
	};
};

export const showTabulatedData = async ( data, selector, options = null ) => {
	const container = document.querySelector( selector );

	// Do my testing for ajax request:
	const formdata = new FormData();
	formdata.append('action', 'generate_table');
	formdata.append('nonce', myJS.nonce);
	formdata.append('data', JSON.stringify(data));

	if ( options ) {
		formdata.append('options', JSON.stringify(options));
	}

	try {
		const response = await fetch(myJS.ajaxurl, {
				method: 'POST',
				body: formdata,
		});

		const result = await response.json();

		if (result.success) {
			container.innerHTML = result.data;
		} else {
			console.error('Error en la respuesta:', result.data);
		}
	} catch (error) {
			console.error('Error en la solicitud AJAX:', error);
	} // end try/catch

}
