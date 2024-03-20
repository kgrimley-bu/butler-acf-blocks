jQuery( window ).load( function() {

	jQuery( '.sidebar-menu__desktopToggle' ).on( 'click', desktopToggle );
    jQuery( '.sidebar-menu__mobileToggle' ).on( 'click', mobileToggle );


	function mobileToggle() {
        jQuery( '.hide-overflow' ).toggle();
    }
    
    function desktopToggle() {
    	jQuery( '.hide-overflow' ).toggle();
    	jQuery( this ).html( 'Hide Links' );
    }
} );