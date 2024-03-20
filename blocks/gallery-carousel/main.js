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
function waitForElement( selector ) {
	return new Promise ( ( resolve ) => {
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

jQuery( document ).ready( function ( $ ) {
	waitForElement( '.gallery-carousel__slider-swipper' ).then( () => {
		const gallerySliders = document.querySelectorAll( ".gallery-carousel__slider-swipper" );
		const slideCount = document.querySelectorAll( ".swiper-slide" ).length;
		console.log( slideCount );
		console.log( 'main gallery carousel' );
		let hasAutoPlay;

		function hasReduceMotion () {
			return window.matchMedia( "(prefers-reduced-motion: reduce)" ).matches;
		}

		const resizeSlides = ( swiper ) => {
			if ( window.innerWidth < 768 ) {
				const allSlides = document.querySelectorAll( ".swiper-slide" );
				const allImages = swiper.imagesToLoad;

				if ( allSlides.length > 0 ) {
					let slidesHeight = [];

					allSlides.forEach( ( el ) => {
						slidesHeight.push( el.offsetHeight );
					});

					const tallestSlide = slidesHeight.sort( function ( a, b ) {
						return b - a;
					})[ 0 ];

					allImages.forEach( ( img ) => {
						if ( img.classList.contains( "gallery-carousel__bg-poster" ) ) {
							img.style.height = tallestSlide + "px";
						}
					});
				}
			}
		};

		if ( hasReduceMotion() == false ) {
			hasAutoPlay = {
				delay: 7000,
				disableOnInteraction: false,
			};
		} else {
			hasAutoPlay = false;
		}
		if ( slideCount > 1 ) {
			gallerySliders.forEach( ( slide ) => {
				const useAutoHeight = window.innerWidth < 1023 && slide.querySelectorAll( ".gallery-carousel__wrapper--no-cutout" ).length > 0 ? true : false;
				new Swiper( slide, {
					loop: true,
					watchSlidesProgress: true,
					autoplay: hasAutoPlay,
					autoHeight: useAutoHeight,
					pagination: {
						el: ".swiper-pagination",
						clickable: true,
						renderBullet: ( index, className ) => {
							const labelArray = JSON.parse( slide.querySelector( ".swiper-pagination" ).dataset.labels );
							const buttonLabel = labelArray[ index ].length > 0 ? labelArray[ index ] : `<span class="sr-only">Slide ${ index + 1 }</span>`;

							return `<div class="${ className }" data-current="${ slide.swiper.activeIndex }">
							<button class="swiper__itemButton gallery-carousel__button" data-slide-id="${ index + 1 }">
							${ buttonLabel }
							</button>
							<span class="swiper__itemPill"></span>
							</div>`;
						},
					},
					on: {
						init: resizeSlides,
					},
				});
			});

	  // pause slides button
			let thisSwiper = document.querySelector( ".gallery-carousel__slider-swipper" );
			let swiper = thisSwiper !== null ? thisSwiper.swiper : false;
			let pauseSlidesButton = document.querySelector( ".gallery-carousel__pauseButton" );

			if ( thisSwiper && pauseSlidesButton ) {
				if ( hasReduceMotion() ) {
					pauseSlidesButton.classList.add( "gallery-carousel__pauseButton--isPaused" );
				}

				pauseSlidesButton.addEventListener( "click", () => {
					if ( swiper.autoplay.running == true ) {
						swiper.autoplay.stop();
						pauseSlidesButton.classList.add( "gallery-carousel__pauseButton--isPaused" );
					} else {
						swiper.autoplay.start();
						pauseSlidesButton.classList.remove( "gallery-carousel__pauseButton--isPaused" );
					}
				});

				// slide labels
				const slideLabels = document.querySelectorAll( ".swiper-tag__item" );

				if ( slideLabels.length > 0 ) {
					slideLabels.forEach( ( label ) => {
						label.addEventListener( "click", ( event ) => {
							swiper.slideTo( event.target.dataset.slideId, 1000 );
						});
					});
				}
			}
		}
	})
});
