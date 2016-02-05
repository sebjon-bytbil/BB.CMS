<?php if ($use_picture == '0') : ?>
    <i class="<?php echo $icon_bytbil; ?>"></i>
<?php else : ?>
    <img src="<?php echo wp_get_attachment_url($icon_image); ?>">
<?php endif; ?>