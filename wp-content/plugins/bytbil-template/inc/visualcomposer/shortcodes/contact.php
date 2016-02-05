<?php
require_once('shortcode.base.php');

/**
 * Kontaktformulär
 */
class ContactShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }
}

function bb_init_contactform_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Kontaktformulär',
        'base' => 'contactform',
        'description' => 'Lägg till ett formulär här',
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
    $map['params'] = apply_filters('bb_alter_contactform_params', $map['params']);

    $vcContact = new ContactShortcode($map);
}
add_action('after_setup_theme', 'bb_init_contactform_shortcode');

?>