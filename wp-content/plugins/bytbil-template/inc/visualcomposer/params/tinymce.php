<?php
add_action('init', 'bb_add_wysiwyg', 10, 0);

function bb_add_wysiwyg()
{
    if (function_exists('add_shortcode_param')) {
        add_shortcode_param('wysiwyg', 'bb_param_wysiwyg', VCADMINURL . 'assets/js/vendor/tinymce/tinymce.min.js');
    }

    wp_register_script('wysiwyg_editor', VCADMINURL . 'assets/js/editor/wysiwyg_editor.js', array(), '1.0.0', true);
    wp_enqueue_script('wysiwyg_editor');
}

function bb_param_wysiwyg($settings, $value)
{

    $id = 'wysiwyg' . bb_generate_wysiwyg_id();
    $output = '';
    $output .= '<textarea id="' . $id . '" class="wysiwyg wpb_vc_param_value wpb-textinput ' . implode(' ', $settings['vc_single_param_edit_holder_class']). '" data-id="' . $id . '"></textarea>';

    return $output;
}

function bb_generate_wysiwyg_id($l = 32)
{
    return preg_replace('/([\d])/', '', substr(md5(uniqid(mt_rand(), true)), 0, $l));
}
