<?php
require_once('shortcode.base.php');

/**
 * Anläggningsinformation
 */
class FacilityInfoShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    public function processData($atts)
    {
        $atts['bool'] = true;
        if (isset($atts['facility']) && $atts['facility'] === '0') {
            $atts['bool'] = false;
        } else {
            $id = $atts['facility'];

            $title = get_the_title($id);
            $atts['title'] = $title;

            $alt_address = get_field('facility-use-postal-adress', $id);
            if ($alt_address) {
                $alt_address = true;
                $address = get_field('facility-other-adress', $id);
                $atts['address'] = $address;
            } else {
                $alt_address = false;
                $address = get_field('facility-visiting-address', $id);
                if ($address) {
                    $address_expl = explode(',', $address['address']);
                    $atts['address'] = $address_expl[0];
                    $atts['city'] = $address_expl[1];
                }
            }
            $atts['alt_address'] = $alt_address;

            $phonenumbers = get_field('facility-phonenumbers', $id);
            if (!empty($phonenumbers)) {
                $atts['phonenumber'] = $phonenumbers[0]['facility-phonenumber-number'];
            } else {
                $atts['phonenumber'] = false;
            }

            $emails = get_field('facility-emails', $id);
            if (!empty($emails)) {
                $atts['email'] = $emails[0]['facility-email-address'];
            } else {
                $atts['email'] = false;
            }

            $open_hours = array();

            if ($atts['all_departments'] === '') {
                $atts['all_departments'] = false;

                if (!isset($atts['departments'])) {
                    $open_hours = false;
                } else {
                    $term_ids = explode(',', $atts['departments']);
                    $departments = get_field('facility-departments', $id);

                    foreach ($departments as $i => $department) {
                        $department_name = strtolower($department['facility-department']);
                        $match = false;
                        foreach ($term_ids as $term_id) {
                            $term = get_term($term_id, 'department');
                            $term_name = strtolower($term->name);
                            if ($term_name === $department_name)
                                $match = true;
                        }

                        if ($match) {
                            $open_hours[$i]['department'] = $department['facility-department'];
                            $open_hours[$i]['open_hours'] = $department['facility-department-openhours'];
                        }
                    }
                }
            } else {
                $atts['all_departments'] = true;

                $departments = get_field('facility-departments', $id);
                if ($departments) {
                    foreach ($departments as $i => $department) {
                        $open_hours[$i]['department'] = $department['facility-department'];
                        $open_hours[$i]['open_hours'] = $department['facility-department-openhours'];
                    }
                } else {
                    $open_hours = false;
                }
            }

            $atts['open_hours'] = $open_hours;
        }

        return $atts;
    }
}

function bb_init_facilityinfo_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Anläggningsinformation',
        'base' => 'facilityinfo',
        'description' => '',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'cpt',
                'post_type' => 'facility',
                'heading' => 'Välj anläggning',
                'param_name' => 'facility',
                'placeholder' => 'Välj anläggning',
                'value' => '',
                'description' => 'Välj en existerande anläggning.'
            ),
            array(
                'type' => 'checkbox',
                'heading' => 'Visa öppettider för alla avdelningar',
                'param_name' => 'all_departments',
                'value' => array(
                    'Ja' => '1'
                )
            ),
            array(
                'type' => 'multiselect',
                'heading' => 'Välj avdelningar',
                'term_tax' => true,
                'term' => 'department',
                'param_name' => 'departments',
                'value' => '',
                'description' => 'Välj vilka avdelningar som du vill visa öppettider för. Ctrl-klicka (⌘ om du har Mac) för att välja flera.'
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_facilityinfo_params', $map['params']);

    $vcFacilityInfo = new FacilityInfoShortcode($map);
}
add_action('after_setup_theme', 'bb_init_facilityinfo_shortcode');

?>
