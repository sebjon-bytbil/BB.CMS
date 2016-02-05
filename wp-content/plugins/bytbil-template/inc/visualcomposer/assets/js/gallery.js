(function(gallery) {
    'use strict';
    gallery(window.jQuery, window, document);

    }(function($, window, document) {
        $(function() {
            // Check if gallery is iframed
            if (window.location !== window.top.location) {
                // Use Visual Composer event to show gallery
                $(window).on('vc_reload', function() {
                    $('a[data-rel^=lightcase]').lightcase({
                        maxWidth: 1170,
                        maxHeight: 640
                    });
                });
            } else {
                $('a[data-rel^=lightcase]').lightcase();
            }
        });
    })
);
