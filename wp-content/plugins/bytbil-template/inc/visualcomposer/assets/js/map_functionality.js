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

window.gMapsLoaded = false, window.mapType;

// Listen for load even
window.addEventListener('loadGoogleMaps', function(e) {
    window.mapType = e.detail;
    if (window.gMapsLoaded !== true) {
        window.gMapsLoaded = true;
        // Create script tag
        var script_tag = document.createElement('script');
        script_tag.setAttribute('id', 'gMapsAPI');
        script_tag.setAttribute('type', 'text/javascript');
        script_tag.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?libraries=places&callback=gMapsCallback');
        (document.getElementsByTagName('head')[0] || document.documentElement).appendChild(script_tag);
    } else {
        window.gMapsCallback();
    }
});

// Callback for Google Maps API
window.gMapsCallback = function() {
    window.gMapsLoaded = true;
    if (window.mapType === 'map')
        initMaps();
    else if (window.mapType === 'places')
        initPlaces();
}

function initPlaces() {
    (function($) {
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
                    window.centerMap(map, markerlatlng, true);
                });
            });
            // [END region_getplaces]
        }
    })(jQuery);
}

function initMaps() {
    $('.bb-map-canvas').each(function() {
        renderMap($(this));
    });
}

function renderMap($map) {
    // Vars
    var data = $map.get(0).dataset;
    var scrollable = true;
    var controls = false;
    var $markers = $map.find('.marker');

    if (data.preventscroll == '1')
        scrollable = false;

    if (data.controls == '1')
        controls = true;

    var args = {
        zoom: parseInt(data.zoom),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: scrollable,
        draggable: scrollable,
        zoomControl: controls,
        streetViewControl: false,
        mapTypeControl: false,
        scaleControl: false,
        styles: styles
    }

    // Create map
    var map = new google.maps.Map($map[0], args);

    // Add a markers reference
    map.markers = [];

    // Add markers
    $markers.each(function() {
        addMarker($(this), map);
    });

    // Center map
    centerMap(map, false, false);
}

function addMarker($marker, map) {
    var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));

    // Create marker
    var marker = new google.maps.Marker({
        map: map,
        position: latlng
    });

    // Add to array
    map.markers.push(marker);

    // If marker contains HTML, add it to an infoWindow
    if ($marker.html()) {
        // Create info window
        var infoWindow = new google.maps.InfoWindow({
            content: $marker.html()
        });
        // Show info window when marker on click
        google.maps.event.addListener(marker, 'click', function() {
            infoWindow.open(map, marker);
        });
        // Reset viewport on info window close
        google.maps.event.addListener(infoWindow, 'closeclick', function() {
            centerMap(map, false, false);
        });
    }
}

function centerMap(map, latlng, single) {
    if (single) {
        map.setCenter(latlng);
    } else {
        // Vars
        var bounds = new google.maps.LatLngBounds();
        // Loop through markers and create bounds
        $.each(map.markers, function(i, marker) {
            var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
            bounds.extend(latlng);
        });

        // If only one marker
        if (map.markers.length == 1) {
            // Set center of map
            map.setCenter(bounds.getCenter());
            map.setZoom(14);
        } else {
            // Fit to bounds
            map.fitBounds(bounds);
        }
    }
}
