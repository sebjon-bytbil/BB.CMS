<?php
add_action('init', 'bb_add_pages', 10, 0);

function bb_add_pages()
{
    add_shortcode_param('pages', 'bb_param_pages');
}

function bb_param_pages($settings, $value)
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

    $pages = get_pages('hierarchical=2');
    foreach ($pages as $page) {
        $option_label = get_the_title($page->ID);
        $option_value = $page->ID;

        $ancestors = get_post_ancestors($page->ID);
        $title_prefix = '';
        for ($i = 0; count($ancestors) > $i; $i++) {
            $title_prefix .= '-';
        }

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
