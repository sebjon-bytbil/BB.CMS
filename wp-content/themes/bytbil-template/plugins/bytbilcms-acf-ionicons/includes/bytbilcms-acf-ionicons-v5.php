<?php

class acf_field_ionicons extends acf_field
{
    var $settings,
        $defaults;

    function __construct()
    {
        $this->name = 'ionicons';
        $this->label = __('Ionicons');
        $this->category = __('Content', 'acf');

        $this->settings = array(
            'dir' => get_template_directory_uri() . '/plugins/bytbilcms-acf-ionicons/bytbilcms-acf-ionicons.php',
            'path' => get_template_directory_uri() . '/plugins/bytbilcms-acf-ionicons/bytbilcms-acf-ionicons.php',
            'version' => '1.0.0'
        );

        parent::__construct();
    }

    function render_field($field)
    {
        echo '<select name="' . $field['name'] . '" id="' . $field['name'] . '" class="acf-ionicons">';
        echo '<option value="">' . 'HE-HE' . '</option>';
        echo '</select>';
    }
}

new acf_field_ionicons();
