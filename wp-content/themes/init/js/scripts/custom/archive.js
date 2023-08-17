let loadMore = document.querySelector('#load_more')

if(loadMore) {
    let page = Number(loadMore.dataset.page)



    loadMore.load = () => {
        if(!loadMore.stopLoad) {
            loadMore.stopLoad = true

            let wrapper = loadMore.parentElement
            let max = Number(loadMore.dataset.max)
            let order = loadMore.dataset.order
            let urlObject = new URL(window.location.href)
            let url = urlObject.href
            let search = urlObject.searchParams.get('s')
    
            page++
            loadMore.disable(true)

            urlObject.searchParams.set('pag', page)

            window.history.replaceState('', '', urlObject.href)
    
            let data = {page, url, search, order}
            requestAxios('loadMore', data, (res) => {
                wrapper.insertAdjacentHTML('beforebegin', res)
    
                if(max == page) {
                    loadMore = null
                    wrapper.remove()
                } else {
                    loadMore.enable()
                    loadMore.stopLoad = false
                }

                addToCartBtn()
                openPopupBtns()
                oneClickBtns()
                initFavBtns()                
            })
        }
    }

    loadMore.addEventListener('click', () => {
        loadMore.load()
    })

    // window.addEventListener('scroll', () => {
    //     if(loadMore) {
    //         let height = window.innerHeight
    //         let rect = loadMore.getBoundingClientRect()
    //
    //         if(rect.top < height) {
    //             loadMore.load()
    //         }
    //     }
    // })

}