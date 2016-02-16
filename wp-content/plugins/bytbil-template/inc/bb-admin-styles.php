<?php
// Load Admin Styles and Scripts
function bytbil_admin_styles()
{
    wp_enqueue_style('ionicons', plugins_url('inc/visualcomposer/assets/css/ionicons.min.css', __FILE__));
    wp_enqueue_style('bytbil_admin', plugins_url('css/bb-hemsida-admin.css', __FILE__));
    wp_enqueue_script('bytbil_admin', plugins_url('js/bb-hemsida-admin.js', __FILE__), array('jquery'));
}
add_action('wp_enqueue_scripts', 'bytbil_admin_styles');
?>