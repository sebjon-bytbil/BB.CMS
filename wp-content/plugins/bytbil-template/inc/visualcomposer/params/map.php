<?php
add_action('init', 'bb_add_param_map', 10, 0);

function bb_add_param_map()
{
    if (function_exists('add_shortcode_param')) {
        add_shortcode_param('map', 'bb_param_map');
    }
    wp_register_script('map_functionality', VCADMINURL . 'assets/js/map_functionality.js', array(), '1.0.0', true);
    wp_enqueue_script('map_functionality');
}

function bb_param_map($settings, $value)
{
    $value = __($value, 'js_composer');

    return '<input name="' . $settings['param_name']
           . '" class="gmapCoordinates wpb_vc_param_value wpb-textinput '
           . $settings['param_name'] . ' ' . $settings['type']
           . '" type="hidden" value="' . $value . '"/>'
           . '<input class="google-map-auto-complete" type="text">'
           . '<div class="google-map-canvas" style="height:300px;"></div>';
}
