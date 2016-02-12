<?php

// Plugins
include 'plugins/bytbilcms-anlaggning/bytbilcms-anlaggning.php';
include 'plugins/bytbilcms-erbjudanden/bytbilcms-erbjudanden.php';
include 'plugins/wp_bootstrap_navwalker.php';

// Activates specified plugins on theme load
function bbtemplate_activate_plugins()
{
    $plugins = array(
        'acf-image-crop-add-on/acf-image-crop.php', # ACF Image Crop
        'acf-repeater/acf-repeater.php', # ACF Repeater
        'advanced-custom-field-repeater-collapser/acf_repeater_collapser.php', # ACF Repeater Collapser
        'advanced-custom-fields/acf.php', # ACF
        'bytbil-template/bytbil-template.php', # BytBil Mallsidor
        'js_composer/js_composer.php', # Visual Composer
        'wp-media-folder/wp-media-folder.php' # WP Media Folder
    );

    include_once(ABSPATH . 'wp-admin/includes/plugin.php');

    foreach ($plugins as $plugin) {
        if (!is_plugin_active($plugin))
            activate_plugin($plugin);
    }
}
add_action('after_switch_theme', 'bbtemplate_activate_plugins');

// Deactivates specified plugins on theme unload
function bbtemplate_deactivate_plugins()
{
    $plugins = array(
        'acf-image-crop-add-on/acf-image-crop.php', # ACF Image Crop
        'acf-repeater/acf-repeater.php', # ACF Repeater
        'advanced-custom-field-repeater-collapser/acf_repeater_collapser.php', # ACF Repeater Collapser
        'advanced-custom-fields/acf.php', # ACF
        'bytbil-template/bytbil-template.php', # BytBil Mallsidor
        'js_composer/js_composer.php', # Visual Composer
        'wp-media-folder/wp-media-folder.php' # WP Media Folder
    );

    include_once(ABSPATH . 'wp-admin/includes/plugin.php');

    foreach ($plugins as $plugin) {
        if (is_plugin_active($plugin))
            deactivate_plugins($plugin);
    }
}
add_action('switch_theme', 'bbtemplate_deactivate_plugins');

// Menus
function bbtemplate_register_menus()
{
    register_nav_menu('header-menu', __('Main menu'));
}
add_action('init', 'bbtemplate_register_menus');

// Hex to RGBA
function theme_hex2rgba($color, $opacity = false)
{
    $default = 'rgb(0,0,0)';

    // Return default if no color provided
    if (empty($color))
        return $default;

    // Sanitize $color if "#" is provided
    if ($color[0] == '#')
        $color = substr($color, 1);

    // Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6)
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    elseif (strlen($color) == 3)
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    else
        return $default;

    // Convert hexadecimal to rgb
    $rgb = array_map('hexdec', $hex);

    // Check if opacity is set (rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba(' . implode(',', $rgb) . ',' . $opacity . ')';
    } elseif ($opacity == '0') {
        $output = 'rgba(' . implode(',', $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(',', $rgb) . ')';
    }

    // Return rgb(a) color string
    return $output;
}
