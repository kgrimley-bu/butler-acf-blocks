let currentlyOpenModal = null;

const s = new Swiper( ".gallery-modal__swipper", {
    direction: 'horizontal',
    loop: true,
    slidesPerView: 1.5,
    spaceBetween: 23,
    centeredSlides: true,
    keyboard: {
        enabled: true,
    },
    pagination: {
        el: '.swiper-pagination',
        type: 'fraction',
        clickable: true
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

/**
 * Causes the passed in `modal` element (this should be the element that includes a Swiper)
 * to be visible by setting `visibility = "visible"`.
 * 
 * @param { Element } modal - Modal Element to show on page.
 */
function openModal( modal ) {
    let dialog = modal.querySelector('.gallery-modal__dialog');
    dialog.style.zIndex = '10';
    dialog.style.visibility = 'visible';
    dialog.classList.toggle('bounce-enter');
    modal.getElementsByClassName( "gallery-modal__wrapper" )[0].classList.add('gallery-modal__wrapper--open');
    currentlyOpenModal = modal;
}

/**
 * Causes the passed in `modal` element (this should be the element that includes a Swiper)
 * to be invisible by setting `visibility = "hidden"`.
 * 
 * @param { Element } modal - Modal Element to hide.
 */
function closeModal ( modal ) {
    let dialog = modal.querySelector('.gallery-modal__dialog');
    dialog.style.zIndex = '0';
    dialog.style.visibility = 'hidden';
    dialog.classList.toggle('bounce-enter');
    modal.getElementsByClassName( "gallery-modal__wrapper" )[ 0 ].classList.remove( 'gallery-modal__wrapper--open' );
    currentlyOpenModal = null;
}

const container = document.querySelectorAll( ".gallery-modal__container" );
/**
 * Add the `onClick()` handlers for each piece PER MODAL BLOCK ON THE PAGE. 
 * This allows us to have multiple `gallery-modal` blocks on one page.
 */
container.forEach( ( modal ) => {
    modal.querySelectorAll( ".gallery-modal__collageImgWrap" ).forEach( function ( picture ) {
        picture.onclick = function () { 
            s.slideToLoop( parseInt( picture.dataset.slidenum ) );
            openModal( modal );
        };
    });

    modal.querySelector( '.gallery-modal__button--open' ).onclick = function () {  
        openModal( modal );
    };
    modal.querySelector( '.gallery-modal__button--close' ).onclick = function () {  
        closeModal( modal );
    };
} );

// When Esc key is pressed, close the modal if it's open.
jQuery( function( $ ) {
    $( document ).on( 'keydown', function ( event ) {
        if ( event.code === "Escape" && currentlyOpenModal ) {
            closeModal( currentlyOpenModal );
        }
    } );
} );

    