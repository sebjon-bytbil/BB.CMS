(function($) {
    'use strict';
    $(function() {
        $('body').on('vcPanel.shown', '#vc_properties-panel', function() {
            $('body').trigger('init.datepicker');
        });

        $('body').on('click', '.vc_param_group-add_content', function() {
            $('body').trigger('init.datepicker');
        });
    });

    $('body').on('init.datepicker', function() {
        $('[data-param_type=datepicker] input').each(function() {
            var $this = $(this);
            $this.datepicker({
                dateFormat: 'yy-mm-dd',
                onClose: function(date) {
                    $this.val(date);
                }
            });
        });
    });
})(jQuery);
