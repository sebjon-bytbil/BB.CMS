<!-- This needs to be fixed. -->
<link rel="stylesheet" href="<?php echo VCADMINURL . 'assets/css/vendor/lightcase.css'; ?>" />
<div class="vehicle-gallery-panel">
    <div class="">
        <div class="row">
        <?php foreach ($items as $key => $item) : ?>
            <div class="col-sm-<?php echo $col; ?>">
                <a data-rel="lightcase:<?php echo $item['id']; ?>"
                   href="<?php echo $item['image_url']; ?>"
                   title="<?php echo $item['headline'] . ': ' . $item['image_text']; ?>"
                   alt="<?php echo $item['headline'] . ': ' . $item['image_text']; ?>">
                    <img src="<?php echo $item['image_url']; ?>" class="gallery-image" />
                </a>
            </div>
            <?php if (($key + 1) % $per_row === 0 && ($key + 1) !== $amount) : ?>
                </div>
                <div class="row">
            <?php endif; ?>
        <?php endforeach; ?>
        </div>
    </div>
</div>
