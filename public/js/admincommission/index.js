/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$('.datepicker').datepicker({
    todayBtn : 'linked',
    format : 'dd-mm-yyyy',
    autoclose : true
});

function printDiv(divID) {
    var oldPage = document.body.innerHTML;
    var divElements = document.getElementById(divID).innerHTML;
    document.body.innerHTML = "<html><head><title></title></head><body>" + divElements + "</body>";

    window.print();
    document.body.innerHTML = oldPage;
    window.location.reload();
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#previewImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(".custom-file-input").on("change", function() {
    let fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

if(jQuery().summernote) {
    $(".summernote").summernote({
        dialogsInBody: true,
        minHeight: 250,
    });
    $(".summernote-simple").summernote({
        dialogsInBody: true,
        minHeight: 150,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['para', ['paragraph']]
        ]
    });
}
