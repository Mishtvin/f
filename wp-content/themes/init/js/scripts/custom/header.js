let header = document.querySelector('.site-header')
let toUpBtn = document.querySelector('.to-up')
// let fixedBtns = document.querySelector('.fixed-btns')

window.onload = () => {

    function headerCheck() {
        let {scrollY} = window
        let {clientHeight} = header

        if(scrollY > clientHeight) {
            toUpBtn.classList.add('show')
        } else {
            toUpBtn.classList.remove('show')
        }
    }

    window.addEventListener('scroll', headerCheck)

    headerCheck()

    if(toUpBtn) {
        toUpBtn.addEventListener('click', () => {
            let body = document.querySelector('body')
    
            body.scrollIntoView()

            headerCheck()
        })
    }
}

/////

let mobileMenuBtn = document.querySelector('.mobile-menu-btn')
let mobileMenu = document.querySelector('.mobile-menu')

mobileMenuBtn.addEventListener('click', () => {
    if(mobileMenu.classList.contains('show')) {
        mobileMenu.hide()
        mobileMenu.classList.remove('show')
        mobileMenuBtn.classList.remove('active')
    } else {
        mobileMenu.show()
        mobileMenu.classList.add('show')
        mobileMenuBtn.classList.add('active')

    }
})

/////

let mobileMenuItems = document.querySelectorAll('.mobile-menu .menu-item-has-children')

if(mobileMenuItems.length) {
    for(let item of mobileMenuItems) {
        item.querySelector('a').insertAdjacentHTML('beforeend', '<span class="mobile-menu-item-toggler icon-down">')
    }

    let mobileMenuItemIoggler = document.querySelectorAll('.mobile-menu-item-toggler')

    if(mobileMenuItemIoggler.length) {
        for(let item of mobileMenuItemIoggler) {
            item.addEventListener('click', (e) => {
                let parent = item.parentElement
                let menu = parent.nextElementSibling

                if(item.classList.contains('active')) {
                    item.classList.remove('active')
                    menu.hide()
                } else {
                    item.classList.add('active')
                    menu.show()
                }

                e.preventDefault()
            })
        }
    }
}

/////

let headerMenuItems = document.querySelectorAll('.bottom-header ul')

if(headerMenuItems.length) {
    for(let item of headerMenuItems) {
        item.classList.add('loaded')
    }
}

/////

let toggleSearch = document.querySelector('.toggle-search')

if(toggleSearch) {
    toggleSearch.addEventListener('click', () => {
        let searchWrapper = document.querySelector('header .search-wrapper')

        searchWrapper.classList.toggle('show')
        searchWrapper.querySelector('input').focus()
    })
}