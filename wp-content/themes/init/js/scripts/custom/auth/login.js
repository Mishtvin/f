function login(e){
    let form = document.querySelector('.auth-form')
    let loginField = document.querySelector('#login_phone_or_email')
    let passwordField = document.querySelector('#login_password')
    let rememberField = document.querySelector('#remember')
    let btn = document.querySelector('#login_send')
    let errors = 0
    let checkFields = [loginField, passwordField]

    e.preventDefault()

    for(field of checkFields){
        errors += field.check()
    }

    if(!errors){
        let login = loginField.getValue()
        let password = passwordField.getValue()
        let remember = rememberField.checked ? 1 : 0
        let data = {login, password, remember}

        btn.disable(true)

        requestAxios('login', data, res => {
            if(res.res == 'error'){
                displayAuthErrors(res.fields)
                btn.enable()
            }else{
                window.location.href = window.city ? '/' + window.city + '/dashboard/' : '/dashboard/'
            }
        })
    }

}

let loginBtn = document.querySelector('#login_send')

if(loginBtn) {
    loginBtn.addEventListener('click', login)
}