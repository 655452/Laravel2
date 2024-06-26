
function updateCartCounts() {
    var cartCount = $('#carTNumber').text();
    $('#nacCount').text(cartCount);
}

$(document).ready(function () {
    updateCartCounts();

    // Poll for changes every second
    setInterval(function () {
        updateCartCounts();
    }, 500);

    // Use MutationObserver to detect changes in the carTNumber element
    var targetNode = document.getElementById('carTNumber');

    var observer = new MutationObserver(function (mutationsList) {
        for (var mutation of mutationsList) {
            if (mutation.type === 'childList' || mutation.type === 'characterData') {
                updateCartCounts();
                break;
            }
        }
    });

    var config = { attributes: true, childList: true, subtree: true, characterData: true };
    observer.observe(targetNode, config);

});

$(".rest-swiper nav a").on("click", function (event) {
    var $anchor = $(this);
    $("html, body").scrollTop($($anchor.attr("href")).offset().top - 90);
});

function selected(id) {
        const enable = document.querySelectorAll('.enable');
        enable.forEach(box => {
            box.classList.remove('selected');
        });
        const slot = document.getElementById("slot_" + id);
        slot.classList.add('selected');
}
