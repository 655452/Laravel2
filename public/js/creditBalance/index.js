/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

$(document).ready(function () {
    "use strict";
    $(document).on('change', "#userRoleID", function () {
        let role = $('#userRoleID').val();
        if (role) {
            $.ajax({
                type: 'POST',
                url: indexUrl,
                data: {'role': role},
                success: function (data) {
                    $('#users').html('0');
                    $('#users').html(data);
                }
            });
        }
    });
});

function printDiv(divID) {
    "use strict";
    let oldPage = document.body.innerHTML;
    let divElements = document.getElementById(divID).innerHTML;
    document.body.innerHTML = "<html><head><title></title></head><body>" + divElements + "</body>";

    window.print();
    document.body.innerHTML = oldPage;
    window.location.reload();
}



