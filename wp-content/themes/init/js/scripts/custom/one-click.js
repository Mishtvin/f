function oneClickBtns() {
    let btns = document.querySelectorAll('.one-click:not(.one-click-inited)')

    if(btns.length) {
        for(let btn of btns) {
            btn.addEventListener('click', () => {
                let id = btn.dataset.key
                let form = document.querySelector('.one-click-form')
                let wrapper = document.querySelector('.append-one-click-product')

                window.oneClickProduct = id
                form.startLoading()
                requestAxios('oneClickProduct', {id}, (res) => {
                    wrapper.innerHTML = res

                    form.stopLoading()
                })
            })

            btn.classList.add('one-click-inited')
        }
    }
}

oneClickBtns()

let oneClickSendBtn = document.querySelector('.one-click-send')

if(oneClickSendBtn) {
    oneClickSendBtn.addEventListener('click', (e) => {
        e.preventDefault()

        grecaptcha.ready(function () {
            grecaptcha.execute('6Le6nHUkAAAAAInNvruFlH4CFiikb9QiriPNxFOR', { action: 'oneclick' }).then(function (token) {
                document.getElementById('recaptchaResponseOneClick').value = token;
                let elem = oneClickSendBtn
                let form = elem.closest('form')
                let fields = {
                    name: 1,
                    phone: 1,
                    recaptcha_response: 1,
                }
                let data = {
                    products: window.window.oneClickProduct + ':' + 1
                }
                let errors = 0

                for(let key in fields) {
                    let required = fields[key]
                    let field = form.querySelector('.' + key)

                    if(field) {
                        let value = field.getValue()

                        if(required) {
                            errors += field.check()
                        }

                        data[key] = value
                    }
                }

                if(!errors) {
                    elem.disable(true)

                    data.type = 'one-click'
                    sendOrder(data, true, () => {
                        if(!window.debug) {
                            window.location.href = window.city ? '/' + window.city + '/success/?type=order' : '/success/?type=order'
                        }
                    })
                }
            })
        })
    })
}