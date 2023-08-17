let timer

function initQuantityInput() {
    let inputs = document.querySelectorAll('.quantity-input:not(.inited)')

    for(let input of inputs) {
        let wrapper = input.parentElement
        let minusBtn = wrapper.querySelector('.minus')
        let plusBtn = wrapper.querySelector('.plus')

        input.update = () => {
            let id = input.dataset.slug
            let value = Number(input.value)

            if(isNaN(value)) {
                value = 1
            }

            value = Math.round(value)
            value = Math.min(100, value)
            value = Math.max(1, value)

            input.value = value

            if(input.classList.contains('cart-item-quantity')) {
                window.cart[id].quantity = value

                if(timer) {
                    timer = clearTimeout(timer)
                    timer = null
                }

                timer = setTimeout(() => {
                    let id = input.dataset.slug
                    let quantity = value
                    let data = {id, quantity}

                    requestAxios('axiosChangeQuantity', data)
                }, 150)

                calcCart()
            }

            if(input.classList.contains('calc-price')) {
                window.quantity = value
                calcProductPrice()
            }
        }

        input.add = () => {
            input.update()

            let value = Number(input.value)

            input.value = value + 1

            input.update()
        }

        input.remove = () => {
            input.update()

            let value = Number(input.value)

            input.value = value - 1

            input.update()
        }

        input.addEventListener('change', input.update)

        minusBtn.addEventListener('click', input.remove)
        plusBtn.addEventListener('click', input.add)

        input.classList.add('inited')
    }
}

initQuantityInput()