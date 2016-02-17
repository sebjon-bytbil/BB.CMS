<?php
/*
Plugin Name: BytBil Nyheter
Description: Skapa och visa Nyheter.
Author: Sebastian Jonsson : BytBil Nordic AB
Version: 2.0.1
Author URI: http://www.bytbil.com
*/

// setup post parent stuff
add_action('admin_menu', function () {
    remove_meta_box('pageparentdiv', 'news', 'normal');
});
add_action('add_meta_boxes', function () {
    add_meta_box('news-parent', 'Föräldrasida', 'news_attributes_meta_box', 'news', 'side', 'high');
});

function news_attributes_meta_box($post)
{
    $post_type_object = get_post_type_object($post->post_type);
    if (true) {
        $pages = wp_dropdown_pages(array('post_type' => 'page', 'selected' => $post->post_parent, 'name' => 'parent_id', 'show_option_none' => __('(no parent)'), 'sort_column' => 'menu_order, post_title', 'echo' => 0));
        if (!empty($pages)) {
            echo $pages;
        } // end empty pages check
    } // end hierarchical check.
}

// Register Custom Post Type
function news_post_type()
{

    $labels = array(
        'name' => _x('Nyheter', 'Post Type General Name', 'text_domain'),
        'singular_name' => _x('Nyhet', 'Post Type Singular Name', 'text_domain'),
        'menu_name' => __('Nyheter', 'text_domain'),
        'parent_item_colon' => __('Nyhetens förälder:', 'text_domain'),
        'all_items' => __('Alla nyheter', 'text_domain'),
        'view_item' => __('Visa Nyhet', 'text_domain'),
        'add_new_item' => __('Lägg till Nyhet', 'text_domain'),
        'add_new' => __('Lägg till Nyhet', 'text_domain'),
        'edit_item' => __('Redigera Nyhet', 'text_domain'),
        'update_item' => __('Uppdatera Nyhet', 'text_domain'),
        'search_items' => __('Sök Nyhet', 'text_domain'),
        'not_found' => __('Inga Nyheter hittade', 'text_domain'),
        'not_found_in_trash' => __('Inga Nyheter i papperskorgen', 'text_domain'),
    );
    $rewrite = array(
        'slug' => 'nyhet',
        'with_front' => false,
        'pages' => true,
        'feeds' => true,
    );
    $args = array(
        'label' => __('news', 'text_domain'),
        'description' => __('En nyhet', 'text_domain'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'revisions',),
        'taxonomies' => array('news_categories'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'rewrite' => $rewrite,
        'capability_type' => 'post',
    );
    register_post_type('news', $args);


    if (get_option("run_perma_flush")) {
        delete_option("run_perma_flush");
        global $wp_rewrite;

        $wp_rewrite->flush_rules(true);
    }
}

// Hook into the 'init' action
add_action('init', 'news_post_type', 0);

add_action('after_setup_theme', 'cptui_register_my_taxes_news_categories',9);
function cptui_register_my_taxes_news_categories()
{
    register_taxonomy('news_categories', array(
        0 => 'news',
    ),
        array('hierarchical' => false,
            'label' => 'Kategorier',
            'show_ui' => true,
            'query_var' => true,
            'show_admin_column' => false,
            'labels' => array(
                'search_items' => 'Kategori',
                'popular_items' => 'Populära kategorier',
                'all_items' => 'Alla kategorier',
                'parent_item' => 'Kategorins förälder',
                'parent_item_colon' => 'Kategorins förälder',
                'edit_item' => 'Redigera kategori',
                'update_item' => 'Uppdatera kategorin',
                'add_new_item' => 'Lägg till kategori',
                'new_item_name' => 'Nytt kategorinamn',
                'separate_items_with_commas' => 'Separera kategorier med kommatecken',
                'add_or_remove_items' => 'Lägg till eller ta bort kategori',
                'choose_from_most_used' => 'Välj bland de mest använda kategorierna',
            )
        ));
}


function bytbil_show_news_feed($posts, $categories = "")
{
    // set up or arguments for our custom query
    if ($posts == 0) {
        $posts = 10;
    }

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    if ($categories != '' && count($categories) != 0) {
        $query_args = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'news_categories',
                    'field' => 'id',
                    'terms' => $categories,
                ),
            ),
            'posts_per_page' => $posts,
            'paged' => $paged
        );

    } else {
        $query_args = array(
            'post_type' => 'news',
            'posts_per_page' => $posts,
            'paged' => $paged
        );
    }

    // create a new instance of WP_Query
    $the_query = new WP_Query($query_args);
    ?>

    <?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); // run the loop ?>
    <article class="news-post">
        <a href="<?php the_permalink(); ?>">
            <h2><?php echo the_title(); ?></h2>

            <div class="excerpt">
                <?php echo excerpt(45); ?>
            </div>
            <span class="date">Skrivet den: <?php echo get_the_date('Y-m-d'); ?></span>
        </a>
    </article>
<?php endwhile; ?>
<?php endif;
    wp_reset_query();
}

?>