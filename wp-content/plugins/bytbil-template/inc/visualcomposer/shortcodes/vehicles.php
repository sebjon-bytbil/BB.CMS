<?php
require_once('shortcode.base.php');

/**
 * Personal
 */
class VehiclesShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }


    private function append_vehicle(&$vehicle, $i, $id)
    {
        
        $vehicle[$i]['name'] = get_the_title($id);
        $image = get_field('vehicle-image', $id);
        $vehicle[$i]['image'] = $image['url'];
        $vehicle[$i]['description'] = get_field('vehicle-description', $id);
        $vehicle[$i]['links'] = get_field('vehicle-links', $id);
    }

    public function processData($atts)
    {
        $vehicles = array();
        $ids = self::Exists($atts['vehicles'], false);
        $row_amount = self::Exists($atts['row_amount'], '3');
        $load_more_button = self::Exists($atts['load_more_button'], false);
        
        if ($ids) {
            $expl = explode(',', $ids);

            foreach ($expl as $i => $id) {
                self::append_vehicle($vehicles, $i, $id);
            }
        }
        
        if(count($vehicles) >= $row_amount && $load_more_button != false){
            $atts['load_more_button'] = true;
        } else {
            $atts['load_more_button'] = false;
        }
        
        $atts['vehicles'] = $vehicles;
        $atts['row_amount'] = $row_amount;

        return $atts;
    }
}

function bb_init_vehicles_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Bilmodeller',
        'base' => 'vehicles',
        'description' => 'Visa bilmodeller',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'cptlist',
                'post_type' => 'vehicle',
                'heading' => 'Välj bilmodeller',
                'param_name' => 'vehicles',
                'value' => '',
                'description' => 'Välj ur en lista av personal',
            ),
            array(
                'type' => 'dropdown',
                'heading' => 'Antal per rad',
                'param_name' => 'row_amount',
                'description' => 'Välj antalet som ska synas per rad',
                'value' => array(
                    'En' => 12,
                    'Två' => 6,
                    'Tre' => 4,
                    'Fyra' => 3,
                    'Sex' => 2
                )
            ),
            array(
                'type' => 'checkbox',
                'heading' => 'Ladda fler-knapp',
                'param_name' => 'load_more_button',
                'description' => 'Bocka i om du vill visa en knapp som laddar in fler modeller - istället för alla på en gång.',
                'value' => array(
                    'Ja' => '1'
                )
            )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_vehicles_params', $map['params']);

    $vcVehicles = new VehiclesShortcode($map);
}
add_action('after_setup_theme', 'bb_init_vehicles_shortcode');

?>