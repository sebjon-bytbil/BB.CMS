<?php

function sitesettings_get_blog_subdomain()
{
    $blog_details = get_blog_details(get_current_blog_id());
    $domain = $blog_details->domain;
    $domain = explode('.', $domain);

    return $domain[0];
}

function sitesettings_styles()
{
    $subdomain = sitesettings_get_blog_subdomain();
    $selected_settings_page = get_option('selected-settings-page');
    if (!$selected_settings_page || $selected_settings_page == 0)
        return '';

    $css_uri = get_template_directory_uri() . '/plugins/bytbilcms-sitesettings/assets/' . $subdomain . '/' . $subdomain . '-' . $selected_settings_page . '.min.css';
    ?>
    <link href="<?php echo $css_uri; ?>" rel="stylesheet">
    <?php
}

function sitesettings_admin_page()
{
    add_submenu_page('edit.php?post_type=sitesettings', 'Aktiv hemsideinställning', 'Aktiv hemsideinställning', 'manage_options', 'sitesettings-picker', 'sitesettings_init_admin_page');
}
add_action('admin_menu', 'sitesettings_admin_page');

function sitesettings_init_admin_page()
{
    include 'admin-page.php';
}

/**
 * On sitesettings post type creation + update.
 */
function sitesettings_on_save($id, $post, $update)
{
    $post_type = get_post_type($id);

    if ($post_type !== 'sitesettings')
        return;

    $subdomain = sitesettings_get_blog_subdomain();

    if (!file_exists(__DIR__ . '/assets/' . $subdomain)) {
        if (!mkdir(__DIR__ . '/assets/' . $subdomain, 0777, false))
            error_log('Failed to create: ' . __DIR__ . '/assets/' . $subdomain . '/');
    }

    $css = '';

    include 'includes/appearance.php';
    $appearance = sitesettings_get_appearance_css($id);
    $css .= $appearance;

    include 'includes/menus.php';
    $menus = sitesettings_get_menus_css($id);
    $css .= $menus;

    $full_dir_path = __DIR__ . '/assets/' . $subdomain . '/';
    $full_css_path = $full_dir_path . $subdomain . '-' . $id . '.css';

    $dir = __DIR__;

    // Delete old CSS if it exists
    if (file_exists($full_css_path))
        unlink($full_css_path);

    // Create CSS
    touch($full_css_path);
    // Give "everyone" write access
    chmod($full_css_path, 0777);
    // Add the CSS
    file_put_contents($full_css_path, $css);

    // Run grunt task
    $output = shell_exec('cd ' . get_template_directory() . ' && /usr/local/bin/node /usr/local/bin/grunt test 2>&1');
}
add_action('wp_insert_post', 'sitesettings_on_save', 10, 3);

/**
 * Returns true if directory is empty.
 * Counts hidden UNIX files.
 */
function sitesettings_is_dir_empty($dir)
{
    if (!is_readable($dir)) return false;
    return (count(scandir($dir)) == 2);
}

/**
 * On sitesettings post type deletion.
 */
function sitesettings_on_delete($id)
{
    $post_type = get_post_type($id);

    if ($post_type !== 'sitesettings')
        return;

    $subdomain = sitesettings_get_blog_subdomain();
    $full_path = __DIR__ . '/assets/' . $subdomain . '/';

    $css = $full_path . $subdomain . '-' . $id . '.css';
    $cssmin = $full_path . $subdomain . '-' . $id . '.min.css';

    if (file_exists($css))
        unlink($css);

    if (file_exists($cssmin))
        unlink($cssmin);

    if (sitesettings_is_dir_empty($full_path))
        rmdir($full_path);

    $selected_settings_page = get_option('selected-settings-page');
    if ($selected_settings_page == $id)
        delete_option('selected-settings-page');
}
add_action('delete_post', 'sitesettings_on_delete', 10);
