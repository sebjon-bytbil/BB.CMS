<?php

function sitesettings_get_menus_css($id)
{
    $css = '';

    // Main menu (mm)
    $mm_font = get_field('sitesetting-menus-font-family', $id);
    $mm_font_size = get_field('sitesetting-menus-font-size', $id) . 'px';
    $mm_bg_color = get_field('sitesetting-menus-background', $id);
    $mm_settings = get_field('sitesetting-menus-settings', $id);
    $mm_shadow = get_field('sitesetting-menus-shadow', $id);
    $mm_border = get_field('sitesetting-menus-border', $id);
    $mm_border_radius = get_field('sitesetting-menus-border-radius-val', $id);

    $mm_shadow_css = '';
    $mm_border_css = '';
    $mm_border_radius_css = '';
    $mm_caps_css = '';

    if ($mm_settings) {
        if (in_array('shadow', $mm_settings)) {
            $mm_shadow_css = <<<CSS
-moz-box-shadow: $mm_shadow;
-o-box-shadow: $mm_shadow;
-webkit-box-shadow: $mm_shadow;
box-shadow: $mm_shadow;
CSS;
        }
        if (in_array('border', $mm_settings)) {
            $mm_border_css = <<<CSS
border: $mm_border;
CSS;
        }
        if (in_array('caps', $mm_settings)) {
            $mm_caps_css .= <<<CSS
    text-transform: uppercase;
CSS;
        }
    }

    $mm_link_color = get_field('sitesetting-menus-link-color', $id);
    $mm_link_bg_color = get_field('sitesetting-menus-link-bgcolor', $id);
    $mm_link_effects = get_field('sitesetting-menus-link-effects', $id);

    $mm_link_effects_css = '';

    if ($mm_link_effects) {
        if (in_array('underline', $mm_link_effects)) {
            $mm_link_effects_css .= <<<CSS
    text-decoration: underline;
CSS;
        }
        if (in_array('bold', $mm_link_effects)) {
            $mm_link_effects_css .= <<<CSS
    font-weight: bold;
CSS;
        }
    }

    $mm_link_color_hover = get_field('sitesetting-menus-link-color-hover', $id);
    $mm_link_bg_color_hover = get_field('sitesetting-menus-link-bgcolor-hover', $id);
    $mm_link_effects_hover = get_field('sitesetting-menus-link-effects-hover', $id);

    $mm_link_effects_hover_css = '';

    if ($mm_link_effects_hover) {
        if (in_array('underline', $mm_link_effects_hover)) {
            $mm_link_effects_hover_css .= <<<CSS
    text-decoration: underline;
CSS;
        }
        if (in_array('bold', $mm_link_effects_hover)) {
            $mm_link_effects_hover_css .= <<<CSS
    font-weight: bold;
CSS;
        }
    }

    if ($mm_settings) {
        if (in_array('hover', $mm_settings)) {
            $css .= <<<CSS
@media (min-width: 768px) {
    #menu .nav > li:hover > ul.dropdown-menu, #menu .nav > li:active > ul.dropdown-menu {
        display: block;
    }
}
CSS;
        }
    }

    $css .= <<<CSS
.nav,
.navbar-header,
.navbar-fixed-top {
    background-color: $mm_bg_color;
    $mm_shadow_css;
    $mm_border_css;
    $mm_border_radius_css;
}
.nav > li > a {
    font-family: $mm_font;
    font-size: $mm_font_size;
    /* Menu link background & color */
    background: $mm_link_bg_color !important;
    color: $mm_link_color !important;
    $mm_link_effects_css
    $mm_caps_css
}
.nav > li > a:hover,
.nav > .open > a,
.nav > .open > a:hover,
.nav > .open > a:focus,
.nav .current-menu-parent > a,
.nav .current-menu-item > a,
.nav .current-page-ancestor > a,
.nav > li > a:focus {
    color: $mm_link_color_hover !important;
    background: $mm_link_bg_color_hover !important;
    $mm_link_effects_hover_css
}
CSS;

    // Submenu (sm)
    $sm_font = get_field('sitesetting-submenus-font-family', $id);
    $sm_font_size = get_field('sitesetting-submenus-font-size', $id) . 'px';
    $sm_bg_color = get_field('sitesetting-submenus-background', $id);
    $sm_link_color = get_field('sitesetting-submenus-link-color', $id);
    $sm_link_bg_color = get_field('sitesetting-submenus-link-bgcolor', $id);
    $sm_link_effects = get_field('sitesetting-submenus-link-effect', $id);

    $sm_link_effects_css = '';

    if ($sm_link_effects) {
        if (in_array('underline', $sm_link_effects)) {
            $sm_link_effects_css .= <<<CSS
    text-decoration: underline;
CSS;
        }
        if (in_array('bold', $sm_link_effects)) {
            $sm_link_effects_css .= <<<CSS
    font-weight: bold;
CSS;
        }
        if (in_array('ucase', $sm_link_effects)) {
            $sm_link_effects_css .= <<<CSS
    text-transform: uppercase;
CSS;
        }
    }

    $sm_link_color_hover = get_field('sitesetting-submenus-link-color-hover', $id);
    $sm_link_bg_color_hover = get_field('sitesetting-submenus-link-bgcolor-hover', $id);
    $sm_link_effects_hover = get_field('sitesetting-submenus-link-effect-hover', $id);

    $sm_link_effects_hover_css = '';

    if ($sm_link_effects_hover) {
        if (in_array('underline', $sm_link_effects_hover)) {
            $sm_link_effects_hover_css .= <<<CSS
    text-decoration: underline;
CSS;
        }
        if (in_array('bold', $sm_link_effects_hover)) {
            $sm_link_effects_hover_css .= <<<CSS
    font-weight: bold;
CSS;
        }
    }

    $css .= <<<CSS
.dropdown-menu {
    background-color: $sm_bg_color;
}
.dropdown-menu li > a,
.dropdown-menu li.current-menu-item > a,
.dropdown-menu .dropdown-menu a,
.dropdown-menu .current-page-ancestor > a {
    font-family: $sm_font;
    font-size: $sm_font_size;
    background-color: $sm_bg_color !important;
    color: $sm_link_color !important;
    $sm_link_effects_css
}
.dropdown-menu li {
    color: $sm_link_color !important;
}
.nav ul > li.menu-item-has-children:before {
    color: inherit !important;
}
.dropdown-menu li > a:hover,
.dropdown-menu li > a:focus,
.dropdown-menu .dropdown-menu a:hover,
.dropdown-menu .dropdown-menu a:focus,
.dropdown-menu li.current-menu-item > a:hover {
    background-color: $sm_link_bg_color_hover !important;
    color: $sm_link_color_hover !important;
    font-size: $sm_font_size;
    $sm_link_effects_hover_css
}
.nav ul > li.menu-item-has-children:hover:before {
    color: $sm_link_color_hover !important;
}
CSS;

    return $css;
}
