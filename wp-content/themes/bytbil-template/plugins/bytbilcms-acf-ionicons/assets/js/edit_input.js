(function($) {

    function initialize_field($el) {
        fa_initialized = false;
        if (fa_initialized) {
            var last_row = $('.row-clone').prev('.row');
            $(last_row).each(function() {
                $('select.ion-select2-field', this).each(function() {
                    $(this).select2({
                        width: '100%'
                    });
                    update_preview(this, $(this).val());
                });
            });

            var last_layout = $('.acf-flexible-content .values').last();
            $('tbody > tr.field_type-ionicons select.ion-select2-field', last_layout).each(function() {
                $(this).select2({
                    width: '100%'
                });
                update_preview(this, $(this).val());
            });
        } else {
            $('.row').each(function() {
                $('select-ion-select2-field', this).each(function() {
                    $(this).select2({
                        width: '100%'
                    });
                    update_preview(this, $(this).val());
                });
            });

            $('.acf-flexible-content .values tbody > tr.field_type-ionicons select.ion-select2-field').each(function() {
                $(this).select2({
                    width: '100%'
                });
                update_preview(this, $(this).val());
            });

            $('.field_type-ionicons select.ion-select2-field').each(function() {
                $(this).select2({
                    width: '100%'
                });
                update_preview(this, $(this).val());
            });
        }

        // ACF 5 Flex Clones
        $('.clones select.ion-select2-field').each(function() {
            $(this).select2('destroy');
        });

        // ACF 5 Repeater Clones
        $('.tr.acf-row.clone select.ion-select2-field').each(function() {
            $(this).select2('destroy');
        });

        // ACF 4 Repeater Clones
        $('.tr.row-clone select.ion-select2-field').each(function() {
            $(this).select2('destroy');
        });

        $('select.ion-select2-field').on('select2-selecting', function(object) {
            update_preview(this, object.val);
        });

        $('select.ion-select2-field').on('select2-highlight', function(object) {
            update_preview(this, object.val);
        });

        $('select.ion-select2-field').on('select2-close', function(object) {
            update_preview(this, $(this).val());
        });

        fa_initialized = true;
    }

    function update_preview(element, selected) {
        var parent = $(element).parent();
        $('.ion-live-preview', parent).html('<i class="ion ' + selected + '"></i>');
    }

    if (typeof acf.add_action !== 'undefined') {
        acf.add_action('ready append', function($el) {
            acf.get_fields({type: 'ionicons'}, $el).each(function() {
                initialize_field($(this));
            });
        });
    } else {
        $(document).live('acf/setup_fields', function(e, postbox) {
            $(postbox).find('.field[data-field_type="ionicons"], .sub_field[data-field_type="ionicons"]').each(function() {
                initialize_field($(this));
            });
        });
    }

})(jQuery);
