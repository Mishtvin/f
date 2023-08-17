let bestDealsTabs = document.querySelectorAll('.best-deals-tab')

for(let tab of bestDealsTabs) {
    tab.addEventListener('click', () => {
        let tabSiblings = tab.siblings()
        let tabKey = tab.dataset.key
        let tabContent = document.querySelector('.catalog[data-key="' + tabKey + '"]')
        let contentSiblings = tabContent.siblings()

        tab.classList.add('active')
        tabContent.style.display = 'flex'
        
        if(contentSiblings.length) {
            for(let elem of contentSiblings) {
                elem.style.display = 'none'
            }
        }

        if(tabSiblings.length) {
            for(let elem of tabSiblings) {
                elem.classList.remove('active')
            }
        }
    })
}