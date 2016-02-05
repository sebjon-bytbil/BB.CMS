<?php if (isset($tabs)) : ?>
<div class="bb-tabs">
    <div id="<?php echo $blockid; ?>" class="panel-group">
        <ul class="nav nav-tabs">
            <?php foreach ($tabs as $i => $tab) : ?>
                <li class="<?php echo ($i === 0) ? ' active' : ''; ?>">
                    <a data-toggle="tab" href="#<?php echo $blockid . '-' . $i; ?>"><?php echo $tab['headline']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
            <?php $i = 0; foreach ($tabs as $i => $tab) : ?>
                <div id="<?php echo $blockid . '-' . $i; ?>" class="tab-pane fade <?php echo ($i === 0) ? ' active' : ''; ?>">
                    <?php echo $tab['tabs_content']; ?>
                </div>
            <?php endforeach; ?>
        </div>
           
    </div>
</div>
<?php endif; ?>
