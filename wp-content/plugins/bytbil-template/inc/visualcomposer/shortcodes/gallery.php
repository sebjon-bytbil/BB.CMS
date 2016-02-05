<?php
require_once('shortcode.base.php');

/**
 * Galleri
 */
class GalleryShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function RegisterScripts()
    {
        //wp_register_style('lightcase-css', VCADMINURL . 'assets/css/vendor/lightcase.css');
        wp_register_script('lightcase', VCADMINURL . 'assets/js/vendor/lightcase.min.js', array(), '1.0.0', true);
        wp_register_script('gallery', VCADMINURL . 'assets/js/gallery.js', array(), '1.0.0', true);
    }

    function EnqueueScripts()
    {
        //wp_enqueue_style('lightcase-css');
        wp_enqueue_script('lightcase');
        wp_enqueue_script('gallery');
    }

    function processData($atts)
    {
        $per_row = $atts['gallery_row_amount'];
        $col = (int) (12 / $per_row);
        $atts['col'] = $col;
        $atts['per_row'] = $per_row;

        $gallery_items = vc_param_group_parse_atts($atts['gallery_items']);

        $atts['amount'] = count($gallery_items);
        $i = 0;
        $items = array();
        foreach ($gallery_items as $item) {
            $items[$i]['id'] = self::GenerateId();

            // Headline
            $headline = self::Exists($item['headline'], '');
            $items[$i]['headline'] = $headline;

            // Image
            $attachment = wp_get_attachment_image_src($item['image'], 'full');
            $image_url = $attachment[0];
            $items[$i]['image_url'] = $image_url;

            // Text
            $text = self::Exists($item['text'], '');
            $items[$i]['image_text'] = $text;

            ++$i;
        }

        $atts['items'] = $items;

        return $atts;
    }
}

function bb_init_gallery_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Galleri',
        'base' => 'gallery',
        'description' => 'Innehåll',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'gallery_items',
                'save_always' => 'true',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'value' => '',
                        'heading' => 'Rubrik',
                        'param_name' => 'headline'
                    ),
                    array(
                        'type' => 'attach_image',
                        'value' => '',
                        'heading' => 'Bild',
                        'param_name' => 'image'
                    ),
                    array(
                        'type' => 'textfield',
                        'value' => '',
                        'heading' => 'Bildtext',
                        'param_name' => 'text',
                        'description' => 'Skriv in en beskrivande text för bilden.'
                    )
                )
            ),
            array(
                'type' => 'textfield',
                'group' => 'Inställningar',
                'heading' => '',
                'param_name' => 'gallery_row_amount',
                'description' => 'Antal bilder per rad.'
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_gallery_params', $map['params']);

    $vcGallery = new GalleryShortcode($map);
}
add_action('after_setup_theme', 'bb_init_gallery_shortcode');

?>