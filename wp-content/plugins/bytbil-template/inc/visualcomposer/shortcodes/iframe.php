<?php
require_once('shortcode.base.php');

/**
 * Iframe
 */
class IFrameShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function processData($atts)
    {
        $atts['iframe'] = true;
        $url = isset($atts['url']) ? $atts['url'] : false;

        if (!$url || filter_var($url, FILTER_VALIDATE_URL) === false)
            $atts['iframe'] = false;

        $border = self::Exists($atts['border'], '0');
        $border_style = ' style="border:0px;"';
        if ($border === '1')
            $border_style = ' style="border:2px solid #2a2a2a;"';

        $atts['border_style'] = $border_style;

        return $atts;
    }
}

function bb_init_iframe_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Iframe',
        'base' => 'iframe',
        'description' => 'Lägg till en iframe',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => 'URL',
                'param_name' => 'url',
                'value' => '',
                'description' => 'Skriv in URLen som du vill ha i din iframe.'
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Höjd',
                'param_name' => 'height',
                'value' => '300',
                'description' => 'Skriv in höjden (i pixlar) för din iframe.'
            ),
            array(
                'type' => 'checkbox',
                'heading' => 'Kantram',
                'param_name' => 'border',
                'description' => 'Bocka i om du vill ha en kantram.',
                'value' => array(
                    'Ja' => '1'
                )
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_iframe_params', $map['params']);

    $vcIframe = new IFrameShortcode($map);
}
add_action('after_setup_theme', 'bb_init_iframe_shortcode');

?>