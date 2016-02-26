<?php
get_header();
?>

<main>
    <section>
    <?php while (have_posts()) : the_post();

        $skip_header = false;
        $image = get_field('offer-image');
        if (!$image)
            $skip_header = true;
        else
            $image = $image['url'];

        // Caption
        $caption_content = get_field('offer-caption-content');

        if ($caption_content) {
            $caption_background_color = 'background: transparent;';
            $caption_background = get_field('offer-caption-color');
            $caption_opacity = get_field('offer-caption-opacity');
            $caption_animation = get_field('offer-caption-animation');
            $caption_border = get_field('offer-caption-border');
            $caption_position = get_field('offer-caption-position');

            // Caption color
            if ($caption_opacity !== 100) {
                $opacity = $caption_opacity * 0.01;
                $caption_background_color = 'background: ' . theme_hex2rgba($caption_background, $opacity) . ';';
            } else {
                $caption_background_color = $caption_background;
            }

            if ($caption_background === '')
                $caption_background_color = 'background: transparent;';

            // Caption border
            if ($caption_border === 'true')
                $caption_border_color = 'border: 10px solid ' . theme_hex2rgba($caption_background, 0.75) . ';';
            else
                $caption_border_color = 'none';

            // Caption style
            if ($caption_background_color !== '' || $caption_border_color !== '')
                $caption_style = $caption_background_color . $caption_border_color;
        }
        ?>

        <?php if ($image) : ?>
        <?php if (!WIDE_DESIGN) : ?>
        <div class="container">
            <div class="col-sm-12">
        <?php endif; ?>
                <div class="flexslider">
                    <ul class="slides">
                        <li style="display: block;">
                            <img src="<?php echo $image; ?>">
                            <?php if ($caption_content) : ?>
                            <div class="caption-wrapper">
                                <div class="caption">
                                    <div class="vertical-align-wrapper" style="<?php echo $overlay_background_color; ?>">
                                        <div class="vertical-align <?php echo $caption_position; ?>">
                                            <div class="horizontal-align">
                                                <div class="caption-contents" style="<?php echo $caption_style; ?>">
                                                <?php echo $caption_content; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
        <?php if (!WIDE_DESIGN) : ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endif ?>

        <?php the_content(); ?>

    <?php endwhile; ?>
    </section>
</main>

<?php get_footer(); ?>
