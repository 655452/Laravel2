

"use strict";

$(document).ready(function () {

  fetchdata();
  function fetchdata() {
    $.ajax({
      type: 'GET',
      url: liveOrderRoute,
      dataType: "html",
      success: function (data) {
        $('.section-body').html(data);
      },
      complete: function (data) {
        setTimeout(fetchdata, 1000 * 30);
      }
    });
  }


});
