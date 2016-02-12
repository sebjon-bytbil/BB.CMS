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

                $amount = count($open_hours);
                $bootstrap = 12 / $amount;
                $atts['bootstrap'] = $bootstrap;
            } else {
                $open_hours = false;
            }
        } else {
            $open_hours = false;
        }

        $atts['open_hours'] = $open_hours;
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
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_openhours_params', $map['params']);

    $vcOpenHours = new OpenHoursShortcode($map);
}
add_action('after_setup_theme', 'vc_init_openhours_shortcode');

?>
