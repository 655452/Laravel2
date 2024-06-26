"use strict";

function updateSortOrderToDatabase(idString){
   jQuery.ajax({
        url: $('#sortable-table tbody').data('url'),
        method:'POST',
        data:{'ids':idString},
        success:function(data){
        }
   });
}

var target = jQuery('#sortable-table tbody');
target.sortable({
    handle: '.sort-handler',
    placeholder: 'highlight',
    axis: "y",
    update: function (e, ui){
       var sortData = target.sortable('toArray',{ attribute: 'data-id'})
       updateSortOrderToDatabase(sortData.join(','))
    }
});