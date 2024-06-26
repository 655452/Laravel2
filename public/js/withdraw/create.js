"use strict";

$('.select2').select2();

$(document).on('change', '#user_id', function () {
    $.ajax({
        type : 'POST',
        url : $(this).data('url'),
        data : {'user_id': $(this).val()},
        dataType : "html",
        success : function (data) {
            $('#userInfo').html(data);
        }
    });
});
