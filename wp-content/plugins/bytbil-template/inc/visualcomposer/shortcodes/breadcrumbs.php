<?php
require_once('shortcode.base.php');

/**
 * Breadcrumbs
 */
class BreadcrumbsShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function processData($atts)
    {
        $atts['breadcrumbs'] = vc_param_group_parse_atts($atts['breadcrumbs']);
        return $atts;
    }
}

function bb_init_breadcrumbs_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Breadcrumbs',
        'base' => 'breadcrumbs',
        'description' => 'Breadcrumbs',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'breadcrumbs',
                'save_always' => 'true',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'value' => '',
                        'heading' => 'Rubrik',
                        'param_name' => 'headline',
                        'description' => 'Accordionens rubrik.'
                    ),
                )
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_breadcrumbs_params', $map['params']);

    $vcBreadCrumbs = new BreadCrumbsShortcode($map);
}
add_action('after_setup_theme', 'bb_init_breadcrumbs_shortcode');

?>