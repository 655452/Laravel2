$(document).ready(function () {
    'use strict';
    $(document).on('change', '#datePick', function () {  datePick

        let date = $(this).val();
        let capacity = $('#qtyInput').val();
        let restaurant = $('#restaurant_id').val();

        $.ajax({
            type: 'POST',
            url: reservationUrl,
            data: {date: date, capacity: capacity, restaurant: restaurant},
            success: function (response) {
                $("#showTimeSlot").html(response);

                $(".time-slot").each(function () {
                    let timeSlot = $(this);
                    $(this).find('input').on('change', function () {
                        let timeSlotValID = timeSlot.find('p').text();
                        $('#TimeSlotId').val(timeSlotValID);
                        $("input:radio").removeAttr("checked");
                        $('#time-slot-' + timeSlotValID).prop("checked", true);
                    });
                });
            }
        });
    });

    $(document).on("click", '.qminus, .qplus, .plusMinusBtn', function () {
        'use strict';
        let date = $('#datePick').val();
        let capacity = $('#qtyInput').val();
        let restaurant = $('#restaurant_id').val();

        $.ajax({
            type: 'POST',
            url: reservationUrl,
            data: {date: date, capacity: capacity, restaurant: restaurant},
            success: function (response) {
                $("#showTimeSlot").html(response);
                $(".time-slot").each(function () {
                    let timeSlot = $(this);
                    $(this).find('input').on('change', function () {
                        let timeSlotValID = timeSlot.find('p').text();
                        $('#TimeSlotId').val(timeSlotValID);
                        $("input:radio").removeAttr("checked");
                        $('#time-slot-' + timeSlotValID).prop("checked", true);
                    });
                });
            }
        });
    });

});

 
