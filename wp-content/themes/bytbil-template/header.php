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
        <link href="<?php echo get_template_directory_uri() . '/assets/css/style.min.css?rel=1456480538298'; ?>" rel="stylesheet">
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

        <header>

            <?php if (!WIDE_DESIGN) : ?>
            <div class="container-fluid wrapper" id="top">
                <div class="col-xs-12 col-sm-6">
                    <a class="navbar-brand" href="/">
                    <?php sitesettings_logotype(); ?>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6">

                </div>
            </div>
            <nav id="menu">
                <div class="container-fluid">
                    <div class="navbar-header" data-toggle="collapse" data-target="#navbar-collapse">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <i class="ion ion-android-menu"></i>
                        </button>
                        <span class="navbar-brand visible-xs">Meny</span>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <?php
                        $menu = new wp_bootstrap_navwalker();

                        if ($id = sitesettings_check_current_setting()) {
                            if (get_field('sitesetting-menus-settings', $id) && in_array('hover', get_field('sitesetting-menus-settings', $id))) {
                                $menu->setHover(true);
                            }
                        }

                        $hover = $menu->getHover() ? 'hover' : 'click';

                        $menu_string = wp_nav_menu(array(
                            'theme_location' => 'header-menu',
                            'echo' => false,
                            'depth' => 3,
                            'container' => false,
                            'menu_class' => 'nav navbar-nav navbar-menu ' . $hover,
                            'walker' => $menu
                        ));

                        echo $menu_string;
                        ?>
                    </div>
                </div>
            </nav>
            <div class="clearfix"></div>

            <?php else : ?>

            <nav id="menu" class="navbar navbar-fixed-top full-width" role="navigation">
                <div class="container-fluid wrapper">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle slideout" data-toggle="offcanvas" data-target=".navbar-offcanvas" data-canvas="body">
                            <span class="sr-only">Toggle navigation</span>
                        </button>
                        <a class="navbar-brand" href="/">
                            <?php sitesettings_logotype(); ?>
                        </a>
                    </div>

                    <?php
                    $menu = new wp_bootstrap_navwalker();

                    if ($id = sitesettings_check_current_setting()) {
                        if (get_field('sitesetting-menus-settings', $id) && in_array('hover', get_field('sitesetting-menus-settings', $id))) {
                            $menu->setHover(true);
                        }
                    }

                    $hover = $menu->getHover() ? 'hover' : 'click';

                    $menu_string = wp_nav_menu(array(
                        'theme_location' => 'header-menu',
                        'depth' => 2,
                        'container' => 'div',
                        'container_class' => 'navbar-offcanvas offcanvas canvas-slid',
                        'menu_class' => 'nav navbar-nav navbar-right ' . $hover,
                        'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                        'walker' => $menu
                    ));

                    echo $menu_string;
                    ?>

                </div>

                <?php sitesettings_shortlinks(); ?>

            </nav>
            <?php endif; ?>

        </header>
