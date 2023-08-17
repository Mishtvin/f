let accords = document.querySelectorAll('.accord-header')

if(accords.length) {
    for(let item of accords) {
        item.addEventListener('click', () => {
            let parent = item.parentElement
            let siblings = parent.siblings()
            
            if(parent.classList.contains('active')) {
                parent.classList.remove('active')
            } else {
                parent.classList.add('active')
            }
    
            for(let elem of siblings) {    
                elem.classList.remove('active')
            }
        })
    }
}



jQuery(document).ready(function () {
    jQuery('#menu-primary > .menu-third.menu-item-has-children > .sub-menu > .menu-item-has-children > a').click(function (e){
        e.preventDefault();
    })
});
