<?php if ($menu !== '0') : ?>
    <?php

    if($submenu != true) {

        echo '<div class="bb-menu">';

        $defaults = array(
            'menu' => $menu
        );
    } else {

        echo '<div class="bb-menu bb-submenu">';

        $defaults = array(
            'menu' => $menu,
            'submenu' => get_the_ID(),
        );
    }
    wp_nav_menu($defaults);
    ?>
    </div>
<?php endif; ?>
