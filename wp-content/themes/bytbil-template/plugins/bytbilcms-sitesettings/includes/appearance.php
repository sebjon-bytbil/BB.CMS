<?php

function sitesettings_get_appearance_css($id)
{
    $css = '';

    // Wrapper
    if ($wrapper = get_field('sitesetting-wrapper-width', $id)) {
        $wrapper = $wrapper . 'px';
        $css .= <<<CSS
.container-fluid.wrapper {
    max-width: $wrapper;
}
CSS;
    }

    // Background
    if ($edit_background = get_field('sitesetting-edit-background', $id)) {
        if ($edit_background == 'color') {
            $background = get_field('sitesetting-background-color', $id);
            $css .= <<<CSS
body {
    background-color: $background;
}
CSS;
        } elseif ($edit_background == 'image') {
            $background = get_field('sitesetting-background-image', $id);
            if ($background) {
                $background_url = $background['url'];
                $css .= <<<CSS
body {
    background: url($background_url);
    background-size: cover;
}
CSS;
            }
        }
    }

    // Rounded Corners
    if ($rounded_corners = get_field('sitesetting-border-radius', $id)) {
        $radius = get_field('sitesetting-border-radius-val', $id);
        $radius = $radius . 'px';
        $css .= <<<CSS
button,
a.vc_btn3 {
    border-radius: $radius !important;
}
.wpb_wrapper {
    border-radius: $radius;
    overflow: hidden;
}
CSS;
    }

    // Font
    $header_font = get_field('sitesetting-font-family-header', $id);
    $header_font_size = get_field('sitesetting-font-size-header', $id);
    $header_font_color = get_field('sitesetting-font-color-header', $id);
    $p_font = get_field('sitesetting-font-family-paragraph', $id);
    $p_font_size = get_field('sitesetting-font-size-paragraph', $id);
    $p_font_color = get_field('sitesetting-font-color-paragraph', $id);

    $css .= <<<CSS
body, p {
    font-family: $p_font;
    font-size: $p_font_size;
    color: $p_font_color;
}
h1, h2, h3, h4, h5 {
    font-family: $header_font;
    color: $header_font_color;
}
h1 {
    font-size: $header_font_size;
}
CSS;

    // Links
    $link_color = get_field('sitesetting-link-color', $id);
    $link_effect_css = '';
    if ($link_effect = get_field('sitesetting-link-effect', $id)) {
        if (in_array('underline', $link_effect)) {
            $link_effect_css .= <<<CSS
    text-decoration: underline;
CSS;
        }
        if (in_array('bold', $link_effect)) {
            $link_effect_css .= <<<CSS
    font-weight: bold;
CSS;
        }
    }
    $link_color_hover = get_field('sitesetting-link-color-hover', $id);
    $link_effect_hover_css = '';
    if ($link_effect_hover = get_field('sitesetting-link-effect-hover', $id)) {
        if (in_array('underline', $link_effect_hover)) {
            $link_effect_hover_css .= <<<CSS
    text-decoration: underline;
CSS;
        }
        if (in_array('bold', $link_effect_hover)) {
            $link_effect_hover_css .= <<<CSS
    font-weight: bold;
CSS;
        }
    }
    $css .= <<<CSS
a,
a:link,
a:visited {
    color: $link_color !important;
    $link_effect_css
}
footer a,
footer a:link,
footer a:visited {
    color: $link_color !important;
    $link_effect_css
}
a:hover {
    color: $link_color_hover !important;
    $link_effect_hover_css
}
footer a:hover {
    color: $link_color_hover !important;
    $link_effect_hover_css
}
CSS;

    return $css;
}













































