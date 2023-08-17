let newsSlider = document.querySelector('.news-slider')

if (newsSlider) {
    new Swiper(newsSlider, {
        slideClass: 'news-card',
        loop: false,
        slidesPerView: 1,
        spaceBetween: 30,
        breakpoints: {
            768: {
                slidesPerView: 2
            },
            1025: {
                slidesPerView: 5
            },
        }
    })
}

/////

let newsRecSlider = document.querySelector('.news-rec-slider')

if (newsRecSlider) {
    new Swiper(newsRecSlider, {
        slideClass: 'news-card',
        loop: false,
        slidesPerView: 1,
        spaceBetween: 30,
        breakpoints: {
            768: {
                slidesPerView: 2
            },
            1025: {
                slidesPerView: 4
            },
        }
    })
}