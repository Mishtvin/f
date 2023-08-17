async function initProductPrices(elem) {
    let selected = []
    let addBtn = elem.querySelector('.add')
    let group = elem.group
    let cities = window.cities

    Object.defineProperty(elem, 'prices', {
        set: (data) => {
            if(!elem.preventRender) {
                let list = elem.querySelector('.prices-list')

                list.innerHTML = ''

                if(Object.keys(data).length) {
                    for(let index in data) {
                        let item = document.createElement('div')
                        let value = data[index]
                        let city = value.slug
                        let listItems = []

                        for(let cityItem of cities) {
                            listItems.push(`<option value="${cityItem[0]}" ${cityItem[0] == city ? 'selected' : ''}>${cityItem[1]}</option>`)
                        }

                        listItems = listItems.join('')

                        item.classList.add('price-item')
                        item.innerHTML = `
                        <select class="city medium">${listItems}</select>
                        <input type="text" placeholder="Цена" class="price-mask price medium" value="${value.price}">
                        <button class="btn outline red-theme close medium"><span class="icon icon-close"></span></button>
                        `

                        let cityInput = item.querySelector('select')
                        let priceInput = item.querySelector('input')
                        let deleteBtn = item.querySelector('.close')

                        cityInput.addEventListener('change', () => {
                            let selected = cityInput.value
                            let data = elem.prices

                            value.slug = selected
                            data[index] = value

                            elem.prices = data
                        })

                        priceInput.addEventListener('change', () => {
                            let data = elem.prices
                            let price = Number(priceInput.getValue()) || 0

                            value.price = price
                            elem.preventRender = true
                            data[index] = value

                            elem.prices = data
                        })

                        deleteBtn.addEventListener('click', () => {
                            let data = elem.prices

                            data.splice(index, 1)

                            elem.prices = data
                        })

                        priceInput.priceMask()

                        list.appendChild(item)
                    }
                }

                if(group) {
                    group.item.prices = data
                    group.refresh()
                }
            } else {
                elem.preventRender = false

                if(group) {
                    group.item.prices = data
                }
            }

            return elem.pricesList = data
        },
        get: () => {
            return elem.pricesList
        }
    })

    elem.prices = selected

    addBtn.addEventListener('click', () => {
        let data = elem.prices
        
        data.push({
            slug: '',
            price: '',
            old_price: 0,
        })

        elem.prices = data
    })

    if(elem.dataset.slug) {
        let slug = elem.dataset.slug

        requestAxios('getProductPrices', {slug}, (res) => {
            elem.prices = res
        })
    }
}

let productPrices = document.querySelectorAll('.product-prices')

if(productPrices.length) {
    requestAxios('get_cities', '', data => {
        let rawCities = data
        let cities = []

        for(let city of Object.values(rawCities)) {
            cities.push([city.slug, city.name])
        }

        window.cities = cities

        for(let elem of productPrices) {
            initProductPrices(elem)
        }

        let manyPrices = document.querySelector('.many-prices')

        if(manyPrices) {
            let selected = []
            let addGroupBtn = manyPrices.querySelector('.add-group')

            Object.defineProperty(manyPrices, 'groups', {
                set: (data = []) => {
                    return this.selected_groups = data
                },
                get: () => {
                    return this.selected_groups
                }
            })

            manyPrices.getValue = () => {
                let rawData = this.selected_groups
                let data = []

                if(rawData.length) {
                    for(let item of rawData) {
                        let {name} = item
                        let prices = item.pricesElement ? item.pricesElement.prices : []

                        data.push({name, prices})
                    }
                }

                return data
            }

            manyPrices.refresh = async () => {
                let data = manyPrices.groups
                let wrapper = manyPrices.querySelector('.groups-list')

                wrapper.innerHTML = ''

                if(data.length) {
                    let index = 0

                    for(let item of data) {
                        let {name} = item
                        let row = await document.createElement('div')
                        let prices = item.pricesElement ? item.pricesElement.prices : []
                        let itemIndex = index

                        if(item.value) {
                            prices = item.value

                            delete item.value
                        }
                        
                        row.innerHTML = `
                        <div class="group-header">
                            <input type="text" placeholder="Наименование" placeholder="Введите наименование" class="group-name" value="${name}">
                            <button class="btn red-theme close-group medium"><span class="icon icon-close"></span></button>
                        </div>
                        <div class="product-prices article">
                            <div class="prices-list"></div>
                            <button class="btn add"><span class="text">Добавить</span></button>
                        </div>
                        `
                        row.classList.add('prices-group')
                        row.classList.add('article')

                        wrapper.appendChild(row)

                        let closeBtn = row.querySelector('.close-group')
                        let nameInput = row.querySelector('.group-name')
                        let pricesWrapper = row.querySelector('.product-prices')

                        closeBtn.addEventListener('click', () => {
                            let data = manyPrices.groups

                            data.splice(itemIndex, 1)

                            manyPrices.groups = data
                            manyPrices.refresh()
                        })

                        nameInput.addEventListener('input', () => {
                            let value = nameInput.getValue()

                            item.name = value
                        })

                        item.pricesElement = pricesWrapper

                        await initProductPrices(pricesWrapper)
                        pricesWrapper.prices = prices

                        index++
                    }
                }

            }

            manyPrices.groups = selected

            addGroupBtn.addEventListener('click', () => {
                let data = manyPrices.groups

                data.push({
                    name: '',
                })

                manyPrices.refresh()
            })

            if(manyPrices.dataset.slug) {
                setTimeout(() => {
                    let slug = manyPrices.dataset.slug

                    requestAxios('getProductVariants', {slug}, (res) => {
                        manyPrices.groups = res
    
                        manyPrices.refresh()
                    })
                }, 200)
            }
        }
    })
}

