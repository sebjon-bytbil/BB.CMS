<?php
$settings_pages = get_posts(array(
    'post_type' => 'sitesettings',
    'post_per_page' => -1,
    'orderby' => 'date',
    'order' => 'ASC'
));
?>
<div class="wrap">
    <h1>Väj aktiv hemsideinställning</h1>

    <p>Här kan du välja vilken av hemsideinställningarna som skall användas.</p>

    <form method="post" action="options.php">
        <?php wp_nonce_field('update-options'); ?>
            <input type="radio" name="selected-settings-page" value="0" <?php if (get_option('selected-settings-page') == 0 || !get_option('selected-settings-page')) : ?> checked <?php endif; ?>/>Standard<br/>
        <?php foreach ($settings_pages as $page) : ?>
            <input type="radio" name="selected-settings-page"
                   value="<?php echo $page->ID; ?>" <?php if (get_option('selected-settings-page') == $page->ID) : ?> checked <?php endif; ?>/><?php echo $page->post_title; ?>
            <br/>
        <?php endforeach; ?>

        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="selected-settings-page" />

        <br/><br/><input class="button" type="submit" name="Submit" value="Spara" />
    </form>
</div>