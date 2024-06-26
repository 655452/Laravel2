/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#previewImage').css({display: 'block'});
            $('#previewImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

function initMap() {

    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition( function(position) {
            getLatLongPosition(position);
        });
    } else {
        alert("Sorry, your browser does not support HTML5 geolocation.");
    }

    function getLatLongPosition(position) {
        let latitude  = position.coords.latitude;
        let longitude = position.coords.longitude;

        const myLatlng = { lat: latitude, lng: longitude };

        const map = new google.maps.Map(document.getElementById("googleMapAddress"), {
            zoom: 15,
            center: myLatlng,
        });

        // Create the initial InfoWindow.
        let infoWindow = new google.maps.InfoWindow({
            content: "Click the map to get latitude & longitude!",
            position: myLatlng,
        });

        infoWindow.open(map);
        var marker;

        // Configure the click listener.
        map.addListener("click", (mapsMouseEvent) => {
            // Close the current InfoWindow.
            infoWindow.close();
            // Create a new InfoWindow.
            infoWindow = new google.maps.InfoWindow({
                position: mapsMouseEvent.latLng,
            });

            var latLng = mapsMouseEvent.latLng.toJSON();
            $('#latitude').val(latLng.lat);
            $('#longitude').val(latLng.lng);
            if (marker)
                marker.setMap(null);
            marker = new google.maps.Marker({
                position: myLatlng,
                map,
                draggable:true,
                title: "Your current location.",
            });

            changeMarkerPosition(latLng,marker)
        });

         marker = new google.maps.Marker({
            position: myLatlng,
            map,
             draggable:true,
            title: "Your current location.",
        });
    }
}

function changeMarkerPosition(latLng,marker) {
    var latlng = new google.maps.LatLng(latLng.lat, latLng.lng);
    marker.setPosition(latlng);
}




$("#save-address").on("click",function() {
    let formData = {
        'id': $('#id').val(),
        'label': $('#label').val(),
        'street': $('#street').val(),
        'note': $('#note').val(),
        'latitude': $('#latitude').val(),
        'longitude': $('#longitude').val()
    };

    $.ajax({
        type : 'POST',
        url : setUrl,
        data : formData,
        success : function (data) {
            jQuery('#label').removeClass('is-invalid');
            jQuery('#street').removeClass('is-invalid');
            jQuery('#note').removeClass('is-invalid');
            jQuery('#latitude').removeClass('is-invalid');
            jQuery('#longitude').removeClass('is-invalid');

            let response = JSON.parse(data);
            if(response.errors != 'undefined') {
                jQuery.each(response.errors, function( index, value ) {
                    jQuery('#'+index).addClass('is-invalid');
                });
            }

            if(response.status) {
                location.reload();
            } else {
                iziToast.error({
                    title: 'Error',
                    message: response.message,
                    position: 'topRight'
                });
            }
        }
    });
});

$(".edit-address").on("click",function() {
    let formData = {
        'id': $(this).data('id'),
        'label': $(this).data('label'),
        'street': $(this).data('street'),
        'note': $(this).data('note'),
        'latitude': $(this).data('latitude'),
        'longitude': $(this).data('longitude')
    };

    jQuery('#id').val(formData.id);
    jQuery('#label').val(formData.label);
    jQuery('#street').val(formData.street);
    jQuery('#note').val(formData.note);
    jQuery('#latitude').val(formData.latitude);
    jQuery('#longitude').val(formData.longitude);
});

$(".resetForm").on("click",function() {
    let formData = {
        'id': '',
        'label': 5,
        'street': '',
        'note': '',
        'latitude': '',
        'longitude': ''
    };

    jQuery('#id').val(formData.id);
    jQuery('#label').val(formData.label);
    jQuery('#street').val(formData.street);
    jQuery('#note').val(formData.note);
    jQuery('#latitude').val(formData.latitude);
    jQuery('#longitude').val(formData.longitude);
});
