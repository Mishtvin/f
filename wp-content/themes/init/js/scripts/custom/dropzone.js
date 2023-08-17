function dropzone(element, callback) {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        element.addEventListener(eventName, preventDefaults, false)
    })
    
    function preventDefaults (e) {
        e.preventDefault()
        e.stopPropagation()
    }

    element.addEventListener('drop', handleDrop, false)

    function handleDrop(e) {
        let dt = e.dataTransfer
        let files = dt.files

        if(files.length) {
            files = Array.from(files)
            
            callback(files)
        }
    }
}