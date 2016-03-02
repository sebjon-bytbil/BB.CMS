<?php

function sitesettings_check_current_setting()
{
    $selected_settings_page = get_option('selected-settings-page');
    if (!$selected_settings_page || $selected_settings_page == 0)
        return false;

    return $selected_settings_page;
}

function sitesettings_get_blog_subdomain()
{
    $blog_details = get_blog_details(get_current_blog_id());
    $domain = $blog_details->domain;
    $domain = explode('.', $domain);

    return $domain[0];
}

function sitesettings_seo()
{
    $id = sitesettings_check_current_setting();

    // Title
    if (get_field('pagesettings-title-tag')) : ?>
        <title><?php the_field('pagesettings-title-tag'); ?></title>
        <meta property="og:title" content="<?php the_field('pagesettings-title-tag'); ?>" />
    <?php elseif (get_field('sitesetting-title-tag', $id)) : ?>
        <title><?php the_field('sitesetting-title-tag', $id); ?></title>
        <meta property="og:title" content="<?php the_field('sitesetting-title-tag', $id); ?>" />
    <?php else : ?>
        <title><?php bloginfo('name'); ?> : <?php wp_title('|', true, 'right'); ?></title>
        <meta property="og:title" content="<?php bloginfo('name'); ?> : <?php wp_title('|', true, 'right'); ?>" />
    <?php endif;

    // Description
    if (get_field('pagesettings-meta-description')) : ?>
        <meta name="description" content="<?php the_field('pagesettings-meta-description'); ?>" />
        <meta property="og:description" content="<?php the_field('pagesettings-meta-description'); ?>" />
    <?php elseif (get_field('sitesetting-meta-description', $id)) : ?>
        <meta name="description" content="<?php the_field('sitesetting-meta-description', $id); ?>" />
        <meta property="og:description" content="<?php the_field('sitesetting-meta-description', $id); ?>" />
    <?php endif;

    // Keywords
    if (get_field('pagesettings-meta-keywords')) : ?>
        <meta name="keywords" content="<?php the_field('pagesettings-meta-keywords'); ?>" />
    <?php elseif (get_field('sitesetting-meta-keywords', $id)) : ?>
        <meta name="keywords" content="<?php the_field('sitesetting-meta-keywords', $id); ?>" />
    <?php endif;

    // Site name ?>
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
    <?php
}

function sitesettings_favicon()
{
    if (!$id = sitesettings_check_current_setting()) {
        return '';
    } else {
        $favicon = get_field('sitesetting-header-favicon', $id);
        if (!$favicon || $favicon == '') {
            return '';
        } else {
            $filetype = substr($favicon, -3);
            if ($filetype == 'png')
                $type = 'image/png';
            elseif ($filetype == 'gif')
                $type = 'image/gif';
            elseif ($filetype == 'ico')
                $type = 'image/x-icon';
            else
                return '';
            ?>
            <link rel="icon" type="<?php echo $type; ?>" href="<?php echo $favicon; ?>" />
            <?php
        }
    }
}

function sitesettings_styles()
{
    $subdomain = sitesettings_get_blog_subdomain();
    if (!$id = sitesettings_check_current_setting())
        return '';

    $css_uri = get_template_directory_uri() . '/plugins/bytbilcms-sitesettings/assets/' . $subdomain . '/' . $subdomain . '-' . $id . '.min.css';
    ?>
    <link href="<?php echo $css_uri; ?>" rel="stylesheet">
    <?php
}

function sitesettings_custom_code()
{
    if (!$id = sitesettings_check_current_setting())
        return '';

    $custom_code = get_field('sitesetting-custom-code', $id);
    if (!$custom_code || $custom_code == '')
        return '';

    if (in_array('css', $custom_code)) {
        $css = get_field('sitesetting-custom-code-css', $id);
        if ($css && $css != '')
            echo $css;
    }
    if (in_array('javascript', $custom_code)) {
        $js = get_field('sitesetting-custom-code-js', $id);
        if ($js && $js != '')
            echo $js;
    }
}

function sitesettings_logotype()
{
    if (!$id = sitesettings_check_current_setting()) {
        return '';
    } else {
        $logotype = get_field('sitesetting-logotype', $id);
        if (!$logotype || $logotype == '') {
            return '';
        } else {
            ?>
            <img src="<?php echo $logotype; ?>" class="logotype" alt="" title="">
            <?php
        }
    }
}

function sitesettings_brands()
{
    if (!$id = sitesettings_check_current_setting()) {
        return '';
    } else {
        $brands = get_field('sitesetting-brands', $id);
        if (!$brands || $brands == '') {
            return '';
        } else { ?>
            <div class="brands"><?php
            foreach ($brands as $brand) :
                $bid = $brand->ID;
                $link = get_field('brand_link', $bid);
                $alt_title = 'Besök ' . $brand->post_title . ' på ' . $link; ?>
                <a target="<?php the_field('brand_link-target', $bid); ?>"
                   href="<?php echo $link; ?>">
                    <img src="<?php the_field('brand_image', $bid); ?>"
                         alt="<?php echo $alt_title; ?>"
                         title="<?php echo $alt_title; ?>">
                </a>
            <?php endforeach; ?></div><?php
        }
    }
}

