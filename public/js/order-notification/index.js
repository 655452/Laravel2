/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$(document).ready(function () {

    load_data();

    function load_data() {
      var table = $('#main-table').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
          url : $('#main-table').attr('data-url'),
        },
        columns : [
          {data : 'id', name : 'id'},
          {data : 'created_at', name : 'created_at'},
          {data : 'status', name : 'status'},
          {data : 'action', name : 'action'}
        ],
        "ordering" : false
      });
    }
  });

  $('#main-table').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip();
})
