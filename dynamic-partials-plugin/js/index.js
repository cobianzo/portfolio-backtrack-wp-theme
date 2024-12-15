import domReady from '@wordpress/dom-ready';
import { handleSubmitFormAndLoadTemplateAjax } from '../public-helpers';

domReady( () => {
	const forms = document.querySelectorAll( 'form[data-dynamic-template-reload]' );
	forms.forEach( ( form ) => {
		form.addEventListener( 'submit', async ( e ) => {
			await handleSubmitFormAndLoadTemplateAjax( e );
		} ); // end add event listener
	} ); // end loop forms
} );
