<?php
require_once('shortcode.base.php');

/**
 * Tabbar
 */
class TabbarShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function processData($atts)
    {
        $atts['tabs'] = vc_param_group_parse_atts($atts['tabs']);
        return $atts;
    }
}

function vc_init_tabs_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Tabbar',
        'base' => 'tabs',
        'description' => 'Tabbar',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'tabs',
                'save_always' => 'true',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'value' => '',
                        'heading' => 'Rubrik',
                        'param_name' => 'headline',
                        'description' => 'Tabbens rubrik.'
                    ),
                    array(
                        'type' => 'wysiwyg',
                        'value' => '',
                        'heading' => 'Innehåll',
                        'param_name' => 'tabs_content',
                        'description' => 'Tabbens innehåll.'
                    )
                )
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_tabs_params', $map['params']);

    $vcTabbar = new TabbarShortcode($map);
}
add_action('after_setup_theme', 'vc_init_tabs_shortcode');

?>