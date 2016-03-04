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
        $('body').trigger('init.ac.map');
    });

   $('body').on('init.ac.map', function() {
       var type = $('select[name=map_type').val();
       if (type == 'facility') {
           $('select[name=map_type]').on('change', function() {
               var value = $(this).val();
               if (value == 'map') {
                   var map = $('.google-map-canvas')[0];
                   google.maps.event.trigger(map, 'resize');
               }
           });
       }
   });
})(jQuery);
