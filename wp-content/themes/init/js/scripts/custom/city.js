let cities = {}

requestAxios('get_cities', '', data => {
    cities = data
})

let searchCityInput = document.querySelector('.search-city')

if(searchCityInput) {
    searchCityInput.addEventListener('input', () => {
        let elem = searchCityInput
        let val = elem.getValue().toLowerCase()
        let show = false
        let dropdown = document.querySelector('.select-city-dropdown')
        let append = dropdown.querySelector('.content')

        append.innerHTML = ''

        if(val.length > 1) {
            let filtred = []
    
            for(let key in cities) {
                let value = cities[key].name.toLowerCase()
                let search = value.indexOf(val)
    
                if(search != -1) {
                    value = cities[key].name
    
                    let cut = `<span class="underline">${value.substr(search, val.length)}</span>` 
    
                    value = value.substr(0, search) + cut + value.substr(search + val.length)
    
                    filtred.push({ key, value })
                }
            }
    
            if(filtred.length) {
                show = true
    
                filtred.slice(0, 5)
    
                for(let city of filtred) {
                    let url = window.location.href

                    console.log(url);

                    url = url.split('//')[1]
                    url = url.split('.')
                    url = [url[url.length - 2], url[url.length - 1]]
                    url = url.join('.')

                    if(city.key) {
                        url = city.key + '.' + url
                    }

                    url = 'https://' + url

                    append.insertAdjacentHTML('beforeend', `<a href="${url}" class="item" data-value="${city.key}"><span class="text">${city.value}</span></a>`)
                }
    
            }
    
        }
    
        if(show) {
            dropdown.show()
        } else {
            dropdown.hide()
        }
    })
}

let selectCityForm = document.querySelector('.select-city-wrapper')

if(selectCityForm) {
    clickOut(selectCityForm, () => {
        let dropdown = document.querySelector('.select-city-dropdown')
        let append = dropdown.querySelector('.content')

        append.innerHTML = ''
        dropdown.hide()
    })
}