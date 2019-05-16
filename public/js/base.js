$(document).ready(function () {

    $('img.deleteSong').on('click', function () {
        let formId = $(this).parent('form').attr('id');
        console.log(formId);
        $('#btn-delete').attr('form', formId);
    });

});