/**
 * Shows and hides the correct icon for the Play/Pause button on the ticker.
 * 
 * @param { "true" | "false" } isPaused - String stating whether the ticker is paused i.e. `"true"` or `"false"`
 * @param { Element } pauseIcon - Element containing the `pause` SVG icon for the ticker icon wrapper.
 * @param { Element } playIcon - Element containing the `play` SVG icon for the ticker icon wrapper.
 */
function playPauseHelper( isPaused, pauseIcon, playIcon ) {  
    if ( isPaused === "false" ) {
        playIcon.classList.remove( "ticker__ticker-icon--show" );
        pauseIcon.classList.add( "ticker__ticker-icon--show" );
    } else if ( isPaused === "true" ) {
        playIcon.classList.add( "ticker__ticker-icon--show" );
        pauseIcon.classList.remove( "ticker__ticker-icon--show" );
    }
}

const ticker_container = document.querySelectorAll( ".ticker__container" );
/**
 * Add the `onClick()` handlers for each piece PER MODAL BLOCK ON THE PAGE. 
 * This allows us to have multiple `ticker` blocks on one page.
 */
ticker_container.forEach( ( modal ) => {
    // Holds the SVG icons for play and pause.
    let pausePlayButton = modal.querySelector( '.ticker__ticker-icon-wrapper' );
    // SVG icon for pause.
    let pauseIcon = modal.querySelector( '.ticker__ticker-icon--pause' );
    // SVG icon for play.
    let playicon = modal.querySelector( '.ticker__ticker-icon--play' );
    // Wraper for the ticker. Holds the mouseenter and mouseleave listeners.
    let tickerWrap = modal.querySelector( '.ticker__ticker-wrap' );
    // The ticker itself (the words that move across the screen & the play/pause button).
    // Also holds the animation keyframes.
    let ticker = modal.querySelector( '.ticker__ticker' );
    
    pausePlayButton.onclick = function () {
        if ( tickerWrap.dataset.paused === "false" ) {
            tickerWrap.dataset.paused = "true";
            ticker.classList.add( "ticker__ticker--paused" );
        } else if ( tickerWrap.dataset.paused === "true" ) {
            tickerWrap.dataset.paused = "false";
            ticker.classList.remove( "ticker__ticker--paused" );
        }  

        playPauseHelper( tickerWrap.dataset.paused, pauseIcon, playicon );
    };

    tickerWrap.addEventListener( "mouseenter", function () {
        pausePlayButton.classList.add( "ticker__ticker-icon-wrapper--show" );
        playPauseHelper( tickerWrap.dataset.paused, pauseIcon, playicon );
    });

    tickerWrap.addEventListener( "mouseleave", function () {  
        pausePlayButton.classList.remove( "ticker__ticker-icon-wrapper--show" );
        playPauseHelper( tickerWrap.dataset.paused, pauseIcon, playicon );
    });
} );

    