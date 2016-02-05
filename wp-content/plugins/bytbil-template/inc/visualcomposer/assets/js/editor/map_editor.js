(function($) {
    'use strict';
    $(function() {
        var loadGoogleMaps = new CustomEvent(
            'loadGoogleMaps', {
                'detail': 'places'
            }
        );
        window.dispatchEvent(loadGoogleMaps);

        $('body').on('vcPanel.shown', '#vc_properties-panel', function() {
            var initAutocomplete = new Event('initAutocomplete');
            window.dispatchEvent(initAutocomplete);
            $('body').trigger('init.map.settings');
        });

        $('body').on('init.map.settings', function() {
            $('[data-param_name=map_type] select').each(function() {
                var $this = $(this);
                var value = $this.val();

                $this.parents('[data-param_name=map_type]').siblings('[data-param_name^=coordinates_]').addClass('vc_dependent-hidden');
                $this.parents('[data-param_name=map_type]').siblings('[data-param_name=coordinates_' + value + ']').removeClass('vc_dependent-hidden');
            });
        });

        $('body').on('change', 'select[name=map_type]', function() {
            var $this = $(this);
            var value = $this.val();

            $this.parents('[data-param_name=map_type]').siblings('[data-param_name^=coordinates_]').addClass('vc_dependent-hidden');
            $this.parents('[data-param_name=map_type]').siblings('[data-param_name=coordinates_' + value + ']').removeClass('vc_dependent-hidden');
        });
    });
})(jQuery);
