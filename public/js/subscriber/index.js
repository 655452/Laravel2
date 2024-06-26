/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

load_data();

function load_data() {
    var table = $('#maintable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
            url : $('#maintable').attr('data-url')
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'owner', name: 'owner' },
            { data: 'plan', name: 'plan' },
            { data: 'price', name: 'price' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' }
        ],
        "ordering" : false
    });
}

$('#maintable').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip();
})
