<?php get_header(); ?>

<main>

    <div>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; endif; ?>
    </div>

</main>

<?php get_footer(); ?>
