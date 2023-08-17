function initPriceTabs() {
    let priceTabs = document.querySelectorAll('.pricing-tabs:not(.inited)')

    if(priceTabs.length) {
        for(let wrapper of priceTabs) {
            let slug = wrapper.dataset.slug
            let tabs = wrapper.querySelectorAll('.price-tab')
            let btn = document.querySelector('.add-to-cart[data-tab-btn="' + slug + '"]')
            let priceBlock = document.querySelector('.single-content .price-block[data-slug="' + slug + '"], .product-info .price-block[data-slug="' + slug + '"]')
            
            for(let tab of tabs) {
                tab.addEventListener('click', () => {
                    let variant = tab.dataset.key
                    let width = tab.dataset.width
                    let height = tab.dataset.height
                    let siblings = tab.siblings()
                    let rawPrice = tab.dataset.rawPrice
                    let sizes = priceBlock.querySelector('.sizes')

                    if(sizes) {
                        sizes.remove()
                    }

                    if(width && height) {
                        let widthElem = document.createElement('div')
                        let heightElem = document.createElement('div')
                        let sizes = document.createElement('div')

                        widthElem.classList.add('item')
                        widthElem.classList.add('icon-width')

                        heightElem.classList.add('item')
                        heightElem.classList.add('icon-height')

                        sizes.classList.add('sizes')

                        sizes.appendChild(widthElem)
                        sizes.appendChild(heightElem)

                        widthElem.textContent = width + ' см.'
                        heightElem.textContent = height + ' см.'

                        priceBlock.appendChild(sizes)
                    }

                    if(siblings.length) {
                        for(let sibling of siblings) {
                            sibling.classList.add('outline')
                        }
                    }

                    tab.classList.remove('outline')
                    btn.dataset.variant = variant

                    window.price = Number(rawPrice)
                    calcProductPrice()
                })
            }

            wrapper.classList.add('inited')
        }
    }
}

initPriceTabs()

function calcProductPrice() {
    let wrapper = document.querySelector('.per-price')

    if(wrapper) {
        let appendPer = wrapper.querySelector('.append-per-price')
        let append = document.querySelector('.append-calced-price')
        let {quantity, price, cur} = window
        let total = (quantity * price).toLocaleString() + ' ' + cur
        let per = (price).toLocaleString() + ' ' + cur

        append.textContent = total

        if(appendPer) {
            appendPer.textContent = per

            if(quantity > 1) {
                wrapper.classList.add('show')
            } else {
                wrapper.classList.remove('show')
            }
        }
    }
}

function enforceMinMax(el) {
    if (el.value != "") {
        if (parseInt(el.value) < parseInt(el.min)) {
            el.value = el.min;
        }
        if (parseInt(el.value) > parseInt(el.max)) {
            el.value = el.max;
        }
    }
}