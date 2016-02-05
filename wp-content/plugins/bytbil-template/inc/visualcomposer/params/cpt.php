<?php
add_action('init', 'bb_add_cpt', 10, 0);

function bb_add_cpt()
{
    add_shortcode_param('cpt', 'bb_param_cpt');
}

function bb_param_cpt($settings, $value)
{
    $output = '';
    $output .= '<select name="'
        . $settings['param_name']
        . '" class="wpb_vc_param_value wpb-input wpb-select '
        . $settings['param_name']
        . ' ' . $settings['type'] . '">';
    if (is_array($value)) {
        $value = isset($value['value']) ? $value['value'] : array_shift($value);
    }

    $output .= '<option value="0">' . $settings['placeholder'] . '</option>';

    $args = array(
        'post_type' => $settings['post_type'],
        'post_status' => 'publish',
        'posts_per_page' => -1
    );
    $posts = get_posts($args);
    foreach ($posts as $post) {
        $option_label = $post->post_title;
        $option_value = $post->ID;

        $selected = '';
        if ($value !== '' && (string) $option_value === (string) $value) {
            $selected = ' selected="selected"';
        }

        $output .= '<option value="' . $option_value . '"' . $selected . '>'
            . $title_prefix . ' ' . $option_label . '</option>';
    }

    $output .= '</select>';

    return $output;
}
?>
