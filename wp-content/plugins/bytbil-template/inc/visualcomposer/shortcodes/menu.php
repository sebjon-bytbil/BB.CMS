<?php
require_once('shortcode.base.php');

/**
 * Meny
 */
class MenuShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function processData($atts)
    {
        $atts['submenu'] = vc_param_group_parse_atts($atts['submenu']);
        return $atts;
    }
}

function bb_init_menu_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Meny',
        'base' => 'menu',
        'description' => 'Menyer',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'dropdown',
                'heading' => 'Meny',
                'param_name' => 'menu',
                'description' => 'Välj den meny som du vill visa.',
                'value' => populate_menus()
            ),
            array(
                'type' => 'checkbox',
                'heading' => 'Undermeny',
                'param_name' => 'submenu',
                'value' => array(
                    'Ja' => true,
                ),
                'description' => 'Visar endast menyvalen tillhörande föräldrasidan',
            ),
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_menu_params', $map['params']);

    $vcMenus = new MenuShortcode($map);
}
add_action('after_setup_theme', 'bb_init_menu_shortcode');

function populate_menus()
{
    $menus = array();
    $nav_menus = get_terms('nav_menu');
    if (!empty($nav_menus)) {
        foreach ($nav_menus as $nav_menu) {
            $menus[$nav_menu->name] = $nav_menu->term_id;
        }
    } else {
        $menus['Inga menyer hittades'] = '0';
    }

    return $menus;
}

?>
