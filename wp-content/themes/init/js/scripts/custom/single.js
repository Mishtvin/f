let singleImage = document.querySelector('.single-image .image-wrapper')

if(singleImage) {
    let img = singleImage.querySelector('img')

    if(img) {

        singleImage.addEventListener('click', () => {
            let img = singleImage.querySelector('img')
    
            if(img) {
                let {src} = img
                let type = 'image'
    
                Fancybox.show([
                    {src, type}
                ])
            }
        })

        

    }
}



// let imageWrapper = document.querySelector('.single-image .image-wrapper')
// if(imageWrapper){
//     new Swiper(imageWrapper, {
//         slideClass: 'news-card',
//         loop: false,
//         slidesPerView: 1,
//     })  
// }

////

let removeProduct = document.querySelector('.delete-product')

if(removeProduct) {
    removeProduct.addEventListener('click', () => {
        add_notif({
            title: 'Удаление товара',
            text: 'Вы уверены что хотите удалить товар?',
            color: 'red',
            icon: 'warning',
            btns: [
                {
                    text: 'Удалить',
                    type: 'text',
                    color: 'red',
                    onClick: (elem) => {
                        let {slug} = removeProduct.dataset
                        closeNotif(elem)
                        requestAxios('axiosRemoveProduct', {slug}, () => {
                            window.location.href = '/product/'
                        })
                    }
                },
                {
                    text: 'Отмена',
                    type: 'text',
                    style: 'outline',
                    onClick: (elem) => {
                        closeNotif(elem)
                    }
                }
            ]
        })
    })
}