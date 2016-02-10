<?php
require_once('shortcode.base.php');

/**
 * Bildspel
 */
class ImageSliderShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    public function RegisterScripts()
    {
        wp_register_script('flexslider', VCADMINURL . 'assets/js/vendor/jquery.flexslider-min.js', array(), '1.0.0', true);
        wp_register_script('imageslider_functionality', VCADMINURL . 'assets/js/imageslider_functionality.js', array(), '1.0.0', true);
        wp_register_script('imageslider', VCADMINURL . 'assets/js/imageslider.js', array(), '1.0.0', true);
    }

    public function EnqueueScripts()
    {
        wp_enqueue_script('flexslider');
        wp_enqueue_script('imageslider_functionality');
        wp_enqueue_script('imageslider');
    }

    private function build_image_slide($slide)
    {
        $processed_slide = array();

        // Dates
        $show_slide = false;
        $todays_date = date('Y-m-d');
        $start_date = self::Exists($slide['image_start_date'], $todays_date);
        $stop_date = self::Exists($slide['image_stop_date'], $todays_date);

        if ($todays_date >= $start_date && $todays_date <= $stop_date) $show_slide = true;
        if (!$show_slide) return array();
        $processed_slide['start_date'] = $start_date;
        $processed_slide['stop_date'] = $stop_date;

        // Image
        $image_full = wp_get_attachment_image_src($slide['image_image'], 'full');
        $processed_slide['image'] = $image_full[0];

        // Link
        $link = vc_build_link($slide['image_link']);
        $processed_slide['link_url'] = $link['url'];
        $processed_slide['link_title'] = $link['title'];
        $processed_slide['link_target'] = $link['target'];

        // Overlay
        $overlay_background_color = self::Exists($slide['image_overlay_color'], 'transparent') . ';';
        $explode_overlay = explode(',', $overlay_background_color);
        if ($explode_overlay[3] === '0.01);')
            $overlay_background_color = 'transparent';
        $processed_slide['overlay_background_color'] = 'background: ' . $overlay_background_color;

        // Caption
        $caption_content = self::Exists($slide['image_caption_content'], false);
        $processed_slide['caption_content'] = $caption_content;

        if ($caption_content) {
            $caption_background_color = self::Exists($slide['image_caption_background_color'], 'transparent') . ';';
            $caption_animation = self::Exists($slide['image_caption_animation'], 'none');
            $caption_border = self::Exists($slide['image_caption_border'], '0');
            if ($caption_border === '1') {
                // Caption border color
                # This does nothing?
                if (substr($caption_background_color, 0, 1) === '#')
                    $caption_border_color = self::hex2rgba($caption_background_color);

                $explode_caption_background_color = explode(',', $caption_background_color);
                $explode_caption_background_color[3] = '0.75);';
                $implode_caption_background_color = implode(',', $explode_caption_background_color);
                $caption_border_color = '10px solid ' . $implode_caption_background_color;
            } else {
                $caption_border_color = 'none;';
            }
            $caption_style = 'background:' . $caption_background_color . 'border:' . $caption_border_color;
            $caption_position = self::Exists($slide['image_caption_position'], 'center');
            $processed_slide['caption_animation'] = $caption_animation;
            $processed_slide['caption_style'] = $caption_style;
            $processed_slide['caption_position'] = $caption_position;
        }
        return $processed_slide;
    }

    private function build_offer_slide($slide)
    {
        $processed_slide = array();
        $id = $slide['offer_offer'];

        // Dates
        $show_slide = false;
        $todays_date = date('Y-m-d');
        $start_date = self::Exists(get_field('offer-date-start', $id), $todays_date);
        $stop_date = self::Exists(get_field('offer-date-stop', $id), $todays_date);

        if ($todays_date >= $start_date && $todays_date <= $stop_date) $show_slide = true;
        if (!$show_slide) return array();
        $processed_slide['start_date'] = $start_date;
        $processed_slide['stop_date'] = $stop_date;

        // Image
        $image = get_field('offer-image', $id);
        $processed_slide['image'] = $image['url'];

        // Link
        $link = get_permalink($id);
        $processed_slide['link_url'] = $link;
        $processed_slide['link_title'] = get_the_title($id);
        $processed_slide['link_target'] = '_self';

        // Caption
        $caption_content = self::Exists(get_field('offer-caption-content', $id), false);
        $processed_slide['caption_content'] = $caption_content;

        if ($caption_content) {
            $caption_background_color = 'background: transparent;';
            $caption_background = get_field('offer-caption-color', $id);
            $caption_opacity = get_field('offer-caption-opacity', $id);
            $caption_animation = get_field('offer-caption-animation', $id);
            $caption_border = get_field('offer-caption-border', $id);
            $caption_position = get_field('offer-caption-position', $id);

            // Caption color
            if ($caption_opacity !== 100) {
                $opacity = $caption_opacity * 0.01;
                $caption_background_color = 'background: ' . self::hex2rgba($caption_background, $opacity) . ';';
            } else {
                $caption_background_color = $caption_background;
            }

            if ($caption_background === '')
                $caption_background_color = 'background: transparent;';

            // Caption border
            if ($caption_border === 'true')
                $caption_border_color = 'border: 10px solid ' . self::hex2rgba($caption_background, 0.75) . ';';
            else
                $caption_border_color = 'none';

            // Caption style
            if ($caption_background_color !== '' || $caption_border_color !== '')
                $caption_style = $caption_background_color . $caption_border_color;

            $processed_slide['caption_animation'] = $caption_animation;
            $processed_slide['caption_content'] = $caption_content;
            $processed_slide['caption_style'] = $caption_style;
            $processed_slide['caption_position'] = $caption_position;
        }

        return $processed_slide;
    }

    public function processData($atts)
    {
        # New stuff
        $processed_slides = array();

        if (!empty($atts['slides'])) {
            $slides = vc_param_group_parse_atts($atts['slides']);

            foreach ($slides as $slide) {
                switch ($slide['slide_type']) {
                    case 'image':
                        array_push($processed_slides, self::build_image_slide($slide));
                        break;
                    case 'offer':
                        array_push($processed_slides, self::build_offer_slide($slide));
                        break;
                }
            }
        }

        $atts['slides'] = $processed_slides;

        /*** SETTINGS ***/
        // Slider animation
        $slider_animation = self::Exists($atts['slider_effect'], 'fade');
        $atts['slider_effect'] = $slider_animation;

        // Slider animation speed
        $slider_animation_speed = self::Exists($atts['slider_animation_speed'], '600');
        $atts['slider_animation_speed'] = $slider_animation_speed;

        // Slider speed
        $slider_speed = self::Exists($atts['slider_speed'], '7') * 1000;
        $atts['slider_speed'] = $slider_speed;

        // Arrows
        $slider_arrows = self::Exists($atts['slider_arrows'], 'false');
        $atts['slider_arrows'] = $slider_arrows;

        // Slideshow controls
        $slider_controls = self::Exists($atts['slider_controls'], 'false');
        $atts['slider_controls'] = $slider_controls;

        return $atts;
    }
}

