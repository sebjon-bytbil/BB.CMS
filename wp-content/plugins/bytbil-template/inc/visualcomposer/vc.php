<?php

define('VCADMINPATH', plugin_dir_path( __FILE__));
define('VCADMINURL', plugin_dir_url(__FILE__));

include('includes/remove-standard-elements.php');

// Icons
include('includes/ionicons.php');

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
include('shortcodes/icons.php');

/**
 * Sets the default directory for VC to check for templates
 */
function vc_default_template_path()
{
    vc_set_shortcodes_templates_dir(VCADMINPATH . 'templates/vc_standard');
}
add_action('init', 'vc_default_template_path');

/**
 * Adds custom CSS to Visual Composer
 */
function vc_load_custom_admin_css()
{
    wp_register_style('vc_custom_admin_css', VCADMINURL . 'assets/css/vc_admin.css', false, '1.0.0');
    wp_enqueue_style('vc_custom_admin_css');
    wp_register_style('ionicons_admin', VCADMINURL . 'assets/css/ionicons.min.css', false, '1.0.0');
    wp_enqueue_style('ionicons_admin');
}
add_action('admin_enqueue_scripts', 'vc_load_custom_admin_css');

/**
 * Removes specified params from standard Visual Composer elements
 */
function vc_remove_standard_params()
{
    // Row
    vc_remove_param('vc_row', 'parallax');
    vc_remove_param('vc_row', 'parallax_image');
    vc_remove_param('vc_row', 'el_id');
    vc_remove_param('vc_row', 'el_class');

    // Btn
    vc_remove_param('vc_btn', 'css_animation');
    vc_remove_param('vc_btn', 'el_class');

    wp_register_style('ionicons', VCADMINURL . 'assets/css/ionicons.min.css', false, '1.0.0');
}
add_action('init', 'vc_remove_standard_params');

/**
 * Adds specified params to standard Visual Composer elements
 */
function vc_add_standard_params()
{
    // Wrapper checkbox
    $wrapper = array(
        'type' => 'checkbox',
        'heading' => 'Wrapper',
        'param_name' => 'wrapper',
        'default_value' => 'false',
        'value' => array(
            'Yes' => 'true'
        ),
        'description' => 'Flytta Design Options CSS till inner wrapper.'
    );
    vc_add_param('vc_column', $wrapper);
}
add_action('init', 'vc_add_standard_params');
