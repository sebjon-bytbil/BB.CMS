(function($){
    "use strict";
    var body = $('body');

    body.on('change', '.vc_wrapper-param-type-radio input[type=radio]', function(){
        var value = $(this).val(),
            $el = $(this),
            name = $(this).attr('name'),
            $parent = $(this).parents('.vc_wrapper-param-type-radio').first();

        $parent.find('input[type=radio]').removeClass('wpb_vc_param_value');
        $(this).addClass('wpb_vc_param_value');

    });
})(jQuery);