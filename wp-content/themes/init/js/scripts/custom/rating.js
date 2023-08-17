let productReviewSend = document.querySelector('#product_review_send')

if(productReviewSend) {
	productReviewSend.addEventListener('click', (e) => {
        e.preventDefault()

        let elem = productReviewSend
        let form = elem.closest('form')
		let rating = Number(form.querySelector('.stars-input input:checked').value) || 5
        let product = window.productID
        let fields = {
            date: 1,
            name: 1,
            review: 1,
        }
		let data = {rating, product}
        let errors = 0
    
        for(let key in fields) {
            let required = fields[key]
            let field = form.querySelector('.' + key)
    
            if(field) {
                let value = field.getValue()
    
                if(required) {
                    errors += field.check()
                }
    
                data[key] = value
            }
        }
    
        if(!errors) {
            elem.disable(true)

			requestAxios('sendProductReview', data, () => {
				elem.enable()

				let popup = form.closest('.popup')
				
				closePopup(popup)

				for(let key in fields) {
					let field = form.querySelector('.' + key)
			
					if(field) {
						field.clear()
					}
				}

				add_notif({
					title: 'Спасибо',
					text: 'Ваш отзыв был отправлен на модерацию',
					icon: 'success',
					color: 'green',
					timeout: 4000
				})
			})
        }
    })
}

/////

let changeReviewStatusBtns = document.querySelectorAll('.change-product-review-status')
let changeStatusAvailable = true

if(changeReviewStatusBtns.length) {
    for(let btn of changeReviewStatusBtns) {
        btn.addEventListener('click', () => {
            if(changeStatusAvailable) {
                let id = btn.dataset.id
                let status = btn.dataset.status
                
                changeStatusAvailable = false

                requestAxios('changeProductReviewStatus', {id, status}, () => {
                    window.location.reload()
                })
            }
        })
    }
}