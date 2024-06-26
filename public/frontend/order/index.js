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
        columns : [
            {data : 'order_code', name : 'order_code'},
            {data : 'created_at', name : 'created_at'},
            {data : 'status', name : 'status'},
            {data : 'payment_status', name : 'payment_status'},
            {data : 'total', name : 'total'},
            {data : 'action', name : 'action'},
        ],
        "ordering" : false
    });
}

$('#maintable').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip();
})
