"use strict";
$(document).on('click', '.confirm-delete', function () {
    $('#delete-link').attr('data-id', $(this).data('id'));
});

$(document).on('click', '#delete-link', function () {
    document.getElementById("detete-" + $(this).data('id')).submit();
});
