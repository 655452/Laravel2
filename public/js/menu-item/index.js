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
  $('#maintable').DataTable().destroy();
  load_data(status);
});


$('#refresh').on('click', function () {
  let activeStatus = $('#maintable').attr('data-status');
  $('#status').val(activeStatus);
  $('#maintable').DataTable().destroy();
  load_data();
});

function load_data(status = '') {
    var table = $('#maintable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
            url : $('#maintable').attr('data-url'),
            data : {status : status}
        },
        columns : [
            {data : 'id', name : 'id'},
            {data : 'name', name : 'name'},
            {data : 'categories', name : 'categories'},
            {data : 'status', name : 'status'},
            {data : 'unit_price', name : 'unit_price'},
            {data : 'action', name : 'action'},
        ],
        "ordering" : true
    });

    let hidecolumn = $('#maintable').data('hidecolumn');
    if(!hidecolumn) {
        table.column( 5 ).visible( false );
    }
}

$('#maintable').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip();
})
