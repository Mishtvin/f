String.prototype.date = function(){
    let val = this.split(' ')
    let date = val[0].split('.')
    let total = ''

    total = date[2] + '-' + date[1] + '-' + date[0]

    if(val[1]){
        let time = val[1]

        total += ' ' + time
    }

    return new Date(total)
}

String.prototype.to_link = function(){
    let link = this

    if(this.indexOf('https://') == -1 && this.indexOf('http://') == -1){
        link = 'https://' + link
    }

    if(link.charAt(link.length - 1) != '/'){
        link += '/'
    }

    return link
}

Number.prototype.get_duration = function(){
    const minutes = Math.floor(this / 60000).toFixed(0)
    const seconds = ((this % 60000) / 1000).toFixed(0)

    return (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds
}

Date.prototype.time = function(){
    const hours = this.getHours()
    const hours_formated = hours > 9 ? hours : '0' + hours

    const minutes = this.getMinutes()
    const minutes_formated = minutes > 9 ? minutes : '0' + minutes

    return hours_formated + ':' + minutes_formated
}

Date.prototype.get_dm = function(){
    const day = this.getDate()
    const day_formated = day > 9 ? day : '0' + day

    const month = this.getMonth() + 1
    const month_formated = month > 9 ? month : '0' + month

    return day_formated + '.' + month_formated
}

Date.prototype.dmY = function(){
    const day = this.getDate()
    const day_formated = day > 9 ? day : '0' + day

    const month = this.getMonth() + 1
    const month_formated = month > 9 ? month : '0' + month

    const year = this.getFullYear()

    return day_formated + '.' + month_formated + '.' + year
}

Date.prototype.Ymd = function(){
    const day = this.getDate()
    const day_formated = day > 9 ? day : '0' + day

    const month = this.getMonth() + 1
    const month_formated = month > 9 ? month : '0' + month

    const year = this.getFullYear()

    return year + '-' + month_formated + '-' + day_formated
}

Date.prototype.left = function(){
    let now = new Date()
    let nowYear = now.getFullYear()
    let nowMonth = now.getMonth()
    let nowDay = now.getDate()
    let nowHour = now.getHours()
    let nowMinutes = now.getMinutes()
    let nowSeconds = now.getSeconds()

    let leftYear = this.getFullYear()
    let leftMonth = this.getMonth()
    let leftDay = this.getDate()
    let leftHour = this.getHours()
    let leftMinutes = this.getMinutes()
    let leftSeconds = this.getSeconds()

    let comparison = {
        years: [nowYear, leftYear],
        months: [nowMonth, leftMonth],
        days: [nowDay, leftDay],
        hours: [nowHour, leftHour],
        minutes: [nowMinutes, leftMinutes],
        seconds: [nowSeconds, leftSeconds],
    }

    let interpreter = {
        years: ['год', 'года', 'лет'],
        months: ['месяц', 'месяца', 'месяцев'],
        days: ['день', 'дня', 'дней'],
        hours: ['час', 'часа', 'часов'],
        minutes: ['минуту', 'минуты', 'минут'],
        seconds: ['секунду', 'секнуды', 'секунд']
    }

    let number = null
    let format = null

    $.each(comparison, (key, value) => {
        if(number === null){

            if(value[1] - value[0] != 0){
                number = value[1] - value[0]
                format = key
            }

        }
    })

    let total = 'сейчас'

    if(number !== null && number > 0){
        let labels = interpreter[format]
        let label = ''

        if(number == 1){
            label = labels[0]
        }else if(number > 1 && number < 5){
            label = labels[1]
        }else{
            label = labels[2]
        }

        total = number + ' ' + label
    }

    return total
}

Date.prototype.weekday = function(){
    return new Intl.DateTimeFormat('en-US', { weekday: 'long'}).format(this)
}

Date.prototype.weekday_ru = function(){
    return new Intl.DateTimeFormat('ru-RU', { weekday: 'long'}).format(this)
}

HTMLElement.prototype.startLoading = function() {
    this.insertAdjacentHTML('beforeend', '<div class="loading-layer"><div class="spinner-wrapper"></div></div>')
    return this
}

HTMLElement.prototype.stopLoading = function() {
    this.querySelector('.loading-layer').remove()
    return this
}

HTMLElement.prototype.top = function(){
    let rect = this.getBoundingClientRect()
    let offset = rect.top + window.scrollY

    return offset
}

HTMLElement.prototype.index = function(){
    let nodes = Array.prototype.slice.call( this.parentElement.children )
    let index = nodes.indexOf(this)

    return index
}

HTMLElement.prototype.siblings = function(check = null){
    let siblings = []

    if(!this.parentNode) {
        return siblings
    }

    let child = this.parentNode.childNodes
    
    for(let sibling of child) {
        if (sibling.nodeType === 1 && sibling !== this) {
            if(!check || check && check(sibling)) {
                siblings.push(sibling)
            }
        }
    }
    return siblings
}

HTMLElement.prototype.show = function(){
    this.style.display = 'block'
}

HTMLElement.prototype.flex = function(){
    this.style.display = 'flex'
}

HTMLElement.prototype.hide = function(){
    this.style.display = 'none'
}

HTMLElement.prototype.resize = function(){
    this.style.height = '0px'
    let height = this.scrollHeight + 2

    this.style.height = 'auto'
    let minHeight = this.clientHeight

    if(!this.getAttribute('cols')) {
        minHeight = 0
    }

    height = Math.max(height, minHeight)
    this.style.height = height + 'px'

    return this
}

function fadeOut(elem, time = 200) {
    let fadeEffect = setInterval(function () {
        if (!elem.style.opacity) {
            elem.style.opacity = 1
        }
        if (elem.style.opacity > 0) {
            elem.style.opacity -= 0.1
        } else {
            clearInterval(fadeEffect)
        }
    }, time)
}

function fadeIn(elem, time = 200) {
    elem.style.opacity = 0

    var last = +new Date()
    var tick = function () {
        elem.style.opacity = +elem.style.opacity + (new Date() - last) / time
        last = +new Date()

        if (+elem.style.opacity < 1) {
            (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16)
        }
    }

    tick()
}

function clickOut(elem, callback) {
    document.addEventListener( 'click', (e) => {
        const withinBoundaries = e.composedPath().includes(elem)

        if ( !withinBoundaries ) {
            callback()
        }
    })
}