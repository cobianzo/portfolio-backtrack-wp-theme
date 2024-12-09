// Función de debounce (Helper)
export const debounce = ( func, delay ) => {
	let timeoutId;
	return ( ...args ) => {
		clearTimeout( timeoutId );
		timeoutId = setTimeout( () => func.apply( null, args ), delay );
	};
};
