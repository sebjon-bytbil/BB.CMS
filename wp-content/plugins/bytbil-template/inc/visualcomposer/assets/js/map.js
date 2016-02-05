(function($) {
    'use strict';

    if (window.location !== window.top.location) {
        $(window).on('vc_reload', function() {
            var initMap = new Event('initMap');
            window.dispatchEvent(initMap);
        });
    }

    var loadGoogleMaps = new CustomEvent(
        'loadGoogleMaps', {
            'detail': 'map'
        }
    );
    window.dispatchEvent(loadGoogleMaps);
})(jQuery);
