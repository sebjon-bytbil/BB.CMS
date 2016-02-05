<?php 
add_action( 'init', "bb_add_param_radio", 10, 0);

function bb_add_param_radio(){
    if (function_exists('add_shortcode_param')) {
        add_shortcode_param( 'radio', "bb_param_radio", VCADMINURL . 'assets/js/radio.js');
    }
}

function bb_param_radio( $settings, $value ){
    $output = '';
    if ( is_array( $value ) ) {
        $value = ''; // fix #1239
    }
    $current_value = strlen( $value ) > 0 ? explode( ",", $value ) : array();
    $values = isset( $settings['value'] ) && is_array( $settings['value'] ) ? $settings['value'] : array( __( 'Yes' ) => 'true' );
    if ( ! empty( $values ) ) {
        foreach ( $values as $label => $v ) {
            $checked = count( $current_value ) > 0 && in_array( $v, $current_value ) ? ' checked="checked"' : '';
            $saveClass = $checked != '' ? 'wpb_vc_param_value' : '';
            $displayInline = isset($settings['display_inline']) && $settings['display_inline'] === false ? "displayblock" : ""; 
            $output .= ' <label class="vc_checkbox-label '. $displayInline .'"><input id="'
            . $settings['param_name'] . '-' . $v . '" value="'
            . $v . '" class="' . $saveClass . ' '
            . $settings['param_name'] . ' ' . $settings['type'] . '" type="radio" name="'
            . $settings['param_name'] . '"'
            . $checked . '> ' . __( $label, "js_composer" ) . '</label>';
        }
    }

    return $output;
}
?>