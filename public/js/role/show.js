$('.mainmodule').each(function() {
    var mainmodule  = $(this).attr('id');

    var mainidCreate    = mainmodule+"_create";
    var mainidEdit   = mainmodule+"_edit";
    var mainidDelete = mainmodule+"_delete";
    var mainidShow   = mainmodule+"_show";

    if (!$('#'+mainmodule).is(':checked')) {
        $('#'+mainidCreate).prop('disabled', true);
        $('#'+mainidCreate).prop('checked', false);

        $('#'+mainidEdit).prop('disabled', true);
        $('#'+mainidEdit).prop('checked', false);

        $('#'+mainidDelete).prop('disabled', true);
        $('#'+mainidDelete).prop('checked', false);

        $('#'+mainidShow).prop('disabled', true);
        $('#'+mainidShow).prop('checked', false);
    }
});

function processCheck(event) {
    var mainmodule  = $(event).attr('id');


    var mainidCreate = mainmodule+"_create";
    var mainidEdit   = mainmodule+"_edit";
    var mainidDelete = mainmodule+"_delete";
    var mainidShow   = mainmodule+"_show";

    if($('#'+mainmodule).is(':checked')) {
        $('#'+mainidCreate).prop('disabled', false);
        $('#'+mainidCreate).prop('checked', true);

        $('#'+mainidEdit).prop('disabled', false);
        $('#'+mainidEdit).prop('checked', true);

        $('#'+mainidDelete).prop('disabled', false);
        $('#'+mainidDelete).prop('checked', true);

        $('#'+mainidShow).prop('disabled', false);
        $('#'+mainidShow).prop('checked', true);
      } else {
        $('#'+mainidCreate).prop('disabled', true);
        $('#'+mainidCreate).prop('checked', false);

        $('#'+mainidEdit).prop('disabled', true);
        $('#'+mainidEdit).prop('checked', false);

        $('#'+mainidDelete).prop('disabled', true);
        $('#'+mainidDelete).prop('checked', false);

        $('#'+mainidShow).prop('disabled', true);
        $('#'+mainidShow).prop('checked', false);
    }
};