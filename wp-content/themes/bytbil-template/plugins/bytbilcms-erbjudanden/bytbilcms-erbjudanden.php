<?php
/*
Plugin Name: BytBil Erbjudanden
Description: Skapa och visa Erbjudanden.
Author: Sebastian Jonsson : BytBil Nordic AB
Version: 2.0.1
Author URI: http://www.bytbil.com
*/

add_action('init', 'cptui_register_my_cpt_offer');
function cptui_register_my_cpt_offer()
{
    register_post_type('offer', array(
            'label' => 'Erbjudande',
            'description' => '',
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'hierarchical' => false,
            'rewrite' => array('slug' => 'erbjudande', 'with_front' => false),
            'query_var' => true,
            'supports' => array('title', 'revisions'),
            'labels' => array(
                'name' => 'Erbjudande',
                'singular_name' => 'Erbjudande',
                'menu_name' => 'Erbjudanden',
                'add_new' => 'Lägg till erbjudande',
                'add_new_item' => 'Lägg till nytt erbjudande',
                'edit' => 'Redigera',
                'edit_item' => 'Redigera erbjudande',
                'new_item' => 'Nytt erbjudande',
                'view' => 'Visa erbjudande',
                'view_item' => 'Visa erbjudande',
                'search_items' => 'Sök erbjudande',
                'not_found' => 'Inga erbjudanden hittades',
                'not_found_in_trash' => 'Inga erbjudanden i papperskorgen',
                'parent' => 'Erbjudandets förälder',
            )
        )
    );
}

