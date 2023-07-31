const searchForm = document.querySelector('.searchForm')
const dataTableCustom = document.querySelector('.dataTableCustom')

searchForm.addEventListener('keydown', (e) => {
    const that = e.target
    const url = that.dataset.url
    const method = that.dataset.method ?? 'GET'
    const value = '?search=' + that.value

    axios.get(url + value).then(function (response) {
        dataTableCustom.innerHTML = response.data
    })
});
