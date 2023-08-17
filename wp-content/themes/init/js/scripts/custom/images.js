let imagePickers = document.querySelectorAll('.image-picker.square input');

let file_list = [];

if(imagePickers.length) {

    for(let elem of imagePickers) {
        // let input = elem.querySelector('input')
        let wrapper = document.querySelectorAll('.image-picker.square label')
        let placeholder = document.querySelector('.image-picker.square label .placeholder')
        let files_list = document.querySelector('.image-picker.square label .files-list')

        Object.defineProperty(elem, 'image', {

            set: (data) => {
                console.log({data})
                if(data) {
                    files_list.innerHTML = "";
                    if( Array.isArray(data) ){
                        for (let i = 0; i < data.length; i++) {



                            let imageWrapper = document.createElement('div')
                            let image = document.createElement('div')
                            let closeImage = document.createElement('div')

                            ////

                            imageWrapper.classList.add('image-wrapper')
                            imageWrapper.dataset.id = i;
                            imageWrapper.dataset.name = btoa(unescape(encodeURIComponent(data[i].name + data[i].size + data[i].type)))
                            image.classList.add('image')
                            image.style.backgroundImage = `url(${data[i].base64})`
                            closeImage.classList.add('close')
                            closeImage.dataset.id = i;
                            closeImage.classList.add('icon-close')

                            ////

                            closeImage.addEventListener('click', (e) => {
                                const image_name = e.target.parentNode.dataset.name;

                                //file_list[image_id] = null;
                                // console.log("file_list_before: ", file_list)

                                file_list = file_list.filter((item, index) => {
                                    //console.log(btoa(unescape(encodeURIComponent(item.name + item.size + item.type))), image_name, index)
                                    return btoa(unescape(encodeURIComponent(item.name + item.size + item.type))) !== image_name;
                                });


                                const image = document.querySelector(`div.image-wrapper[data-name="${image_name}"]`);
                                //console.log(image, `div.image-wrapper[data-id="${image_name}"]`)
                                image.parentNode.removeChild(image);

                                // console.log("file_list_after: ", file_list)
                                wrapper[0].classList.remove('js--files-chosen')
                                //elem.setImage(file_list)

                                //elem.setImage('')
                                image[0] = data[i].name;
                                requestAxios('axiosDeleteProductImage', image);

                                e.preventDefault()
                            })

                            ////

                            placeholder.innerHTML = ''
                            files_list.appendChild(imageWrapper)
                            imageWrapper.appendChild(image)
                            imageWrapper.appendChild(closeImage)

                            wrapper[0].classList.add('js--files-chosen')
                        }
                    }else{
                        let imageWrapper = document.createElement('div')
                        let image = document.createElement('div')
                        let closeImage = document.createElement('div')

                        ////

                        imageWrapper.classList.add('image-wrapper')
                        image.classList.add('image')
                        image.style.backgroundImage = `url(${data.base64})`
                        imageWrapper.dataset.name = btoa(unescape(encodeURIComponent(data.name + data.size + data.type)))
                        closeImage.classList.add('close')
                        closeImage.classList.add('icon-close')

                        ////

                        closeImage.addEventListener('click', (e) => {

                            elem.setImage('')

                            e.preventDefault()
                        })

                        ////

                        placeholder.innerHTML = ''
                        files_list.appendChild(imageWrapper)
                        imageWrapper.appendChild(image)
                        imageWrapper.appendChild(closeImage)
                    }
                } else {
                    placeholder.innerHTML = `
                        <span class="icon icon-image"></span>
                        <div class="title">Выберите или перетащите изображение</div>
                    `
                    files_list.innerHTML = '';
                }

                return this.attachedImage = data
            },
            get: () => {
                return this.attachedImage
            }
        })

        elem.setImage = (file = '') => {
            if(file) {
                for (let i = 0; i < file.length; i++) {
                    file_list.push(file[i])
                }
                processFiles({
                    files: file_list,
                    callback: (files) => {
                        elem.image = files
                    },
                    fileAllowedTypes: ['image/jpeg', 'image/png', 'image/webp']
                })
            } else {
                elem.image = ''
            }

            elem.value = ''
        }

        elem.addEventListener('change', () => {

            let {files} = elem


            if(files.length) {
                console.log(files.length);
                elem.setImage(files)
            }
        })

        dropzone(wrapper[0], files => {
            elem.setImage(files)
        })

        elem.setImage('')

        if(elem.dataset.image) {
            let image = elem.dataset.image

            image = image.split(',');

            requestAxios('getImageData', {image}, (res) => {
                console.log(res);
                elem.image = res
            })
        }
    }
}
