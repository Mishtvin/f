function checkLazy() {
    let lazyImages = document.querySelectorAll('[loading="lazy"]:not(.ready)')

    if(lazyImages.length) {
        let height = window.innerHeight
        for(let image of lazyImages) {
            let rect = image.getBoundingClientRect()

            if(rect.bottom > 0 && rect.top < height) {
                image.removeAttribute('loading')
                image.classList.add('ready')
            }

        }
    }
}

window.addEventListener('scroll', checkLazy)

////

function lazyLoad() {
    let lazyImages = document.querySelectorAll('.lazy:not(.loaded)')

    if(lazyImages.length) {
        let height = window.innerHeight
        for(let image of lazyImages) {
            let rect = image.getBoundingClientRect()

            if(rect.bottom > 0 && rect.top < height) {
                let {src} = image.dataset

                image.src = src
                image.classList.add('loaded')
            }

        }
    }
}

window.addEventListener('scroll', lazyLoad)

lazyLoad()