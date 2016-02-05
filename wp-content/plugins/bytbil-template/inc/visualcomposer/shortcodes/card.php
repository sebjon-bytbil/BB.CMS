<?php 
require_once('shortcode.base.php');

/**
 * Kort
 */
class CardShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    public function ProcessData($atts){
        if ($atts['use_picture'] == "0" && !isset($atts['icon_bytbil'])){
            $atts['icon_bytbil'] = "";
        }

        $atts['links'] = vc_param_group_parse_atts( $atts['link_list'] );

        return $atts;
    }
}

function bb_init_card_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Kort',
        'base' => 'card',
        'description' => 'Kort',
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
                'heading' => 'välj ikon',
                'param_name' => 'icon_bytbil',
                'settings' => array(
                    'type' => 'icon_bytbil',
                    'emptyIcon' => true, 
                    'iconsPerPage' => 200, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'use_picture',
                    'value' => '0'
                ),
            ),
            array(
                'type' => 'attach_image',
                'heading' => 'Välj bild',
                'param_name' => 'icon_image',
                'dependency' => array(
                    'element' => 'use_picture',
                    'value' => '1'
                ),
            ),
            array(
                'type' => 'textfield',
                'holder' => '',
                'class' => '',
                'heading' => 'Rubrik',
                'param_name' => 'headline',
                'value' => '',
                'description' => 'Skriv in en rubrik som ska visas under ikon/bild'
            ),
            array(
                'type' => 'textarea_html',
                'holder' => 'div',
                'class' => 'content',
                'heading' => 'Text',
                'param_name' => 'blockcontent',
                'value' => '',
                'description' => 'Skriv in text som ska visas i kortet'
            ),
            array(
                'type' => 'param_group',
                'holder' => '',
                'class' => '',
                'heading' => 'Länklista',
                'param_name' => 'link_list',
                'description' => 'Skapa länklista',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'holder' => '',
                        'class' => '',
                        'heading' => 'URL',
                        'param_name' => 'href',
                        'value' => '',
                        'description' => 'Skriv in adressen som länken ska leda till'
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => '',
                        'class' => '',
                        'heading' => 'Länktext',
                        'param_name' => 'text',
                        'value' => '',
                        'description' => 'Skriv in en tillhörande text till länken'
                    )
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Extra CSS-klasser',
                'param_name' => 'css_classes',
                'value' => '',
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_card_params', $map['params']);

    $vcCards = new CardShortcode($map);
}
add_action('after_setup_theme', 'bb_init_card_shortcode');

?>