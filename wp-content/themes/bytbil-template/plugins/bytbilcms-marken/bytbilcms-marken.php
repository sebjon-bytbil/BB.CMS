<?php
/*
Plugin Name: BytBil Märken
Description: Skapa och visa bildmärken.
Author: Sebastian Jonsson : BytBil Nordic AB
Version: 2.0.1
Author URI: http://www.bytbil.com
*/

add_action('init', 'cptui_register_my_cpt_brand');
function cptui_register_my_cpt_brand()
{
    register_post_type('brand', array(
        'label' => 'Märken',
        'description' => '',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'rewrite' => array('slug' => 'brand', 'with_front' => true),
        'query_var' => true,
        'supports' => array('title', 'revisions'),
        'labels' => array(
            'name' => 'Märken',
            'singular_name' => 'Märke',
            'menu_name' => 'Märken',
            'add_new' => 'Lägg till',
            'add_new_item' => 'Lägg till märke',
            'edit' => 'Redigera',
            'edit_item' => 'Redigera märke',
            'new_item' => 'Nytt märke',
            'view' => 'Visa märke',
            'view_item' => 'Visa märke',
            'search_items' => 'Sök märke',
            'not_found' => 'Inga märken hittade',
            'not_found_in_trash' => 'Inga märken i papperskorgen',
            'parent' => 'Märkets förälder',
        )
    ));
}


if (function_exists("register_field_group")) {
    register_field_group(array(
        'id' => 'acf_fordonsmarke',
        'title' => 'Märke',
        'fields' => array(
            array(
                'key' => 'field_5358a619e9438',
                'label' => 'Bild',
                'name' => 'brand_image',
                'type' => 'image',
                'save_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
                'instructions' => 'Ladda upp eller välj ett märke du vill visa i sidhuvudet',
            ),
            array(
                'key' => 'field_5358a70fcf235',
                'label' => 'Länk',
                'name' => 'brand_link',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
                'instructions' => 'Ange vilken adress man skall komma till man klickar på märket',
            ),
            array(
                'key' => 'field_5357d92cb8510',
                'label' => 'Länkbeteende',
                'name' => 'brand_link-target',
                'type' => 'radio',
                'column_width' => '',
                'choices' => array(
                    '_blank' => 'Nytt fönster',
                    '_self' => 'Samma fönster',
                ),
                'default_value' => '_blank',
                'allow_null' => 0,
                'multiple' => 0,
                'instructions' => 'Välj om adressen skall öppnas i nytt eller samma fönster ',
                'layout' => 'horizontal',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'brand',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array(
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array(),
        ),
        'menu_order' => 0,
    ));
}

?>