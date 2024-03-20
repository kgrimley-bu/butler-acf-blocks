jQuery( function( $ ) {
    function hasReduceMotion() {
        return window.matchMedia( "(prefers-reduced-motion: reduce)" ).matches;
    }

    document.querySelectorAll( '.jump-finder-video-plyr-mp4' ).forEach( ( player ) => {
        const jumpVideoPlayer = new Plyr( player, {
            autoplay: true,
            muted: true,
            iconPrefix: 'plyr',
            iconUrl: '/wp-content/plugins/butler-acf-blocks/assets/images/plyr.svg',
            controls: [ 'play-large' ]
        });

        if ( hasReduceMotion() == false ) {
            jumpVideoPlayer.play();
        }
    });
});

/*
 *   This content is licensed according to the W3C Software License at
 *   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
 *
 *   Simple accordion pattern example
 */

'use strict';

class jumpFinderAccordion {
  constructor(domNode) {
    this.rootEl = domNode;
    this.buttonEl = this.rootEl.querySelector('button[aria-expanded]');

    const controlsId = this.buttonEl.getAttribute('aria-controls');
    this.contentEl = document.getElementById(controlsId);

    this.open = this.buttonEl.getAttribute('aria-expanded') === 'true';

    // add event listeners
    this.buttonEl.addEventListener('click', this.onButtonClick.bind(this));
  }

  onButtonClick() {
    this.toggle(!this.open);
  }

  toggle(open) {
    // don't do anything if the open state doesn't change
    if (open === this.open) {
      return;
    }

    // update the internal state
    this.open = open;

    // handle DOM updates
    this.buttonEl.setAttribute('aria-expanded', `${open}`);
    if (open) {
      this.contentEl.removeAttribute('hidden');
    } else {
      this.contentEl.setAttribute('hidden', '');
    }
  }

  // Add public open and close methods for convenience
  open() {
    this.toggle(true);
  }

  close() {
    this.toggle(false);
  }
}

// init accordions
document.addEventListener( "DOMContentLoaded", () => {
	const accordions = document.querySelectorAll('.accordion h3');
	accordions.forEach((accordionEl) => {
    if ( accordionEl.querySelector( 'button[aria-expanded]' ) != null) {
	    new jumpFinderAccordion(accordionEl);
    }
	});
} );
