<?php if ($accordions) : ?>
<div class="bb-accordion">
    <div id="<?php echo $blockid; ?>" class="panel-group">
    <?php foreach ($accordions as $i => $accordion) : ?>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="<?php echo ($i > 0) ? 'collapsed' : ''; ?>" data-toggle="collapse" data-parent="#<?php echo $blockid; ?>" href="#<?php echo $blockid . '-' . $i; ?>">
                        <?php echo isset($accordion['headline']) ? $accordion['headline'] : ''; ?>
                    </a>
                </h4>
            </div>
            <div id="<?php echo $blockid . '-' . $i; ?>" class="panel-collapse collapse<?php echo ($i === 0) ? ' in' : ''; ?>">
                <div class="panel-body">
                    <?php echo isset($accordion['accordion_content']) ? $accordion['accordion_content'] : ''; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
