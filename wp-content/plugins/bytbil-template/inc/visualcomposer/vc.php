<?php

define('VCADMINPATH', plugin_dir_path( __FILE__));
define('VCADMINURL', plugin_dir_url(__FILE__));

include('includes/remove-standard-elements.php');

// Custom params
include('params/cpt.php');
include('params/cptlist.php');
include('params/datepicker.php');
include('params/map.php');
include('params/pages.php');
include('params/radio.php');
include('params/wysiwyg.php');

// Shortcodes
include('shortcodes/separator.php'); # Avskiljare
include('shortcodes/imageslider.php'); # Bildspel
include('shortcodes/offers.php'); # Erbjudanden
include('shortcodes/map.php'); # Karta
include('shortcodes/puffs.php'); # Puffar

/**
 * Adds custom CSS to Visual Composer
 */
function vc_load_custom_admin_css()
{
    wp_register_style('vc_custom_admin_css', VCADMINURL . 'assets/css/vc_admin.css', false, '1.0.0');
    wp_enqueue_style('vc_custom_admin_css');
}
add_action('admin_enqueue_scripts', 'vc_load_custom_admin_css');

/**
 * Removes specified params from standard Visual Composer elements
 */
function vc_alter_standard_params()
{
    // Row
    vc_remove_param('vc_row', 'parallax');
    vc_remove_param('vc_row', 'parallax_image');
    vc_remove_param('vc_row', 'el_id');
    vc_remove_param('vc_row', 'el_class');

    // Btn
    vc_remove_param('vc_btn', 'css_animation');
    vc_remove_param('vc_btn', 'el_class');
}
add_action('init', 'vc_alter_standard_params');

/**
 * Removes items from array, based on param_name.
 *
 * @param name string||array - the param_name to remove.
 * @param params array - map array
 */
function bb_remove_item_from_params($name, &$params)
{
    $is_array = false;
    if (is_array($name))
        $is_array = true;

    foreach ($params as $i => &$param) {
        if ($param['type'] === 'param_group') {
            foreach ($param['params'] as $j => &$group_param) {
                if ($is_array && in_array($group_param['param_name'], $name)) {
                    unset($param['params'][$j]);
                    continue;
                }

                if ($group_param['param_name'] === $name)
                    unset($param['params'][$j]);
            }
            $param['params'] = array_values($param['params']);
        } else {
            if ($is_array && in_array($param['param_name'], $name)) {
                unset($params[$i]);
                continue;
            }

            if ($param['param_name'] === $name)
                unset($params[$i]);
        }
    }

    $params = array_values($params);
}

/**
 * Fixes key values in arrays.
 */
function fix_array_keys($array)
{
    foreach ($array as $k => $v) {
        if (is_array($v))
            $array[$k] = fix_array_keys($v);
    }
    return array_values($array);
}