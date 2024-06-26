

$(function() {

   $(".qtyButtons input").after('<div class="qtyInc"></div>');
   $(".qtyButtons input").before('<div class="qtyDec"></div>');

   $(".qtyDec, .qtyInc").on("click", function() {

      var $button = $(this);
      var oldValue = $button.parent().find("input").val();

      if ($button.hasClass('qtyInc')) {
         var newVal = parseFloat(oldValue) + 1;
      } else {
         // don't allow decrementing below zero
         if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
         } else {
            newVal = 0;
         }
      }

      $button.parent().find("input").val(newVal);
      qtySum();
      $(".qtyTotal").addClass("rotate-x");

   });

});

// Adjusting Panel Dropdown Width
$(window).on('load resize', function() {
   var panelTrigger = $('.booking-widget .panel-dropdown a');
   $('.booking-widget .panel-dropdown .panel-dropdown-content').css({
      'width' : panelTrigger.outerWidth()
   });
});
