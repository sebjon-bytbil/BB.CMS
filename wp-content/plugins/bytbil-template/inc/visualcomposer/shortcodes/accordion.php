<?php
require_once('shortcode.base.php');

/**
 * Accordion
 */
class AccordionShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function processData($atts)
    {
        $accordions = vc_param_group_parse_atts($atts['accordions']);
        $filtered = array_filter($accordions);

        if (!empty($filtered))
            $atts['accordions'] = $accordions;
        else
            $atts['accordions'] = false;

        return $atts;
    }
}

function vc_init_accordion_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Accordion',
        'base' => 'accordion',
        'description' => 'Accordion',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'accordions',
                'save_always' => 'true',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'value' => '',
                        'heading' => 'Rubrik',
                        'param_name' => 'headline',
                        'description' => 'Accordionens rubrik.'
                    ),
                    array(
                        'type' => 'wysiwyg',
                        'value' => '',
                        'heading' => 'Innehåll',
                        'param_name' => 'accordion_content',
                        'description' => 'Accordionens innehåll.'
                    )
                )
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_accordion_params', $map['params']);

    $vcAccordion = new AccordionShortcode($map);
}
add_action('after_setup_theme', 'vc_init_accordion_shortcode');

?>