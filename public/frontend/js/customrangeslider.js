$(document).ready(function () {
    $(".custonDropdown").click(function () {
        
        $(this).siblings().toggleClass('active');
    });

    $(".panel-apply").click(function () {
        
        console.log( document.getElementById("search").value)
        $(this).closest(".cDrop").removeClass("active");
    });
});

$('input[type="range"]').rangeslider({
    polyfill: false
});
 

$('#relationship-status-slider').on('change input', function () {
    $('#relationship-status-output').text($(this).val());
});
