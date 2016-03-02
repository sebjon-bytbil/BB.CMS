<?php

include_once 'ionicons.php';

class acf_field_ionicons extends acf_field
{
    var $settings,
        $defaults;

    function __construct()
    {
        // Vars
        $this->name = 'ionicons';
        $this->label = __('Ionicons');
        $this->category = __('Content', 'acf');
        $this->defaults = array();

        parent::__construct();

        $this->settings = array(
            'path' => apply_filters('acf/helpers/get_path', __FILE__),
            'basedir' => apply_filters('acf/helpers/get_dir', __FILE__),
            'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
            'version' => '1.0.0'
        );
    }

    function create_options($field)
    {
        $key = $field['name'];

        ?>
        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e('Default Icon', 'acf'); ?></label>
            </td>
            <td>
                <div class="ion-field-wrapper">
                    <div class="ion-live-preview"></div>
                    <?php

                    //do_action('acf/create_field', array(
                        //'type' => 'select',
                        //'name' => 'fields[' . $key . '][default_value]',
                        //'value' => $field['default_value'],
                        //'class' => 'ionicons',
                        //'choices' => array_merge(array('null' => __('Select', 'acf')), $field['choices'])
                    //));

                    ?>
                </div>
            </td>
        </tr>

        <tr class="field_option field_option_<?php echo $this->name; ?>">
            <td class="label">
                <label><?php _e('Allow null?', 'acf'); ?></label>
            </td>
            <td>
                <?php

                do_action('acf/create_field', array(
                    'type' => 'radio',
                    'name' => 'fields[' . $key . '][allow_null]',
                    'value' => $field['allow_null'],
                    'choices' => array(
                        1 => __('Yes', 'acf'),
                        0 => __('No', 'acf'),
                    ),
                    'layout' => 'horizontal',
                ));

                ?>
            </td>
        </tr>
        <?php
    }

    function create_field($field)
    {
        echo '<div class="ion-field-wrapper">';
        echo '<div class="ion-live-preview"></div>';
        echo '<select id="' . $field['id'] . '" name="' . $field['name'] . '" id="' . $field['name'] . '" class="acf-ionicons ' . $field['class'] . ' ion-select2-field">';

        if ($field['allow_null'])
            echo '<option value="">' . __('Select', 'acf') . ' -</option>';

        $icons = get_ionicons();

        if (is_array($icons)) {
            foreach ($icons as $icon) {
                $selected = '';
                if ($icon['value'] == $field['value'])
                    $selected = ' selected="selected"';
                echo '<option value="' . $icon['value'] . '"' . $selected . '>' . $icon['content'] . '</option>';
            }
        }

        echo '</select>';
        echo '</div>';
    }

    function input_admin_enqueue_scripts()
    {
        wp_enqueue_script('acf-input-ionicons-select2', $this->settings['dir'] . '../assets/js/select2/select2.min.js', array(), $this->settings['version']);
        wp_enqueue_script('acf-input-ionicons-edit-input', $this->settings['dir'] . '../assets/js/edit_input.js', array(), $this->settings['version']);
        wp_enqueue_style('acf-input-ionicons-input', $this->settings['dir'] . '../assets/css/input.css', array(), $this->settings['version']);
        wp_enqueue_style('acf-input-ionicons', $this->settings['dir'] . '../assets/css/ionicons.css', array(), $this->settings['version']);
        wp_enqueue_style('acf-input-select2-css', $this->settings['dir'] . '../assets/css/select2.css', array(), $this->settings['version']);
    }

    function field_group_admin_enqueue_scripts()
    {
        wp_enqueue_script('ionicons-select2', $this->settings['dir'] . '../assets/js/select2/select2.min.js', array(), $this->settings['version']);
        wp_enqueue_script('ionicons-create-input', $this->settings['dir'] . '../assets/js/create_input.js', array(), $this->settings['version']);
        wp_enqueue_style('acf-input-ionicons-input', $this->settings['dir'] . '../assets/css/input.css', array(), $this->settings['version']);
        wp_enqueue_style('acf-input-ionicons', $this->settings['dir'] . '../assets/css/ionicons.css', array(), $this->settings['version']);
        wp_enqueue_style('acf-input-ionicons-select2-css', $this->settings['dir'] . '../assets/css/select2.css', array(), $this->settings['version']);
    }
}

new acf_field_ionicons();
