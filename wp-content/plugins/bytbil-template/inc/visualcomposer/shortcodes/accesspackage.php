<?php
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

            var_dump('<pre>', get_field('bytbil-alias', 'options'), '</pre>');

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