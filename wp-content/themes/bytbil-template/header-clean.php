<!DOCTYPE html>
<html lang=""<?php if (is_user_logged_in()) {
    echo ' class="push-down-admin-menu"';
} ?>>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <?php sitesettings_seo(); ?>

        <?php sitesettings_favicon(); ?>

        <!-- Webfonts -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>

        <!-- Main -->
        <link href="<?php echo get_template_directory_uri() . '/assets/css/style.min.css?rel=1456756591788'; ?>" rel="stylesheet">
        <?php sitesettings_styles(); ?>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <?php wp_head(); ?>

        <?php sitesettings_custom_code(); ?>
    </head>

    <body<?php if (!WIDE_DESIGN) : ?> class="narrow"<?php endif; ?>>

        <?php if (!WIDE_DESIGN) : ?>
        <div class="wrapper">
        <?php endif; ?>
