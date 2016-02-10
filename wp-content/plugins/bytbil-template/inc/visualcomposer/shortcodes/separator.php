<?php
require_once('shortcode.base.php');

/**
 * Avskiljare
 */
class SeparatorShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    public function processData($atts)
    {
        return $atts;
    }
}

function bb_init_separator_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Avskiljare',
        'base' => 'separator',
        'description' => '',
        'class' => '',
        'show_settings_on_create' => false,
        'weight' => 10,
        'category' => 'Innehåll'
    );

    $vcSeparator = new SeparatorShortcode($map);
}
add_action('after_setup_theme', 'bb_init_separator_shortcode');
