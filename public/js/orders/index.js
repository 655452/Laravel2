/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$(document).ready(function () {
    $('.input-daterange').datepicker({
      todayBtn : 'linked',
      format : 'dd-mm-yyyy',
      autoclose : true
    });

    load_data();

    function load_data(startDate = '', endDate = '', status = '') {
      var table = $('#main-table').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
          url : $('#main-table').attr('data-url'),
          data : {startDate : startDate, endDate : endDate, status : status}
        },
        columns : [
          {data : 'id', name : 'id'},
          {data : 'user_id', name : 'user_id'},
          {data : 'created_at', name : 'created_at'},
          {data : 'order_type', name : 'order_type'},
          {data : 'status', name : 'status'},
          {data : 'total', name : 'total'},
          {data : 'action', name : 'action'},
        ],
        "ordering" : false
      });

      let hidecolumn = $('#main-table').data('hidecolumn');
      if(!hidecolumn) {
          table.column( 6 ).visible( false );
      }
    }

    $('#date-search').on('click', function () {
      let startDate = $('#start_date').val();
      let endDate = $('#end_date').val();
      let status = $('#status').val();
      $('#main-table').DataTable().destroy();
      load_data(startDate, endDate, status);
    });

    $('#refresh').on('click', function () {
      let orderPendingStatus = $('#main-table').attr('data-status');
      $('#start_date').val('');
      $('#end_date').val('');
      $('#status').val(orderPendingStatus);
      $('#main-table').DataTable().destroy();
      load_data();
    });
  });

  $('#main-table').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip();
})
