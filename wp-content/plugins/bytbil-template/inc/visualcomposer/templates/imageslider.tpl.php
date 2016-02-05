<div class="bb-imageslider">
    <div class="bb-slideshow flexslider" id="slideshow-<?php echo $blockid; ?>"
        data-id="<?php echo $blockid; ?>"
        data-slideshow="slider"
        data-animationspeed="<?php echo $slider_animation_speed; ?>"
        data-animation="<?php echo $slider_effect; ?>"
        data-speed="<?php echo $slider_speed; ?>"
        data-arrows="<?php echo $slider_arrows; ?>"
        data-controls="<?php echo $slider_controls; ?>"
        <?php if ($slider_controls === 'thumbs') { echo ' data-thumbnailsize="' . $slider_thumbnail_size . '"'; } ?>>
        <ul class="slides">
        <?php foreach ($slides as $slide) : ?>
            <li>
            <?php if ($slide['slider_link'] !== 'none') : ?>
                <a href="<?php echo $slide['url']; ?>" target="<?php echo $slide['target']; ?>">
            <?php endif; ?>
                    <img src="<?php echo $slide['image_url']; ?>"
                         srcset="<?php echo $slide['image_full_url']; ?> 1000w, <?php echo $slide['image_medium_url']; ?> 500w"
                         alt="<?php echo ''; ?>"
                         title="<?php echo ''; ?>" />
                    <div class="caption-wrapper" style="<?php if ($slider_border === '1') { echo $slider_border_style; } ?>">
                    <?php if ($slide['type'] == 'image_text') : ?>
                        <div class="caption<?php if ($slide['overlay_dotted'] === '1') { echo ' bg-overlay dotted-black'; } ?>" data-animation="<?php echo $slide['caption_animation']; ?>">
                            <div class="vertical-align-wrapper" style="<?php echo $slide['overlay_background_color']; ?>">
                                <div class="vertical-align <?php echo $slide['caption_position']; ?>">
                                    <div class="horizontal-align">
                                        <div class="caption-contents"
                                             style="<?php echo $slide['caption_style']; ?>">
                                            <?php echo $slide['caption_content']; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($slide['type'] == 'offer') : ?>
                        <div class="caption" data-animation="<?php echo $slide['caption_animation']; ?>">
                            <div class="vertical-align-wrapper">
                                <div class="vertical-align <?php echo $slide['caption_position']; ?>">
                                    <div class="horizontal-align">
                                        <div class="caption-contents" style="<?php echo $slide['caption_style']; ?>"><?php echo $slide['caption_content']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    </div>
            <?php if ($slider_link !== 'none') : ?>
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
