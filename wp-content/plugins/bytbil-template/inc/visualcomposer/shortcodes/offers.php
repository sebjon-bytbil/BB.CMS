<?php
require_once('shortcode.base.php');

/**
 * Erbjudanden
 */
class OffersShortcode extends ShortcodeBase
{
    function __construct($vcMap)
    {
        parent::__construct($vcMap);
    }

    function processData($atts)
    {
        $brand_dropdown = (self::Exists($atts['brand_dropdown']) == '1') ? true : false;
        $atts['brand_dropdown'] = $brand_dropdown;

        $all_link = (self::Exists($atts['link_all_offers']) == '1') ? true : false;
        $atts['link_all_offers'] = $all_link;

        if ($atts['offers_choice'] == 'all') {

            $show_as_slideshow = (self::Exists($atts['show_as_slideshow']) == '1') ? true : false;
            $atts['show_as_slideshow'] = $show_as_slideshow;

            if ($show_as_slideshow) {
                if (!wp_script_is('flexslider') && !wp_script_is('imageslider_functionality') && !wp_script_is('imageslider')) {
                    wp_register_script('flexslider', VCADMINURL . 'assets/js/vendor/jquery.flexslider-min.js', array(), '1.0.0', true);
                    wp_register_script('imageslider_functionality', VCADMINURL . 'assets/js/imageslider_functionality.js', array(), '1.0.0', true);
                    wp_register_script('imageslider', VCADMINURL . 'assets/js/imageslider.js', array(), '1.0.0', true);
                    wp_enqueue_script('flexslider');
                    wp_enqueue_script('imageslider_functionality');
                    wp_enqueue_script('imageslider');
                }
            }

            $columns = $atts['columns'];

            $relation = array('relation' => 'OR');
            $posts_per_page = $atts['posts_per_page'];

            if($atts['posts_per_page'] == null) {
                $posts_per_page = "-1";
            }

            // Set up the array for brand filtration
            $brand_query = array();
            if($atts['offer_brands']) {
                $offer_brands = explode(",", $atts['offer_brands']);

                foreach($offer_brands as $offer_brand) {
                    array_push(
                        $brand_query,
                        array(
                            'key'       => 'offer-brands',
                            'value'     => $offer_brand,
                            'compare'   => 'LIKE',
                        )
                    );
                }
                $brand_query = array_merge($relation, $brand_query);
            }

            // Set up the array for facility filtration
            $facility_query = array();
            if($atts['offer_facilities']) {
                $offer_facilities = explode(",", $atts['offer_facilities']);

                foreach($offer_facilities as $offer_facility) {
                    array_push(
                        $facility_query,
                        array(
                            'key'       => 'offer-facililties',
                            'value'     => $offer_facility,
                            'compare'   => 'LIKE',
                        )
                    );
                }
                $facility_query = array_merge($relation, $facility_query);
            }

            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $args = array(
                'posts_per_page'    => $posts_per_page,
                'orderby'           => 'date',
                'order'             => 'DESC',
                'paged'             => $paged,
                'post_type'         => 'offer',
                'meta_query'        => array(
                    'relation' => 'AND',
                    $brand_query,
                    $facility_query,
                    array(
                        'relation' => 'AND',
                        array(
                            'relation' => 'OR',
                            array(
                                'key'       => 'offer-date-start',
                                'value'     => date("Ymd"),
                                'compare'   => '<=',
                                'type'      => 'date',
                            ),
                            array(
                                'key'       => 'offer-date-start',
                                'value'     => '',
                                'compare'   => '=',
                            ),
                        ),
                        array(
                            'relation' => 'OR',
                            array(
                                'key'       => 'offer-date-stop',
                                'value'     => date("Ymd"),
                                'compare'   => '>=',
                                'type'      => 'date',
                            ),
                            array(
                                'key'       => 'offer-date-stop',
                                'value'     => '',
                                'compare'   => '=',
                            ),
                        ),
                    ),
                )
            );

            //echo "<pre>"; print_r($args); echo "</pre>"; // Useful for viewing the arguments in their entirety

            $offers = new WP_Query( $args );

            if ( $offers->have_posts() ) :

                $brands = array();
                $items = array();
                $i = 0;

                while ( $offers->have_posts() ) : $offers->the_post();

                    // Headline
                    $items[$i]['id'] = get_the_ID();
                    $items[$i]['headline'] = get_the_title();

                    $items[$i]['permalink'] = get_the_permalink();

                    // Ingress
                    $items[$i]['ingress'] = get_field('offer-subheader');

                    // Image
                    $offer_image = get_field('offer-image');
                    $items[$i]['image'] = $offer_image['url'];
                    $items[$i]['image_medium'] = $offer_image['sizes']['slideshow-medium'];
                    $items[$i]['image_full'] = $offer_image['sizes']['slideshow-full'];

                    // Date
                    $items[$i]['date_stop'] = get_field('offer-date-stop');

                    // Brands
                    $offer_brands = get_field('offer-brands');
                    $brands_list = array();
                    foreach($offer_brands as $offer_brand) {
                        if ($brand_dropdown) {
                            array_push($brands, $offer_brand->post_title);
                        }
                        array_push($brands_list, $offer_brand->post_title);
                    }
                    $items[$i]['brands'] = $brands_list;

                    $links = get_field('offer-links');
                    $links_list = array();
                    foreach($links as $link) {
                        $link_url = "";
                        if ($link['offer-link-external'] != null) {
                            $link_url = $link['offer-link-external'];
                        } else if ($link['offer-link-internal'] != null) {
                            $link_url = $link['offer-link-internal'];
                        } else if ($link['offer-link-file'] != null) {
                            $link_url = $link['offer-link-file']['url'];
                        }

                        $link_target = $link['offer-link-target'];
                        if($link_target == "") {
                            $link_target = "_self";
                        }

                        array_push(
                            $links_list,
                            array(
                                'text' => $link['offer-link-text'],
                                'url' => $link_url,
                                'target' => $link_target
                            )
                        );
                    }
                    $items[$i]['links'] = $links_list;

                    $i++;
                endwhile;

                $atts['items'] = $items;

            endif;

            $atts['pagination_prev'] = get_previous_posts_link( '&lsaquo; Föregående sida' );
            $atts['pagination_separator'] = get_previous_posts_link() ? " &nbsp;|&nbsp; " : "";
            $atts['pagination_next'] = get_next_posts_link( 'Nästa sida &rsaquo;', $offers->max_num_pages );

            wp_reset_query();

        } else {

            $id = self::Exists($atts['offer'], false);
            if ($id) {
                $atts['id'] = $id;
                $image = get_field('offer-image', $id);
                $atts['image_url'] = $image['url'];

                $title = get_the_title($id);
                $atts['title'] = $title;

                $ingress = get_field('offer-subheader', $id);
                $atts['ingress'] = $ingress;

                $permalink = get_the_permalink($id);
                $atts['permalink'] = $permalink;
            }

        }

        if ($brand_dropdown && !empty($brands)) {
            // Register and enqueue jQuery shuffle and BBShuffle
            wp_register_script('jquery-shuffle', VCADMINURL . 'assets/js/vendor/jquery.shuffle.min.js', array(), '1.0.0', true);
            wp_register_script('BBShuffle', VCADMINURL . 'assets/js/BBShuffle.js', array(), '1.0.0', true);
            wp_enqueue_script('jquery-shuffle');
            wp_enqueue_script('BBShuffle');

            $brands = array_unique($brands);
            $atts['brands'] = $brands;
        }

        return $atts;
    }
}

