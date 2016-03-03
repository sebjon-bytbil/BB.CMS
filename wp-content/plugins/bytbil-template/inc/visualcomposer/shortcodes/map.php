<?php
require_once('shortcode.base.php');

/**
 * Karta
 */
class MapShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function RegisterScripts()
    {
        wp_register_script('map', VCADMINURL . 'assets/js/map.js', array(), '1.0.0', true);
    }

    function EnqueueScripts()
    {
        wp_enqueue_script('map');
    }

    function processData($atts)
    {
        $atts['single'] = false;
        $atts['facilities'] = false;
        $type = self::Exists($atts['map_type'], 'map');
        if ($type === 'facility') {
            if (isset($atts['facility']) && $atts['facility'] !== '') {
                $facilities = array();
                $facility = $atts['facility'];
                $ids = explode(',', $facility);

                foreach ($ids as $i => $id) {
                    $facilities[$i]['name'] = get_the_title($id);

                    $coordinates = array();
                    $visiting_address = get_field('facility-visiting-address', $id);
                    $coordinates['lat'] = $visiting_address['lat'];
                    $coordinates['lng'] = $visiting_address['lng'];
                    $facilities[$i]['coordinates'] = $coordinates;

                    $custom_address = get_field('facility-use-postal-adress', $id);
                    if ($custom_address) {
                        $address = get_field('facility-other-adress', $id);
                    } else {
                        $visiting_address = explode(',', $visiting_address['address']);
                        $address = $visiting_address[0] . ' ' . $visiting_address[1];
                    }
                    $facilities[$i]['address'] = $address;

                    $facilities[$i]['phonenumbers'] = get_field('facility-phonenumbers', $id);

                    $facilities[$i]['emails'] = get_field('facility-emails', $id);
                }

                $atts['facilities'] = $facilities;
                $atts['zoom'] = 14;
            }
        } else if ($type === 'map') {
            $atts['single'] = true;
            $coordinates = self::Exists($atts['map'], '');
            if ($coordinates !== '') {
                $coordinates_expl = explode(',', $coordinates);
                $coordinates = array(
                    'lat' => $coordinates_expl[0],
                    'lng' => $coordinates_expl[1]
                );
                $zoom = $coordinates_expl[2];
            } else {
                $coordinates = array(
                    'lat' => '',
                    'lng' => '',
                );
            }
            $atts['coordinates'] = $coordinates;
            $atts['zoom'] = self::Exists($zoom, '16');
        }

        $prevent_scroll = self::Exists($atts['preventscroll'], '0');
        $atts['preventscroll'] = $prevent_scroll;

        $controls = self::Exists($atts['controls'], '0');
        $atts['controls'] = $controls;

        if (isset($atts['height'])) {
            $height = self::Exists($atts['height'], '300');
            $atts['height'] = $height;
        } else {
            $atts['height'] = 580;
        }

        return $atts;
    }
}

function bb_init_map_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Karta',
        'base' => 'map',
        'description' => 'Karta',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'front_enqueue_js' => array(
            VCADMINURL . 'assets/js/editor/map_editor.js'
        ),
        'params' => array(
            array(
                'type' => 'dropdown',
                'heading' => 'Välj från anläggning eller hitta plats på kartan',
                'param_name' => 'map_type',
                'value' => array(
                    'Anläggning' => 'facility',
                    'Karta' => 'map'
                ),
                'description' => 'Välj om du vill visa en karta från en existerande anläggning eller om du vill hitta en plats på kartan.'
            ),
            array(
                'type' => 'cptlist',
                'post_type' => 'facility',
                'heading' => 'Välj anläggning',
                'param_name' => 'facility',
                'placeholder' => 'Välj anläggning',
                'description' => 'Välj en existerande anläggning.',
                'dependency' => array(
                    'element' => 'map_type',
                    'value' => 'facility'
                )
            ),
            array(
                'type' => 'map',
                'heading' => 'Karta',
                'param_name' => 'map',
                'description' => 'Sök efter den plats som du vill visa på kartan.',
                'dependency' => array(
                    'element' => 'map_type',
                    'value' => 'map'
                )
            ),
            array(
                'type' => 'checkbox',
                'heading' => 'Förhindra scroll',
                'param_name' => 'preventscroll',
                'description' => 'Bocka i om du inte vill att man ska kunna scrolla på kartan.',
                'value' => array(
                    'Ja' => '1'
                )
            ),
            array(
                'type' => 'checkbox',
                'heading' => 'Kontroller',
                'param_name' => 'controls',
                'description' => 'Bocka i om du vill visa kontroller på kartan.',
                'value' => array(
                    'Ja' => '1'
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Höjd',
                'param_name' => 'height',
                'description' => 'Ange höjden i pixlar.',
                'value' => ''
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
    $map['params'] = apply_filters('bb_alter_map_params', $map['params']);

    $vcMap = new MapShortcode($map);
}
add_action('after_setup_theme', 'bb_init_map_shortcode');

?>