if (function_exists('register_field_group')) {
    register_field_group(array(
        'id' => 'acf_erbjudande',
        'title' => 'Erbjudande',
        'fields' => array(
            array(
                'key' => 'field_541d5526c4384',
                'label' => 'Innehåll',
                'name' => '',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_541d5ac33bef0',
                'label' => 'Ingresstext',
                'name' => 'offer-subheader',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_541d5564c4385',
                'label' => 'Beskrivning',
                'name' => 'offer-description',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
            ),
            array(
                'key' => 'field_541d559bc4386',
                'label' => 'Bild',
                'name' => 'offer-image',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_541d560ec4388',
                'label' => 'Länkar',
                'name' => 'offer-links',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_541d562cc4389',
                        'label' => 'Text',
                        'name' => 'offer-link-text',
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
                        'key' => 'field_541d5643c438a',
                        'label' => 'Länktyp',
                        'name' => 'offer-link-type',
                        'type' => 'radio',
                        'column_width' => '',
                        'choices' => array(
                            'external' => 'Extern URL',
                            'internal' => 'Lokal sida',
                            'file' => 'Fil eller media',
                        ),
                        'other_choice' => 0,
                        'save_other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                    ),
                    array(
                        'key' => 'field_541d5af83bef1',
                        'label' => 'Extern URL',
                        'name' => 'offer-link-external',
                        'type' => 'text',
                        'conditional_logic' => array(
                            'status' => 1,
                            'rules' => array(
                                array(
                                    'field' => 'field_541d5643c438a',
                                    'operator' => '==',
                                    'value' => 'external',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                        'column_width' => '',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'none',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_541d5b103bef2',
                        'label' => 'Lokal sida',
                        'name' => 'offer-link-internal',
                        'type' => 'page_link',
                        'conditional_logic' => array(
                            'status' => 1,
                            'rules' => array(
                                array(
                                    'field' => 'field_541d5643c438a',
                                    'operator' => '==',
                                    'value' => 'internal',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                        'column_width' => '',
                        'post_type' => array(
                            0 => 'page',
                        ),
                        'allow_null' => 0,
                        'multiple' => 0,
                    ),
                    array(
                        'key' => 'field_541d5b2b3bef3',
                        'label' => 'Fil eller media',
                        'name' => 'offer-link-file',
                        'type' => 'file',
                        'conditional_logic' => array(
                            'status' => 1,
                            'rules' => array(
                                array(
                                    'field' => 'field_541d5643c438a',
                                    'operator' => '==',
                                    'value' => 'file',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                        'column_width' => '',
                        'save_format' => 'object',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_541d5688c438b',
                        'label' => 'Länkbeteende',
                        'name' => 'offer-link-target',
                        'type' => 'radio',
                        'column_width' => '',
                        'choices' => array(
                            '_blank' => 'Öppna i nytt fönster',
                            '_self' => 'Öppna i samma fönster',
                        ),
                        'other_choice' => 0,
                        'save_other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                    ),
                ),
                'row_min' => '',
                'row_limit' => '',
                'layout' => 'row',
                'button_label' => 'Lägg till länk',
            ),
            array(
                'key' => 'field_541d56c3c100k',
                'label' => 'Bildspelsinställningar',
                'name' => '',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_541d56c3c101k',
                'label' => 'Textrutans innehåll',
                'name' => 'offer-caption-content',
                'type' => 'wysiwyg',
                'instructions' => 'Skriv i innehållet du vill visa i textrutan på bildspelet.',
                'column_width' => '',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'no',
            ),
            array(
                'key' => 'field_541d56c3c102k',
                'label' => 'Textrutans bakgrundsfärg',
                'name' => 'offer-caption-color',
                'type' => 'color_picker',
                'instructions' => 'Välj vilken färg textrutan skall ha',
                'column_width' => '',
                'default_value' => 'transparent',
            ),
            array(
                'key' => 'field_541d56c3c103k',
                'label' => 'Textrutans styrka',
                'name' => 'offer-caption-opacity',
                'type' => 'number',
                'instructions' => 'Fyll i en styrka för genomskinligheten på textrutans bakgrund.',
                'column_width' => '',
                'default_value' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '%',
                'min' => 0,
                'max' => 100,
                'step' => '',
            ),
            array(
                'key' => 'field_541d56c3c104k',
                'label' => 'Animera textrutan',
                'name' => 'offer-caption-animation',
                'type' => 'select',
                'instructions' => 'Välj om du vill visa textrutan med en animeringseffekt.',
                'column_width' => '',
                'choices' => array(
                    'none' => 'Ingen',
                    'fade' => 'Tona in',
                    'left' => 'Glid in från vänster',
                    'right' => 'Glid in från höger',
                ),
                'default_value' => 'none',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_541d56c3c105k',
                'label' => 'Visa kantram',
                'name' => 'offer-caption-border',
                'type' => 'radio',
                'instructions' => 'Välj om textrutan skall ha en kantram.',
                'column_width' => '',
                'choices' => array(
                    'false' => 'Nej',
                    'true' => 'Ja',
                ),
                'other_choice' => 0,
                'save_other_choice' => 0,
                'default_value' => 'false',
                'layout' => 'horizontal',
            ),
            array(
                'key' => 'field_541d56c3c106k',
                'label' => 'Textrutans position',
                'name' => 'offer-caption-position',
                'type' => 'radio',
                'instructions' => 'Bestäm vart i bilden textrutan skall placeras.',
                'column_width' => '',
                'choices' => array(
                    'center' => 'Centrerad',
                    'left' => 'Vänster',
                    'right' => 'Höger',
                    'top-center' => 'Centrerad i överkant',
                    'top-left' => 'Vänster i överkant',
                    'top-right' => 'Höger i överkant',
                    'bottom-center' => 'Centrerad i underkant',
                    'bottom-left' => 'Vänster i underkant',
                    'bottom-right' => 'Höger i överkant',
                ),
                'other_choice' => 0,
                'save_other_choice' => 0,
                'default_value' => 'center',
                'layout' => 'horizontal',
            ),
            array(
                'key' => 'field_541d56c3c438c',
                'label' => 'Inställningar',
                'name' => '',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_541d56d0c438d',
                'label' => 'Erbjudandet startar',
                'name' => 'offer-date-start',
                'type' => 'date_picker',
                'date_format' => 'yy-mm-dd',
                'display_format' => 'yy-mm-dd',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_541d5700c438e',
                'label' => 'Erbjudandet slutar',
                'name' => 'offer-date-stop',
                'type' => 'date_picker',
                'date_format' => 'yy-mm-dd',
                'display_format' => 'yy-mm-dd',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_541d5712c438f',
                'label' => 'Märken',
                'name' => 'offer-brands',
                'type' => 'relationship',
                'return_format' => 'object',
                'post_type' => array(
                    0 => 'brand',
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
            array(
                'key' => 'field_541d5744c4390',
                'label' => 'Anläggningar',
                'name' => 'offer-facililties',
                'type' => 'relationship',
                'return_format' => 'object',
                'post_type' => array(
                    0 => 'facility',
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
                    'value' => 'offer',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array(
            'position' => 'acf_after_title',
            'layout' => 'default',
            'hide_on_screen' => array(
                0 => 'the_content',
                1 => 'excerpt',
                2 => 'custom_fields',
                3 => 'discussion',
                4 => 'comments',
                5 => 'revisions',
                6 => 'slug',
                7 => 'author',
                8 => 'format',
                9 => 'featured_image',
                10 => 'categories',
                11 => 'tags',
                12 => 'send-trackbacks',
            ),
        ),
        'menu_order' => 0,
    ));
}

if (function_exists('add_image_size')) {
    add_image_size('erbjudande-1170x450', 1170, 450, true);
    add_image_size('erbjudande-585x225', 585, 225, true);
    add_image_size('erbjudande-409x157', 409, 157, true);
    add_image_size('erbjudande-292x112', 292, 112, true);
}

function bytbil_check_offer_date($start_date, $stop_date)
{
    $show_offer = false;

    if (empty($start_date) && !empty($stop_date)) {
        if (date('Ymd') <= $stop_date) {
            $show_offer = true;
        }
    } elseif (!empty($start_date) && empty($stop_date)) {
        if (date('Ymd') >= $start_date) {
            $show_offer = true;
        }
    } elseif (!empty($start_date) && !empty($stop_date)) {
        if (date('Ymd') >= $start_date) {
            if (date('Ymd') <= $stop_date) {
                $show_offer = true;
            }
        }
    } else {
        $show_offer = true;
    }

    return $show_offer;
}

?>