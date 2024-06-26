/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$(document).ready(function () {
    load_data();

    function load_data(status = '') {
        var table = $('#maintable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: $('#maintable').attr('data-url'),
                data: {status: status}
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'payment_type', name: 'payment_type'},
                {data: 'date', name: 'date'},
                {data: 'amount', name: 'amount'},
                {data: 'action', name: 'action'}
            ],
            "ordering": false
        });
    }

    $('#maintable').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

});
