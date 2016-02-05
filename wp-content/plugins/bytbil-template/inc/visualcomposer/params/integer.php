<?php 
add_action( 'init', "bb_add_param_integer", 10, 0);

function bb_add_param_integer(){
  if (function_exists('add_shortcode_param')) {
    add_shortcode_param( 'integer', "bb_param_integer");
  }
  
}

function bb_param_integer( $settings, $value ){

    $html = '<div class="my_param_block">';
    $html .= '<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ';
    $html .= esc_attr( $settings['param_name'] ) . ' ';
    $html .= esc_attr( $settings['type'] ) . '_field" type="number" value="' . esc_attr( $value ) . '" ';

    if (isset($settings['min'])) {
      $html .= 'min="' . esc_attr( $settings['min'] ) . '" ';
    }
     if (isset($settings['max'])) {
      $html .= 'max="' . esc_attr( $settings['max'] ) . '" ';
    }

    $html .= '/>';
    $html .= '</div>';
    return $html;
}
?>