function bb_init_offers_shortcode()
{
    // Map array
    $map = array(
        'name' => 'Erbjudanden',
        'base' => 'offers',
        'description' => 'Visa erbjudanden',
        'class' => '',
        'show_settings_on_create' => true,
        'weight' => 10,
        'category' => 'Innehåll',
        'params' => array(
            array(
                'type' => 'dropdown',
                'heading' => 'Urval av erbjudanden',
                'param_name' => 'offers_choice',
                'value' => array(
                    'Alla erbjudanden' => 'all',
                    'Enskilt erbjudande' => 'single',
                )
            ),
            array(
                'type' => 'cpt',
                'post_type' => 'offer',
                'heading' => 'Välj erbjudande',
                'param_name' => 'offer',
                'placeholder' => 'Välj erbjudande',
                'value' => '',
                'description' => 'Välj ett existerande erbjudande.',
                'dependency' => array(
                    'element' => 'offers_choice',
                    'value' => 'single'
                )
            ),
            array(
                'type' => 'multiselect',
                'post_type' => 'brand',
                'heading' => 'Filtrera på märke',
                'param_name' => 'offer_brands',
                'dependency' => array(
                    'element' => 'offers_choice',
                    'value' => 'all'
                )
            ),
            array(
                'type' => 'multiselect',
                'post_type' => 'facility',
                'heading' => 'Filtrera på ort',
                'param_name' => 'offer_facilities',
                'dependency' => array(
                    'element' => 'offers_choice',
                    'value' => 'all'
                )
            ),
            array(
                'type' => 'checkbox',
                'heading' => 'Visa som bildspel',
                'param_name' => 'show_as_slideshow',
                'value' => array(
                    'Ja' => '1'
                ),
                'dependency' => array(
                    'element' => 'offers_choice',
                    'value' => 'all'
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => 'Kolumner per rad',
                'param_name' => 'columns',
                'placeholder' => 'Kolumner per rad',
                'value' => array(
                    'En' => 12,
                    'Två' => 6,
                    'Tre' => 4,
                    'Fyra' => 3,
                    'Sex' => 2,
                ),
                'dependency' => array(
                    'element' => 'offers_choice',
                    'value' => 'all'
                )
            ),
            array(
                'type' => 'integer',
                'heading' => 'Poster per sida',
                'param_name' => 'posts_per_page',
                'placeholder' => 'Poster per rad',
                'min' => 0,
                'max' => 100,
                'dependency' => array(
                    'element' => 'offers_choice',
                    'value' => 'all'
                )
            ),
            array(
                'type' => 'checkbox',
                'heading' => 'Inkludera sidbläddring',
                'param_name' => 'pagination',
                'value' => array(
                    'Ja' => 1,
                ),
                'dependency' => array(
                    'element' => 'offers_choice',
                    'value' => 'all'
                )
            ),
            array(
                'type' => 'checkbox',
                'heading' => 'Visa märkes-dropdown',
                'param_name' => 'brand_dropdown',
                'description' => 'Bocka i om du vill kunna välja märken i vyn.',
                'value' => array(
                    'Ja' => '1'
                )
            ),
           array(
               'type' => 'checkbox',
               'heading' => 'Länka till alla erbjudanden',
               'param_name' => 'link_all_offers',
               'description' => 'Bocka i om vill visa en länk till alla erbjudanden.',
               'value' => array(
                   'Ja' => '1'
               )
           )
        )
    );

    // Alter params filter
    $map['params'] = apply_filters('bb_alter_offers_params', $map['params']);

    $vcOffers = new OffersShortcode($map);
}
add_action('after_setup_theme', 'bb_init_offers_shortcode');

?>