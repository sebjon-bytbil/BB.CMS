<?php

define('VCADMINPATH', plugin_dir_path( __FILE__));
define('VCADMINURL', plugin_dir_url(__FILE__));

include('includes/remove-standard-elements.php');

// Custom params
include('params/cpt.php');
include('params/datepicker.php');
include('params/pages.php');
include('params/radio.php');
include('params/wysiwyg.php');

// Shortcodes
include('shortcodes/imageslider.php'); # Bildspel
//include('shortcodes/accesspackage.php'); # Accesspaket
//include('shortcodes/accordion.php'); # Accordion
//include('shortcodes/facilities.php'); # Anläggningar
//include('shortcodes/facility.php'); # Anläggning
//include('shortcodes/facilitycard.php'); # Anläggningskort
//include('shortcodes/reserve.php'); # Boka provkörning
//include('shortcodes/breadcrumbs.php'); # Breadcrumbs
//include('shortcodes/offers.php'); # Erbjudanden
//include('shortcodes/form.php'); # Formulär
//include('shortcodes/gallery.php'); # Galleri
//include('shortcodes/iframe.php'); # IFrame
//include('shortcodes/icons.php'); # Ikoner
//include('shortcodes/map.php'); # Karta
//include('shortcodes/buttons.php'); # Knappar
//include('shortcodes/contact.php'); # Kontaktformulär
//include('shortcodes/card.php'); # Kort
//include('shortcodes/menu.php'); # Meny
//include('shortcodes/news.php'); # Nyheter
//include('shortcodes/staff.php'); # Personal
//include('shortcodes/social.php'); # Sociala länkar
//include('shortcodes/tabs.php'); # Tabbar
//include('shortcodes/text.php'); # Text block
//include('shortcodes/video.php'); # Video
//include('shortcodes/openhours.php'); # Öppettider
//include('shortcodes/vehicles.php'); # Bilmodeller

// Custom params
//include('params/integer.php');
//include('params/map.php');
//include('params/multiselect.php');
//include('params/cptlist.php');

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
 * Removes specified params from row element
 */
function vc_alter_row_params()
{
    vc_remove_param('vc_row', 'parallax');
    vc_remove_param('vc_row', 'parallax_image');
    vc_remove_param('vc_row', 'el_id');
    vc_remove_param('vc_row', 'el_class');
}
add_action('init', 'vc_alter_row_params');

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