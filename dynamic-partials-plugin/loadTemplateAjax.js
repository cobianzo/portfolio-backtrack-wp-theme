// @BOOK:LOADTEMPLATEAJAX
// Javascript helper to easily load or reload a php template into a container.

export const loadTemplateAjax = async ( templateName, containerSelector, args = [] ) => {
	const formdata = new FormData();
	formdata.append( 'action', 'load_template_ajax' );
	formdata.append( 'template_name', templateName );
	formdata.append( 'args', JSON.stringify( args ) );
	formdata.append( 'nonce', window.myJS.nonce );

	const containerAll = document.querySelectorAll( containerSelector );
	if ( ! containerAll ) {
		console.error(
			'loadTemplateAjax called but we didnt find the container:',
			containerSelector
		);
		return;
	}
	try {
		const response = await fetch( window.myJS.ajaxurl, {
			method: 'POST',
			body: formdata,
		} );

		const result = await response.json();

		if ( result.success ) {
			containerAll.forEach( ( container ) => {
				container.innerHTML = result.data;
			} );
		} else {
			console.error( 'Error en la respuesta loadTemplateAjax:', result.data );
		}
	} catch ( error ) {
		console.error( `Error en la solicitud AJAX loadTemplateAjax:`, templateName, error );
	} // end try/catch
};
