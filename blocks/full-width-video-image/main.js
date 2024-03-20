jQuery( function( $ ) {
    function hasReduceMotion() {
        return window.matchMedia( "(prefers-reduced-motion: reduce)" ).matches;
    }

    function isInViewport( element ) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= ( window.innerHeight || document.documentElement.clientHeight ) &&
            rect.right <= ( window.innerWidth || document.documentElement.clientWidth )
        );
    }

    document.querySelectorAll( '.full-width-video-image-plyr-mp4' ).forEach( ( player ) => {
        const fullVideoPlayer = new Plyr( player, {
            autoplay: false,
            muted: true,
            iconPrefix: 'plyr',
            iconUrl: '/wp-content/plugins/butler-acf-blocks/assets/images/plyr.svg',
            controls: [ 'play-large' ]
        });

        if ( hasReduceMotion() == false ) {
            fullVideoPlayer.play();
        }
    });

    gsap.registerPlugin( ScrollTrigger, ScrollToPlugin );

    const text1 = ".full-width-video-image__outlined-line-1";
    const text2 = ".full-width-video-image__outlined-line-2";
    const outlineWrap = ".full-width-video-image__outlined";
    const mediaWrap = ".full-width-video-image__wrapper";
    const headlineText = ".full-width-video-image__headline";

    const showHeadline = () => {
        document.querySelectorAll( headlineText ).forEach( ( headline ) => {
            // We want to prevent not-visible headlines from being shown. 
            //Only add this class if the headline is in the viewport.
            if( isInViewport( headline ) ) {
                headline.classList.add( 'full-width-video-image__headline--show' );
            }
        });   
    }

    const hideHeadline = () => {
        document.querySelectorAll( headlineText ).forEach( ( headline ) => {
            headline.classList.remove( 'full-width-video-image__headline--show' );
        });
    }

    if ( hasReduceMotion() == false ) {
        const timeline = gsap.timeline();

        document.querySelectorAll( text1 ).forEach( ( headline ) => {
            timeline.to(headline, {
                scrollTrigger: {
                    trigger: outlineWrap,
                    start: "top 50%",
                    endTrigger: outlineWrap,
                    end: "top 90%",
                    scrub: 3,
                    id: "outlined 1"
                },
                x: '50%',
            }, 0);
        });

        document.querySelectorAll( text2 ).forEach( ( headline ) => {
            timeline.to( headline, {
                scrollTrigger: {
                    trigger: outlineWrap,
                    start: "top 50%",
                    endTrigger: outlineWrap,
                    end: "top 90%",
                    scrub: 3,
                    id: "outlined 2"
                },
                x: '-50%',
            }, 0);
        });

        if ( document.querySelector( mediaWrap ) ) {
            document.querySelectorAll( mediaWrap ).forEach( ( wrap ) => {

                timeline.from( wrap, 
                    {
                        scrollTrigger: {
                            trigger: wrap,
                            start: "top 160px",
                            end: "bottom",
                            scrub: true,
                            id: "wrapper",
                            pin: true,
                            onUpdate: self => {
                                // controls toggling on headline
                                if( self.progress >= 0 && self.direction == 1 ) {
                                    showHeadline();
                                }

                                if( self.progress > 0 && self.direction == -1 ) {
                                    showHeadline();
                                } else if ( self.progress == 0 && self.direction == -1 ) {
                                    hideHeadline();
                                }
                            },
                        },
                        scale: 1.5,
                },
                '<'
            );
        });} else if ( document.querySelector( '.full-width-video-image' ) ) {
            document.forEach( block => {
                block.classList.add( 'full-width-video-image--no-motion' );
                showHeadline();
            } );
        }
    }
});
