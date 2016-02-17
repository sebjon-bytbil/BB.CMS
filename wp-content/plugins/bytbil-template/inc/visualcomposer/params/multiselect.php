<?php
add_action('init', 'bb_add_multiselect', 10, 0);

function bb_add_multiselect()
{
    if (function_exists('add_shortcode_param')) {
        add_shortcode_param('multiselect', 'bb_param_multiselect');
    }

    wp_register_script('multiselect', VCADMINURL . 'assets/js/multiselect.js', array(), '1.0.0', true);
    wp_enqueue_script('multiselect');
}

function bb_param_multiselect($settings, $value)
{
    $output = '';
    $output .= '<select multiple name="'
        . $settings['param_name']
        . '" class="wpb_vc_param_value wpb-input wpb-select '
        . $settings['param_name']
        . ' ' . $settings['type'] . '">';

    if (!is_array($value))
        $value = explode(',', $value);

    $term = (isset($settings['term_tax']) && $settings['term_tax']) ? true : false;

    if ($term) {
        $terms = get_terms($settings['term'], 'hide_empty=0');

        if (count($terms) > 0) {
            foreach ($terms as $tax_term) {
                $option_label = $tax_term->name;
                $option_value = $tax_term->term_id;

                $output .= build_select_option($option_label, $option_value, $value);
            }
        }
    } else {
        $args = array(
            'post_type' => $settings['post_type'],
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        $posts = get_posts($args);

        if (count($posts) > 0) {
            foreach ($posts as $post) {
                $option_label = $post->post_title;
                $option_value = $post->ID;

                $output .= build_select_option($option_label, $option_value, $value);
            }
        }
    }

    $output .= '</select>';

    return $output;
}

function build_select_option($option_label, $option_value, $value)
{
    $selected = '';
    if (!is_null($value)) {
        if (in_array($option_value, $value))
            $selected = ' selected="selected"';
    }

    return '<option value="' . $option_value . '"' . $selected . '>' . $option_label . '</option>';
}

?>
