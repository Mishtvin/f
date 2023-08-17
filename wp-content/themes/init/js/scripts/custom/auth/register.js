// function register(e){
//     let form = document.querySelector('.auth-form')
//     let firstNameField = document.querySelector('#register_firstname')
//     let lastNameField = document.querySelector('#register_lastname')
//     let phoneField = document.querySelector('#register_phone')
//     let emailField = document.querySelector('#register_email')
//     let passwordField = document.querySelector('#register_password')
//     let passwordConfirmField = document.querySelector('#register_password_confirm')
//     let checkbox = document.querySelector('#register_accert')
//     let btn = document.querySelector('#register_send')
//     let errors = 0
//     let checkFields = [firstNameField, lastNameField, phoneField, emailField, passwordField, passwordConfirmField, checkbox]

//     e.preventDefault()

//     for(field of checkFields){
//         errors += field.check()
//     }

//     if(!errors){
//         let firstName = firstNameField.getValue()
//         let lastName = lastNameField.getValue()
//         let phone = phoneField.getValue()
//         let email = emailField.getValue()
//         let password = passwordField.getValue()
//         let passwordConfirm = passwordConfirmField.getValue()
//         let data = {firstName, lastName, phone, email, password, passwordConfirm}

//         if(password != passwordConfirm){
//             add_notif({
//                 title: 'Ошибка',
//                 text: 'Пароли должны совпадать',
//                 icon: 'close',
//                 color: 'red',
//                 timeout: 4000
//             })

//             passwordConfirmField.classList.add('error')
//         }else{
//             requestAxios('register', data, (res) => {                
//                 if(res.res == 'error'){
//                     displayAuthErrors(res.fields)
//                     btn.enable()
//                 }else{
//                     window.location.href = window.city ? '/' + window.city + '/dashboard/' : '/dashboard/'
//                 }
//             })

//             btn.disable(true)
//         }
//     }

// }

// let registerSend = document.querySelector('#register_send')

// if(registerSend) {
//     registerSend.addEventListener('click', register)
// }

function register(e){
    let form = document.querySelector('.auth-form')
    let firstNameField = document.querySelector('#register_firstname')
    let lastNameField = document.querySelector('#register_lastname')
    let emailField = document.querySelector('#register_email')
    let passwordField = document.querySelector('#register_password')
    let passwordConfirmField = document.querySelector('#register_password_confirm')
    let checkbox = document.querySelector('#register_accert')
    let btn = document.querySelector('#register_send')
    let errors = 0
    let checkFields = [firstNameField, lastNameField, emailField, passwordField, passwordConfirmField, checkbox]

    e.preventDefault()

    for(field of checkFields){
        errors += field.check()
    }

    if(!errors){
        let firstName = firstNameField.getValue()
        let lastName = lastNameField.getValue()
        let email = emailField.getValue()
        let password = passwordField.getValue()
        let passwordConfirm = passwordConfirmField.getValue()
        let data = {firstName, lastName, email, password, passwordConfirm}

        if(password != passwordConfirm){
            add_notif({
                title: 'Ошибка',
                text: 'Пароли должны совпадать',
                icon: 'close',
                color: 'red',
                timeout: 4000
            })

            passwordConfirmField.classList.add('error')
        }else{
            requestAxios('register', data, (res) => {                
                if(res.res == 'error'){
                    displayAuthErrors(res.fields)
                    btn.enable()
                }else{
                    window.location.href = window.city ? '/' + window.city + '/dashboard/' : '/dashboard/'
                }
            })

            btn.disable(true)
        }
    }

}

let registerSend = document.querySelector('#register_send')

if(registerSend) {
    registerSend.addEventListener('click', register)
}