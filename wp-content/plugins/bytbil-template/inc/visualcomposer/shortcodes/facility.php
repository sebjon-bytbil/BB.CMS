<?php
require_once('shortcode.base.php');

/**
 * Anläggningar
 */
class FacilityShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function processData($atts) {

        $id = self::Exists($atts['facility'], false);
        if ($id) {

            // Facility/location name
            $atts['name'] = get_the_title($id);

            // Permalink
            $atts['permalink'] = get_the_permalink($id);

            // Visiting address
            $visiting_address = get_field('facility-visiting-address',$id);
            $visiting_address = explode(",", $visiting_address['address']);
            $atts['visiting_address_street'] = $visiting_address[0];
            $atts['visiting_address_zip_postal'] = $visiting_address[1];

            // Postal address
            $atts['use_postal'] = get_field('facility-use-postal-adress',$id);
            $atts['postal_address'] = get_field('facility-other-adress',$id);

            // Phone numbers
            $atts['phonenumbers'] = get_field('facility-phonenumbers',$id);

            // E-mail addresses
            $atts['emails'] = get_field('facility-emails',$id);

            // Departments
            $atts['departments'] = get_field('facility-departments',$id);

            // Other open hours
            $atts['other_open_hours'] = get_field('facility-other-openhours',$id);

        }

        return $atts;
    }
}

function bb_init_facility_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Anläggning',
        'base' => 'facility',
        'description' => 'Enskild anläggning',
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
                'description' => 'skriv in en rubrik'
            ),
            array(
                'type' => 'cpt',
                'post_type' => 'facility',
                'heading' => 'Välj anläggning',
                'param_name' => 'facility',
                'placeholder' => 'Välj anläggning',
                'value' => '',
                'description' => 'Välj en existerande anläggning.'
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_facility_params', $map['params']);

    $vcFacilities = new FacilityShortcode($map);
}
add_action('after_setup_theme', 'bb_init_facility_shortcode');

?>