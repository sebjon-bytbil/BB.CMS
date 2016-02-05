(function($) {
    'use strict';

    var dialog = $('#vc_add-element-dialog');
    if (typeof dialog !== undefined && dialog.length > 0) {
        var ninja = dialog.find('ul.wpb-content-layouts li[data-element=ninja_forms_display_form]');
        if (typeof ninja !== undefined && ninja.length > 0) {
            ninja.remove();
        }
    }
})(jQuery);
