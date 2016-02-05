<?php
require_once('shortcode.base.php');

/**
 * Textblock
 */
class TextShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function processData($atts)
    {
        $content = htmlspecialchars($atts['the_content']);
        $content = preg_replace('/\`{2}/', '"', $content);
        $atts['the_content'] = htmlspecialchars_decode($content);

        return $atts;
    }
}

function bb_init_text_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Textblock',
        'base' => 'text',
        'description' => 'Innehåll',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'wysiwyg',
                'value' => '',
                'heading' => 'Innehåll',
                'param_name' => 'the_content',
                'description' => 'Textblockets innehåll.'
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
    $map['params'] = apply_filters('bb_alter_text_params', $map['params']);

    $vcText = new TextShortcode($map);
}
add_action('after_setup_theme', 'bb_init_text_shortcode');

?>