<?php if (isset($the_buttons)) : ?>
    <?php foreach ($the_buttons as $button) : ?>
    <a class="<?php echo $button['width'] != "auto" ? "col-sm-" . $button['width'] : ""; ?> btn <?php echo $extra_css; ?>" href=""><?php echo $button['button_text']; ?></a>
    <?php endforeach; ?>
<?php endif; ?>
<div class="bb-buttons">
    <h2><?php echo $headline ?></h2>
    <?php echo $blockcontent ?>
</div>