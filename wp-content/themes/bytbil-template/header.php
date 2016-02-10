<!DOCTYPE html>
<html lang=""<?php if (is_user_logged_in()) {
    echo ' class="push-down-admin-menu"';
} ?>>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <meta property="og:title" content="Facebook Open Graph Meta-tags"/>
        <meta property="og:image" content="./img/icons/apple-touch-icon-152x152.png"/>
        <meta property="og:site_name" content="Title for Facebook"/>
        <meta property="og:description" content="Facebook's Open Graph protocol allows for web developers to turn their websites into Facebook 'graph' objects, allowing a certain level of customization over how information is carried over from a non-Facebook website to Facebook when a page is 'recommended', 'liked', or just generally shared."/>

        <title>BytBil : Bootstrap Template</title>

        <!-- Shortcut Icons -->
        <link rel="shortcut icon" href="">
        <link rel="icon" type="image/x-icon" href="./img/icons/favicon.ico" />
        <link rel="icon" type="image/png" href="./img/icons/favicon.png" />
        <link rel="icon" type="image/gif" href="./img/icons/favicon.gif" />

        <!-- Touch Icons -->
        <link href="#" rel="apple-touch-icon" />
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="./img/iconsapple-touch-icon-57x57.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="./img/iconsapple-touch-icon-114x114.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="./img/iconsapple-touch-icon-72x72.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="./img/iconsapple-touch-icon-144x144.png">
        <link rel="apple-touch-icon-precomposed" sizes="60x60" href="./img/iconsapple-touch-icon-60x60.png">
        <link rel="apple-touch-icon-precomposed" sizes="120x120" href="./img/iconsapple-touch-icon-120x120.png">
        <link rel="apple-touch-icon-precomposed" sizes="76x76" href="./img/iconsapple-touch-icon-76x76.png">
        <link rel="apple-touch-icon-precomposed" sizes="152x152" href="./img/iconsapple-touch-icon-152x152.png">
        <link rel="apple-touch-icon-precomposed" sizes="180x180" href="./img/iconsapple-touch-icon-180x180.png">

        <!-- Webfonts -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>

        <!-- Main -->
        <link href="<?php echo get_template_directory_uri() . '/assets/css/style.min.css?rel=1455106648968'; ?>" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <?php wp_head(); ?>
    </head>

    <body>

        <header>

            <nav class="navbar navbar-fixed-top full-width" role="navigation">
                <div class="container-fluid wrapper">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle slideout" data-toggle="offcanvas" data-target=".navbar-offcanvas" data-canvas="body">
                            <span class="sr-only">Toggle navigation</span>
                        </button>
                        <a class="navbar-brand" href="#">
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/autoking-logotype-neg.png'; ?>" class="logotype" alt="Logotype" title="Logotype">
                        </a>
                    </div>

                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header-menu',
                        'depth' => 2,
                        'container' => 'div',
                        'container_class' => 'navbar-offcanvas offcanvas canvas-slid',
                        'menu_class' => 'nav navbar-nav navbar-right',
                        'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                        'walker' => new wp_bootstrap_navwalker()
                    ));
                    ?>

                </div>
            </nav>

        </header>
