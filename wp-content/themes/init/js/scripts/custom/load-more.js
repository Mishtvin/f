// let load_more = $('#load_more')

// if(load_more.length) {
//     let page = Number(load_more.data('page'))

//     load_more.click(function(){
//         let elem = $(this)
//         let wrapper = elem.parent()
//         let max = Number(elem.data('max'))
//         let url = window.location.href

//         page++
//         elem.disable(true)

//         let data = {page, url}
//         requestAxios('load_more', data, (res) => {
//             wrapper.before(res)

//             if(max == page) {
//                 wrapper.remove()
//             } else {
//                 elem.enable()
//             }
            
//         })
//     })
// }