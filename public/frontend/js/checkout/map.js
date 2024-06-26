function initMap() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            if (lastAddress) {
                initAutocomplete();
                getLatLongPosition(lastAddress_latitude, lastAddress_longitude);
            } else {
                initAutocomplete();
                getLatLongPosition(position.coords.latitude, position.coords.longitude);
            }

        });
    } else {
        alert("Sorry, your browser does not support HTML5 geolocation.");
    }
}

function getLatLongPosition(latitude, longitude) {
    const myLatlng = {
        lat: parseFloat(latitude),
        lng: parseFloat(longitude)
    };
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
    let total = 0;
    map.addListener("click", (mapsMouseEvent) => {
        // Close the current InfoWindow.
        infoWindow.close();
        // Create a new InfoWindow.
        infoWindow = new google.maps.InfoWindow({
            position: mapsMouseEvent.latLng,
        });

        var latLng = mapsMouseEvent.latLng.toJSON();

        var latlng = new google.maps.LatLng(latLng.lat, latLng.lng);
        var geocoder = geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            'latLng': latlng
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    $('#autocomplete-input').val(results[1].formatted_address);

                }
            }
        });


        let dis = distance(parseFloat(locationLat), parseFloat(locationLong), latLng.lat, latLng.lng)
        var delivery_charge = basicCharge;

        if (dis > freeZone) {
            dis = dis - parseFloat(freeZone);
            delivery_charge = dis * chragePerKilo + parseFloat(basicCharge);
        }

        if(orderType){
             total = subtotal - parseInt(couponAmount);
        }else {
             total = (subtotal - parseInt(couponAmount) ) + parseInt(delivery_charge);
        }

        sessionStorage.removeItem('charge');
        $('#lat').val(latLng.lat);
        $('#long').val(latLng.lng);
        $('#delivery_chearge').text(parseInt(delivery_charge));
        $('#total').text(parseFloat(total).toFixed(2));
        $('#total_delivery_charge').val(parseInt(delivery_charge));

         sessionStorage.setItem('charge',delivery_charge);
         const mode = sessionStorage.getItem('charge');
        // console.log(mode);

        if (marker)
            marker.setMap(null);
        marker = new google.maps.Marker({
            position: myLatlng,
            map,
            draggable: true,
            title: "Your current location.",
        });

        changeMarkerPosition(latLng, marker)

    });

    let dis = distance(locationLat, locationLong, latitude, longitude)
    var delivery_charge = basicCharge;

    if (dis > freeZone) {
        dis = dis - parseFloat(freeZone);
        delivery_charge = dis * chragePerKilo + parseFloat(basicCharge);
    }

    total = 0;
    if(orderType){
        total = subtotal - parseInt(couponAmount);
    }else {
        total = (subtotal- parseInt(couponAmount) ) + parseInt(delivery_charge);
    }
    sessionStorage.removeItem('charge');
    $('#delivery_chearge').text(parseInt(delivery_charge));
    $('#total').text(parseFloat(total).toFixed(2));
    $('#total_delivery_charge').val(parseInt(delivery_charge));
    $('#lat').val(latitude);
    $('#long').val(longitude);
    sessionStorage.setItem('charge',delivery_charge);
    const mode = sessionStorage.getItem('charge');
    // console.log(mode);



    marker = new google.maps.Marker({
        position: myLatlng,
        map,
        draggable: true,
        title: "Your current location.",
    });
}

function changeMarkerPosition(latLng, marker) {
    var latlng = new google.maps.LatLng(latLng.lat, latLng.lng);
    marker.setPosition(latlng);
}

var mapLat = mapLat;
var mapLong = mapLong;

function initAutocomplete() {
    if (lastAddress) {
        getLocation(lastAddress_latitude, lastAddress_longitude);
    } else {
        if (mapLat != '' && mapLong != '') {
            getLocation(mapLat, mapLong);
        } else {
            getLocation(null, null);
        }
    }

    var input = document.getElementById('autocomplete-input');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        getLatLongPosition(place.geometry.location.lat(), place.geometry.location.lng());
        $('#lat').val(place.geometry.location.lat());
        $('#long').val(place.geometry.location.lng());

        if (!place.geometry) {
            return;
        }
    });

    if ($('.modalAddressSearch')[0]) {
        setTimeout(function () {
            $(".pac-container").prependTo("#autocomplete-container");
        }, 300);
    }
}
var geocoder;

function getLocation(lat, long) {

    geocoder = new google.maps.Geocoder();
    if (navigator.geolocation) {
        if (lat && long) {
            showGetPosition(lat, long)
        } else {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
    } else {
        var msg = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    var Latitude = position.coords.latitude;
    var Longitude = position.coords.longitude;
    $('#lat').val(Latitude);
    $('#long').val(Longitude);
    getLatLongPosition(Latitude, Longitude);

    var latlng = new google.maps.LatLng(Latitude, Longitude);
    geocoder.geocode({
        'latLng': latlng
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                $('#autocomplete-input').val(results[0].formatted_address);
            }
        }
    })

}

