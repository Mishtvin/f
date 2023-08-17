let requestSend = document.querySelector('.request-send')

if(requestSend) {
    requestSend.addEventListener('click', (e) => {
        e.preventDefault()

        grecaptcha.ready(function () {
            grecaptcha.execute('6Le6nHUkAAAAAInNvruFlH4CFiikb9QiriPNxFOR', { action: 'request' }).then(function (token) {
                document.getElementById('recaptchaResponseRequest').value = token;
                let elem = requestSend
                let form = elem.closest('form')
                let fields = {
                    name: 1,
                    phone: 1,
                    message: 0,
                    recaptcha_response: 1,
                }
                let data = {}
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

                    data.type = 'request'

                    sendOrder(data, false, (res) => {
                        if(!window.debug) {
                            window.location.href = '/success/'
                        }
                    })
                }
            })
        })


    })
}