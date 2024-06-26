/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";
load_data();
function load_data() {
     $('#maintable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
            url : $('#maintable').attr('data-url'),
        },
        columns: [
            { data: 'product_image', name: 'product_image' },
            { data: 'product_name', name: 'product_name' },
            { data: 'shop_name', name: 'shop_name' },
            { data: 'action', name: 'action' },
        ],
        "ordering" : false
    });
}

$('#maintable').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip();
})
