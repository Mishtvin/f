let advantages = document.querySelectorAll('.advantages-grid .advantage')

for(let item of advantages) {
    let showMore = item.querySelector('.text-wrapper')

    clickOut(item, () => {
        item.classList.remove('show')
    })

    showMore.addEventListener('click', () => {
        item.classList.add('show')
    })
}