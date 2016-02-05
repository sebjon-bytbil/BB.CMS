<?php
require_once('shortcode.base.php');

/**
 * Open hours
 */
class OpenHoursShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function processData($atts)
    {
        $open_hours = array();

        $id = self::Exists($atts['facility'], false);
        if ($id) {
            $departments = get_field('facility-departments', $id);
            if ($departments) {
                foreach ($departments as $i => $department) {
                    $open_hours[$i]['department'] = $department['facility-department'];
                    $open_hours[$i]['open_hours'] = $department['facility-department-openhours'];
                }
            } else {
                $open_hours = false;
            }
        } else {
            $open_hours = false;
        }

        $atts['open_hours'] = $open_hours;

        $accordion = self::Exists($atts['show_as_accordion'], false) == 1 ? true : false;
        $atts['show_as_accordion'] = $accordion;

        return $atts;
    }
}

function vc_init_openhours_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Öppettider',
        'base' => 'openhours',
        'description' => 'Öppettider',
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
                'description' => 'Välj vilken anläggnings öppettider du vill visa.'
            ),
            array(
                'type' => 'checkbox',
                'heading' => 'Visa som accordion',
                'param_name' => 'show_as_accordion',
                'description' => 'Bocka i om du vill visa öppettiderna som en accordion.',
                'value' => array(
                    'Ja' => '1'
                )
            ),
            //array(
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_openhours_params', $map['params']);

    $vcOpenHours = new OpenHoursShortcode($map);
}
add_action('after_setup_theme', 'vc_init_openhours_shortcode');

?>
