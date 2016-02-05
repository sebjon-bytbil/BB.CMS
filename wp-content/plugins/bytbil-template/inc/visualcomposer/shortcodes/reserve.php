<?php
require_once('shortcode.base.php');

/**
 * Boka provkörning
 */
class ReserveShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }
}

function bb_init_reserve_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Boka provkörning',
        'base' => 'reserve',
        'description' => 'Formulär för boka provkörning',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'textfield',
                'holder' => 'h2',
                'class' => '',
                'heading' => 'Rubrik',
                'param_name' => 'headline',
                'value' => '',
                'description' => 'Skriv in en rubrik'
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_reserve_params', $map['params']);

    $vcReserve = new ReserveShortcode($map);
}
add_action('after_setup_theme', 'bb_init_reserve_shortcode');

?>