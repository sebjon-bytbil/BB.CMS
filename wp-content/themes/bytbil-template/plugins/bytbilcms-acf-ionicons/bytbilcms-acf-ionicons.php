<?php

class bytbil_acf_ionicons
{
    function __construct()
    {
        // Version 4
        add_action('acf/register_fields', array($this, 'register_fields'));
    }

    function register_fields()
    {
        include_once('includes/bytbilcms-acf-ionicons-v4.php');
    }
}

new bytbil_acf_ionicons();
