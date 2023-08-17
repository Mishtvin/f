let resoreSend = document.querySelector('#restore_send')

if(resoreSend) {
    resoreSend.addEventListener('click', (e) => {
        let btn = resoreSend
        let input = document.querySelector('#restore_phone_or_email')
        let form = btn.closest('form')
        let success_screen = form.nextElementSibling
    
        if(!input.check()) {
            btn.disable(true)
    
            requestAxios('restore_check', input.getValue(), res => {
                if(res.res == 'error'){
                    displayAuthErrors(res.fields)
                    btn.enable()
                }else{
                    form.hide()
                    success_screen.show()
                }
            })
        }
    
        e.preventDefault()
    })
}

/////

let newPasswordSend = document.querySelector('#restore_send')

if(newPasswordSend) {
    newPasswordSend.addEventListener('click', (e) => {
        e.preventDefault()

        let btn = newPasswordSend
        let password_field = document.querySelector('#restore_password')
        let confirm_field = document.querySelector('#restore_password_confirm')
        let form = btn.closest('form')
        let success_screen = form.nextElementSibling
    
        if(!password_field.check()) {
            let password = password_field.getValue()
            let confirm = confirm_field.getValue()
            let token = document.querySelector('#token').getValue()
    
            if(password == confirm) {
                let data = {token, password}
                btn.disable(true)
    
                requestAxios('restore_send', data, res => {    
                    if(res.res == 'error'){
                        displayAuthErrors(res.fields)
                        btn.enable()
                    }else{
                        form.hide()
                        success_screen.show()
    
                        setTimeout(() => {
                            window.location.href = window.city ? '/' + window.city + '/login/' : '/login/'
                        }, 5000)
                    }
                })
    
            } else {
                confirm_field.classList.add('error')
                add_notif({
                    title: 'Ошибка',
                    text: 'Пароли не совпадают',
                    icon: 'close',
                    color: 'red',
                    timeout: 4000
                })
            }
        }
    })
}