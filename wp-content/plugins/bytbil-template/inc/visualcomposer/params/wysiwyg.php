<?php
add_action('init', 'bb_add_wysiwyg', 10, 0);
function bb_add_wysiwyg()
{
    if (function_exists('add_shortcode_param')) {
        add_shortcode_param('wysiwyg', 'bb_param_wysiwyg');
    }

    if (file_exists(get_stylesheet_directory() . '/vc_params/js/wysiwyg_editor.js')) {
        wp_register_script('wysiwyg_editor', get_stylesheet_directory_uri() . '/vc_params/js/wysiwyg_editor.js', array(), '1.0.0', true);
    } else {
        wp_register_script('wysiwyg_editor', VCADMINURL . 'assets/js/editor/wysiwyg_editor.js', array(), '1.0.0', true);
    }

    wp_localize_script('wysiwyg_editor', 'bb_wysiwyg_css', bb_get_wysiwyg_styles());
    wp_localize_script('wysiwyg_editor', 'bb_wysiwyg_buttons', bb_get_wysiwyg_buttons());
    wp_localize_script('wysiwyg_editor', 'bb_wysiwyg_icons', bb_get_wysiwyg_icons());
    wp_enqueue_script('wysiwyg_editor');
}

function bb_get_wysiwyg_styles()
{
    $style_urls = bb_add_wysiwyg_styles();
    $urls = null;

    if (isset($styles) && is_array($styles) && sizeof($styles) >= 1) {
        $urls = json_encode($style_urls);
    } else {
        $urls = $style_urls;
    }

    $vars = array(
        'urls' => $urls
    );

    return $vars;
}

function bb_add_wysiwyg_styles()
{
    $urls = '';

    return apply_filters('bb_alter_wysiwyg_styles', $urls);
}

function bb_get_wysiwyg_buttons()
{
    $buttons = bb_add_wysiwyg_buttons();

    $vars = array(
        'buttons' => json_encode($buttons)
    );

    return $vars;
}

function bb_add_wysiwyg_buttons()
{
    $buttons = array(
        array(
            'text' => 'Svart',
            'value' => 'black'
        ),
        array(
            'text' => 'Vit',
            'value' => 'white'
        )
    );

    return apply_filters('bb_alter_wysiwyg_buttons', $buttons);
}

function bb_get_wysiwyg_icons()
{
    $icons = bb_add_wysiwyg_icons();

    $vars = array(
        'icons' => json_encode($icons)
    );

    return $vars;
}

function bb_add_wysiwyg_icons()
{
    $icons = array(
        array(
            'text' => 'Ingen',
            'value' => 'none'
        )
    );

    return apply_filters('bb_alter_wysiwyg_icons', $icons);
}

function bb_param_wysiwyg($settings, $value)
{
    $content = htmlspecialchars($value);

    $tinymce = '<textarea id="" class="wysiwyg">' . $content . '</textarea>';

    $hidden = '<input type="hidden" name="' . $settings['param_name']
              . '" class="wysiwyg-input vc_textarea_html_content wpb_vc_param_value '
              . $settings['param_name']
              . '" value="' . $content . '" />';

    $output = $tinymce . $hidden;

    return $output;
}
