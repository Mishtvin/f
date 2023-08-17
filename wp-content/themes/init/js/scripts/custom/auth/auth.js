function displayAuthErrors(fields){
    for(let id in fields) {
        let value = fields[id]
        let input = document.querySelector('#' + id)

        if(input) {
            input.classList.add('error')
        }

        add_notif({
            title: 'Ошибка',
            text: value,
            icon: 'close',
            color: 'red',
            timeout: 4000
        })
    }
}
