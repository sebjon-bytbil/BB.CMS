(function($) {
    'use strict';

    if (window.location !== window.top.location) {
        $(window).on('vc_reload', function() {
            imageslider.refresh_imageslider();
        });
    }

    imageslider.refresh_imageslider();
})(jQuery);