function showGetPosition(lat, long) {
    var Latitude = lat;
    var Longitude = long;
    $('#lat').val(Latitude);
    $('#long').val(Longitude);


    var latlng = new google.maps.LatLng(Latitude, Longitude);
    geocoder.geocode({
        'latLng': latlng
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                $('#autocomplete-input').val(results[0].formatted_address);
            }
        }
    })

}



//modal
function editBtn(id) {
    let editurl = $('#edit' + id).attr('data-url');
    let updateurl = $('#edit' + id).attr('data-attr');
    localStorage.setItem("total_delivery_charge", $('#total_delivery_charge').val());

    $.ajax({
        type: 'GET',
        url: editurl,
        dataType: "html",
        success: function (data) {
            let address = JSON.parse(data);
            $("#addressForm").attr('action', updateurl);
            $("#formMethod").val('PUT');
            $("#autocomplete-input").val(address.address);
            $("#lat").val(address.latitude);
            $("#long").val(address.longitude);
            $("#id").val(address.id);
            $("#apartment").val(address.apartment);
            $("#label").val(address.label);
            $("#label_name").val(address.label_name);
            if (address.label == 15) {
                $('.label-name').show();
            }
        }
    });
}


$(document).on('click', '#add-new', function (event) {
    let href = $('#add-new').attr('data-attr');
    modalshow(href);
});

$(document).on('click', '#address-btn', function (event) {
    event.preventDefault();
    var apartmentValue = document.getElementById("apartment").value.trim();
    var labelNameValue = document.getElementById("label_name").value.trim();
    var label = document.getElementById("label").value.trim();
    var jsalertDiv = document.querySelector('.jsalert');

    if (apartmentValue == "" || label == "" ) {
        event.preventDefault();
        jsalertDiv.innerText = "Please fill out all required fields.";
        return false;
    } else if ($('#label').val() == 15 && labelNameValue == "") {
        event.preventDefault();
        jsalertDiv.innerText = "Please fill out all required fields.";
        return false;
    } else {
        $("#address-btn").attr('data-bs-dismiss', 'modal');
        document.getElementById("addressForm").submit();
    }
});


if ($('.check-errors1').text() != "" || $('.check-errors2').text() != "") {

    let href = $('#edit-url').attr('data-attr');
    if ($("#formMethod").val() == 'PUT') {
        href = $('#edit-url').attr('data-attr');
    } else {
        href = $('#add-new').attr('data-attr');
    }
    modalshow(href);
}

function modalshow(href) {
    localStorage.setItem("total_delivery_charge", $('#total_delivery_charge').val());
    $('#addressModal').modal('show');
    $("#addressForm").attr('action', href);
}

$(document).on('click', '#modalClose', function (event) {
    const prevDeliveryCharge = localStorage.getItem("total_delivery_charge");
    let total = 0;
    if(orderType){
        total = subtotal - parseInt(couponAmount);
    }else {
        total = (subtotal - parseInt(couponAmount) ) + parseInt(prevDeliveryCharge);
    }

    $('#delivery_chearge').text(parseInt(prevDeliveryCharge));
    $('#total').text(parseFloat(total).toFixed(2));
    $('#total_delivery_charge').val(parseInt(prevDeliveryCharge));

    window.localStorage.removeItem("total_delivery_charge");

});


if ($('#label').val() == 15) {
    $('.label-name').show();
} else {
    $('.label-name').hide();
}

$('#label').on('change', function () {
    if ($('#label').val() == 15) {
        $('.label-name').show();
    } else {
        $('.label-name').hide();
    }
});


$(document).ready(function() {
    $(".moreAddress").hide();
    $("#moreAddressShow").click(function() {

        $(".moreAddress").toggle(200);
    });
});


function distance(lat1, lon1, lat2, lon2) {
    var radlat1 = Math.PI * lat1 / 180
    var radlat2 = Math.PI * lat2 / 180
    var theta = lon1 - lon2
    var radtheta = Math.PI * theta / 180
    var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
    dist = Math.acos(dist)
    dist = dist * 180 / Math.PI
    dist = dist * 60 * 1.1515
    dist = dist * 1.609344
    return dist
}


function deliveryAddress(latitude, longitude) {
    sessionStorage.removeItem('charge');
    let dis = distance(locationLat, locationLong, latitude, longitude);
    var delivery_charge = basicCharge;

    if (dis > freeZone) {
        dis = dis - parseFloat(freeZone);
        delivery_charge = dis * chragePerKilo + parseFloat(basicCharge);
    }

    let total = 0;
    if(orderType){
        total = subtotal - parseInt(couponAmount);
    }else {
        total = (subtotal - parseInt(couponAmount) ) + parseInt(delivery_charge);
    }


    $('#delivery_chearge').text(parseInt(delivery_charge));
    $('#total').text(parseFloat(total).toFixed(2));
    $('#total_delivery_charge').val(parseInt(delivery_charge));
    sessionStorage.setItem('charge',delivery_charge);
    const mode = sessionStorage.getItem('charge');
    // console.log(mode);
}
