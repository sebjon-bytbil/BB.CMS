<?php
wp_enqueue_script('jquery-masonry');
wp_enqueue_script('wpmf-gallery');
$class[] = "gallery-masonry gallery-portfolio";
$class[] = "galleryid-{$id}";
$class[] = "gallery-columns-{$columns}";
$class[] = "gallery-size-{$size_class}";
$class[] = 'wpmf-gallery-bottomspace-' . $bottomspace;
$class[] = 'wpmf-gallery-clear';

$class = implode(' ', $class);

$padding_portfolio = get_option('wpmf_padding_portfolio');
if(!isset($padding_portfolio) && $padding_portfolio == ''){
    $padding_portfolio = 10;
}
$output = "<div class='wpmf-gallerys'><div id='$selector' data-gutter-width='" . $padding_portfolio . "' data-columns='" . $columns . "' class='{$class}'>";
$i = 0;
$pos = 1;

foreach ($attachments as $id => $attachment) {
    $link_target = get_post_meta( $attachment->ID, '_gallery_link_target', true );
    if ($customlink) {
        $image_output = $this->wpmf_gallery_get_attachment_link($id, $size, false, false, false, $targetsize, $customlink, $link_target);
        $url_image = get_post_meta($id, _WPMF_GALLERY_PREFIX . 'custom_image_link', true);
        if($url_image == '') $url_image = get_attachment_link($id);
        $icon = "<a href='$url_image' title='$attachment->post_title' class='hover_img' target='$link_target'></a><a class='portfolio_lightbox' href='$url_image' title='$attachment->post_title' target='$link_target'>+</a>";
        if($url_image == '') $url_image = get_attachment_link($id);
    } else if (!empty($link) && 'file' === $link) {
        $image_output = $this->wpmf_gallery_get_attachment_link($id, $size, false, false, false, $targetsize, $customlink, $link_target);
        if(strpos($image_output, "data-lightbox='0'")){
            $url_image = get_post_meta($id, _WPMF_GALLERY_PREFIX . 'custom_image_link', true);
            $icon = "<a data-lightbox='0' href='$url_image' title='$attachment->post_title' class='hover_img' target='$link_target'></a><a data-lightbox='0' class='portfolio_lightbox' href='$url_image' title='$attachment->post_title' target='$link_target'>+</a>";
        }else{
            $url_image = wp_get_attachment_url($id);
            $icon = "<a data-lightbox='1' href='$url_image' title='$attachment->post_title' class='hover_img'></a><a data-lightbox='1' class='portfolio_lightbox' href='$url_image' title='$attachment->post_title'>+</a>";
        }

    } else if (!empty($link) && 'none' === $link) {
        if(get_post_meta($id, _WPMF_GALLERY_PREFIX . 'custom_image_link', true) != ''){
            $image_output = $this->wpmf_gallery_get_attachment_link($id, $size, false, false, false, $targetsize, $customlink, $link_target);
            $url_image = get_post_meta($id, _WPMF_GALLERY_PREFIX . 'custom_image_link', true);
            $icon = "<a href='$url_image' title='$attachment->post_title' class='hover_img' target='$link_target'></a><a class='portfolio_lightbox' href='$url_image' title='$attachment->post_title' target='$link_target'>+</a>";
        }else{
            $image_output = wp_get_attachment_image($id, $size, false);
            $icon = "<span class='hover_img'></span><span class='portfolio_lightbox' title='$attachment->post_title'>+</span>";
        }
    } else {
        $image_output = $this->wpmf_gallery_get_attachment_link($id, $size, true, false, false, 'large', false, $link_target);
    }
    
    $image_meta = wp_get_attachment_metadata($id);
    $orientation = '';
    if (isset($image_meta['height'], $image_meta['width']))
        $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
    
    
    $output .= "<div class='gallery-item gallery-item-position-" . $pos . " gallery-item-attachment-" . $id . "'>";
    $output .= "<div class='gallery-icon {$orientation}'>$icon $image_output</div>";
    if (trim($attachment->post_excerpt) || trim($attachment->post_title)) {
        $output .= "<div class='wpmf-caption-text wpmf-gallery-caption'>
                        <span class='title'>" . wptexturize($attachment->post_title) . " </span><br>
                        <span class='excerpt'>" . wptexturize($attachment->post_excerpt) . "</span>
                        </div>";
    }
    $output .= "</div>";

    $pos++;
}

$output .= "</div></div>\n";
?>