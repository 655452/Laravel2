/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";
var Url = Url;
$(document).ready(function () {
    $('.input-daterange').datepicker({
        todayBtn: 'linked',
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    $("#reservation_date").on('change',function(){
        var date = $(this).val();
        var capacity = $('#guest').val();
        var restaurant_id = document.getElementById("restaurant_id");
        var restaurant = restaurant_id.value;

        $.ajax({
            type:'POST',
            url:Url,
            data:{date:date,capacity:capacity,restaurant:restaurant},
            success:function(response) {
                $("#timeSlotList").html(response);
            }
        });
    });
  
    $("#restaurant_id").on('change',function(){
        var restaurant = $(this).val();
        var date = $('#reservation_date').val();
        var capacity = $('#guest').val();
        $.ajax({
            type:'POST',
            url:Url,
            data:{date:date,capacity:capacity,restaurant:restaurant},
            success:function(response) {
                $("#timeSlotList").html(response);
            }
        });
    });
    $("#guest").on('change',function(){
        var date = $('#reservation_date').val();
        var capacity = $(this).val();
        var restaurant_id = document.getElementById("restaurant_id");
        var restaurant = restaurant_id.value;

        $.ajax({
            type:'POST',
            url:Url,
            data:{date:date,capacity:capacity,restaurant:restaurant},
            success:function(response) {
                $("#timeSlotList").html(response);
            }
        });
    });
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#previewImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

$("#user_id").on('change',function(){
    var userID = $(this).val();
    $.ajax({
        type:'POST',
        url:UserUrl,
        data:{userID:userID},
        success:function(response) {
            $("#first_name").val(response.first_name);
            $("#last_name").val(response.last_name);
            $("#email").val(response.email);
            $("#phone").val(response.phone);
        }
    });
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
