<?php
require_once('shortcode.base.php');

/**
 * Formulär
 */
class FormShortcode extends ShortcodeBase
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

function bb_init_form_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Formulär',
        'base' => 'form',
        'description' => 'Formulär',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'textfield',
                'holder' => '',
                'class' => '',
                'heading' => 'Rubrik',
                'param_name' => 'headline',
                'value' => '',
                'description' => 'Skriv in en rubrik som ska visas i formuläret'
            ),
            array(
                'type' => 'textarea_html',
                'holder' => 'div',
                'class' => 'formcontent',
                'heading' => 'Text',
                'param_name' => 'formcontent',
                'value' => '',
                'description' => 'Skriv in text som ska visas i formuläret'
            ),
            array(
                'type' => 'dropdown',
                'heading' => 'Välj formulär',
                'param_name' => 'form_id',
                'description' => 'Välj ett existerande formulär i listan.',
                'value' => populate_form_values()
            ),
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_form_params', $map['params']);

    $vcForm = new FormShortcode($map);
}
add_action('after_setup_theme', 'bb_init_form_shortcode');

function populate_form_values()
{
    if (!function_exists('ninja_forms_get_all_forms')) {
        return array(
            'Formulär är inte aktiverat' => '0'
        );
    }

    $forms_data = ninja_forms_get_all_forms();
    $forms = array();
    if (!empty($forms_data)) {
        foreach ($forms_data as $i => $v) {
            if (is_array($v)) {
                $forms[$v['name']] = $v['id'];
            }
        }
    } else {
        return array(
            'Hittade inga formulär' => '0'
        );
    }

    return $forms;
}
