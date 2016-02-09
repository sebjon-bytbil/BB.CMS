<?php

// Plugins
include 'plugins/bytbilcms-anlaggning/bytbilcms-anlaggning.php';
include 'plugins/bytbilcms-erbjudanden/bytbilcms-erbjudanden.php';
include 'plugins/bytbilcms-fordonsurval/bytbilcms-fordonsurval.php';
include 'plugins/wp_bootstrap_navwalker.php';

// Activates specified plugins on theme load
function bbtemplate_activate_plugins()
{
    $plugins = array(
        'acf-image-crop-add-on/acf-image-crop.php', # ACF Image Crop
        'acf-options-page/acf-options-page.php', # ACF Options Page
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
        'acf-options-page/acf-options-page.php', # ACF Options Page
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
