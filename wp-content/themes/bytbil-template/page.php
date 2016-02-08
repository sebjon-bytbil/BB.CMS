<?php get_header(); ?>

<main>
    <section>
        <div class="container-fluid wrapper align-center">
        <?php while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
