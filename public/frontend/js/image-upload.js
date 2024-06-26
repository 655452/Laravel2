"use strict";
function readURL(input) {
    if (input.files && input.files[0]) {
        let fileName = input.files[0].name;
        $('.custom-file-label').html(fileName);
    }
}