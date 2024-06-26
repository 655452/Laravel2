$(document).ready(function () {
    "use strict";
    /*File Upload*/
    FilePond.registerPlugin(FilePondPluginImagePreview);
    // Turn input element into a pond
    FilePond.setOptions({
        server: {
            url: '/filepond/api',
            process: '/process',
            revert: '/revert',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        onprocessfile: function(error, file) {
            loadPreview();
        },
        onremovefile: function(error, file) {
            loadPreview();
        }
    });

    $('.my-pond').filepond();
    /* File Upload ends */
    $("#seeAnotherField").on('change',function(){
        if ($(this).val() == "text") {
            $('#qrCodeTextDiv').show();
            $('#qrCodeLogoDiv').hide();
            $('#qrCodeText').attr('required', '');
            $('#qrCodeText').attr('data-error', 'This field is required.');
        } else if ($(this).val() == "logo") {
            $('#qrCodeTextDiv').hide();
            $('#qrCodeLogoDiv').show();
            $('#qrCodeLogo').attr('required', '');
            $('#qrCodeLogo').attr('data-error', 'This field is required.');
        } else {
            $('#qrCodeTextDiv').hide();
            $('#qrCodeLogoDiv').hide();
            $('#qrCodeText').removeAttr('required');
            $('#qrCodeText').removeAttr('data-error');
            $('#qrCodeLogo').removeAttr('required');
            $('#qrCodeLogo').removeAttr('data-error');
        }
    });
   
     $("#seeAnotherField").trigger("change");

     /* qr code preview ajax*/
     $('.qr-input').on('change load', function(e) {
         loadPreview();
     });

     function loadPreview() {
         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });

         let formData = new FormData(document.getElementById("qrCodeFrom"));

         $.ajax({
             type:'POST',
             url: "/admin/qr-code/preview",
             data: formData,
             cache:false,
             contentType: false,
             processData: false,
             success: (data) => {
                 $("#qrImage").attr("src", "data:image/png;base64," + data)
                 $("#download").attr("href", "data:image/png;base64," + data)
             },
             error: function(e){
                 console.log(e);
             }
         });
     }
});
/* qr code preview ajax ends*/
