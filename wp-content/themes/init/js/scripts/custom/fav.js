function favStartLoading() {
    let wrapper = document.querySelector('.fav-append')
    
    if(wrapper && !wrapper.querySelector('.loading-layer')) {
        wrapper.startLoading()
    }
}

function favStopLoading() {
    let wrapper = document.querySelector('.fav-append')
    
    if(wrapper) {
        wrapper.stopLoading()
    }
}

function updateFav() {
    let appendItems = document.querySelector('.fav-append')

    let favQuantityData = document.querySelectorAll('.fav-quantity-data')
    let favQuantity = document.querySelectorAll('.fav-quantity')

    let favBtns = document.querySelectorAll('.add-to-fav')

    favStartLoading()

    requestAxios('axiosFavInfo', '', data => {
        let {fav, items_structure, quantity} = data

        if(appendItems) {
            appendItems.innerHTML = items_structure
        }

        initRemoveFavItem()

        if(favQuantityData.length) {
            for(let elem of favQuantityData) {
                elem.dataset.count = quantity
            }
        }

        if(favQuantity.length) {
            for(let elem of favQuantity) {
                elem.textContent = quantity
            }
        }

        if(favBtns.length) {
            for(let btn of favBtns) {
                btn.classList.remove('active')
            }

            for(let btn of favBtns) {
                let id = btn.dataset.id

                if(fav.indexOf(id) != -1) {
                    btn.classList.add('active')
                }
            }
        }

        addToCartBtn()
        openPopupBtns()
        oneClickBtns()
        initFavBtns()
    })
}

function initFavBtns() {
    let addToFavBtns = document.querySelectorAll('.add-to-fav:not(.inited)')

    if(addToFavBtns.length) {
        for(let btn of addToFavBtns) {
            btn.addEventListener('click', () => {
                let id = btn.dataset.id

                favStartLoading()
                requestAxios('axiosAddToFav', {id}, () => {
                    add_notif({
                        title: 'Избранные',
                        text: btn.classList.contains('active') ? 'Товар удален из избранных' : 'Товар добавлен в избранные',
                        link: '/fav/',
                        icon: 'success',
                        timeout: 4000
                    })

                    updateFav()
                })
            })

            btn.classList.add('inited')
        }
    }
}

initFavBtns()

function initRemoveFavItem() {
    let btns = document.querySelectorAll('.remove-fav-item:not(.inited)')

    if(btns.length) {
        for(let btn of btns) {
            btn.addEventListener('click', () => {
                let btns = document.querySelectorAll('.remove-fav-item')
                let id = btn.dataset.id

                for(let btn of btns) {
                    btn.remove()
                }

                favStartLoading()

                requestAxios('axiosRemoveFromFav', {id}, () => {
                    updateFav()
                })
            })

            btn.classList.add('inited')
        }
    }
}

initRemoveFavItem()