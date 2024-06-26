/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

load_data();


$('#date-search').on('click', function () {
    let status = $('#status').val();
    $('#main-table').DataTable().destroy();
    load_data(status);
  });

$('#refresh').on('click', function () {
    $('#status').val('');
    $('#maintable').DataTable().destroy();
    load_data();
});


function load_data(status = '') {
    var table = $('#maintable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
            url : $('#maintable').attr('data-url'),
            data : {'status' : status}
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'order_code', name: 'order_code' },
            { data: 'user_name', name: 'user_name' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' },
        ],
        "ordering" : false
    });

}

$('#maintable').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip();
})
