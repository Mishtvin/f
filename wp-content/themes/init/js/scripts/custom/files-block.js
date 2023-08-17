/*let fileSizes = {
    mb: 1048576,
    kb: 1024,
}
let fileAllowedTypes = [
    'image/jpeg',
    'image/png',
]
let renameFileFormates = {
    'svg+xml': 'svg',
    'vnd.microsoft.icon': 'ico',
    'x-zip': 'zip',
    'x-zip-compressed': 'zip',
    'javascript': 'js',
    'msword': 'doc',
    'vnd.openxmlformats-officedocument.wordprocessingml.document': 'docx',
    'vnd.openxmlformats-officedocument.spreadsheetml.sheet': 'xlsx'
}
let fileMaxSize = fileSizes.mb * 9
let maxFilesCount = 10

let fileTooLargeError = 'Файл слишком много весит'
let fileTypeError = 'Недопустимый тип файла'
let fileMaxCountError = `Вы можете загрузить не более ${maxFilesCount} `

if (maxFilesCount == 1) {
    fileMaxCountError += 'файла'
} else if (maxFilesCount > 1 && maxFilesCount < 5) {
    fileMaxCountError += 'файлов'
} else {
    fileMaxCountError += 'файлов'
}

let file_blocks = $('.input-wrapper.gallery input')

if (file_blocks.length) {
    file_blocks.each(function () {
        let elem = $(this)
        let label = elem.siblings('label')
        let selected = elem.data('selected')

        elem[0].files_list_data = []
        Object.defineProperty(elem[0], 'files_list', {
            set: (files) => {
                this.files_list_data = [...files]

                if (files.length) {
                    let files_list = []
                    let index = 0

                    label.addClass('not-empty')

                    function append_file(file) {
                        let type = file.type
                        let name = file.name
                        let size = (file.size / fileSizes.mb).toFixed(2) + ' МБ.'
                        let item_classes = ['file-item']

                        if (type == 'image/png') {
                            item_classes.push('png')
                        }

                        files_list.push(`
                            <div class="${item_classes.join(' ')}" data-id="${index}">
                                <div class="close-file-item icon-close" data-id="${index}"></div>
                                <div class="thumbnail"><img src="${file.base64}"></div>
                                <div class="file-name">${name}</div>
                                <div class="file-size">${size}</div>
                            </div>
                        `)

                        files.shift()
                        index++

                        if (files.length) {
                            process_file(files[0])
                        } else {
                            label.find('.line').html(files_list.join(''))

                            label.find('.close-file-item').click(function (e) {
                                let btn = $(this)
                                let id = btn.data('id')

                                elem[0].remove_file(id)

                                e.preventDefault()
                            })
                        }
                    }

                    function process_file(file) {
                        if (file.base64) {
                            append_file(file)
                        } else {
                            let reader = new FileReader()
                            reader.onloadend = () => {
                                file.base64 = reader.result
                                append_file(file)
                            }
                            reader.readAsDataURL(file)
                        }
                    }

                    process_file(files[0])
                } else {
                    label.removeClass('not-empty')
                }

                return this.files_list_data
            },
            get: () => {
                return this.files_list_data
            }
        })

        elem[0].add_files = (files) => {
            let filtred = []

            if (files && files.length) {

                let files_count = elem[0].files_list.length

                filesLimitError = false

                for (let file of files) {
                    let name = file.name
                    let size = file.size
                    let type = file.type

                    let errors = 0

                    if (size > fileMaxSize) {
                        addNotif({
                            title: name,
                            text: fileTooLargeError,
                            icon: 'close',
                            color: 'red',
                            timeout: 4000
                        })

                        errors++
                    }

                    if (!fileAllowedTypes.includes(type)) {
                        addNotif({
                            title: name,
                            text: fileTypeError,
                            icon: 'close',
                            color: 'red',
                            timeout: 4000
                        })

                        errors++
                    }

                    if (!errors) {
                        files_count++

                        if (files_count > maxFilesCount) {
                            filesLimitError = true
                        } else {
                            filtred.push(file)
                        }

                    }
                }

                if (filesLimitError) {
                    addNotif({
                        title: 'Ошибка',
                        text: fileMaxCountError,
                        icon: 'close',
                        color: 'red',
                        timeout: 4000
                    })
                }

                files = [...elem[0].files_list, ...filtred]
                elem[0].files_list = files
            } else {
                elem[0].files_list = []
            }
        }

        elem[0].remove_file = (id) => {
            let files = elem[0].files_list

            files.splice(id, 1)
            elem[0].files_list = files
        }

        elem.on('change', function () {
            let files = elem[0].files

            if (files.length) {
                files = Array.from(files)
                elem[0].add_files(files)
                elem.val('')
            }
        })

        function preventDefaults(e) {
            e.preventDefault()
            e.stopPropagation()
        }

        for (let event_name of ['dragenter', 'dragover', 'dragleave', 'drop']) {
            label[0].addEventListener(event_name, preventDefaults, false)
        }

        label[0].addEventListener('drop', (e) => {
            let data = e.dataTransfer
            let files = data.files

            if (files.length) {
                files = Array.from(files)

                elem[0].add_files(files)
            }
        })

        elem[0].sortable = new Sortable(label.find('.line')[0], {
            animation: 150,
            ghostClass: 'sortable-ghost',
            dataIdAttr: 'data-id',
            onUpdate: function () {
                let array = elem[0].sortable.toArray()
                let old_order = elem[0].files_list
                let new_order = []

                for (let index of array) {
                    new_order.push(old_order[index])
                }

                elem[0].files_list = new_order
            },
        })

        if (selected) {
            selected = String(selected)
            selected = selected.split(',')
            requestAjax('init_get_images', selected, res => {
                res = JSON.parse(res)

                elem[0].add_files(res)
            })
        }
    })
}

let edit_avatars = $('.edit-avatar input')

if (edit_avatars.length) {
    edit_avatars.each(function () {
        let elem = $(this)
        let empty_text = elem.data('label')
        let wrapper = elem.parent()
        let label = wrapper.find('label')
        let selected = elem.data('id')

        function append_avatar(avatar) {
            label.addClass('loaded')
            label.html(`
                <div class="image" style="background-image: url('${avatar.base64}')">
                    <div class="btn blur delete-avatar small square"><span class="icon icon-close"></span></div>
                </div>
            `)

            label.find('.delete-avatar').click((e) => {
                e.preventDefault()

                elem[0].remove_avatar()
            })
        }

        elem[0].avatar_data = ''
        Object.defineProperty(elem[0], 'avatar', {
            set: (avatar) => {
                this.avatar_data = avatar

                elem.removeClass('error')

                if (avatar) {
                    append_avatar(avatar)
                } else {
                    label.removeClass('loaded')

                    label.html(`
                        <div class="placeholder icon-camera">
                            <div class="text">${empty_text}</div>
                        </div>
                    `)
                }

                return this.avatar_data
            },
            get: () => {
                return this.avatar_data
            }
        })

        elem[0].set_avatar = (file) => {
            let name = file.name
            let size = file.size
            let type = file.type

            let errors = 0
            
            if (size > fileMaxSize) {
                addNotif({
                    title: name,
                    text: fileTooLargeError,
                    icon: 'close',
                    color: 'red',
                    timeout: 4000
                })

                errors++
            }

            if (!fileAllowedTypes.includes(type)) {
                addNotif({
                    title: name,
                    text: fileTypeError,
                    icon: 'close',
                    color: 'red',
                    timeout: 4000
                })

                errors++
            }

            if (!errors) {
                function send_avatar(file) {
                    let {name, size, type, base64} = file
                    let new_file = {name, size, type, base64}

                    elem[0].avatar = new_file
                }

                if(file.base64) {
                    send_avatar(file)
                } else {
                    let reader = new FileReader()
                    reader.onloadend = function () {
                        file.base64 = reader.result
                        send_avatar(file)
                    }
                    reader.readAsDataURL(file)
                }
            }
        }

        elem[0].remove_avatar = () => {
            elem[0].avatar = ''
        }

        elem.on('change', function () {
            let files = elem[0].files

            if (files.length) {
                files = Array.from(files)
                elem[0].set_avatar(files[0])
                elem.val('')
            }
        })

        elem[0].avatar = ''

        if(selected) {
            requestAjax('init_get_images', [selected], res => {
                res = JSON.parse(res)

                if(res.length) {
                    elem[0].set_avatar(res[0])
                }
            })
        }
    })
}*/