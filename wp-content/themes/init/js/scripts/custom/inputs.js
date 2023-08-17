let clearInputBtns = document.querySelectorAll('.clear-input')

if(clearInputBtns.length) {

    for(let btn of clearInputBtns) {
        let parent = btn.parentNode
        let input = parent.querySelector('input')
        let error = parent.querySelector('.error-message')

        if(error) {
            error.remove()
        }

        input.classList.remove('error')

        if(input.mask) {
            input.mask.unmaskedValue = ''
        } else {
            input.val('')
        }
    }

}

/////

let showPasswordBtns = document.querySelectorAll('.show-password')

if(showPasswordBtns.length) {

    for(let btn of showPasswordBtns) {
        btn.addEventListener('click', () => {
            let parent = btn.parentNode
            let input = parent.querySelector('input')
            let type = input.type
    
            if(type == 'password') {
                input.type = 'text'
            } else {
                input.type = 'password'
            }
        })
    }

}

function display_error(input, message){
    let parent = input.parentNode
    let error = parent.querySelector('.error-message')

    if(error) {
        error.remove()
    }
}

HTMLElement.prototype.check = function() {
    let parent = this.parentNode
    let error = parent.querySelector('.error-message')
    let val = String(this.value).trim()

    if(error) {
        error.remove()
    }

    let errors = 0
    let type = this.type

    if(this.classList.contains('link-field')) {
        if(val) {
            if(val.indexOf('https://') == -1 && val.indexOf('http://') == -1) {
                val = 'https://' + val
            }

            if(val.chartAt(val.length - 1) != '/') {
                val += '/'
            }

            try {
                new URL(val)
            } catch (e) {
                errors++
            }
        }else{
            errors++
        }
    } else if (this.classList.contains('email')) {
        let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/
        let emailTest = regex.test(val)

        if(!emailTest && val == ''){
            this.classList.add('error')
            errors++
        }else if(!emailTest){
            this.classList.add('error')
            errors++
        }else{
            this.classList.remove('error')
        }
    }else if(type == 'checkbox') {
        if(this.checked){
            this.classList.remove('error')
        }else{
            this.classList.add('error')
            errors++
        }
    } else {
        let isMasked = this.mask ? true : false
    
        if(val) {
            this.classList.remove('error')
        }else{
            errors++
            this.classList.add('error')
        }
    
        if(isMasked && !errors) {
            let type = this.mask.type

            if(type == 'phone')  {
                val = this.mask.unmaskedValue

                if(val.length == 11) {
                    this.classList.remove('error')
                } else {
                    errors++
                    this.classList.add('error')
                }
            } else {
                if(val.indexOf('_') == -1) {
                    this.classList.remove('error')
                }else{
                    errors++
                    this.classList.add('error')
                }
            }
        }
        
        this.addEventListener('input', () => {
            this.classList.remove('error')
        })
    }

    return errors
}

HTMLElement.prototype.disable = function(appendLoading = false) {
    this.setAttribute('disabled', 'disabled')

    if(appendLoading && this.classList.contains('btn') && !this.querySelector('.spinner')) {
        let spinner = document.createElement('span')

        spinner.classList.add('spinner')
        this.classList.add('loading')

        this.appendChild(spinner)
    }
}

HTMLElement.prototype.enable = function() {
    let spinner = this.querySelector('.spinner')

    this.classList.remove('loading')

    if(spinner) {
        spinner.remove()
    }

    this.removeAttribute('disabled')
}

HTMLElement.prototype.getValue = function() {
    if(this.classList.contains('select-date')) {
        let val = this.selected

        if(val) {
            return val
        }
    } else if (this.classList.contains('link-field')) {
        let val = String(this.value).trim()

        if(val.indexOf('https://') == -1 && val.indexOf('http://') == -1) {
            val = 'https://' + val
        }

        if(val.charAt(val.length - 1) != '/') {
            val += '/'
        }

        let check = val.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g)

        return check ? val : ''
    } else {
        let hasMask = this.mask

        if(hasMask) {
            if(this.mask.type == 'time' || this.mask.type == 'date') {
                let val = String(this.value).trim()

                if(!val) {
                    return ''
                }else if(val.indexOf('_') != -1) {
                    return ''
                }

                return val
            }else if(this.mask.type == 'slug') {
                let val = String(this.mask.unmaskedValue).trim()
                return val
            }else{
                return String(this.mask.unmaskedValue).trim()
            }
        }else{
            return String(this.value).trim()
        }
    }
}

HTMLElement.prototype.clear = function() {
    let hasMask = this.mask

    if(hasMask) {
        this.mask.unmaskedValue = ''
    }else{
        this.value = ''
    }

    return this
}

let inputs = document.querySelectorAll('input, textarea')

if(inputs.length) {
    for(let input of inputs) {
        input.classList.remove('error')
    }
}

let resizeInputs = document.querySelectorAll('textarea.resize')

if(resizeInputs.length) {
    for(let input of resizeInputs) {
        input.addEventListener('input', input.resize)

        input.resize()
    }
}