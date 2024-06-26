/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

load_data();

$('#date-search').on('click', function () {
    let status    = $('#status').val();
    let requested = $('#requested').val();
    $('#maintable').DataTable().destroy();
    load_data(status, requested);
});

$('#refresh').on('click', function () {
    $('#status').val('');
    $('#requested').val('');
    $('#maintable').DataTable().destroy();
    load_data();
});

function load_data(status = '', requested = '') {
    var table = $('#maintable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
            url : $('#maintable').attr('data-url'),
            data : {'status' : status, 'requested' : requested}
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'phone', name: 'phone' },
            { data: 'table', name: 'table' },
            { data: 'created_at', name: 'created_at' },
            { data: 'status', name: 'status'},
            { data: 'action', name: 'action'},
        ],
        "ordering" : false
    });

    let hidecolumn = $('#maintable').data('hidecolumn');
    if(!hidecolumn) {
        table.column( 5 ).visible( false );
    }
}

$('#maintable').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip();
})
