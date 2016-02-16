<?php
/* Custom Taxonomies */
function bbtemplate_register_taxonomies()
{
    // Avdelning
    register_taxonomy(
        'department',
        array(
            0 => 'employee'
        ),
        array(
            'hierarchical' => true,
            'label' => 'Avdelning',
            'show_ui' => true,
            'query_var' => true,
            'show_admin_column' => false,
            'labels' => array(
                'search_items' => 'Avdelning',
                'popular_items' => 'Populära',
                'all_items' => 'Alla',
                'parent_item' => 'Avdelningens förälder',
                'parent_item_colon' => '',
                'edit_item' => 'Redigera',
                'update_item' => 'Uppdatera',
                'add_new_item' => 'Lägg till',
                'new_item_name' => 'Ny avdelning',
                'separate_items_with_commas' => '',
                'add_or_remove_items' => 'Lägg till/ta bort',
                'choose_from_most_used' => 'Välj från populära'
            )
        )
    );

    // Märke
    register_taxonomy(
        'brand',
        array(
            0 => 'employee'
        ),
        array(
            'hierarchical' => true,
            'label' => 'Märke',
            'show_ui' => true,
            'query_var' => true,
            'show_admin_column' => false,
            'labels' => array(
                'search_items' => 'Märke',
                'popular_items' => 'Populära',
                'all_items' => 'Alla',
                'parent_items' => 'Märkets förälder',
                'parent_item_colon' => '',
                'edit_item' => 'Redigera',
                'update_item' => 'Uppdatera',
                'add_new_item' => 'Lägg till',
                'new_item_name' => 'Nytt märke',
                'separate_items_with_commas' => '',
                'add_or_remove_items' => 'Lägg till/ta bort',
                'choose_from_most_used' => 'Välj från populära'
            )
        )
    );
}
add_action('init', 'bbtemplate_register_taxonomies');

/**
 * Automatically adds terms based if they exist or not,
 * upon post creation.
 */
function bbtemplate_add_term($post_id, $post, $update)
{
    if ($update) {
        $post_type = get_post_type($post_id);
        if ($post_type === 'facility') {
            $departments = get_field('facility-departments', $post_id);
            if ($departments) {
                foreach ($departments as $department) {
                    if ($department['facility-department'] !== '') {
                        if (is_null(term_exists($department['facility-department'], 'department'))) {
                            wp_insert_term(
                                $department['facility-department'],
                                'department',
                                array(
                                    'description' => '',
                                    'slug' => $department['facility-department']
                                )
                            );
                        }
                    }
                }
            }
        } elseif ($post_type === 'brand') {
            if (is_null(term_exists($post->post_title, 'brand'))) {
                wp_insert_term(
                    $post->post_title,
                    'brand',
                    array(
                        'description' => '',
                        'slug' => $post->post_title
                    )
                );
            }
        }
    }
}
add_action('wp_insert_post', 'bbtemplate_add_term', 10, 3);
?>
