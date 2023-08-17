let flowersSearch = document.querySelector('#search_flower')

if(flowersSearch) {
    let items = document.querySelectorAll('.categories-grid .category')

    if(items.length) {
        let empty = document.createElement('div')
        let wrapper = document.querySelector('.categories-grid')

        empty.classList.add('empty-block')
        empty.innerHTML = `
            <span class="icon icon-error"></span>
            <div class="h6">Ничего не найдено</div>
        `

        flowersSearch.addEventListener('input', () => {
            let query = flowersSearch.getValue().toLocaleLowerCase()
            let show = 0

            if(wrapper.contains(empty)) {
                wrapper.removeChild(empty)
            }

            if(query) {
                for(let item of items) {
                    let tag = item.dataset.search

                    if(tag.indexOf(query) != -1) {
                        show++

                        item.show()
                    } else {
                        item.hide()
                    }

                    if(!show) {
                        wrapper.appendChild(empty)
                    }
                }
            } else {
                for(let item of items) {
                    item.show()
                }
            }
        })
    }
}