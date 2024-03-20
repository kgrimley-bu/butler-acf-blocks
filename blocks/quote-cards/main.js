window.addEventListener('load', function () {
	jQuery('.quote-cards-wrapper > .acf-innerblocks-container').slick({
		infinite: true,
		slidesToShow: 2,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 800,
				settings: {
					slidesToShow: 1,
				},
			},
		],
	})
})
