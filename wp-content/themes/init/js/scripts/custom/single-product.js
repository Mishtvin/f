let productSlider = $('.product-main-slider')

if(productSlider.length) {
    let thumnbails = $('.product-thumbnails .image')

    productSlider.slick({
        prevArrow: '<button class="btn blur rounded prev"><span class="icon icon-left"></span></button>',
        nextArrow: '<button class="btn blur rounded next"><span class="icon icon-right"></span></button>',
    })

    productSlider.on('beforeChange', function(event, slick, currentSlide, nextSlide){
        thumnbails.removeClass('active')
        thumnbails.eq(nextSlide).addClass('active')
    })

    thumnbails.click(function(){
        let elem = $(this)
        let index = elem.index()

        productSlider.slick('slickGoTo', index)
    })

    let images = productSlider.find('img:not(.slick-cloned)')

    console.log(images);
    
    if (images.length) {
        let options = []

        images.each(function(){
            let elem = $(this)
            // let img = elem.find('img')
            let src = elem.attr('src')
            let type = 'image'

            options.push({src, type})
        })

        images.click(function(){
            let elem = $(this)
            let index = elem.data('slick-index')

            Fancybox.show(
                options,
                {
                    startIndex: index,
                    infinite: false,
                }
            )
        })
    }
}