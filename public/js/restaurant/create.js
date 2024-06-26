/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

function readURL(input,previewImage) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#'+previewImage).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
    let fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

if(jQuery().summernote) {
    $(".summernote").summernote({
        dialogsInBody: true,
        minHeight: 250,
    });
    $(".summernote-simple").summernote({
        dialogsInBody: true,
        minHeight: 150,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['para', ['paragraph']]
        ]
    });
}

// Timepicker
if(jQuery().timepicker && $(".timepicker").length) {
	$(".timepicker").timepicker({
		icons: {
			up: 'fas fa-chevron-up',
			down: 'fas fa-chevron-down'
		}
	});
}
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

        const map = new google.maps.Map(document.getElementById("googleMap"), {
            zoom: 15,
            center: myLatlng,
        });

        // Create the initial InfoWindow.
        let infoWindow = new google.maps.InfoWindow({
            content: "Click the map to get latitude & longitude!",
            position: myLatlng,
        });

        infoWindow.open(map);
        // Configure the click listener.
        var marker;

        map.addListener("click", (mapsMouseEvent) => {
            // Close the current InfoWindow.
            infoWindow.close();
            // Create a new InfoWindow.
            infoWindow = new google.maps.InfoWindow({
                position: mapsMouseEvent.latLng,
            });

            var latLng = mapsMouseEvent.latLng.toJSON();
            $('#lat').val(latLng.lat);
            $('#long').val(latLng.lng);
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
