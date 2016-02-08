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

    function RegisterScripts()
    {
        wp_register_script('flexslider', VCADMINURL . 'assets/js/vendor/jquery.flexslider-min.js', array(), '1.0.0', true);
        wp_register_script('imageslider_functionality', VCADMINURL . 'assets/js/imageslider_functionality.js', array(), '1.0.0', true);
        wp_register_script('imageslider', VCADMINURL . 'assets/js/imageslider.js', array(), '1.0.0', true);
    }

    function EnqueueScripts()
    {
        wp_enqueue_script('flexslider');
        wp_enqueue_script('imageslider_functionality');
        wp_enqueue_script('imageslider');
    }

    private function build_slide_array($item, $prefix)
    {
        $slide = array();
        $slide['type'] = 'image_text';

        // Dates
        $show_slide = false;
        $todays_date = date('Y-m-d');
        $start_date = self::Exists($item[$prefix . 'start_date'], $todays_date);
        $stop_date = self::Exists($item[$prefix . 'stop_date'], $todays_date);

        if ($todays_date >= $start_date && $todays_date <= $stop_date) $show_slide = true;
        if (!$show_slide) return false;

        // Image
        $original = wp_get_attachment_image_src($item[$prefix . 'slider_image'], 'full');
        $slideshow_full = wp_get_attachment_image_src($item[$prefix . 'slider_image'], 'slideshow-full');
        $slideshow_medium = wp_get_attachment_image_src($item[$prefix . 'slider_image'], 'slideshow-medium');

        $slide['image_url'] = $original;
        $slide['image_full_url'] = isset($slideshow_full[0]) ? $slideshow_full[0] : '';
        $slide['image_medium_url'] = isset($slideshow_medium[0]) ? $slideshow_medium[0] : '';

        // Link
        $target = '_blank';
        $url = '';
        $link_type = $item[$prefix . 'link_type'];
        if ($link_type === 'internal') {
            // Get internal page link
            $page_id = self::Exists($item[$prefix . 'link_internal'], '#');
            $url = get_permalink($page_id);
            $target = '_self';
        } elseif ($link_type === 'external') {
            // Get external page link
            $url = self::Exists($item[$prefix . 'link_external'], '#');
        } elseif ($link_type === 'file') {
            // Get file link
            $url = '';
        }
        $slide['slider_link'] = $link_type;
        $slide['url'] = $url;
        $slide['target'] = $target;

        // Overlay
        $overlay_dotted = self::Exists($item[$prefix . 'overlay_dotted'], '0');
        $overlay_background_color = self::Exists($item[$prefix . 'overlay_color'], 'transparent') . ';';
        $explode_overlay = explode(',', $overlay_background_color);
        if ($explode_overlay[3] === '0.01);') {
            $overlay_background_color = 'transparent';
        }
        $slide['overlay_dotted'] = $overlay_dotted;
        $slide['overlay_background_color'] = 'background: ' . $overlay_background_color;

        // Caption
        $caption_content = self::Exists($item[$prefix . 'caption_content'], '');
        $caption_background_color = self::Exists($item[$prefix . 'caption_color'], 'transparent') . ';';
        $caption_animation = self::Exists($item[$prefix . 'caption_animation'], 'fade');
        $caption_border = self::Exists($item[$prefix . 'caption_border'], '0');
        if ($caption_border === '1') {
            // Caption border color
            if (substr($caption_background_color, 0, 1) === '#') {
                $slider_border_color = self::hex2rgba($caption_background_color);
            }
            $expl_caption_bg = explode(',', $caption_background_color);
            $expl_caption_bg[3] = '0.75);';
            $impl_caption_bg = implode(',', $expl_caption_bg);
            $caption_border_color = '10px solid ' . $impl_caption_bg;
        } else {
            $caption_border_color = 'none;';
        }
        $caption_style = 'background:' . $caption_background_color . 'border:' . $caption_border_color;
        $caption_position = self::Exists($item[$prefix . 'caption_position'], 'center');
        $slide['caption_content'] = $caption_content;
        $slide['caption_animation'] = $caption_animation;
        $slide['caption_style'] = $caption_style;
        $slide['caption_position'] = $caption_position;

        return $slide;
    }

    private function build_offer_array($item, $prefix = '')
    {
        $offer = array();
        $id = $item[$prefix . 'offer'];
        $offer['id'] = $id;
        $offer['type'] = 'offer';

        $offer['url'] = get_permalink($id);
        $offer['slider_link'] = 'internal';
        $offer['target'] = '_self';

        // Dates
        $show_slide = false;
        $todays_date = date('Ymd');
        $start_date = get_field('offer-date-start', $id);
        $stop_date = get_field('offer-date-stop', $id);

        if ($start_date === '') $start_date = $todays_date;
        if ($stop_date === '') $stop_date = $todays_date;

        if ($todays_date >= $start_date && $todays_date <= $stop_date) $show_slide = true;
        if (!$show_slide) return false;

        // Image
        $image = get_field('offer-image', $id);
        $offer['image_url'] = isset($image['url']) ? $image['url'] : '';
        $offer['image_full_url'] = isset($image['sizes']['slideshow-full']) ? $image['sizes']['slideshow-full'] : '';
        $offer['image_medium_url'] = isset($image['sizes']['slideshow-medium']) ? $image['sizes']['slideshow-medium'] : '';

        // Caption
        $caption_background_color = 'background: transparent;';
        $caption_content = get_field('offer-caption-content', $id);
        $caption_background = get_field('offer-caption-color', $id);
        $caption_opacity = get_field('offer-caption-opacity', $id);
        $caption_animation = get_field('offer-caption-animation', $id);
        $caption_border = get_field('offer-caption-border', $id);
        $caption_position = get_field('offer-caption-position', $id);

        // Caption color
        if ($caption_opacity != 100) {
            $opacity = $caption_opacity * 0.01;
            $caption_background_color = 'background: ' . self::hex2rgba($caption_background, $opacity) . ';';
        } else {
            $caption_background_color = $caption_background;
        }

        if ($caption_background === '') {
            $caption_background_color = 'background: transparent;';
        }

        // Caption border
        if ($caption_border === 'true') {
            $caption_border_color = 'border: 10px solid ' . self::hex2rgba($caption_background, 0.75) . ';';
        } else {
            $caption_border_color = 'none';
        }

        // Caption style
        if ($caption_background_color !== '' || $caption_border_color !== '') {
            $caption_style = $caption_background_color . $caption_border_color;
        }

        $offer['caption_animation'] = $caption_animation;
        $offer['caption_content'] = $caption_content;
        $offer['caption_style'] = $caption_style;
        $offer['caption_position'] = $caption_position;

        return $offer;
    }

    function processData($atts)
    {
        $slides = array();

        $slider_type = self::Exists($atts['slider_type'], '');
        switch ($slider_type) {
            case 'image_text':
                $slider_items = self::Exists($atts['dep_image_text'], '');
                if ($slider_items !== '') {
                    $slider_items = vc_param_group_parse_atts($slider_items);
                    foreach ($slider_items as $item) {
                        if (false !== ($slide = self::build_slide_array($item, 'dpt_'))) {
                            array_push($slides, $slide);
                        }
                    }
                }
                break;
            case 'offers':
                $slider_items = self::Exists($atts['dep_offers'], '');
                if ($slider_items !== '') {
                    $slider_items = vc_param_group_parse_atts($slider_items);
                    foreach ($slider_items as $item) {
                        if (false !== ($slide = self::build_offer_array($item))) {
                            array_push($slides, $slide);
                        }
                    }
                }
                break;
            case 'both':
                $slider_items = self::Exists($atts['dep_both'], '');
                if ($slider_items !== '') {
                    $slider_items = vc_param_group_parse_atts($slider_items);
                    foreach ($slider_items as $item) {
                        switch ($item['type']) {
                            case 'imgt':
                                if (false !== ($slide = self::build_slide_array($item, 'imgt_'))) {
                                    array_push($slides, $slide);
                                }
                                break;
                            case 'offer':
                                if (false !== ($slide = self::build_offer_array($item, 'offer_'))) {
                                    array_push($slides, $slide);
                                }
                                break;
                            default:
                                continue;
                                break;
                        }
                    }
                }
                break;
        }

        /*** SETTINGS ***/
        // Slider border
        $slider_border = self::Exists($atts['slider_border'], '0');
        if ($slider_border === '1') {
            $slider_border_color = self::Exists($atts['slider_border_color'], 'transparent');
            if (substr($slider_border_color, 0, 1) === '#') {
                $slider_border_color = self::hex2rgba($slider_border_color);
            }
            $expl_border_color = explode(',', $slider_border_color);
            $expl_border_color[3] = '0.75);';
            $impl_border_color = implode(',', $expl_border_color);
            $slider_border_style = 'border: 10px solid ' . $impl_border_color;
            $atts['slider_border_style'] = $slider_border_style;
        }

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
        $slider_thumbnail_size = '';
        $slider_controls = self::Exists($atts['slider_controls'], 'false');
        $atts['slider_controls'] = $slider_controls;
        if ($slider_controls === 'thumbs') {
            $slider_thumbnail_size = 150;
            $slider_controls_thumbs = self::Exists($atts['slider_controls_thumbs'], 'medium');
            if ($slider_controls_thumbs === 'small') {
                $slider_thumbnail_size = 75;
            } elseif ($slider_controls_thumbs === 'large') {
                $slider_thumbnail_size = 290;
            }
            $atts['slider_thumbnail_size'] = $slider_thumbnail_size;
        }

        $atts['slides'] = $slides;

        return $atts;
    }
}

