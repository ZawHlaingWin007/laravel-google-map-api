// Fancybox v5 Initialize
// Fancybox.bind("[data-fancybox]", {
//     // options
// });

// Get Current Location Coordinates
function getCurrentLocation(callback) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            // Current Location Coordinates
            let currentLat = position.coords.latitude;
            let currentLng = position.coords.longitude;

            callback(currentLat, currentLng);
        }, showGoogleMapError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

// Get the distance between two places in km or m
function getDistanceBetweenTwoPlaces(firstLatLng, secondLatLng, isKM = false) {
    let distance = google.maps.geometry.spherical.computeDistanceBetween(
        firstLatLng,
        secondLatLng
    );
    return isKM ? distance / 1000 : distance;
}

// Google Map Marker
function addMapMarker(props) {
    var marker = new google.maps.Marker({
        position: props.coords,
        map: props.map,
    });

    if (props.icon) {
        marker.setIcon(props.icon)
    }

    if (props.label) {
        marker.setLabel(props.label)
    }

    return marker;
}

// Google Map Popup Info
function showMapInfoWindow(contentString, LatLng) {
    let infoWindow = new google.maps.InfoWindow({
        content: contentString,
        position: LatLng
    });

    return infoWindow;
}

// Throw Google Map Errors
function showGoogleMapError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            mapContainer.innerHTML = "User denied the request for Geolocation.";
            break;
        case error.POSITION_UNAVAILABLE:
            mapContainer.innerHTML = "Location information is unavailable.";
            break;
        case error.TIMEOUT:
            mapContainer.innerHTML =
                "The request to get user location timed out.";
            break;
        case error.UNKNOWN_ERROR:
            mapContainer.innerHTML = "An unknown error occurred.";
            break;
    }
}
