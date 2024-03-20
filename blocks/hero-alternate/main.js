jQuery( function( $ ) {
    document.querySelectorAll( '.hero-alternate__video' ).forEach( ( player ) => {

        function hasReduceMotion() {
            return window.matchMedia( "(prefers-reduced-motion: reduce)" ).matches;
        }

        const heroAltPlayer = new Plyr( player, {
            debug: false,
            autoplay: false,
            clickToPlay: false,
            controls: [
                'play'
            ]
        });

        // adds color overlay option to video wrapper
        heroAltPlayer.elements.container.classList.add( 'color-overlay__media' );

        if ( hasReduceMotion() == false ) {
            heroAltPlayer.play();
        }
    });
});