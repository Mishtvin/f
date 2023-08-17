let slider = document.querySelector('.reviews-slider')

if (slider) {
	new Swiper(slider, {
		slideClass: 'review-card',
		loop: false,
		navigation: {
			nextEl: '.reviewsSliderNext',
			prevEl: '.reviewsSliderPrev',
		},
		speed: 600,
		slidesPerView: 1,
		spaceBetween: 30,
		autoHeight: true,
		breakpoints: {
            1025: {
				autoHeight: false,
                slidesPerView: 2
            }
        }
	})
}

/////

let reviewBtns = document.querySelectorAll('.review-btn')

if(reviewBtns.length) {
	for(let btn of reviewBtns) {
		btn.addEventListener('click', () => {
			let popup = document.querySelector('.review-popup')

			openPopup(popup)
		})
	}
}

/////

let reviewsSend = document.querySelector('#review_send')

if(reviewsSend) {
	reviewsSend.addEventListener('click', (e) => {
        e.preventDefault()

        let elem = reviewsSend
        let form = elem.closest('form')
		let rating = Number(form.querySelector('.stars-input input:checked').value) || 5
        let fields = {
            date: 1,
            name: 1,
            phone: 1,
            review: 1,
        }
		let imageField = document.querySelector('#review_image')
		let image = imageField.image
		let data = {rating, image}
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

			requestAxios('sendReview', data, () => {
				elem.enable()

				let popup = form.closest('.popup')
				
				closePopup(popup)

				imageField.setImage = ''

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