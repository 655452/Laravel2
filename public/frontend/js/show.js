$(document).ready(function () {
    'use strict';
    $("#mobileCartBtn").on('click', function () {
        const mediaQuery = window.matchMedia('(max-width: 991px)')
        if (mediaQuery.matches) {
            $(".cart-modal").toggle();
        }
    });
    $("#desktopmobilecart").on('click', function () {
        const mediaQuery = window.matchMedia('(max-width: 991px)')
        if (mediaQuery.matches) {
            $(".cart-modal").toggle();
        }
    });
    $(".cartClose").on('click', function () {
        const mediaQuery = window.matchMedia('(max-width: 991px)')
        if (mediaQuery.matches) {
            $(".cart-modal").toggle();
        }
    });

    $('.fa-star').hover(function () {
        $(this).addClass('star-hover');
        $(this).prevAll('.fa-star').addClass('star-hover');
    }, function () {
        $(this).removeClass('star-hover');
        $(this).prevAll('.fa-star').removeClass('star-hover');
    });

    $("#datePick").change(function () {
        var date = $(this).val();
        var dateParts = date.split('-');

        if (dateParts.length === 3 && !isNaN(dateParts[0]) && !isNaN(dateParts[1]) && !isNaN(
            dateParts[2])) {
            // Create a JavaScript Date object from the input
            var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);

            // Define an array of month names
            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
                "Nov", "Dec"
            ];

            // Format the date as "dd Mon yyyy"
            var formattedDate = jsDate.getDate().toString().padStart(2, '0') + ' ' + monthNames[
                jsDate.getMonth()] + ' ' + jsDate.getFullYear();

            $(".dateshow").text(formattedDate);
        } else {
            $(".dateshow").text("Invalid date");
        }
    });

    // Add a click event handler for the plus button
    $(".qplus").click(function () {
        var qtyInput = $('#qtyInput');
        var qty = parseInt(qtyInput.val()) + 1; // Increase the value by 1
        qtyInput.val(qty); // Update the input field with the new value
        $(".guestotal").text(qty); // Update .guestotal with the new value
    });

    // Add a click event handler for the minus button
    $(".qminus").click(function () {
        var qtyInput = $('#qtyInput');
        var qty = parseInt(qtyInput.val()) - 1; // Decrease the value by 1
        if (qty >= 1) { // Ensure qty doesn't go below 1
            qtyInput.val(qty); // Update the input field with the new value
            $(".guestotal").text(qty); // Update .guestotal with the new value
        }
    });

    $(".enable").on('click', function () {
        $(".enable").removeClass('selected');
        $(this).addClass('selected');
    });

    $(".showClosedNotification").on('click', function () {
        iziToast.error({
            title: 'Warning',
            message: 'This restaurant is closed now.',
            position: 'topRight'
        });
    });


    $(document).on('click', '#bkkkid', function (event) {
        event.preventDefault();

        var showTimeSlot = document.getElementById("showTimeSlot").innerHTML;
        var jsbookDiv = document.querySelector('.jsbook');

        if (showTimeSlot.trim() === "") {
            jsbookDiv.innerText = "Please select a time slot.";
            return false;
        } else {
            $(this).closest("form").submit();
        }
    });



});
