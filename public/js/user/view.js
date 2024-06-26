/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$(function() {
  "use strict";
    $('#maintable').DataTable({
        processing: true,
        serverSide: true,
        ajax : {
          url : $('#maintable').attr('data-url'),
          data : {delivery_boy_id : $('#maintable').data('deliveryboyid')}
        },
        columns : [
          {data : 'id', name : 'id'},
          {data : 'user_id', name : 'user_id'},
          {data : 'created_at', name : 'created_at'},
          {data : 'status', name : 'status'},
          {data : 'action', name : 'action'},
        ],
        "ordering": false
    });
});
