<?php
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_installningar',
        'title' => 'Inställningar',
        'fields' => array (
            array (
                'key' => 'field_56b9df118c3c5',
                'label' => 'BytBil-alias',
                'name' => 'bytbil-alias',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ));
}
require_once('shortcode.base.php');

/**
 * Accesspaket
 */
class AccessPackageShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function processData($atts)
    {
        $id = self::Exists($atts['assortment'], false);
        if ($id) {

            $atts['assortment_id'] = $id;

            $atts['assortment_alias'] = get_field('bytbil-alias','options');

            $assortment_string = get_field('assortment_string', $id);
            $atts['assortment_string'] = $assortment_string;

            $assortment_page = get_field('assortment_page', $id);
            $atts['assortment_page'] = $assortment_page;

            /*$image = get_field('offer-image', $id);
            $atts['image_url'] = $image['url'];

            $title = get_field('offer-title', $id);
            $atts['title'] = $title;*/
        }

        return $atts;
    }
}

function vc_init_accesspackage_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Accesspaket',
        'base' => 'accesspackage',
        'description' => 'Visa fordon',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'textfield',
                'holder' => 'h2',
                'class' => '',
                'heading' => 'Rubrik',
                'param_name' => 'headline',
                'value' => '',
                'description' => 'Skriv in en rubrik'
            ),
            array(
                'type' => 'cpt',
                'post_type' => 'assortment',
                'heading' => 'Välj fordonsurval',
                'param_name' => 'assortment',
                'placeholder' => 'Välj fordonsurval',
                'value' => '',
                'description' => 'Välj ett existerande fordonsurval.'
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_accesspackage_params', $map['params']);

    $vcAccessPackage = new AccessPackageShortcode($map);
}
add_action('after_setup_theme', 'vc_init_accesspackage_shortcode');

?>