import domReady from '@wordpress/dom-ready';

window.dynamicPartials = {
	// @BOOK:LOADTEMPLATEAJAX
	// Usage: see below
	loadTemplateAjax: async ( templateName, containerSelector, args = [] ) => {
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
	},

	/**
	 * // @BOOK:LOADTEMPLATEAJAX
	 * Usage:
	 * <form data-dynamic-template-reload="part-edit-contribution-list">
	 * 	must include input 'action', input 'nonce' + the args for the php template as inputs
	 *
	 * The ajax action in the input will be executed in php
	 * After the action is finished, we can reload certain templates separated by comma in
	 * the attr 'data-dynamic-template-reload'. The templates are stock-templates/blocks
	 *	@TODO: when this form is regenerated we need to make it work
	 * @param e
	 */
	handleSubmitFormAndLoadTemplateAjax: async ( e ) => {
		e.preventDefault();
		const sform = e.target;
		const formdata = new FormData( sform );
		const params = {};
		for ( const [ key, value ] of formdata.entries() ) {
			params[ key ] = value;
		}

		console.log( 'Retrieved params:', params );
		let templateNames = sform.getAttribute( 'data-dynamic-template-reload' );

		if ( ! templateNames ) {
			// if the template names is not in the data attribute,
			// let's see if it's in the hidden input
			if ( params.template_names ) {
				templateNames = params.template_names;
			}
		}
		const templateNamesArray = templateNames.split( ',' );
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
					const params = Object.fromEntries( formdata );
					templateNamesArray.forEach( ( templateName ) => {
						window.dynamicPartials.loadTemplateAjax(
							`stock-templates/blocks/${ templateName.trim() }`,
							`[data-dynamic-partial="${ templateName.trim() }"]`,
							params
						);
					} );
				}
			} )
			.catch( ( error ) => {
				console.error(
					`Error in fetching ticker contribution for "${ params.action }":`,
					error,
					params
				);
			} );
	},

	// Apply the handler to all forms with the attr `data-dynamic-template-reload`
	submitFormAndLoadTemplateAjax: async () => {
		const forms = document.querySelectorAll( 'form[data-dynamic-template-reload]' );
		forms.forEach( ( form ) => {
			form.addEventListener( 'submit', async ( e ) => {
				await window.dynamicPartials.handleSubmitFormAndLoadTemplateAjax( e );
			} ); // end add event listener
		} ); // end loop forms
	},
};

domReady( () => {
	// async
	window.dynamicPartials.submitFormAndLoadTemplateAjax();
} );
