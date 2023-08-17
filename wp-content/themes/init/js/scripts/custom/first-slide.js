let mainSlider = document.querySelector('.main-slider')

if(mainSlider) {
    let slides = mainSlider.querySelectorAll('.slide')

    if(slides.length > 1) {
        new Swiper(mainSlider, {
            slideClass: 'slide',
            loop: true,
            navigation: {
              nextEl: '.mainSliderNext',
              prevEl: '.mainSliderPrev',
            },
            speed: 600,
            autoplay: {
                delay: 4000
            },
            pagination: {
                el: '.main-slider-pagination',
            },
        })
    }
}