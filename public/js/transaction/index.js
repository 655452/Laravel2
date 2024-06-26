/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";
load_data();

var today = new Date();

$('.datepicker').datepicker({
  todayBtn : 'linked',
  format : 'dd-mm-yyyy',
  autoclose : true,
  endDate: "today",
  maxDate: today
});

$('#get-search').on('click', function () {
    let user_id    = $('#user_id').val();
    let from_date = $('#from_date').val();
    let to_date   = $('#to_date').val();

    $('#maintable').DataTable().destroy();
    load_data(user_id, from_date, to_date);
});

$('#refresh').on('click', function () {
    $('#maintable').DataTable().destroy();
    load_data();
});

function load_data(user_id, from_date, to_date) {
    var table = $('#maintable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
            url : $('#maintable').attr('data-url'),
            data : {user_id : user_id, from_date : from_date, to_date : to_date}
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'from_user', name: 'from_user' },
            { data: 'to_user', name: 'to_user' },
            { data: 'type', name: 'type' },
            { data: 'date', name: 'date' },
            { data: 'amount', name: 'amount' },
        ],
        "ordering" : false
    });

    let hidecolumn = $('#maintable').data('hidecolumn');
    if(!hidecolumn) {
        table.column( 6 ).visible( false );
    }
}
