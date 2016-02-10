(function($) {
    'use strict';

    $(function() {
        $('body').on('vcPanel.shown', '#vc_properties-panel', function() {
            $('body').trigger('init.imageslider');
        });

        $('body').on('click', '.vc_param_group-add_content', function() {
            $('body').trigger('init.imageslider');
        });
    });

    function toggleDependent(init, val, $parent) {
        if (init) {
            $('select[name=slides_slide_type]').each(function() {
                var val = $(this).val();
                var $parent = $(this).parent().parent();

                $parent.siblings('[data-param_name^=slides_image_], [data-param_name^=slides_offer_]').addClass('vc_dependent-hidden');
                $parent.siblings('[data-param_name^=slides_' + val + '_]').removeClass('vc_dependent-hidden');
            });
        } else {
            $parent.siblings('[data-param_name^=slides_image_], [data-param_name^=slides_offer_]').addClass('vc_dependent-hidden');
            $parent.siblings('[data-param_name^=slides_' + val + '_]').removeClass('vc_dependent-hidden');
        }
    }

    $('body').on('change', 'select[name=slides_slide_type]', function() {
        toggleDependent(false, $(this).val(), $(this).parent().parent());
    });

    $('body').on('init.imageslider.params', function() {
        var v = $('select[name=slides_slide_type]').val();
        toggleDependent(true, null, null);
    });
})(jQuery);
