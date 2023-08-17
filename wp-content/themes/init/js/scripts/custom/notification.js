let notificationIndex = 1

window.closeNotif = notification => {
    notification.remove()
}

window.add_notif = options => {
    const notifWrapper = document.querySelector('.push-notifications')

    if(notifWrapper) {
        options.title = options.title ? `<h6>${options.title}</h6>` : ''
        options.text = options.text ? `<p>${options.text}</p>` : ''
        options.icon = options.icon || ''
        options.iconUser = options.iconUser || ''
        options.color = options.color || ''
        options.timeout = options.timeout || null
        options.onClose = options.onClose || null
        options.btns = options.btns || []
        options.link = options.link || null
    
        let timer = 0
        let icon = ''
        let elemType = 'div'
        let attrs = [`data-id="${notificationIndex}"`]
        let classes = ['notif-item']
    
        if(options.color) {
            classes.push(options.color + '-theme')
        }
    
        if(options.link) {
            elemType = 'a'
            attrs.push(`href="${options.link}"`)
            classes.push('prevent-focus')
        }
    
        if(options.icon || options.iconUser) {
            const iconClasses = ['avatar']
    
            if(options.iconUser) {
                icon = options.iconUser.charAt(0)
                iconClasses.push('online')
            }else if(options.icon) {
                iconClasses.push('icon-' + options.icon)
            }
    
            icon = `<span class="${iconClasses.join(' ')}">${icon}</span>`
        }
    
        let btns = []
        let btnsActions = {}
    
        if(options.btns.length) {
            for(let key in options.btns) {
                let btn = options.btns[key]

                let btnClasses = ['btn', 'medium']
                let content = ''
                let elemType = 'button'
                let attrs = [`data-index="${key}"`]
    
                if(btn.link) {
                    elemType = 'a'
                    attrs.push(`href="${btn.link}"`)
                }
    
                if(btn.style) {
                    btnClasses.push(btn.style)
                }
    
                if(btn.color) {
                    btnClasses.push(btn.color + '-theme')
                }
    
                if(btn.onClick) {
                    btnsActions[key] = btn.onClick
                }
    
                if(btn.type == 'text') {
                    contentClasses = ['text']
    
                    if(btn.icon) {
                        contentClasses.push('icon-' + btn.icon)
                    }
    
                    content = `<span class="${contentClasses.join(' ')}">${btn.text}</span>`
                }else if(btn.type == 'icon') {
                    contentClasses = ['icon']
    
                    if(btn.icon) {
                        contentClasses.push('icon-' + btn.icon)
                    }
    
                    content = `<span class="${contentClasses.join(' ')}"></span>`
                }
    
                btns.push(`<${elemType} class="${btnClasses.join(' ')}" ${attrs.join(' ')}>${content}</${elemType}>`)
            }
        }
    
        if(btns.length) {
            btns = `
                <div class="inline">
                    <div class="line">${btns.join('')}</div>
                </div>
            `
        }else{
            btns = ''
        }
    
        let notification = `
            <${elemType} class="${classes.join(' ')}" ${attrs.join(' ')}>
                <div class="notif-wrapper">
                    ${icon}
                    <div class="notif-content article-mc">
                        ${options.title}
                        ${options.text}
                        ${btns}
                    </div>
                    <span class="close-notif close-icon icon-close"></span>
                </div>
            </${elemType}>
        `
        
        notifWrapper.insertAdjacentHTML('beforeend', notification)    
        notification = document.querySelector(`.notif-item[data-id="${notificationIndex}"]`)
        notification.style.display = 'block'
        
        for(let key in btnsActions) {
            let action = btnsActions[key]
            let target = notification.querySelector(`.btn[data-index="${key}"]`)

            target.addEventListener('click', (e) => {
                e.preventDefault()
                action(notification, options)
            })
        }
        
        notification.querySelector('.close-notif').addEventListener('click', (e) => {
            e.preventDefault()
    
            if(options.onClose) {
                options.onClose(notification, options)
            }else{
                clearTimeout(timer)
                timer = 0
    
                closeNotif(notification)
            }
        })
        
        notification.resetTimer = () => {
            if(options.timeout) {
    
                if(timer) {
                    clearTimeout(timer)
                    timer = 0
                }
                timer = setTimeout(() => closeNotif(notification), options.timeout)
            }
        }
    
        notification.resetTimer()
        
        notification.addEventListener('mouseenter', () => {
            clearTimeout(timer)
            timer = 0            
        })

        notification.addEventListener('mouseleave', () => {
            notification.resetTimer()         
        })
    
        notificationIndex++
    
        playRing()
    }
}