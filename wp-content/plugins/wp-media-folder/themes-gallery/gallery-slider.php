<?php
wp_enqueue_script('wpmf-gallery-flexslider');
wp_enqueue_script('wpmf-gallery');
wp_enqueue_style('wpmf-flexslider-style');

$output = '<svg display="none" width="0" height="0" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<defs>
<symbol id="icon-chevron-right" viewBox="0 0 1024 1024">
	<title>chevron-right</title>
	<path class="path1" d="M426.667 256l-60.373 60.373 195.627 195.627-195.627 195.627 60.373 60.373 256-256z"></path>
</symbol>
<symbol id="icon-chevron-left" viewBox="0 0 1024 1024">
	<title>chevron-left</title>
	<path class="path1" d="M657.707 316.373l-60.373-60.373-256 256 256 256 60.373-60.373-195.627-195.627z"></path>
</symbol>
</defs>
</svg>';
$output .= "<div class='wpmf-gallerys'><div id='$selector' data-id='$selector' class='gallery gallery-link-".$link." flexslider carousel wpmfflexslider' data-columns='$columns'>";
$output .= "<ul class='slides wpmf-slides'>";
$i = 0;
$pos = 1;

$height_array= array();
foreach ($attachments as $id => $attachment) {
    $sizes =image_get_intermediate_size($attachment->ID,$size);
    if(!$sizes){
        $img_data = wp_get_attachment_metadata($attachment->ID);
        $height_img = $img_data['height'];
    }else{
        $height_img = $sizes['height'];
    }
    $height_array[] = $height_img;
}

foreach ($attachments as $id => $attachment) {
    $sizes =image_get_intermediate_size($attachment->ID,$size);
    if(!$sizes){
        $sizes = wp_get_attachment_metadata($attachment->ID);
    }
    if(is_numeric($sizes['height']) && $sizes['height'] != 0){
        $ratio = $sizes['width']/$sizes['height'];
    }else{
        $ratio = 1;
    }
    
    $link_target = get_post_meta( $attachment->ID, '_gallery_link_target', true );
    if (!$img = wp_get_attachment_image_src($id, $size))
        continue;
    
    list($src, $width, $height) = $img;
    $alt = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true))); // Use Alt field first
    
    if($columns == 1){
        $image_output = "<img src='{$src}' width='{$width}' height='{$height}' alt='{$alt}' />";
    }else{
        $image_output = "<img src='{$src}' data-ratio='$ratio' width='".max($height_array)*$ratio."' alt='{$alt}' style='width:".max($height_array)*$ratio."px;min-height:".max($height_array)."px !important' />";
    }
    
    if (!empty($link)) {
        if ($customlink) {
            $url = get_post_meta($id, _WPMF_GALLERY_PREFIX . 'custom_image_link', true);
            if($url == '') $url = get_attachment_link($id);
            $image_output = '<a href="' . $url . '" target="' . $link_target . '">' . $image_output . '</a>';
        } else if ('post' === $link) {
            $url = get_attachment_link($id);
            $image_output = '<a href="' . $url . '" target="' . $link_target . '">' . $image_output . '</a>';
        } else if ('file' === $link) {
            //$url = wp_get_attachment_url($id);
            if(get_post_meta($id, _WPMF_GALLERY_PREFIX . 'custom_image_link', true) != ''){
                $lightbox = 0;
                $url = get_post_meta($id, _WPMF_GALLERY_PREFIX . 'custom_image_link', true);
            }else{
                $lightbox = 1;
                $url = wp_get_attachment_url($id);
            }
            $image_output = '<a data-lightbox="'.$lightbox.'" href="' . $url . '" target="' . $link_target . '" title="'.$attachment->post_title.'">' . $image_output . '</a>';
        }else{
            if(get_post_meta($id, _WPMF_GALLERY_PREFIX . 'custom_image_link', true) != ''){
                $lightbox = 0;
                $url = get_post_meta($id, _WPMF_GALLERY_PREFIX . 'custom_image_link', true);
                $image_output = '<a data-lightbox="'.$lightbox.'" href="' . $url . '" target="' . $link_target . '" title="'.$attachment->post_title.'">' . $image_output . '</a>';
            }else{
                if($columns == 1){
                    $image_output = "<img src='{$src}' width='{$width}' height='{$height}' alt='{$alt}' />";
                }else{
                    $image_output = "<img src='{$src}' data-ratio='$ratio' width='".max($height_array)*$ratio."' alt='{$alt}' style='width:".max($height_array)*$ratio."px;min-height:".max($height_array)."px !important' />";
                }
            }
            
        }
    }

    $image_meta = wp_get_attachment_metadata($id);

    $orientation = '';
    if (isset($image_meta['height'], $image_meta['width']))
        $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
    
    
    if($columns == 1){
        $output .= "<li class='wpmf-gg-one-columns gallery-item item gallery-item-position-" . $pos . " gallery-item-attachment-" . $id . "'>";
    }else{
        $output .= "<li class='gallery-item item gallery-item-position-" . $pos . " gallery-item-attachment-" . $id . "' style='min-height:0px;position: relative;height:".max($height_array)."px'>";
    }
    $output .= "<div class='gallery-icon {$orientation}'>$image_output</div>";
    if (trim($attachment->post_excerpt) || trim($attachment->post_title)) {
        $output .= "<div class='wpmf-front-box top'>";
        $output .= "<a>";
        $output .= "<span class='title'>" . wptexturize($attachment->post_title) . " </span>";
        $output .= "<span class='caption'>" . wptexturize($attachment->post_excerpt) . "</span>";
        $output .= "</a>";
        $output .= "</div>";
    }

    $output .= "</li>";
    $pos++;
}


$output .= "</ul>";
$output .= '
            <svg class="icon-wpmf-nav icon-chevron-right"><use xlink:href="#icon-chevron-right"></use></svg>
            <svg class="icon-wpmf-nav icon-chevron-left"><use xlink:href="#icon-chevron-left"></use></svg>
	';
$output .= "</div></div>";
?>
