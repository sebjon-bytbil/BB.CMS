<?php

// Activates specified plugins on theme load
function bbtemplate_activate_plugins()
{
    $plugins = array(
        'bytbil-template/bytbil-template.php', # BytBil Mallsidor
        'js_composer/js_composer.php' # Visual Composer
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
        'bytbil-template/bytbil-template.php', # BytBil Mallsidor
        'js_composer/js_composer.php' # Visual Composer
    );

    include_once(ABSPATH . 'wp-admin/includes/plugin.php');

    foreach ($plugins as $plugin) {
        if (is_plugin_active($plugin))
            deactivate_plugins($plugin);
    }
}
add_action('switch_theme', 'bbtemplate_deactivate_plugins');
