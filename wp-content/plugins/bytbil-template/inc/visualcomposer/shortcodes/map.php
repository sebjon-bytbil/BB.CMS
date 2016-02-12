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
        $map_type = self::Exists($atts['map_type'], 'map');
        if ($map_type === 'facility') {
            $id = self::Exists($atts['coordinates_facility'], '');
            if ($id !== '') {
                $facility_list = explode(",", $atts['coordinates_facility']);

                $facilities = array();

                $args = array(
                    'posts_per_page'    => -1,
                    'orderby'           => 'title',
                    'order'             => 'ASC',
                    'post_type'         => 'facility',
                );

                $facility_query = new WP_Query( $args );

                if ( $facility_query->have_posts() ) :

                    $i = 0;

                    while ( $facility_query->have_posts() ) : $facility_query->the_post();

                        $facilities[$i]['slug'] = $facility_query->post->post_name;

                        // Facility/location name
                        $facilities[$i]['name'] = get_the_title();

                        // Permalink
                        $facilities[$i]['permalink'] = get_the_permalink();

                        // Visiting address
                        $visiting_address = get_field('facility-visiting-address');
                        $visiting_address = explode(",", $visiting_address['address']);
                        $facilities[$i]['visiting_address_street'] = $visiting_address[0];
                        $facilities[$i]['visiting_address_zip_postal'] = $visiting_address[1];

                        // Postal address
                        $facilities[$i]['use_postal'] = get_field('facility-use-postal-adress');
                        $facilities[$i]['postal_address'] = get_field('facility-other-adress');

                        // Phone numbers
                        $facilities[$i]['phonenumbers'] = get_field('facility-phonenumbers');

                        // E-mail addresses
                        $facilities[$i]['emails'] = get_field('facility-emails');

                        // Departments
                        $facilities[$i]['departments'] = get_field('facility-departments');

                        $i++;

                    endwhile;

                endif;

                wp_reset_query();

                $coordinates = array();

                $i = 0;
                foreach($facility_list as $facility) {
                    if($facility_list[$i] !== "0") { // Temporary solution to a weird bug related to a hex value
                        array_push($coordinates, get_field('facility-visiting-address', $facility_list[$i]));
                    }
                    $i++;
                }
            }

            $atts['facilities'] = $facilities;
            $atts['coordinates_list'] = $coordinates;
            $atts['zoom'] = 14;

        } else if ($map_type === 'map') {
            $coordinates = self::Exists($atts['coordinates_map'], '');
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
                'param_name' => 'coordinates_facility',
                'placeholder' => 'Välj anläggning',
                'value' => '',
                'description' => 'Välj en existerande anläggning.'
            ),
            array(
                'type' => 'map',
                'heading' => 'Karta',
                'param_name' => 'coordinates_map',
                'value' => '',
                'description' => 'Sök efter den plats som du vill visa på kartan.'
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
                'type' => 'checkbox',
                'heading' => 'Anläggningskort',
                'param_name' => 'map_departments',
                'description' => 'Bocka i om du vill visa anläggningskort ovanpå kartan.',
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