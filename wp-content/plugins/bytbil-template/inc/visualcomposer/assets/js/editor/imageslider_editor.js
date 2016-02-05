(function($) {
    'use strict';

    $(function() {
        $('body').on('vcPanel.shown', '#vc_properties-panel', function() {
            $('body').trigger('init.imageslider.settings');
            $('body').trigger('init.imageslider');
        });

        $('body').on('click', '.vc_param_group-add_content', function() {
            $('body').trigger('init.imageslider');
        });
    });

    function toggleHidden($el, prefix) {
        var v = $el.val();

        $el.parents('[data-param_name^=' + prefix + ']').addClass('vc_dependent-hidden');
        $el.parents('[data-param_name=' + prefix + v + ']').removeClass('vc_dependent-hidden');
    }

    $('body').on('init.imageslider.settings', function() {
        if (!$('[data-param_name=slider_border] input').is(':checked')) {
            $('[data-param_name=slider_border_color]').addClass('vc_dependent-hidden');
        }

        var $slider_controls = $('[data-param_name=slider_controls] select');
        var slider_controls_value = $slider_controls.val();
        if (slider_controls_value !== 'thumbs') {
            $('[data-param_name=slider_controls_thumbs]').addClass('vc_dependent-hidden');
        }
    });

    $('body').on('init.imageslider.params', function() {
        $('[data-param_name=slider_images_link_type] select').each(function() {
            toggleHidden($(this), 'slider_images_link_');
        });

        $('select[name=slider_type]').each(function() {
            toggleHidden($(this), 'dep_');
        });

        $('select[name=dep_both_type]').each(function() {
            var $t = $(this);
            var v = $t.val();

            $t.parents('[data-param_name=dep_both_type]').siblings('[data-param_name^=dep_both_]').addClass('vc_dependent-hidden');
            $t.removeClass('vc_dependent-hidden');
            $t.parents('[data-param_name=dep_both_type]').siblings('[data-param_name^=dep_both_' + v + ']').removeClass('vc_dependent-hidden');
        });
    });

    $('body').on('change', 'select[name=slider_images_link_type]', function() {
        toggleHidden($(this), 'slider_images_link_');
    });

    $('body').on('change', 'select[name=slider_type]', function() {
        toggleHidden($(this), 'dep_');
    });

    $('body').on('change', 'select[name=dep_both_type]', function() {
        var $t = $(this);
        var v = $t.val();

        $t.parents('[data-param_name=dep_both_type]').siblings('[data-param_name^=dep_both_]').addClass('vc_dependent-hidden');
        $t.removeClass('vc_dependent-hidden');
        $t.parents('[data-param_name=dep_both_type]').siblings('[data-param_name^=dep_both_' + v + ']').removeClass('vc_dependent-hidden');
    });

    $('body').on('change', 'input[name=slider_border]', function() {
        var $this = $(this);
        var value = $this.val();

        if ($this.is(':checked')) {
            $this.parents('[data-param_name=slider_border]').siblings('[data-param_name=slider_border_color]').removeClass('vc_dependent-hidden');
        } else {
            $this.parents('[data-param_name=slider_border]').siblings('[data-param_name=slider_border_color]').addClass('vc_dependent-hidden');
        }
    });

    $('body').on('change', 'select[name=slider_controls]', function() {
        var $this = $(this);
        var value = $this.val();

        $this.parents('[data-param_name=slider_controls]').siblings('[data-param_name=slider_controls_thumbs]').addClass('vc_dependent-hidden');
        if (value === 'thumbs') {
            $this.parents('[data-param_name=slider_controls]').siblings('[data-param_name=slider_controls_thumbs]').removeClass('vc_dependent-hidden');
        }
    });
})(jQuery);
