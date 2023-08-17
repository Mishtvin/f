let sendBtns = document.querySelectorAll('.order-btn')

if(sendBtns.length) {
    for(let btn of sendBtns) {
        btn.addEventListener('click', (e) => {
            e.preventDefault()

            grecaptcha.ready(function () {
                grecaptcha.execute('6Le6nHUkAAAAAInNvruFlH4CFiikb9QiriPNxFOR', { action: 'request' }).then(function (token) {
                    document.getElementById('recaptchaResponseCart').value = token;
                    let btns = document.querySelectorAll('.order-btn')
                    let form = document.querySelector('.checkout-form')
                    let fields = {
                        name: 1,
                        phone: 1,
                        email: 1,
                        recipient_name: 1,
                        recipient_phone: 1,
                        address: 1,
                        delivery_date: 1,
                        delivery_time: 1,
                        postcard: 0,
                        message: 0,
                        recaptcha_response: 1,
                    }
                    let data = {}
                    let delivery = []
                    let errors = 0

                    for(let key in fields) {
                        let required = fields[key]
                        let field = form.querySelector('.' + key)

                        if(field) {
                            let value = field.getValue()

                            if(required) {
                                errors += field.check()
                            }

                            if(key == 'delivery_date' || key == 'delivery_time') {
                                delivery.push(value)
                            } else {
                                data[key] = value
                            }
                        }
                    }

                    data.delivery = delivery.join(' ')

                    if(!errors) {
                        for(let btn of btns) {
                            btn.disable(true)
                        }

                        sendOrder(data, true, () => {
                            if(!window.debug) {
                                let url = '/success/?type=order';
                                if (window.city) url = '/' + window.city + url;
                                window.location.href = url
                            }
                        })
                    }
                })
            })
        })
    }
}

function sendOrder(fields, products, callback) {
    let type = fields.type || 'order'
    products = products ? 1 : 0

    fields.city = window.city
    fields.type = type

    requestAxios('axiosSendOrder', {type, fields, products}, (res) => {
        if(callback) {
            callback()
        }
    })
}

function cartStartLoading() {
    let cartProducts = document.querySelector('.cart-products')
    let cartBtns = document.querySelectorAll('.order-btn')
    
    if(cartProducts && !cartProducts.querySelector('.loading-layer')) {
        cartProducts.startLoading()
    }

    if(cartBtns.length) {
        for(let btn of cartBtns) {
            btn.disable()
        }
    }
}

function cartStopLoading() {
    let cartProducts = document.querySelector('.cart-products')
    let cartBtns = document.querySelectorAll('.order-btn')
    
    if(cartProducts) {
        cartProducts.stopLoading()
    }

    if(cartBtns.length) {
        for(let btn of cartBtns) {
            btn.enable()
        }
    }
}

function updateCart() {
    let quantityElements = document.querySelectorAll('.cart-quantity')
    let quantityDataElements = document.querySelectorAll('.cart-quantity-data')
    let priceElements = document.querySelectorAll('.cart-price')
    let priceDataElements = document.querySelectorAll('.cart-price-data')

    cartStartLoading()

    requestAxios('axiosCartInfo', '', (res) => {
        let cartProducts = document.querySelector('.cart-products')
        let cartBtns = document.querySelectorAll('.order-btn')
        let promoWrapper = document.querySelector('.promo-wrapper')
        let {cart, session, quantity, price, oldPrice, cartItems, cartItemsData, promoForm} = res

        cartStopLoading()

        if(promoWrapper) {
            promoWrapper.innerHTML = promoForm
            initPromoForm()
        }
        
        if(quantityElements.length) {
            for(let elem of quantityElements) {
                elem.textContent = quantity
            }
        }
                
        if(quantityDataElements.length) {
            for(let elem of quantityDataElements) {
                elem.dataset.count = quantity
            }
        }

        if(priceElements.length) {
            for(let elem of priceElements) {
                elem.textContent = price.toLocaleString()
            }
        }
                
        if(priceDataElements.length) {
            for(let elem of priceDataElements) {
                elem.dataset.price = price.toLocaleString()
            }
        }

        if(cartBtns.length) {
            for(let btn of cartBtns) {
                if(price >= window.minPrice) {
                    btn.removeAttribute('disabled')
                } else {
                    btn.setAttribute('disabled', 'disabled')
                }
            }
        }

        if(cartProducts) {
            cartProducts.innerHTML = cartItems

            initQuantityInput()
            initRemoveCartItem()
        }
    })
}

