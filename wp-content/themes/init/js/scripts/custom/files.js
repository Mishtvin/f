let fileSizes = {
    mb: 1048576,
    kb: 1024,
}

let fileMaxSize = fileSizes.mb * 2

let fileAllowedTypes = [
    'audio/mp4',
    'audio/mpeg',
    'audio/ogg',
    'audio/webm',

    'image/gif',
    'image/jpeg',
    'image/pjpeg',
    'image/png',
    'image/svg+xml',
    'image/vnd.microsoft.icon',
    'image/webp',

    'application/msword',
    'application/zip',
    'application/pdf',
    'application/javascript',
    'application/json',
    'application/x-zip',
    'application/x-zip-compressed',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

    'text/css',
    'text/csv',
    'text/html',
    'text/javascript',
    'text/php',
    'text/xml',

    'video/mpeg',
    'video/mp4',
    'video/ogg',
    'video/webm',
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
let paintFile = {
    pdf: 'red',
    msword: 'blue',
}

let fileTooLargeError = 'Файл слишком много весит'
let fileTypeError = 'Недопустимый тип файла'

function processFiles(options = {}) {
    let {files, callback, fileAllowedTypes = fileAllowedTypes} = options
    let newFiles = []

    files.forEach(file => {
        let name = file.name
        let size = file.size
        let type = file.type

        let errors = 0

        if(size > fileMaxSize) {
            add_notif({
                title: name,
                text: fileTooLargeError,
                icon: 'close',
                color: 'red',
                timeout: 4000
            })

            errors++
        }

        if(!fileAllowedTypes.includes(type)) {
            add_notif({
                title: name,
                text: fileTypeError,
                icon: 'close',
                color: 'red',
                timeout: 4000
            })

            errors++
        }

        if(!errors) {
            newFiles.push(file)
        }
    })
    
    if(newFiles.length) {
        let processedFiles = []
        let length = newFiles.length
        let index = 0
        
        let processFile = (file, file_index) => {
            let data = {
                name: file.name,
                size: file.size,
                type: file.type,
                id: file_index
            }
            let reader = new FileReader()

            reader.onload = res => {
                data.base64 = res.target.result

                processedFiles.push(data)

                index++

                if(length == index) {
                    callback(processedFiles)
                }

            }

            reader.readAsDataURL(file)
        }        

        newFiles.forEach((file, index) => {
            processFile(file, index);
        })
    }
}