/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

 "use strict";
 $(document).ready(function () {
     load_data();
 
     $('#date-search').on('click', function () {
         let user_id = $('#user_id').val();
         $('#maintable').DataTable().destroy();
         load_data(user_id);
     });
 
     $('#refresh').on('click', function () {
         let activeStatus = $('#maintable').attr('data-status');
         $('#status').val(activeStatus);
         $('#maintable').DataTable().destroy();
         load_data(activeStatus);
     });
 
     function load_data(user_id = 0) {
         var table = $('#maintable').DataTable({
             processing: true,
             serverSide: true,
             ajax: {
                 url: $('#maintable').attr('data-url'),
                 data: {user_id : user_id}
             },
             columns: [
                 {data: 'id', name: 'id'},
                 {data: 'title', name: 'title'},
                 {data: 'description', name: 'description'},
                 {data: 'type', name: 'type'},
                 {data: 'action', name: 'action'},
             ],
             "ordering": false
         });
 
         // let hidecolumn = $('#maintable').data('hidecolumn');
         // if (!hidecolumn) {
         //     table.column(4).visible(false);
         // }
     }
 
     $('#maintable').on('draw.dt', function () {
         $('[data-toggle="tooltip"]').tooltip();
     });
 });
 