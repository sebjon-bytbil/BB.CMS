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
    'wrapper' => false,
    'column_link' => false,
), $atts ) );

$link = false;
if ($column_link) {
    $column_link = vc_build_link($column_link);
    $link = $column_link['url'];
}

$el_class = $this->getExtraClass( $el_class );
$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );
$el_class .= ' wpb_column vc_column_container';
$style = $this->buildStyle( $font_color );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class, $this->settings['base'], $atts );
if ($wrapper) {
    $output .= "\n\t" . '<div class="' . str_replace('vc_', '', $css_class) . '">';
    $output .= "\n\t\t" . '<div class="wpb_wrapper ' . vc_shortcode_custom_css_class( $css, ' ' ) . '">';
} else {
    $output .= "\n\t" . '<div class="' . $css_class . ' ' . vc_shortcode_custom_css_class( $css, ' ' ) . '"' . $style . '>';
    $output .= "\n\t\t" . '<div class="wpb_wrapper">';
}
if ($link)
    $output .= "\n\t\t\t" . '<a href="' . $link . '">';
$output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );
if ($link)
    $output .= "\n\t\t\t" . '</a>';
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( $el_class ) . "\n";
echo $output;