function openPopup(popup){
    if(typeof(popup) == 'string'){
        popup = document.querySelector('.popup.' + popup)
    }

    if(popup) {
        popup.style.display = 'block'
    }
}

function closePopup(popup){
    if(typeof(popup) == 'string'){
        popup = document.querySelector('.popup.' + popup)
    }

    if(popup) {
        popup.style.display = 'none'
    }
}

let orderBtn = document.querySelectorAll('.order-btn')

if(orderBtn.length) {
    for(let btn of orderBtn) {
        btn.addEventListener('click', () => {
            openPopup('order-popup')
        })
    }
}

let closePopupBtn = document.querySelectorAll('.close-popup')

if(closePopupBtn.length) {
    for(let elem of closePopupBtn) {
        elem.addEventListener('click', () => {
            let popup = elem.closest('.popup')
            let btn = popup.querySelector('.btn')
    
            closePopup(popup)
            btn.removeAttribute('disabled')
        })
    }
}

function openPopupBtns() {
    let openPopupBtn = document.querySelectorAll('.open-popup:not(.inited)')

    if(openPopupBtn.length) {
        for(let elem of openPopupBtn) {
            elem.addEventListener('click', () => {
                let popup = document.querySelector('.' + elem.dataset.popup)
                
                openPopup(popup)
            })

            elem.classList.add('inited')
        }
    }
}

openPopupBtns()