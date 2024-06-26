(function($) {
    "use strict"; // Start of use strict

    $('#demoadmin').click(function() { 
        $('#demoemail').val('admin@example.com');
        $('#demopassword').val('123456');
        $('#demopassword').attr('type','text');
    });

    $('#democustomer').click(function() {
        $('#demoemail').val('customer@example.com');
        $('#demopassword').val('123456');
        $('#demopassword').attr('type','text');
    });

    $('#demorestaurantowner').click(function() {
        $('#demoemail').val('restaurantowner@example.com');
        $('#demopassword').val('123456');
        $('#demopassword').attr('type','text');
    });

    $('#demodeliveryboy').click(function() {
        $('#demoemail').val('deliveryboy@example.com');
        $('#demopassword').val('123456');
        $('#demopassword').attr('type','text');
    });

})(jQuery); // End of use strict
