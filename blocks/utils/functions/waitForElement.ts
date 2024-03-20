/**
 *  Waits for the specified element to be rendered on the page, THEN replaces it with the React code.
 * 
 * 	@param selector - Class name of the element to look for on the page
 * 
 * 	@returns `Promise<Element | null>` - Returns an element if it finds it on the page, returns null if element is not found
 * 
 * 	@example 
 * 			 waitForElm( '.button-class' ).then( ( elm ) => {
 * 				// run code here once element with class 'button-class' is found.
 * 			 }
 */
function waitForElement( selector: string ) {
	return new Promise<Element | null> ( ( resolve ) => {
		if ( document.querySelector( selector ) ) {
			return resolve( document.querySelector( selector ) );
		}

		const observer = new MutationObserver( ( mutations ) => {
			if ( document.querySelector( selector ) ) {
				resolve( document.querySelector( selector ) );
				observer.disconnect();
			}
		});

		observer.observe( document.body, {
			childList: true,
			subtree: true,
		});
	});
}

export default waitForElement;