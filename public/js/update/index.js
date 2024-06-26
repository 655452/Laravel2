'use strict';

$('#main-table').DataTable({
  processing : true,
  serverSide : true,
  ajax : $('#main-table').attr('data-url'),
  columns : [
    {data : 'id', name : 'id'},
    {data : 'created_at', name : 'created_at'},
    {data : 'version', name : 'version'},
    {data : 'status', name : 'status'},
    {data : 'action', name : 'action'},
  ],
  "ordering" : false
});

$(document).on('click', '#check-update', function () {
  'use strict';
  $.ajax({
    type : 'GET',
    url : $(this).attr('data-url'),
    dataType : "html",
    success : function (data) {
      let response = JSON.parse(data);
      $('#update-box').removeClass('d-none').addClass('d-block');
      $('#check-message').html(response.message);
      if (response.status === false) {
        $('#click-update').hide();
        $('#cancel-update').hide();
      }
      if (response.status) {
        $('#check-update').hide();
        $(document).on('click', '#click-update', function () {
          $('#update-box').removeClass('d-block').addClass('d-none');
          $('#progress-box').removeClass('display-none');
          let current_progress = 0;
          let interval = setInterval(function () {
            current_progress += 1;
            $("#dynamic").css("width", current_progress + "%").attr("aria-valuenow", current_progress).text(current_progress + "% Complete");
            if (current_progress >= 100)
              clearInterval(interval);
          }, 1500);
          $.ajax({
            type : 'GET',
            url : $(this).attr('data-url'),
            dataType : "html",
            success : function (data) {
              let response = JSON.parse(data);
              if (response.status) {
                document.getElementById('logout-form').submit();
              } else {
                $('#progress-box').addClass('display-none');
                $('#update-box').removeClass('d-none');
                $('#check-message').html(response.message);
                $('#click-update').hide();
                $('#cancel-update').hide();
              }
            }
          });
        });
      }
    }
  });
});

$(document).on('click', '#cancel-update', function () {
  'use strict';
  $('#update-box').removeClass('d-block').addClass('d-none');
  $('#check-update').show();
});

$(document).on('click', '.update-view', function () {
  'use strict';
  let id = $(this).attr('data-content');
  $.ajax({
    type : 'GET',
    url : $(this).attr('data-url'),
    data : {id : id},
    dataType : "html",
    success : function (data) {
      let response = JSON.parse(data);
      $('.modal-data-info').html(response.log);
    }
  })
});

$('#maintable').on('draw.dt', function () {
  $('[data-toggle="tooltip"]').tooltip();
})