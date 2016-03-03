(function($) {
    'use strict';

    function loadGoogleMaps() {
        var loadGoogleMaps = new CustomEvent(
            'loadGoogleMaps', {
                'detail': 'places'
            }
        );
        window.dispatchEvent(loadGoogleMaps);
    }

    $('body').on('vcPanel.shown', '#vc_properties-panel', function() {
        loadGoogleMaps();
    });
})(jQuery);