function addToCart(slug, variant = 0, quantity = 1, callback , florist_data = []) {
    if(variant) {
        slug += '.' + variant
    }

    let data = {slug, quantity, florist_data}

    requestAxios('axiosAddToCart', data, () => {
        add_notif({
            title: 'Корзина',
            text: 'Товар добавлен в корзину',
            link: '/cart/',
            icon: 'cart',
            color: 'green',
            timeout: 4000
        })

        if(callback) {
            callback()
        }

        updateCart()
    })
}

function addToCartBtn() {
    let btns = document.querySelectorAll('.add-to-cart:not(.inited)')

    if(btns.length) {
        for(let btn of btns) {
            btn.addEventListener('click', () => {
                let slug = btn.dataset.key
                let variant = Number(btn.dataset.variant) || 0
                let wrapper = btn.closest('.price-wrapper')
                let quantity = wrapper.querySelector('.quantity-input')
                let florist_data = {};
                if(slug === 'buketpofoto') {
                    var rand = function() {
                        return Math.random().toString(36).substr(2);
                    };
                    var token = function() {
                        return rand() + rand();
                    };
                    var file_token = token();

                    const url = '/wp-content/themes/init/upload_image.php';
                    const files = document.querySelector('.florist_file').files;
                    if (files.length > 0) {
                        var florist_file_ext = files[0]['name'].split('.').pop();
                        const formData = new FormData();
                        for (let i = 0; i < files.length; i++) {
                            let file = files[i]
                            formData.append('files[]', file)
                        }
                        formData.append('token', file_token)
                        fetch(url, {
                            method: 'POST',
                            body: formData,
                        }).then((response) => {
                            console.log(response)
                        })
                        florist_data = {
                            "florist_price": document.querySelector('.florist_price').value,
                            "florist_comment": document.querySelector('.florist_comment').value,
                            "florist_file": file_token + '.' + florist_file_ext
                        };
                    } else {
                        florist_data = {
                            "florist_price": document.querySelector('.florist_price').value,
                            "florist_comment": document.querySelector('.florist_comment').value
                        };
                    }

                } else {
                    florist_data = false;
                }

                if(quantity) {
                    quantity = quantity.value
                    quantity = Number(quantity)

                    if(isNaN(quantity)) {
                        quantity = 1
                    }
        
                    quantity = Math.round(quantity)
                    quantity = Math.min(100, quantity)
                    quantity = Math.max(1, quantity)
                } else {
                    quantity = 1
                }

                btn.disable(true)
                addToCart(slug, variant, quantity, () => {
                    btn.enable()
                }, florist_data)
            })

            btn.classList.add('inited')
        }
    }
}

addToCartBtn()

function initRemoveCartItem() {
    let btns = document.querySelectorAll('.remove-cart-item:not(.inited)')

    if(btns.length) {
        for(let btn of btns) {
            btn.addEventListener('click', () => {
                let id = btn.dataset.id
                let wrapper = btn.closest('.large-product-item')
                let parent = wrapper.parentNode

                requestAxios('axiosRemoveFromCart', {id})
                wrapper.remove()

                delete window.cart[id]

                calcCart()

                if(!parent.children.length) {
                    parent.insertAdjacentHTML('beforeend', `
                    <div class="empty-block">
                        <div class="icon icon-error"></div>
                        <h6>Корзина пуста</h6>
                    </div>
                    `)
                }
            })

            btn.classList.add('inited')
        }
    }
}

initRemoveCartItem()

