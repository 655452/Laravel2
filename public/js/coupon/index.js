/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

load_data();

$('#date-search').on('click', function () {
    let discount_type = $('#discount_type').val();
    let coupon_type = $('#coupon_type').val();
    $('#maintable').DataTable().destroy();
    load_data(discount_type, coupon_type);
});

$('#refresh').on('click', function () {
    $('#discount_type').val('');
    $('#coupon_type').val('');
    $('#maintable').DataTable().destroy();
    load_data();
});

function load_data(discount_type = '', coupon_type = '') {
    var table = $('#maintable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: $('#maintable').attr('data-url'),
            data: { 'discount_type': discount_type, 'coupon_type': coupon_type }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'coupon_type', name: 'coupon_type' },
            { data: 'limit', name: 'limit' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' },
        ],
        "ordering": false
    });

    let hidecolumn = $('#maintable').data('hidecolumn');
    if (!hidecolumn) {
        table.column(5).visible(false);
    }
}

$('#maintable').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip();
})
