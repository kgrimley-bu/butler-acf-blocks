jQuery( function( $ ) {

    /* !! Old code from the original block. Deals with FancyCursor !!
    import { createApp } from 'vue'

    import { initBlock } from './util/blocks'

    import Sketches from '../components/sketches.vue';

    import FancyCursor from '../components/fancy-cursor.vue';

    import './callout-two-column-quote.css'

    initBlock('callout-two-column-quote__item', (el) => {
        const two_col_quote = createApp({
            name: 'Two Column Quote',
            data() {
                return {
                    image: '',
                    kicker: '',
                    headline: '',
                    description: '',
                    cta: ''
                }
            },
            components: {
                Sketches
            },
            mounted() {

                this.image = el.querySelector('.callout-two-column-quote__media'),
                    this.kicker = el.querySelector('.callout-two-column-quote__kicker'),
                    this.headline = el.querySelector('.callout-two-column-quote__heading'),
                    this.description = el.querySelector('.callout-two-column-quote__quote-text'),
                    this.cta = el.querySelector('.callout-two-column-quote__links')

            }
        });

        two_col_quote.component('fancy-cursor', FancyCursor);
        two_col_quote.mount(el);
    });*/

    gsap.registerPlugin(ScrollTrigger);

    const selectAll = e => document.querySelectorAll(e);
    const quotes = selectAll(".callout-two-column-quote__text");
    const images = selectAll(".callout-two-column-quote__media");

    quotes.forEach((quote, i) => {
        gsap.to(quote, {
            scrollTrigger: {
                trigger: quote,
                start: "top 50%",
                endTrigger: quote,
                end: "bottom 30%",
                scrub: 1,
                id: "quote"
            },
            y: '5%',
            duration: 2
        });
    });

    images.forEach((image, i) => {
        gsap.to(image, {
            scrollTrigger: {
                trigger: image,
                start: "top 50%",
                endTrigger: image,
                end: "bottom 30%",
                scrub: 1,
                id: "quote"
            },
            y: '-3%',
            duration: 2
        });
    });
});
