let taxTabs = document.querySelectorAll('.tax-tab')

if(taxTabs.length) {
    let allowSend = true

    for(let btn of taxTabs) {
        btn.addEventListener('click', () => {
            if(allowSend) {
                let {name, slug} = btn.dataset         
                let popup = document.querySelector('.rec-popup')
                let title = popup.querySelector('.popup-title')
                let append = popup.querySelector('.catalog')
                let {city} = window
    
                allowSend = false
                title.textContent = name
                btn.classList.add('loading')

                requestAxios('getTaxProducts', {slug, city}, (res) => {
                    append.innerHTML = res

                    openPopup(popup)

                    allowSend = true
                    btn.classList.remove('loading')
                    
                    addToCartBtn()
                    openPopupBtns()
                    oneClickBtns()
                    initFavBtns()
                })
            }
        })   
    }
}