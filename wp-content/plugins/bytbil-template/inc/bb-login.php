<?php

// Ändra Loginfönster
function bytbil_login()
{
    wp_enqueue_style('bytbil_admin', plugins_url('css/bytbilcms_login.css', __FILE__));
}
add_action('login_enqueue_scripts', 'bytbil_login');

?>