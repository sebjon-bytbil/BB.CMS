// Specific styling on elements.
var styles = [
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#444444"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#00adef"
            },
            {
                "visibility": "on"
            }
        ]
    }
];

window.gMapsLoaded, window.mapType;

// Listen for load event.
window.addEventListener('loadGoogleMaps', function(e) {
    if (window.gMapsLoaded !== true) {
        window.gMapsLoaded = true;
        window.mapType = e.detail;

        // Create script tag
        var script_tag = document.createElement('script');
        script_tag.setAttribute('id', 'gMapsAPI');
        script_tag.setAttribute('type', 'text/javascript');
        script_tag.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?libraries=places&callback=gMapsCallback');
        (document.getElementsByTagName('head')[0] || document.documentElement).appendChild(script_tag);
    }
});

// Callback for Google Maps API.
window.gMapsCallback = function() {
    if (window.mapType === 'map') {
        var initMap = new Event('initMap');
        window.dispatchEvent(initMap);
    }
}

// Event for init autocomplete for places api.
window.addEventListener('initAutocomplete', function() {
    var mapCanvas = document.querySelector('.google-map-canvas');
    var coordinates = document.querySelector('.gmapCoordinates');

    if (null !== mapCanvas) {
        var defaults = {
            lat: 59.329391,
            lng: 18.068634,
            zoom: 10
        };

        if (coordinates.value !== '') {
            var split = coordinates.value.split(',');
            defaults.lat = parseFloat(split[0]);
            defaults.lng = parseFloat(split[1]);
            defaults.zoom = parseInt(split[2]);
        }

        var map = new google.maps.Map(mapCanvas, {
            center: {
                lat: defaults.lat,
                lng: defaults.lng
            },
            zoom: defaults.zoom,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false,
            draggable: false,
            zoomControl: true,
            streetViewControl: false,
            mapTypeControl: false,
            scaleControl: false,
            styles: styles
        });

        // Get the search box and link it to the UI element.
        var input = document.querySelector('.google-map-auto-complete');
        var searchBox = new google.maps.places.SearchBox(input);
        var markers = [];

        if (coordinates.value !== '') {
            var latlng = new google.maps.LatLng(defaults.lat, defaults.lng);
            var geocoder = new google.maps.Geocoder;

            geocoder.geocode({'location': latlng}, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        map.setZoom(defaults.zoom);
                        markers.push(new google.maps.Marker({
                            map: map,
                            position: latlng
                        }));
                        input.value = results[1].formatted_address;
                    }
                }
            });
        }

        // Bias the searchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        map.addListener('zoom_changed', function() {
            var split = coordinates.value.split(',');
            split[2] = map.getZoom();
            coordinates.value = split.join(',');
        });

        // [START region_getplaces]
        // Listen for the event fired when the user selects a prediciton and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out old markers.
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                markers.push(new google.maps.Marker({
                    map: map,
                    title: place.name,
                    position: place.geometry.location
                }));

                // Add coordinates to hidden input for VC.
                var latlng = place.geometry.location.lat() + ',' + place.geometry.location.lng() + ',' + map.getZoom();
                coordinates.value = latlng;

                var markerlatlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
                window.centerMap(map, markerlatlng);
            });
        });
        // [END region_getplaces]
    }
});

// Event for init map.
window.addEventListener('initMap', function() {
    var maps = document.querySelectorAll('.bb-google-map');
    if (window.gMapsLoaded !== true || typeof google === 'undefined') {
        return;
    }

    [].forEach.call(maps, function(map) {
        if (map.dataset.lat === '' && map.dataset.lng === '') {
            // Set some defaults
            map.dataset.defaults = true;
            map.dataset.lat = 59.329391;
            map.dataset.lng = 18.068634;
            map.dataset.zoom = 10;
        }
        renderMap(map);
    });
});

function renderMap(map) {
    var scrollable = true;
    var controls = false;

    if (map.dataset.preventscroll == '1') {
        scrollable = false;
    }

    if (map.dataset.controls == '1') {
        controls = true;
    }

    var args = {
        zoom: parseInt(map.dataset.zoom),
        center: new google.maps.LatLng(map.dataset.lat, map.dataset.lng),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: scrollable,
        draggable: scrollable,
        zoomControl: controls,
        streetViewControl: false,
        mapTypeControl: false,
        scaleControl: false,
        styles: styles
    };

    // Create map.
    var gMap = new google.maps.Map(map, args);

    // Add a markers reference.
    gMap.markers = [];

    var latlng = new google.maps.LatLng(map.dataset.lat, map.dataset.lng);

    if (map.dataset.defaults === 'false') {
        // Add marker
        addMarker(gMap, latlng);
    }

    // Center map
    centerMap(gMap, latlng, map.dataset.panby);
}

function addMarker(map, latlng) {
    var marker = new google.maps.Marker({
        map: map,
        position: latlng
    });
}

function centerMap(map, latlng, panby) {
    var split = panby.split(',');
    map.setCenter(latlng);
    map.panBy(parseInt(split[0]), parseInt(split[1]));
}
