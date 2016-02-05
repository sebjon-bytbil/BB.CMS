<?php if($id) { ?>

<div class="bb-offers">
    <div class="offer-image">
        <img src="<?php echo $image_url; ?>" alt="" title="" />
    </div>
    <h2><?php echo $title; ?></h2>
    <p><?php echo $ingress; ?></p>
    <a class="btn" href="<?php echo $permalink; ?>">Visa hela erbjudandet</a>
</div>

<?php } else { ?>

<?php if ($brand_dropdown) : ?>
    <p>Välj märke</p>
    <select class="bb-offers-<?php echo $blockid; ?>">
        <option value="all">Alla märken</option>
        <?php foreach ($brands as $brand) : ?>
            <option value="<?php echo $brand; ?>"><?php echo $brand; ?></option>
        <?php endforeach; ?>
    </select>
<?php endif; ?>

<div class="bb-offers">
    <div class="row">
    <?php if ($show_as_slideshow) : ?>

        <div class="bb-slideshow flexslider" id="slideshow-<?php echo $blockid; ?>"
            data-id="<?php echo $blockid; ?>"
            data-slideshow="slider"
            data-animationspeed="600"
            data-animation="fade"
            data-speed="7000"
            data-arrows="true"
            data-controls="true">
            <ul class="slides">
            <?php foreach ($items as $key => $item) : ?>
                <li>
                    <a href="<?php echo $item['permalink']; ?>">
                        <img src="<?php echo $item['image']; ?>" alt="" title="" />
                        <div class="caption-wrapper">
                            <div class="caption bg-overlay">
                                <div class="vertical-align-wrapper" style="background: rgba(0,0,0,0.6);">
                                    <div class="vertical-align center">
                                        <div class="horizontal-align">
                                            <div class="caption-contents" style="text-align: center; color: #fff;">
                                                <h2><?php echo $item['headline']; ?></h2>
                                                <p><?php echo $item['ingress']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>

    <?php else : ?>
        <div class="shuffle-grid-<?php echo $blockid; ?> shuffle--container shuffle--fluid shuffle">

        <?php foreach($items as $key => $item) { ?>
            <?php
            if ($brand_dropdown) {
                $brand_string = '';
                foreach ($item['brands'] as $brand) {
                    $brand_string .= $brand . ' ';
                }
            }
            ?>

            <div class="picture-item bb-offer-card-<?php echo $blockid; ?> col-xs-12 col-sm-<?php echo $columns; ?>"<?php echo $brand_dropdown ? ' data-groups=\'["' . trim($brand_string) . '"]\'' : ''; ?>>
                <figure>
                    <div class="offer-image">
                        <img src="<?php echo $item['image']; ?>" alt="" title="" />
                    </div>
                    <h2><?php echo $item['headline']; ?></h2>
                    <p><?php echo $item['ingress']; ?></p>
                    <a class="btn btn-blue" href="<?php echo $item['permalink']; ?>">Visa hela erbjudandet</a>
                </figure>
            </div>

        <?php } ?>

        </div>

    <?php endif; ?>

    </div>
</div>

<?php if ($brand_dropdown) : ?>
<script>
jQuery(document).ready(function() {
    new BBShuffle.Shuffle.init('.shuffle-grid-<?php echo $blockid; ?>', '.bb-offers-<?php echo $blockid; ?>', '.bb-offer-card-<?php echo $blockid; ?>', false);
});
</script>
<?php endif; ?>

<?php if ($show_as_slideshow) : ?>
<script>
if (window.location !== window.top.location) {
    imageslider.refresh_imageslider();
}
</script>
<?php endif; ?>

<?php } ?>
