<?php if (!empty($slides)) : ?>
<div class="bb-imageslider">
    <div class="bb-slideshow flexslider" id="slideshow-<?php echo $blockid; ?>"
        data-id="<?php echo $blockid; ?>"
        data-slideshow="slider"
        data-animationspeed="<?php echo $slider_animation_speed; ?>"
        data-animation="<?php echo $slider_effect; ?>"
        data-speed="<?php echo $slider_speed; ?>"
        data-arrows="<?php echo $slider_arrows; ?>"
        data-controls="<?php echo $slider_controls; ?>">
        <ul class="slides">
        <?php foreach ($slides as $slide) : ?>
            <li>
            <?php if ($slide['link']) : ?>
                <a href="<?php echo $slide['link_url']; ?>" target="<?php echo $slide['link_target']; ?>" title="<?php echo $slide['link_title']; ?>">
            <?php endif; ?>
                    <img src="<?php echo $slide['image']; ?>">

                    <?php if ($slide['caption_content']) : ?>
                    <div class="caption-wrapper" style="<?php if ($slider_border === '1') { echo $slider_border_style; } ?>">
                        <div class="caption">
                            <div class="vertical-align-wrapper" style="<?php echo $slide['overlay_background_color']; ?>">
                                <div class="vertical-align <?php echo $slide['caption_position']; ?>">
                                    <div class="horizontal-align">
                                        <div class="caption-contents" data-animation="<?php echo $slide['caption_animation']; ?>" style="<?php echo $slide['caption_style']; ?>">
                                        <?php echo $slide['caption_content']; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

            <?php if ($slide['link']) : ?>
                </a>
            <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>

    <script>
    if (window.location !== window.top.location) {
        imageslider.refresh_imageslider();
    }
    </script>
</div>
<?php endif; ?>
