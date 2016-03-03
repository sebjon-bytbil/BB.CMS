(function($, window) {
    'use strict';

    function loadGoogleMaps() {
        var loadGoogleMaps = new CustomEvent(
            'loadGoogleMaps', {
                'detail': 'map'
            }
        );
        window.dispatchEvent(loadGoogleMaps);
    }

    if (window.location !== window.top.location) {
        $(window).on('vc_reload', function() {
            loadGoogleMaps();
        });
    } else {
        loadGoogleMaps();
    }
})(jQuery, window);