let checkboxGroups = document.querySelectorAll('.checkbox-groups')

if(checkboxGroups.length) {
    for(let group of checkboxGroups) {
        let checkboxGroupsItems = group.querySelectorAll('.checkbox-groups input[type="checkbox"]')

        for(let item of checkboxGroupsItems) {
            item.addEventListener('change', () => {
                let isChecked = item.checked
                let wrapper = item.closest('.checkbox-groups-item')
                let parents = []
                let childrens = wrapper.querySelectorAll('.children input')
                let parent = wrapper.parentElement.closest('.checkbox-groups-item')
    
                if(parent) {
                    parents.push(parent.querySelector('input'))
    
                    let parentParent = parent.parentElement.closest('.checkbox-groups-item')
    
                    if(parentParent) {
                        parents.push(parentParent.querySelector('input'))
                    }
                }
    
    
                if(isChecked) {
                    if(parents.length) {
                        for(let elem of parents) {
                            elem.checked = true
                        }
                    }
                } else {
                    if(childrens.length) {
                        for(let elem of childrens) {
                            elem.checked = false
                        }
                    }
                }
            })
        }

        group.getValue = () => {
            let value = []
            let checked = group.querySelectorAll('.checkbox-groups input[type="checkbox"]:checked')

            if(checked.length) {
                for(let item of checked) {
                    value.push(item.id)
                }
            }

            return value
        }
    }
}

let product_btn = document.querySelector('#save_product')

if(product_btn) {
    product_btn.addEventListener('click', () => {
        let errors = []

        let slug = product_btn.dataset.slug || ''
        let imageField = document.querySelector('#product_image')
        let titleField = document.querySelector('#product_title')
        let descriptionField = document.querySelector('#product_description')
        let priceField = document.querySelector('#product_price')
        let pricesField = document.querySelector('#regional_prices')
        let variantsField = document.querySelector('#many_prices')
        let taxonomiesField = document.querySelector('#taxonomies')
        let tagsField = document.querySelector('#tags')

        let image = imageField.image
        let title = titleField.getValue()
        let description = descriptionField.getValue()
        let price = priceField.getValue() || 0
        let rawPrices = pricesField.prices
        let rawVariants = variantsField.getValue()
        let prices = {}
        let variants = {}
        let taxonomies = taxonomiesField.getValue()
        let tags = tagsField.getValue()

        if(!image) {
            errors.push('Выберите изображение')
        }

        if(!title) {
            errors.push('Введите наименование')
        }
        
        if(!price) {
            errors.push('Введите цену')
        }
        
        if(rawPrices.length) {
            for(let item of rawPrices) {
                prices[item.slug] = {
                    price: item.price || 0,
                    old_price: item.old_price || 0,
                }
            }
        }

        if(rawVariants.length) {
            for(let item of rawVariants) {
                let variantPrices = {}
                let basicPrice = 0

                if(item.prices) {
                    for(let priceItem of item.prices) {

                        if(!basicPrice || priceItem.price < basicPrice) {
                            basicPrice = priceItem.price
                        }

                        variantPrices[priceItem.slug] = {
                            price: priceItem.price || 0,
                            old_price: priceItem.old_price || 0,
                        }
                    }
                }

                variants[item.name] = {
                    title: item.name,
                    price: basicPrice,
                    prices: variantPrices
                }
            }

        }

        variants = Object.assign({}, variants)
        let data = {slug, image, title, description, price, prices, variants, taxonomies, tags}

        if(!taxonomies.length) {
            errors.push('Выберите категории')
        }

        if(errors.length) {
            for(let error of errors) {
                add_notif({
					title: 'Ошибка',
					text: error,
					icon: 'error',
					color: 'red',
					timeout: 4000
				})
            }
        } else {
            product_btn.disable(true)
            console.log(data);

            setTimeout(() => {
                requestAxios('axiosAddProduct', data, (url) => {
                    console.log(url);
                    if(!window.debug) {
                        window.location.href = url
                    }
                })
            }, 1500)
        }
    })
}