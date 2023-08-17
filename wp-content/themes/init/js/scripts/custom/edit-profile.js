let saveEditBtn = document.querySelector('#save_edit')

if(saveEditBtn) {
    saveEditBtn.addEventListener('click', (e) => {
        let elem = saveEditBtn
        let form = elem.closest('form')
        let name_field = document.querySelector('#edit_name')
        let surname_field = document.querySelector('#edit_surname')
        let phone_field = document.querySelector('#edit_phone')
        let email_field = document.querySelector('#edit_email')
        let password_field = document.querySelector('#edit_password')
        let confirm_field = document.querySelector('#edit_password_confirm')
        let check_fields = [name_field, surname_field, phone_field, email_field]
        let errors = 0
    
        for(let field of check_fields){
            errors += field.check()
        }
    
        e.preventDefault()
        
        if(!errors){
            let name = name_field.getValue()
            let surname = surname_field.getValue()
            let phone = phone_field.getValue()
            let email = email_field.getValue()
            let password = password_field.getValue()
            let confirm = confirm_field.getValue()
            let results = {name, surname, phone, email}
            let send = true
    
            if(password){
                if(password != confirm){
                    add_notif({
                        title: 'Ошибка',
                        text: 'Пароли не совпадают',
                        icon: 'close',
                        color: 'red',
                        timeout: 3500
                    })
    
                    send = false
                }else{
                    results.password = password
                }
            }
    
            if(send){
                elem.disable(true)
    
                requestAxios('editProfile', results, function(res){
                    elem.enable()
    
                    console.log(res);
                    if(res){
                        res = JSON.parse(res)
                        displayAuthErrors(res)
                    }else{
                        add_notif({
                            title: 'Редактирование',
                            text: 'Ваши данные успешно изменены',
                            icon: 'success',
                            color: 'green',
                            timeout: 3500
                        })
                    }
                })
            }
    
        }
    })
}