function bb_init_imageslider_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Bildspel',
        'base' => 'imageslider',
        'description' => 'Bildspel med bilder eller existerande erbjudanden',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'front_enqueue_js' => array(
            VCADMINURL . 'assets/js/editor/imageslider_editor.js',
            VCADMINURL . 'assets/js/vendor/jquery-ui.min.js',
            VCADMINURL . 'assets/js/datepicker.js'
        ),
        'front_enqueue_css' => array(
            VCADMINURL . 'assets/css/vendor/jquery-ui.min.css'
        ),
        'params' => array(

            # New stuff
            array(
                'type' => 'param_group',
                'param_name' => 'slides',
                'save_always' => 'yes',
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Typ',
                        'param_name' => 'slide_type',
                        'value' => array(
                            'Bild med text' => 'image',
                            'Erbjudande' => 'offer'
                        )
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => 'Bild',
                        'param_name' => 'image_image',
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => 'Overlay bakgrundsfärg',
                        'param_name' => 'image_overlay_color',
                        'description' => 'Välj vilken färg samt styrka som overlay skall ha.'
                    ),
                    array(
                        'type' => 'wysiwyg',
                        'heading' => 'Textrutans innehåll',
                        'param_name' => 'image_caption_content',
                        'description' => 'Skriv i innehållet som du vill visa i textrutan på bildspelet.'
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => 'Textrutans bakgrundsfärg',
                        'param_name' => 'image_caption_background_color',
                        'description' => 'Välj vilken färg samt styrka som textrutan skall ha.'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Animera textrutan',
                        'param_name' => 'image_caption_animation',
                        'value' => array(
                            'Ingen' => 'none',
                            'Tona in' => 'fade',
                            'Glid in från vänster' => 'left',
                            'Glid in från höger' => 'right'
                        ),
                        'description' => 'Välj om du vill visa textrutan med en animeringseffekt.'
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => 'Visa kantram',
                        'param_name' => 'image_caption_border',
                        'value' => array(
                            'Ja' => '1'
                        ),
                        'description' => 'Bocka i om du vill visa en kantram på textrutan.'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Textrutans position',
                        'param_name' => 'image_caption_position',
                        'value' => array(
                            'Centrerad' => 'center',
                            'Vänster' => 'left',
                            'Höger' => 'right',
                            'Centrerad i överkant' => 'top-center',
                            'Vänster i överkant' => 'top-left',
                            'Höger i överkant' => 'top-right',
                            'Centrerad i underkant' => 'bottom-center',
                            'Vänster i underkant' => 'bottom-left',
                            'Höger i underkant' => 'bottom-right'
                        ),
                        'description' => 'Bestäm var i bilden textrutan skall placeras.'
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => 'Länk',
                        'param_name' => 'image_link',
                        'description' => 'Skapa en länk om du vill länka bilden.'
                    ),
                    array(
                        'type' => 'datepicker',
                        'heading' => 'Visa från',
                        'param_name' => 'image_start_date',
                        'description' => 'Fyll i det datum som bilden skall visas från.',
                    ),
                    array(
                        'type' => 'datepicker',
                        'heading' => 'Visa till',
                        'param_name' => 'image_stop_date',
                        'description' => 'Fyll i det datum som bilden skall visas till.'
                    ),
                    array(
                        'type' => 'cpt',
                        'post_type' => 'offer',
                        'heading' => 'Välj erbjudande',
                        'param_name' => 'offer_offer',
                        'placeholder' => 'Välj erbjudande',
                        'description' => 'Välj ett existerande erbjudande.'
                    )
                )
            ),
            array(
                'type' => 'dropdown',
                'group' => 'Inställningar',
                'heading' => 'Animationseffekt',
                'param_name' => 'slider_effect',
                'value' => array(
                    'Tona in / ut' => 'fade'
                    # 'Glid in / ut' => 'slide'
                ),
                'description' => 'Välj den animationseffekt bilderna skall växla med.'
            ),
            array(
                'type' => 'dropdown',
                'group' => 'Inställningar',
                'heading' => 'Animationshastighet',
                'param_name' => 'slider_animation_speed',
                'value' => array(
                    'Standard' => '600',
                    'Snabb' => '250',
                    'Långsam' => '950'
                ),
                'description' => 'Välj vilken animationshastighet bilderna skall växla med.'
            ),
            array(
                'type' => 'textfield',
                'group' => 'Inställningar',
                'heading' => 'Tid per bild',
                'param_name' => 'slider_speed',
                'value' => '',
                'description' => 'Fyll i det antal sekunder varje bild skall visas i.'
            ),
            array(
                'type' => 'radio',
                'group' => 'Inställningar',
                'heading' => 'Pilar',
                'param_name' => 'slider_arrows',
                'value' => array(
                    'Ja' => 'true',
                    'Nej' => 'false'
                ),
                'description' => 'Välj om du vill visa pilar i bildspelet.'
            ),
            array(
                'type' => 'dropdown',
                'group' => 'Inställningar',
                'heading' => 'Bildkontroller',
                'param_name' => 'slider_controls',
                'value' => array(
                    'Punkter' => 'true',
                    'Inga kontroller' => 'false'
                ),
                'description' => 'Välj vilken typ av bildkontroller som skall visas.'
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_imageslider_params', $map['params']);

    $vcImageSlider = new ImageSliderShortcode($map);
}
add_action('after_setup_theme', 'bb_init_imageslider_shortcode');

?>