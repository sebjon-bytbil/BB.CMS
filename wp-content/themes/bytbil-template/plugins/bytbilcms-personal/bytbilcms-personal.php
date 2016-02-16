<?php
/*
Plugin Name: BytBil Personal
Description: Skapa och visa Personal.
Author: Sebastian Jonsson : BytBil Nordic AB
Version: 2.0.1
Author URI: http://www.bytbil.com
*/
add_action('init', 'cptui_register_my_cpt_employee');
function cptui_register_my_cpt_employee()
{
    register_post_type('employee', array(
            'label' => 'Personal',
            'description' => '',
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'hierarchical' => false,
            'rewrite' => array('slug' => 'employee', 'with_front' => true),
            'query_var' => true,
            'supports' => array('title', 'revisions', 'thumbnail'),
            'labels' => array(
                'name' => 'Personal',
                'singular_name' => 'Personal',
                'menu_name' => 'Personal',
                'add_new' => 'Lägg till Personal',
                'add_new_item' => 'Lägg till ny Personal',
                'edit' => 'Redigera',
                'edit_item' => 'Redigera Personal',
                'new_item' => 'Ny Personal',
                'view' => 'Visa Personal',
                'view_item' => 'Visa Personal',
                'search_items' => 'Sök Personal',
                'not_found' => 'Ingen Personal hittades',
                'not_found_in_trash' => 'Ingen Personal hittades i papperskorgen',
                'parent' => 'Personalens förälder',
            )
        )
    );
}

add_action('init', 'cptui_register_my_cpt_employee_list');
function cptui_register_my_cpt_employee_list()
{
    register_post_type('employee_list', array(
        'label' => 'Personallistor',
        'description' => '',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=employee',
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'rewrite' => array('slug' => 'employee_list', 'with_front' => true),
        'query_var' => true,
        'supports' => array('title', 'editor', 'revisions'),
        'labels' => array(
            'name' => 'Personallistor',
            'singular_name' => 'Personallista',
            'menu_name' => 'Personallistor',
            'add_new' => 'Lägg till',
            'add_new_item' => 'Lägg till Personallista',
            'edit' => 'Redigera',
            'edit_item' => 'Redigera Personallista',
            'new_item' => 'Ny Personallista',
            'view' => 'Visa Personallista',
            'view_item' => 'Visa Personallista',
            'search_items' => 'Sök Personallista',
            'not_found' => 'Inga Personallistor hittade',
            'not_found_in_trash' => 'Inga Personallistor i papperskorgen',
            'parent' => 'Personallistans förälder',
        )
    ));
}

if (function_exists("register_field_group")) {
    register_field_group(array(
        'id' => 'acf_personal',
        'title' => 'Personal',
        'fields' => array(
            array(
                'key' => 'field_541adbd75e30d',
                'label' => 'Bild',
                'name' => 'employee-image',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_541adbf85e30e',
                'label' => 'Titel',
                'name' => 'employee-jobtitle',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_541adc115e30f',
                'label' => 'Telefonnummer',
                'name' => 'employee-phonenumbers',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_541adc245e310',
                        'label' => 'Rubrik',
                        'name' => 'employee-phonenumber-title',
                        'type' => 'text',
                        'column_width' => '',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'none',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_541adc425e311',
                        'label' => 'Nummer',
                        'name' => 'employee-phonenumber-number',
                        'type' => 'text',
                        'column_width' => '',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'none',
                        'maxlength' => '',
                    ),
                ),
                'row_min' => '',
                'row_limit' => '',
                'layout' => 'table',
                'button_label' => 'Lägg till telefonnummer',
            ),
            array(
                'key' => 'field_541adc705e312',
                'label' => 'E-post',
                'name' => 'employee-email',
                'type' => 'email',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_54123asd3a105b9c',
                'label' => 'Dölj epostaddress',
                'name' => 'employee-email-hide',
                'type' => 'true_false',
                'message' => '',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_541adc875e313',
                'label' => 'Anläggning',
                'name' => 'employee-facility',
                'type' => 'post_object',
                'post_type' => array(
                    0 => 'facility',
                ),
                'taxonomy' => array(
                    0 => 'all',
                ),
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_541adc705ea71',
                'label' => 'Fritext (frivilligt)',
                'name' => 'employee-textarea',
                'type' => 'textarea',
                'maxlength' => -1,
                'rows' => 2,
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'employee',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array(
            'position' => 'acf_after_title',
            'layout' => 'default',
            'hide_on_screen' => array(
                0 => 'permalink',
                1 => 'the_content',
                2 => 'excerpt',
                3 => 'custom_fields',
                4 => 'discussion',
                5 => 'comments',
                6 => 'revisions',
                7 => 'slug',
                8 => 'author',
                9 => 'format',
                10 => 'categories',
                11 => 'tags',
                12 => 'send-trackbacks',
            ),
        ),
        'menu_order' => 0,
    ));

    register_field_group(array(
        'id' => 'acf_personallista',
        'title' => 'Personallista',
        'fields' => array(
            array(
                'key' => 'field_541adde4b2771',
                'label' => 'Personal',
                'name' => 'employee_list',
                'type' => 'relationship',
                'return_format' => 'object',
                'post_type' => array(
                    0 => 'employee',
                ),
                'taxonomy' => array(
                    0 => 'all',
                ),
                'filters' => array(
                    0 => 'search',
                ),
                'result_elements' => array(
                    0 => 'post_title',
                ),
                'max' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'employee_list',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array(
            'position' => 'acf_after_title',
            'layout' => 'default',
            'hide_on_screen' => array(
                0 => 'permalink',
                1 => 'the_content',
                2 => 'excerpt',
                3 => 'custom_fields',
                4 => 'discussion',
                5 => 'comments',
                6 => 'revisions',
                7 => 'slug',
                8 => 'author',
                9 => 'format',
                10 => 'featured_image',
                11 => 'categories',
                12 => 'tags',
                13 => 'send-trackbacks',
            ),
        ),
        'menu_order' => 0,
    ));
}