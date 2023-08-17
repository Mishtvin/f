let toggleOrdersBtns = document.querySelectorAll('.toggle-order')

if(toggleOrdersBtns.length) {
    for(let btn of toggleOrdersBtns) {
        btn.addEventListener('click', () => {
            let wrapper = btn.closest('.order-item')
            let dropdown = wrapper.querySelector('.order-dropdown')

            if(wrapper.classList.contains('active')) {
                wrapper.classList.remove('active')
                dropdown.hide()
            } else {
                wrapper.classList.add('active')
                dropdown.show()
            }
        })
    }
}