<?php
// I hate this file so much
//define('VCADMINPATH', plugin_dir_path( __FILE__));
//define('VCADMINURL', plugin_dir_url(__FILE__));

//include('includes/deactivatevcblocks.php');

// Shortcodes
//include('shortcodes/accesspackage.php'); # Accesspaket
//include('shortcodes/accordion.php'); # Accordion
//include('shortcodes/facilities.php'); # Anläggningar
//include('shortcodes/facility.php'); # Anläggning
//include('shortcodes/facilitycard.php'); # Anläggningskort
//include('shortcodes/imageslider.php'); # Bildspel
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
//include('params/radio.php');
//include('params/pages.php');
//include('params/datepicker.php');
//include('params/map.php');
//include('params/wysiwyg.php');
//include('params/cpt.php');
//include('params/multiselect.php');
//include('params/cptlist.php');

//add_filter('vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2);
function custom_css_classes_for_vc_row_and_vc_column($class_string, $tag)
{
    if (!is_admin()) {
        if ($tag == 'vc_row' || $tag == 'vc_row_inner') {
            $class_string = str_replace('vc_row-fluid', 'row', $class_string);
        }
        if ($tag == 'vc_column' || $tag == 'vc_column_inner') {
            $class_string = preg_replace('/vc_(col-\w{1,2}-\d{1,2})/', '$1', $class_string);
        }
    }

    return $class_string; // Important: you should always return modified or original $class_string
}

//add_action('wp_enqueue_scripts', 'enqueue_and_register_owl_slider_scripts');
function enqueue_and_register_owl_slider_scripts()
{
    wp_register_style('vc_style', VCADMINURL . 'assets/css/vc_style.css', array(), '1.0.0', 'all');
    wp_enqueue_style('vc_style');

    wp_register_style('owl-carousel', VCADMINURL . 'assets/css/vendor/owl.carousel.css', array(), '1.0.0', 'all');
    wp_enqueue_style('owl-carousel');

    wp_register_script('owl-carousel', VCADMINURL . 'assets/js/vendor/owl.carousel.min.js', array(), '1.0.0', true);
    wp_register_script('row-carousel', VCADMINURL . 'assets/js/rowslider.js', array('owl-carousel'), '1.0.0', true);
    wp_localize_script('row-carousel', 'rowSlider', array(
        'xs' => apply_filters('owl-carousel-xs', 0),
        'sm' => apply_filters('owl-carousel-sm', 768),
        'md' => apply_filters('owl-carousel-md', 992),
        'lg' => apply_filters('owl-carousel-lg', 1200)
    ));
}

//add_action('admin_enqueue_scripts', 'vc_load_custom_admin_js');
function vc_load_custom_admin_js()
{
    wp_register_script('vc_general', VCADMINURL . 'assets/js/general.js', array(), '1.0.0', true);
    wp_enqueue_script('vc_general');
}

//add_action('admin_enqueue_scripts', 'vc_load_custom_admin_css');
function vc_load_custom_admin_css()
{
    wp_register_style('vc_custom_admin_css', VCADMINURL . 'assets/css/vc_admin.css', false, '1.0.0');
    wp_enqueue_style('vc_custom_admin_css');
}

//add_action('init', 'setDefaultTemplatePathForVisualComposerTemplates', 1, 1);
function setDefaultTemplatePathForVisualComposerTemplates($sd)
{
    //vc_set_shortcodes_templates_dir(VCADMINPATH . 'templates/visualcomposerstandard');
    //error_log(vc_shortcodes_theme_templates_dir('vc-row.php'));
}

//add_action('init', 'visualcomposeraddrowparams', 1, 1);
function visualcomposeraddrowparams($sd)
{
    //vc_remove_param('vc_row', 'parallax');
    //vc_remove_param('vc_row', 'parallax_image');
    //vc_remove_param('vc_row', 'el_id');
    //vc_remove_param('vc_row', 'el_class');


    $showrowasslideshow = array(
        'type' => 'checkbox',
        'heading' => 'Visa rad som bildspel',
        'param_name' => 'showrowasslideshow',
        'value' => array(
            'Ja' => 'true'
        ),
        'description' => 'Detta bestämmer om raden ska vara ett bildspel eller inte.',
        'weight' => 1
    );
    //vc_add_param('vc_row', $showrowasslideshow);
    
    $overlaycolor = array(
        'type' => 'colorpicker',
        'value' => '',
        'heading' => 'Overlay backgrundsfärg',
        'param_name' => 'overlaycolor',
        'description' => 'Välj vilken färg samt styrka som overlay skall ha.',
        'weight' => 1
    );
    //vc_add_param('vc_row', $overlaycolor);
    
    /*$dottedoverlay = array(
        'type' => 'checkbox',
        'heading' => 'Prickig overlay',
        'param_name' => 'dotted_overlay',
        'value' => array(
            'Ja' => 'true'
        ),
        'description' => 'Bocka i om du vill visa en prickig overlay.',
        'weight' => 1
    );
    
    vc_add_param('vc_row', $dottedoverlay);
    */

    $displayascard = array(
        'type' => 'dropdown',
        'heading' => 'Visa som kort',
        'param_name' => 'displayascard',
        'default_value' => 'false',
        'value' => array(
            'Nej' => 'false',
            'Ja' => 'true',
            'Ja, med ikon och rubrik' => 'cardicon'
        ),
        'description' => 'Visa kolumn som kort.',
        'weight' => 1
    );
    //vc_add_param('vc_column', $displayascard);
    //vc_add_param('vc_column_inner', $displayascard);

    $cardicon = array(
        'type' => 'iconpicker',
        'heading' => 'Välj ikon',
        'param_name' => 'icon_bytbil',
        'settings' => array(
            'type' => 'icon_bytbil',
            'emptyIcon' => true,
            'iconsPerPage' => 200
        ),
        'dependency' => array(
            'element' => 'displayascard',
            'value' => 'cardicon'
        ),
        'weight' => 1
    );
    //vc_add_param('vc_column', $cardicon);
    //vc_add_param('vc_column_inner', $cardicon);

    $cardheader = array(
        'type' => 'textfield',
        'heading' => 'Kortrubrik',
        'param_name' => 'card_headline',
        'value' => '',
        'description' => 'Skriv in en rubrik som ska visas under ikon/bild',
        'weight' => 1,
        'dependency' => array(
            'element' => 'displayascard',
            'value' => 'cardicon'
        )
    );
    //vc_add_param('vc_column', $cardheader);
    //vc_add_param('vc_column_inner', $cardheader);
}

/**
 * Removes items from array, based on param_name.
 *
 * @param name string||array - the param_name to remove.
 * @param params array - map array
 */
function bb_remove_item_from_params($name, &$params)
{
    $is_array = false;
    if (is_array($name)) {
        $is_array = true;
    }

    foreach ($params as $i => &$param) {
        if ($param['type'] === 'param_group') {
            foreach ($param['params'] as $j => &$group_param) {
                if ($is_array && in_array($group_param['param_name'], $name)) {
                    unset($param['params'][$j]);
                    continue;
                }

                if ($group_param['param_name'] === $name) {
                    unset($param['params'][$j]);
                }
            }
            $param['params'] = array_values($param['params']);
        } else {
            if ($is_array && in_array($param['param_name'], $name)) {
                unset($params[$i]);
                continue;
            }

            if ($param['param_name'] === $name) {
                unset($params[$i]);
            }
        }
    }

    $params = array_values($params);
}

function fix_array_keys($array) {
    foreach ($array as $k => $v) {
        if (is_array($v)) {
            $array[$k] = fix_array_keys($v);
        }
    }
    return array_values($array);
}