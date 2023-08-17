function initPromoForm() {
    let promoBtn = document.querySelector('.promo-send:not(.inited)')
    let promoInput = document.querySelector('#promo_input:not(.inited)')
    let removePromo = document.querySelector('.promo-remove')
    
    if(promoBtn && promoInput) {
        promoBtn.addEventListener('click', (e) => {
            e.preventDefault()

            if(!promoInput.check()) {
                let code = promoInput.getValue()
                
                promoBtn.disable(true)
                requestAxios('axiosApplyPromo', {code}, (res) => {
                    if(res) {
                        add_notif({
                            title: 'Промокод',
                            text: `Промокод '${res.code}' применен`,
                            link: '/cart/',
                            icon: 'success',
                            color: 'green',
                            timeout: 4000
                        })

                        window.promo = res

                        requestAxios('axiosPromoForm', '', res => {
                            let promoWrapper = document.querySelector('.promo-wrapper')
                            
                            if(promoWrapper) {
                                promoWrapper.innerHTML = res
                                initPromoForm()
                                calcCart()
                            }
                        })
                    } else {
                        promoBtn.enable()
                        promoInput.classList.add('error')

                        add_notif({
                            title: 'Промокод',
                            text: `Вы ввели неверный промокод`,
                            link: '/cart/',
                            icon: 'error',
                            color: 'red',
                            timeout: 4000
                        })
                    }
                })
            }
        })
    }

    if(removePromo) {
        removePromo.addEventListener('click', () => {
            removePromo.disable(true)

            requestAxios('axiosRemovePromo', '', () => {
                window.promo = null

                requestAxios('axiosPromoForm', '', res => {
                    let promoWrapper = document.querySelector('.promo-wrapper')
                    
                    if(promoWrapper) {
                        promoWrapper.innerHTML = res
                        initPromoForm()
                        calcCart()
                    }
                })
            })
        })
    }
}

initPromoForm()