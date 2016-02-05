<?php
add_action('init', 'bb_add_cptlist', 10, 0);

function bb_add_cptlist()
{
    if (function_exists('add_shortcode_param')) {
        add_shortcode_param('cptlist', 'bb_param_cptlist');
    }
    wp_register_script('Sortable', VCADMINURL . 'assets/js/vendor/Sortable.min.js', array(), '1.0.0', true);
    wp_register_script('cptlist', VCADMINURL . 'assets/js/cptlist.js', array(), '1.0.0', true);
    wp_enqueue_script('Sortable');
    wp_enqueue_script('cptlist');
}

function bb_param_cptlist($settings, $value)
{
    $value = __($value, 'js_composer');

    $output = '';

    $output .= '<div class="cptlist-wrapper">';
    $output .= '<input id="cptlist-input" name="' . $settings['param_name']
        . '" class="wpb_vc_param_value wpb-textinput '
        . $settings['param_name'] . ' ' . $settings['type']
        . '" type="hidden" value="' . $value . '" />';
    $output .= '<div class="cptlist-search"><input type="search" placeholder="Sök" data-posttype="' . $settings['post_type'] . '"></div>';
    $output .= '<div class="cptlist"><ul><li class="cptlist-loading"><img src="' . VCADMINURL . 'assets/images/wpspin_light.gif"></li></ul></div>';
    $output .= '<div class="cptlist-added"><ul><li class="cptlist-loading"><img src="' . VCADMINURL . 'assets/images/wpspin_light.gif"></li></ul></div>';
    $output .= '<div class="clearfix"></div>';
    $output .= '<script>';
    $output .= "var getCptList = new CustomEvent('getCptList', {'detail': '" . $settings['post_type'] . "'});";
    $output .= 'window.dispatchEvent(getCptList);';
    $output .= '</script>';
    $output .= '</div>';

    return $output;
}

add_action('wp_ajax_getcptlist', 'bb_getcptlist');
function bb_getcptlist()
{
    $post_type = sanitize_text_field($_POST['post_type']);

    $data = array();

    $args = array(
        'orderby' => 'title',
        'order' => 'ASC',
        'post_status' => 'publish',
        'post_type' => $post_type,
        'posts_per_page' => -1
    );
    $posts = get_posts($args);

    if (!empty($posts)) {
        foreach ($posts as $i => $post) {
            $data[$i]['id'] = $post->ID;
            $data[$i]['title'] = $post->post_title;
        }
    }

    echo json_encode($data); die();
}

add_action('wp_ajax_searchcptlist', 'bb_searchcptlist');
function bb_searchcptlist()
{
    $post_type = sanitize_text_field($_GET['post_type']);
    $search_string = sanitize_text_field($_GET['value']);

    $return_posts = array();

    $args = array(
        'orderby' => 'title',
        'order' => 'ASC',
        'post_status' => 'publish',
        'post_type' => $post_type,
        'posts_per_page' => -1
    );

    if ($search_string !== '') {
        $args['s'] = $search_string;
    }

    $posts = new WP_Query($args);

    if (!empty($posts)) {
        $i = 0;
        while ($posts->have_posts()) {
            $posts->the_post();
            $return_posts[$i]['id'] = $posts->post->ID;
            $return_posts[$i]['title'] = get_the_title($posts->post->ID);
            $i++;
        }
    }

    wp_reset_postdata();

    echo json_encode($return_posts); die();
}
