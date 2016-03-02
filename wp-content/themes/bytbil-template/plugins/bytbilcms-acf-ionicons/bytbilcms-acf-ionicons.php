<?php

class bytbil_acf_ionicons
{
    function __construct()
    {
        // Version 4
        add_action('acf/register_fields', array($this, 'register_fields'));

        // Version 5
        add_action('acf/include_field_types', array($this, 'include_field_types'));
    }

    function register_fields()
    {
        include_once('includes/bytbilcms-acf-ionicons-v4.php');
    }

    function include_field_types()
    {
        include_once('includes/bytbilcms-acf-ionicons-v5.php');
    }
}

new bytbil_acf_ionicons();
