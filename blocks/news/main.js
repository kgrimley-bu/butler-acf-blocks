var init = false;
var swiper;
function swiperCard() {
  if (window.innerWidth <= 768) {
    if (!init) {
      init = true;
      swiper = new Swiper( ".news__wrapper", {
            direction: 'horizontal',
            loop: false,
            keyboard: {
                enabled: true,
            },
            pagination: {
                el: '.swiper-pagination',
                type: 'fraction',
                clickable: true
            },
            navigation: {
                nextEl: '.news-swiper-button-next',
                prevEl: '.news-swiper-button-prev',
            },
        });
    }
  } else if (init) {
    swiper.destroy();
    init = false;
  }
}
swiperCard();
window.addEventListener("resize", swiperCard);