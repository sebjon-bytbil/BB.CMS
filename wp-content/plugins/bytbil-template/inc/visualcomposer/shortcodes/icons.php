<?php
require_once('shortcode.base.php');

/**
 * Ikoner
 */
class IconsShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    public function ProcessData($atts)
    {
        if ($atts['use_picture'] == '0' && !isset($atts['icon_bytbil'])) {
            $atts['icon_bytbil'] = '';
        }

        return $atts;
    }
}

function bb_init_icons_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Ikoner',
        'base' => 'icons',
        'description' => 'Ikoner',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'dropdown',
                'heading' => 'Välj ikontyp',
                'param_name' => 'use_picture',
                'value' => array(
                    'Välj en ikon' => '0',
                    'Välj egen bild som ikon' => '1',
                )
            ),
            array(
                'type' => 'iconpicker',
                'heading' => 'Välj ikon',
                'param_name' => 'icon_bytbil',
                'settings' => array(
                    'type' => 'icon_bytbil',
                    'emptyIcon' => true,
                    'iconsPerPage' => 200,
                ),
                'dependency' => array(
                    'element' => 'use_picture',
                    'value' => '0'
                )
            ),
            array(
                'type' => 'attach_image',
                'heading' => 'Välj bild',
                'param_name' => 'icon_image',
                'dependency' => array(
                    'element' => 'use_picture',
                    'value' => '1',
                )
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_icons_params', $map['params']);

    $vcIcons = new IconsShortcode($map);
}
add_action('after_setup_theme', 'bb_init_icons_shortcode');

?>