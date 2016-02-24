<?php

function sitesettings_get_header_css($id)
{
    $shortlinks = get_field('sitesetting-header-shortlinks', $id);
    if (!$shortlinks || $shortlinks == '')
        return '';

    $css = '';

    $i = 1;
    while (has_sub_fields('sitesetting-header-shortlinks', $id)) {
        if (get_sub_field('sitesetting-header-shortlink-appearance')) {
            $bg_color = get_sub_field('sitesetting-header-shortlink-bgcolor');
            $bg_color_hover = get_sub_field('sitesetting-header-shortlink-bgcolor-hover');
            $text_color = get_sub_field('sitesetting-header-shortlink-color');
            $text_color_hover = get_sub_field('sitesetting-header-shortlink-color-hover');

            $css .= <<<CSS
#link$i.top-menu-link {
    background: $bg_color;
    color: $text_color;
}
a#link$i.top-menu-link:hover {
    background: $bg_color_hover;
    color: $text_color_hover;
}
CSS;
        }
        $i++;
    }

    return $css;
}