function bb_init_imageslider_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Bildspel',
        'base' => 'imageslider',
        'description' => 'Bildspel med bilder eller existerand erbjudanden',
        'class' => '',
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
            array(
                'type' => 'dropdown',
                'heading' => 'Bildspelstyp',
                'param_name' => 'slider_type',
                'value' => array(
                    'Bilder med text' => 'image_text',
                    'Erbjudanden' => 'offers',
                    'Både och' => 'both'
                ),
                'description' => 'Välj vilken typ av bildspel du vill ha.'
            ),
            array(
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'dep_image_text',
                'save_always' => 'yes',
                'dependency' => array(
                    'element' => 'slider_type',
                    'value' => 'image_text'
                ),
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'value' => '',
                        'heading' => 'Bild',
                        'param_name' => 'dpt_slider_image'
                    ),
                    array(
                        'type' => 'colorpicker',
                        'value' => '',
                        'heading' => 'Overlay bakgrundsfärg',
                        'param_name' => 'dpt_overlay_color',
                        'description' => 'Välj vilken färg samt styrka som overlay skall ha.'
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => 'Prickig overlay',
                        'param_name' => 'dpt_overlay_dotted',
                        'description' => 'Bocka i om du vill ha en prickig overlay.',
                        'value' => array(
                            'Ja' => 1
                        )
                    ),
                    array(
                        'type' => 'wysiwyg',
                        'value' => '',
                        'heading' => 'Textrutans innehåll',
                        'param_name' => 'dpt_caption_content',
                        'description' => 'Skriv i innehållet du vill visa i textrutan på bildspelet.'
                    ),
                    array(
                        'type' => 'colorpicker',
                        'value' => '',
                        'heading' => 'Textrutans bakgrundsfärg',
                        'param_name' => 'dpt_caption_color',
                        'description' => 'Välj vilken färg samt styrka som textrutan skall ha.'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Animera textrutan',
                        'param_name' => 'dpt_caption_animation',
                        'value' => array(
                            'Ingen' => 'none',
                            'Tona in' => 'fade',
                            'Glid in från vänster' => 'left',
                            'Glif in från höger' => 'right'
                        ),
                        'description' => 'Välj om du vill visa textrutan med en animeringseffekt.'
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => 'Visa kantram',
                        'param_name' => 'dpt_caption_border',
                        'description' => 'Bocka i om du vill visa en kantram på textrutan.',
                        'value' => array(
                            'Ja' => '1',
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Textrutans position',
                        'param_name' => 'dpt_caption_position',
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
                        'value' => '',
                        'param_name' => 'dpt_link',
                        'description' => 'Skapa en länk om du vill länka bilden.'
                    ),
                    array(
                        'type' => 'datepicker',
                        'heading' => 'Visa från',
                        'param_name' => 'dpt_start_date',
                        'value' => '',
                        'description' => 'Fyll i det datum bilden skall visas från.'
                    ),
                    array(
                        'type' => 'datepicker',
                        'heading' => 'Visa till',
                        'param_name' => 'dpt_stop_date',
                        'value' => '',
                        'description' => 'Fyll i det datum bilden skall visas till.'
                    )
                )
            ),
            array(
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'dep_offers',
                'save_always' => 'yes',
                'dependency' => array(
                    'element' => 'slider_type',
                    'value' => 'offers'
                ),
                'params' => array(
                    array(
                        'type' => 'cpt',
                        'post_type' => 'offer',
                        'heading' => 'Välj erbjudande',
                        'param_name' => 'offer',
                        'placeholder' => 'Välj erbjudande',
                        'value' => '',
                        'description' => 'Välj ett existerande erbjudande.'
                    )
                )
            ),
            array(
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'dep_both',
                'save_always' => 'yes',
                'dependency' => array(
                    'element' => 'slider_type',
                    'value' => 'both'
                ),
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Typ',
                        'param_name' => 'type',
                        'value' => array(
                            'Bild med text' => 'imgt',
                            'Erbjudande' => 'offer'
                        ),
                        'description' => 'Välj vilken typ du vill ha.'
                    ),
                    array(
                        'type' => 'cpt',
                        'post_type' => 'offer',
                        'heading' => 'Välj erbjudande',
                        'param_name' => 'offer_offer',
                        'placeholder' => 'Välj erbjudande',
                        'value' => '',
                        'description' => 'Välj ett existerande erbjudande.'
                    ),
                    array(
                        'type' => 'attach_image',
                        'value' => '',
                        'heading' => 'Bild',
                        'param_name' => 'imgt_slider_image'
                    ),
                    array(
                        'type' => 'colorpicker',
                        'value' => '',
                        'heading' => 'Overlay backgrundsfärg',
                        'param_name' => 'imgt_overlay_color',
                        'description' => 'Välj vilken färg samt styrka som overlay skall ha.'
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => 'Prickig overlay',
                        'param_name' => 'imgt_overlay_dotted',
                        'description' => 'Bocka i om du vill ha en prickig overlay.',
                        'value' => array(
                            'Ja' => 1
                        )
                    ),
                    array(
                        'type' => 'wysiwyg',
                        'value' => '',
                        'heading' => 'Textrutans innehåll',
                        'param_name' => 'imgt_caption_content',
                        'description' => 'Skriv i innehållet du vill visa i textrutan på bildspelet.'
                    ),
                    array(
                        'type' => 'colorpicker',
                        'value' => '',
                        'heading' => 'Textrutans bakgrundsfärg',
                        'param_name' => 'imgt_caption_color',
                        'description' => 'Välj vilken färg samt styrka som textrutan skall ha.'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Animera textrutan',
                        'param_name' => 'imgt_caption_animation',
                        'value' => array(
                            'Ingen' => 'none',
                            'Tona in' => 'fade',
                            'Glid in från vänster' => 'left',
                            'Glif in från höger' => 'right'
                        ),
                        'description' => 'Välj om du vill visa textrutan med en animeringseffekt.'
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => 'Visa kantram',
                        'param_name' => 'imgt_caption_border',
                        'description' => 'Bocka i om du vill visa en kantram på textrutan.',
                        'value' => array(
                            'Ja' => '1',
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Textrutans position',
                        'param_name' => 'imgt_caption_position',
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
                        'type' => 'dropdown',
                        'heading' => 'ANVÄND WP LINK ISTÄLLET',
                        'param_name' => 'imgt_link_type',
                        'value' => array(
                            'Ingenting' => 'none',
                            'Intern sida' => 'internal',
                            'Extern URL' => 'external',
                            'Fil eller media' => 'file'
                        ),
                        'description' => 'Välj om du vill länka hela bilden till ett innehåll.'
                    ),
                    array(
                        'type' => 'pages',
                        'heading' => 'Sida',
                        'param_name' => 'imgt_link_internal',
                        'value' => '',
                        'description' => 'Välj en sida som bilden skall länka till.'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'URL',
                        'param_name' => 'imgt_link_external',
                        'value' => '',
                        'description' => 'Fyll i en adress som bilden skall länka till.'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => 'Fil',
                        'param_name' => 'imgt_link_file',
                        'value' => '',
                        'description' => 'Välj eller ladda upp en fil som bilden skall länka till.'
                    ),
                    array(
                        'type' => 'datepicker',
                        'heading' => 'Visa från',
                        'param_name' => 'imgt_start_date',
                        'value' => '',
                        'description' => 'Full i det datum bilden skall visas från.'
                    ),
                    array(
                        'type' => 'datepicker',
                        'heading' => 'Visa till',
                        'param_name' => 'imgt_stop_date',
                        'value' => '',
                        'description' => 'Fyll i det datum bilden skall visas till.'
                    )
                )
            ),
            array(
                'type' => 'checkbox',
                'group' => 'Inställningar',
                'heading' => 'Kantram',
                'param_name' => 'slider_border',
                'save_always' => 'true',
                'value' => array(
                    'Ja' => '1'
                ),
                'description' => 'Bocka i om du vill visa en kantram på bildspelet.'
            ),
            array(
                'type' => 'colorpicker',
                'group' => 'Inställningar',
                'heading' => 'Ramfärg',
                'param_name' => 'slider_border_color',
                'value' => '',
                'description' => 'Välj en färg du vill rama in bildspelet med.',
            ),
            array(
                'type' => 'dropdown',
                'group' => 'Inställningar',
                'heading' => 'Animationseffekt',
                'param_name' => 'slider_effect',
                'value' => array(
                    'Tona in / ut' => 'fade',
                    'Glid in / ut' => 'slide'
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
                    'Miniatyrer' => 'thumbs',
                    'Inga kontroller' => 'false'
                ),
                'description' => 'Välj vilken typ av bildkontroller som skall visas.'
            ),
            array(
                'type' => 'dropdown',
                'group' => 'Inställningar',
                'heading' => 'Miniatyrstorlek',
                'param_name' => 'slider_controls_thumbs',
                'value' => array(
                    'Standard' => 'medium',
                    'Små' => 'small',
                    'Stora' => 'large'
                ),
                'description' => 'Välj vilken storlek miniatyrerna skall ha.'
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_imageslider_params', $map['params']);

    $vcImageSlider = new ImageSliderShortcode($map);
}
add_action('after_setup_theme', 'bb_init_imageslider_shortcode');

?>