function sitesettings_shortlinks()
{
    if (!$id = sitesettings_check_current_setting()) {
        return '';
    } else {
        $shortlinks = get_field('sitesetting-header-shortlinks', $id);
        if (!$shortlinks || $shortlinks == '') {
            return '';
        } else {
            ?>
            <div class="header-shortlinks pull-right">
            <?php
            $i = 1;
            while (has_sub_fields('sitesetting-header-shortlinks', $id)) {
                $text = get_sub_field('sitesetting-header-shortlink-text');
                $type = get_sub_field('sitesetting-header-shortlink-type');

                if ($type == 'phone')
                    $url = 'tel:' . get_sub_field('sitesetting-header-shortlink-phone');
                elseif ($type == 'external')
                    $url = get_sub_field('sitesetting-header-shortlink-url');
                elseif ($type == 'internal')
                    $url = get_sub_field('sitesetting-header-shortlink-page');
                elseif ($type == 'email')
                    $url = 'mailto:' . get_sub_field('sitesetting-header-shortlink-email');

                $target = get_sub_field('sitesetting-header-shortlink-target');

                $icon = false;
                if (get_sub_field('sitesetting-header-shortlink-appearance')) {
                    $shortlink_icon = get_sub_field('sitesetting-header-shortlink-icon');
                    if ($shortlink_icon && $shortlink_icon != '')
                        $icon = true;
                }

                $target = get_sub_field('sitesetting-header-shortlink-target');
                ?>

                <a id="link<?php echo $i; ?>" href="<?php echo $url; ?>" target="<?php echo $target; ?>" class="top-menu-link"><?php if ($icon) : ?><i class="ion <?php echo $shortlink_icon; ?>"></i> <?php endif; ?><?php echo $text; ?></a>

                <?php
                $i++;
            }
            ?>
            </div>
            <?php
        }
    }
}

function sitesettings_footer()
{
    if (!$id = sitesettings_check_current_setting()) {
        // "Standard" footer
        include 'includes/footer.php';
    } else {
        $footer = get_field('sitesetting-footer', $id);
        if (!$footer || $footer == '') {
            // "Standard" footer
            include 'includes/footer.php';
        } else {
            ?>
            <footer>
            <?php echo do_shortcode($footer->post_content); ?>
            </footer>
            <?php
        }
    }
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

    include 'includes/header.php';
    $header = sitesettings_get_header_css($id);
    $css .= $header;

    include 'includes/forms.php';
    $forms = sitesettings_get_forms_css($id);
    $css .= $forms;

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
    $output = shell_exec('cd ' . get_template_directory() . ' && /usr/local/bin/node /usr/local/bin/grunt customcss 2>&1');
}
add_action('wp_insert_post', 'sitesettings_on_save', 10, 3);

/**
 * Returns true if directory is empty.
 */
function sitesettings_is_dir_empty($dir)
{
    if (!is_readable($dir)) return false;
    // scandir includes hidden UNIX files, hence 2 (.+..)
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

/**
 * Gets field settings for specified field ID
 */
function sitesettings_get_field_settings($id)
{
    global $ninja_forms_loading;
    global $ninja_forms_processing;

    if (is_object($ninja_forms_processing))
        $row = $ninja_forms_processing->get_field_settings($id);
    elseif (is_object($ninja_forms_loading))
        $row = $ninja_forms_loading->get_field_settings($id);
    else
        $row = null;

    return $row;
}

/**
 * Modifies field wrap classes
 */
function sitesettings_field_wrap_class($field_wrap_class, $id)
{
    $field_wrap_class = str_replace('field-wrap', 'field-wrap form-group', $field_wrap_class);

    return $field_wrap_class;
}

/**
 * Modifies form field classes
 */
function sitesettings_form_field($data, $id)
{
    $settings = sitesettings_get_field_settings($id);

    if (is_null($settings) || empty($settings['type']))
        return $data;

    if (empty($data['class']))
        $data['class'] = '';

    if ($settings['type'] === '_text' ||
        $settings['type'] === '_textarea' ||
        $settings['type'] === '_profile_pass' ||
        $settings['type'] === '_spam' ||
        $settings['type'] === '_number' ||
        $settings['type'] === '_country' ||
        $settings['type'] === '_tax' ||
        $settings['type'] === '_calc') {
        $data['class'] .= ' form-control';
    }

    if ($settings['type'] === '_desc')
        $data['class'] .= ' form-group';

    if ($settings['type'] === '_list') {
        if ($settings['data']['list_type'] !== 'checkbox' && $settings['data']['list_type'] !== 'radio')
            $data['class'] .= ' form-control';
    }

    if ($settings['type'] === '_submit')
        $data['class'] .= ' btn';

    return $data;
}

if (defined('NINJA_FORMS_VERSION')) {
    // Apply bootstrap classes to ninja forms fields
    add_filter('ninja_forms_display_field_wrap_class', 'sitesettings_field_wrap_class', 10, 2);
    add_action('ninja_forms_field', 'sitesettings_form_field', 10, 2);
}