function calcCart() {
    let data = window.cart
    let promo = window.promo
    let totalQuantity = 0
    let totalPrice = 0
    let totalDiscount = 0
    let totalOldPrice = 0

    let quantityElements = document.querySelectorAll('.cart-quantity')
    let quantityDataElements = document.querySelectorAll('.cart-quantity-data')
    let priceElements = document.querySelectorAll('.cart-price')
    let priceDataElements = document.querySelectorAll('.cart-price-data')
    let oldPriceElements = document.querySelectorAll('.cart-old-price')
    let oldPriceDataElements = document.querySelectorAll('.cart-old-price-data')
    let discountElements = document.querySelectorAll('.cart-discount')
    let discountDataElements = document.querySelectorAll('.cart-discount-data')
    let cartBtns = document.querySelectorAll('.order-btn')
    let minPriceWarning = document.querySelector('.min-price-warning')

    if(data) {
        for(let item of Object.values(data)) {
            let {slug, oldPricePer, pricePer, quantity} = item
            let totalPricePer = quantity * pricePer
            let totalOldPricePer = quantity * oldPricePer || totalPricePer
            let discount = totalOldPricePer - totalPricePer
            let priceElem = document.querySelector('.product-total-price[data-id="' + slug + '"]')
            let oldPriceElem = document.querySelector('.product-old-price[data-id="' + slug + '"]')
            let discountElem = document.querySelector('.product-discount[data-id="' + slug + '"]')

            totalQuantity += quantity
            totalPrice += totalPricePer
            totalOldPrice += totalOldPricePer
            totalDiscount += discount

            if(priceElem) {
                priceElem.innerHTML = totalPricePer.toLocaleString()
            }

            if(oldPriceElem) {
                oldPriceElem.innerHTML = totalOldPricePer.toLocaleString()
            }

            if(discountElem) {
                discountElem.innerHTML = discount.toLocaleString()
            }
        }
    }

    if(promo) {
        let {discount, type} = promo

        if(type == 'percent') {
            discount = (discount * 0.01) * totalPrice
        }

        discount = Math.round(discount)
        totalPrice = Math.max(0, totalPrice - discount)
        totalDiscount = Math.min(totalOldPrice, totalDiscount + discount)
    }

    if(quantityElements.length) {
        for(let elem of quantityElements) {
            elem.textContent = totalQuantity
        }
    }
            
    if(quantityDataElements.length) {
        for(let elem of quantityDataElements) {
            elem.dataset.count = totalQuantity
        }
    }

    if(priceElements.length) {
        for(let elem of priceElements) {
            elem.textContent = totalPrice.toLocaleString()
        }
    }
            
    if(priceDataElements.length) {
        for(let elem of priceDataElements) {
            elem.dataset.price = totalPrice.toLocaleString()
        }
    }

    if(oldPriceElements.length) {
        for(let elem of oldPriceElements) {
            elem.textContent = totalOldPrice.toLocaleString()
        }
    }
            
    if(oldPriceDataElements.length) {
        for(let elem of oldPriceDataElements) {
            elem.dataset.price = totalOldPrice.toLocaleString()
        }
    }

    if(discountElements.length) {
        for(let elem of discountElements) {
            elem.textContent = totalDiscount.toLocaleString()
        }
    }
            
    if(discountDataElements.length) {
        for(let elem of discountDataElements) {
            elem.dataset.price = totalDiscount.toLocaleString()
        }
    }

    if(cartBtns.length) {
        for(let btn of cartBtns) {
            if(totalPrice >= window.minPrice) {
                btn.removeAttribute('disabled')
                btn.querySelector('span').textContent = 'Оформить заказ'
            } else {
                btn.setAttribute('disabled', 'disabled')
                btn.querySelector('span').textContent = `Минимальная сумма ${window.minPrice.toLocaleString()} ${window.cur}`
            }
        }
    }

    if(minPriceWarning) {
        let appendDiff = minPriceWarning.querySelector('.append-min-price-diff')

        appendDiff.textContent = (window.minPrice - totalPrice).toLocaleString() + ' ' + window.cur

        if(totalPrice >= window.minPrice) {
            minPriceWarning.hide()
        } else {
            minPriceWarning.flex()
        }
    }
}

calcCart()

let clearCartBtn = document.querySelector('.clear-cart-btn')

if(clearCartBtn) {
    clearCartBtn.addEventListener('click', () => {
        let wrapper = document.querySelector('.cart-products')
        requestAxios('axiosClearCart')

        wrapper.innerHTML = `
        <div class="empty-block">
            <div class="icon icon-error"></div>
            <h6>Корзина пуста</h6>
        </div>
        `

        window.cart = {}
        calcCart()
    })
}