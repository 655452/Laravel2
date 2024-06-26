/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";




jQuery(".file-upload-input").on('change', function() {
    var file = this.files;
    if (file.length > 0) {
        var file = file[0];
        jQuery(this).siblings().eq(0).text(file.name);
    } else {
        jQuery(this).siblings().eq(0).text('Choose file');
    }
});

jQuery(document).ready(function(){
    jQuery(".delete").on("click", function(){
        return confirm("Are you sure want to delete this record?");
    });
});
