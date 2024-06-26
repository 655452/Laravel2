window.addEventListener('showCartQty', event => {
    $('.cartCount').text(event.detail.qty);
});

window.addEventListener('openFormModalCart', event => {
    setTimeout(function() {
        $('#cartModal').modal('show');
    }, 100);
});

window.addEventListener('closeFormModalCart', event => {

    $('#cartModal').modal('hide')
});
