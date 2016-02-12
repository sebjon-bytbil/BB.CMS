<?php

function something()
{
    $icons = array(
        'type' => 'dropdown',
        'heading' => 'Icon library',
        'value' => array(
            'Font Awesome' => 'fontawesome',
            'Open Iconic' => 'openiconic',
            'Typicons' => 'typicons',
            'Entypo' => 'entypo',
            'Linecons' => 'linecons',
            'Pixel' => 'pixelicons',
            'Ion icons' => 'ionicons'
        ),
        'param_name' => 'i_type',
        'description' => 'Select icon library.',
        'dependency' => array(
            'element' => 'add_icon',
            'value' => 'true'
        ),
        'integrated_shortcode' => 'vc_icon',
        'integrated_shortcode_field' => 'i_'
    );

    $ionicons = array(
        'type' => 'iconpicker',
        'heading' => __( 'Icon', 'js_composer' ),
        'param_name' => 'i_icon_ionicons',
        'settings' => array(
            'emptyIcon' => false,
            'type' => 'ionicons',
            'source' => require_once('icons/ionicons.php')
        ),
        'dependency' => array(
            'element' => 'i_type',
            'value' => 'ionicons'
        ),
        'description' => __( 'Select icon from library.', 'js_composer' ),
    );

    vc_remove_param('vc_btn', 'i_type');
    vc_add_param('vc_btn', $icons);
    vc_add_param('vc_btn', $ionicons);

}
add_action('init', 'something');


