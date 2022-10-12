$(document).ready(function () {
    $('#ajaxRef').on('click', function () {
        BX.ajax.runComponentAction('bitrix:news.detail',
            'triggerAjax', {})
            .then(function (response) {
                if (response.status === 'success') {
                    let textElem = document.getElementById("ajax-report-text");
                    textElem.innerText = "Ваше мнение учтено №" + JSON.stringify(response.data["ID"]);
                }
            })

    });
});