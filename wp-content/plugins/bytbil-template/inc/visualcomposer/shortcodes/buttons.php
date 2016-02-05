<?php
require_once('shortcode.base.php');

/**
 * Knappar
 */
class ButtonsShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function processData($atts)
    {
        $buttons = vc_param_group_parse_atts($atts['the_buttons']);
        $atts['the_buttons'] = $buttons;

        return $atts;
    }
}

function bb_init_buttons_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Knappar',
        'base' => 'buttons',
        'description' => 'Knappar',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'textfield',
                'holder' => '',
                'class' => '',
                'heading' => 'Extra CSS-klasser för knappar',
                'param_name' => 'extra_css',
                'value' => '',
                'description' => 'Dessa klasser läggs till på alla knappar i gruppen'
            ),
            array(
                'type' => 'param_group',
                'heading' => 'Knappar',
                'param_name' => 'the_buttons',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => 'Knapptext',
                        'param_name' => 'button_text',
                        'value' => ''
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Bredd',
                        'param_name' => 'width',
                        'value' => array(
                            '100%' => '12',
                            '75%' => '9',
                            '50%' => '6',
                            '25%' => '3',
                            'Anpassa' => 'auto'
                        )
                    ),
                    array(
                        'type' => 'href',
                        'heading' => 'Länka till',
                        'param_name' => 'link_to',
                        'value' => ''
                    )
                )
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_buttons_params', $map['params']);

    $vcButtons = new ButtonsShortcode($map);
}
add_action('after_setup_theme', 'bb_init_buttons_shortcode');

?>