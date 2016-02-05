<?php
add_action('init', 'bb_add_param_datepicker', 10, 0);

function bb_add_param_datepicker()
{
    if (function_exists('add_shortcode_param')) {
        /**
         * Right now the datepicker script needs to be specified inside the shortcode-creation.
         * Same goes with the CSS. I'm using https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css ATM.
         *
         * See front_enqueue_js and front_enqueue_css - https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332#vc_map()-Parameters
         */
        //add_shortcode_param('datepicker', 'bb_param_datepicker', VCADMINURL . 'assets/js/datepicker.js');
        add_shortcode_param('datepicker', 'bb_param_datepicker');
    }
}

function bb_param_datepicker($settings, $value)
{
    $value = __( $value, "js_composer" );
    $value = htmlspecialchars( $value );

    return '<input name="' . $settings['param_name']
           . '" class="wpb_vc_param_value wpb-textinput '
           . $settings['param_name'] . ' ' . $settings['type']
           . '" type="text" value="' . $value . '"/>';
}
