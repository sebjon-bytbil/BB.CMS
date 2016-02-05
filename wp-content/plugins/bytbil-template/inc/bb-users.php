<?php

// Function for Checking User
function is_user($usertype)
{
    $user = wp_get_current_user();
    if ( in_array( $usertype, (array) $user->roles ) ) {
        return true;
    }
}

// Ta bort användarroller
function bytbil_user_roles()
{
    remove_role('subscriber');
    remove_role('contributor');
    remove_role('editor');
    remove_role('author');

    $user = get_current_user();

    // Läs in Admin inställningar om användaren är inloggad
    if ($user) {
        add_action('admin_enqueue_scripts', 'bytbil_admin_styles');
    }
}
add_action('admin_init', 'bytbil_user_roles');

?>