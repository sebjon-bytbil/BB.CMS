<?php
/**
 * @var $this WPBakeryShortCode_VC_Column
 */
$output = $font_color = $el_class = $width = $offset = '';
extract( shortcode_atts( array(
    'font_color' => '',
    'el_class' => '',
    'width' => '1/1',
    'css' => '',
    'offset' => '',
    "displayascard" => false,
    'icon_bytbil' => '',
    'card_headline' => ''
), $atts ) );
$el_class = $this->getExtraClass( $el_class );
$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );
$el_class .= ' wpb_column vc_column_container';
$style = $this->buildStyle( $font_color );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class, $this->settings['base'], $atts );
if ($displayascard == 'cardicon') {
    $output .= "\n\t" . '<div class="' . $css_class . '"' . $style . '>';
    $output .= "\n\t\t" . '<div class="wpb_wrapper vc_column card' . vc_shortcode_custom_css_class( $css, ' ' ) . '">';
    $output .= "\n\t\t\t" . '<div class="card-header">';
    $output .= "\n\t\t\t\t" . '<span class="card-icon">';
    $output .= "\n\t\t\t\t\t" . '<i class="' . $icon_bytbil . '"></i>';
    $output .= "\n\t\t\t\t" . '</span>';
    $output .= "\n\t\t\t\t" . '<h5 class="card-title">' . $card_headline . '</h5>';
    $output .= "\n\t\t\t" . '</div>';
    $output .= "\n\t\t\t" . '<div class="card-body">';
} else {
    $output .= "\n\t" . '<div class="' . $css_class . ' ' . vc_shortcode_custom_css_class( $css, ' ' ) . '"' . $style . '>';
    $output .= "\n\t\t" . '<div class="wpb_wrapper vc_column">';
}
$output .= "\n\t\t\t\t" . wpb_js_remove_wpautop( $content );
if ($displayascard == 'cardicon') {
    $output .= "\n\t\t\t" . '</div>';
}
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( $el_class ) . "\n";
echo $output;