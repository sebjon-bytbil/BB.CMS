<?php get_header(); ?>

<main>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="row">
        <div class="col-xs-12">
            <h2><?php the_title(); ?></h2>
            <p>Publicerad <?php echo the_date('Y-m-d'); ?></p>
            <?php echo wpautop(get_the_content()); ?>
        </div>
    </div>
<?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
