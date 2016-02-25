<?php

function sitesettings_get_forms_css($id)
{
    $css = '';

    // Fields
    $border_input = get_field('sitesetting-forms-inputs-border', $id);
    $global_border_radius = get_field('sitesetting-forms-border-radius-global', $id);
    if ($global_border_radius) {
        $border_radius = get_field('sitesetting-border-radius-val', $id) . 'px';
    } else {
        $border_radius = get_field('sitesetting-forms-border-radius', $id) . 'px';
    }
    $color = get_field('sitesetting-forms-input-text-color', $id);
    $placholder_color = get_field('sitesetting-forms-placeholder-color', $id);

    // Buttons
    $button_bg_color = get_field('sitesetting-forms-buttons-bgc', $id);
    $button_color = get_field('sitesetting-forms-buttons-color', $id);
    $border_button = get_field('sitesetting-forms-buttons-border', $id);

    $border_button_css = '';
    if ($border_button) {
        $border_button_css = 'border: ' . $border_button;
    }

    $css .= <<<CSS
.field-wrap input[type="text"],
.field-wrap input[type="email"],
.field-wrap input[type="number"],
.field-wrap textarea {
    color: $color;
    border-radius: $border_radius;
}
::-webkit-input-placeholder,
:-moz-placeholder,
::-moz-placeholder,
:-ms-input-placeholder {
    color: $placeholder_color;
}
.field-wrap input[type="submit"],
.field-wrap button {
    background-color: $button_bg_color;
    border-radius: $border_radius;
    color: $button_color;
    $border_button_css;
}
CSS;

    return $css;
}
