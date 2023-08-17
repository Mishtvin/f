let recently = document.querySelector('.recently-items-slider')

if(recently) {
    new Swiper(recently, {
        slideClass: 'recently-item',
        loop: false,
        slidesPerView: 1,
        spaceBetween: 10,
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