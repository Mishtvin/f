function postAjax(name, data){
    axios.post('/wp-admin/admin-ajax.php?action=' + name, data)
}

function requestAxios(name, data, func){
    axios.post('/wp-admin/admin-ajax.php?action=' + name, data)
    .then(function (response) {
        if(func) {
            func(response.data)
        }
    })
}

function unmaskedPhone(val){
    return val.replace(/[^0-9]/g, '')
}

window.isp = () => {
    requestAxios('getIspAddress', '', (res) => {
        window.open(res, '_blank')
    })
}