"use strict";

$('.datepicker').datepicker({
    todayBtn : 'linked',
    format : 'dd-mm-yyyy',
    autoclose : true,
   	startDate : "today"
});

$('.select2').select2();
$(function() {
var userID = $('#user_id').val();
if(userID){
    console.log(userID)
    $.ajax({
        type : 'POST',
        url : $('#user_id').data('url'),
        data : {'user_id': userID},
        dataType : "html",
        success : function (data) {
            $('#userInfo').html(data);
        }
    });
}
})

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