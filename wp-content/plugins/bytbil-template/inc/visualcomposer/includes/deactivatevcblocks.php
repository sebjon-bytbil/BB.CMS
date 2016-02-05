<?php

//disable all the things!!
add_action( "init", "removeStandardVCElements", 1, 1 );

function removeStandardVCElements(){
      if (function_exists("vc_remove_element")) {
            vc_remove_element( "layerslider_vc" );
            vc_remove_element( "ninja_forms_dislay_form" ); # Not working as intended
            vc_remove_element( "rev_slider_vc" );
            vc_remove_element( "vc_facebook" );
            vc_remove_element( "vc_accordion" );
            vc_remove_element( "vc_basic_grid" );
            vc_remove_element( "vc_btn" );
            vc_remove_element( "vc_button" );
            vc_remove_element( "vc_button2" );
            vc_remove_element( "vc_carousel" );
            // vc_remove_element( "vc_columninner" );
            vc_remove_element( "vc_column_text" );
            // vc_remove_element( "vc_column" );
            vc_remove_element( "vc_cta_button" );
            vc_remove_element( "vc_cta_button2" );
            vc_remove_element( "vc_cta" );
            vc_remove_element( "vc_customfield" );
            vc_remove_element( "vc_custom_heading" );
            vc_remove_element( "vc_empty_space" );
            vc_remove_element( "vc_flickr" );
            vc_remove_element( "vc_gallery" );
            vc_remove_element( "vc_gitem_animated_block" );
            vc_remove_element( "vc_gitem_col" );
            vc_remove_element( "vc_gitem_image" );
            vc_remove_element( "vc_gitem_post_data" );
            vc_remove_element( "vc_gitem_post_date" );
            vc_remove_element( "vc_gitem_post_excerpt" );
            vc_remove_element( "vc_gitem_post_meta" );
            vc_remove_element( "vc_gitem_post_title" );
            vc_remove_element( "vc_gitem_row" );
            vc_remove_element( "vc_gitem_zone_a" );
            vc_remove_element( "vc_gitem_zone_b" );
            vc_remove_element( "vc_gitem_zone_c" );
            vc_remove_element( "vc_gitem_zone" );
            vc_remove_element( "vc_gitem" );
            vc_remove_element( "vc_gmaps" );
            vc_remove_element( "vc_googleplus" );
            vc_remove_element( "vc_icon" );
            vc_remove_element( "vc_images_carousel" );
            vc_remove_element( "vc_masonry_grid" );
            vc_remove_element( "vc_masonry_media_grid" );
            // you think this is madness? it is!
            // If only VC could have an action to remove all standars it would be easy
            // if they change a name only god will know witch line to remove from this code
            // this code will only grow and induce a heart attack on the future developer.
            // I feel sorry for leaving this but it is the only way.
            // If your mission is to clean this mess. Go get some coffe and a cookie. 
            // if you are here to demonstrate bad code, THIS WAS THE ONLY WAY! 
            // now i'm sad. it's your fault.
            vc_remove_element( "vc_media_grid" );
            vc_remove_element( "vc_message" );
            vc_remove_element( "vc_message_old" );
            vc_remove_element( "vc_pie" );
            vc_remove_element( "vc_pinterest" );
            vc_remove_element( "vc_posts_grid" );
            vc_remove_element( "vc_posts_slider" );
            vc_remove_element( "vc_progress_bar" );
            vc_remove_element( "vc_raw_html" );
            vc_remove_element( "vc_raw_js" );
            // vc_remove_element( "vc_row_inner" );
            // vc_remove_element( "vc_row" );
            vc_remove_element( "vc_separator" );
            vc_remove_element( "vc_single_image" );
            vc_remove_element( "vc_tab" );
            vc_remove_element( "vc_tabs" );
            vc_remove_element( "vc_teaser_grid" );
            vc_remove_element( "vc_text_separator" );
            vc_remove_element( "vc_toggle" );
            vc_remove_element( "vc_toggle_old" );
            vc_remove_element( "vc_tour" );
            vc_remove_element( "vc_tweetmeme" );
            vc_remove_element( "vc_twitter" );
            vc_remove_element( "vc_video" );
            vc_remove_element( "vc_widget_sidebar" );

            //wpstuff.. WHY CAN'T I DISABLE THIS FEATURE???
            vc_remove_element('vc_wp_search');
            vc_remove_element('vc_wp_meta');
            vc_remove_element('vc_wp_recentcomments');
            vc_remove_element('vc_wp_calendar');
            vc_remove_element('vc_wp_pages');
            vc_remove_element('vc_wp_tagcloud');
            vc_remove_element('vc_wp_custommenu');
            vc_remove_element('vc_wp_text');
            vc_remove_element('vc_wp_posts');
            vc_remove_element('vc_wp_categories');
            vc_remove_element('vc_wp_archives');
            vc_remove_element('vc_wp_rss');
      }
}