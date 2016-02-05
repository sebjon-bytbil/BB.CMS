<?php
require_once('shortcode.base.php');

/**
 * Anläggningskort
 */
class FacilityCardShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function RegisterScripts()
    {
        wp_register_script('map', VCADMINURL . 'assets/js/map.js', array(), '1.0.0', true);
    }

    function EnqueueScripts()
    {
        wp_enqueue_script('map');
    }

    function processData($atts)
    {
        $id = self::Exists($atts['facility'], '');
        if ($id !== '') {
            $title = get_the_title($id);
            $atts['title'] = $title;

            $content = htmlspecialchars($atts['facility_content']);
            $content = preg_replace('/\`{2}/', '"', $content);
            $atts['facility_content'] = htmlspecialchars_decode($content);

            $coordinates = get_field('facility-visiting-address', $id);
            if ($coordinates) {
                $atts['coordinates'] = $coordinates;
                $atts['zoom'] = 14;
            }

            $i = 0;
            $buttons = array();
            $facility_buttons = vc_param_group_parse_atts($atts['facility_buttons']);
            foreach ($facility_buttons as $button) {
                $buttons[$i]['text'] = $button['button_text'];
                $buttons[$i]['color'] = $button['color'];
                $buttons[$i]['link_to'] = $button['link_to'];
                ++$i;
            }

            $atts['buttons'] = $buttons;
        }

        return $atts;
    }
}

function bb_init_facilitycard_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Anläggningskort',
        'base' => 'facilitycard',
        'description' => 'Anläggningskort - Header',
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
                'type' => 'wysiwyg',
                'value' => '',
                'heading' => 'Innehåll',
                'param_name' => 'facility_content',
                'description' => 'Skriv i innehållet som du vill visa i anläggningskortet.'
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_facilitycard_params', $map['params']);

    $vcFacilityCard = new FacilityCardShortcode($map);
}
add_action('after_setup_theme', 'bb_init_facilitycard_shortcode');

?>
