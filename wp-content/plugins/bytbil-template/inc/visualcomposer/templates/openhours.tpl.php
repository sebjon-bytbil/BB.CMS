<?php if($open_hours) : ?>
    <?php if ($show_as_accordion) : ?>
    <div class="bb-accordion">
        <div id="<?php echo $blockid; ?>" class=panel-group">
        <?php foreach ($open_hours as $i => $open_hour) : ?>
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#<?php echo $blockid; ?>" href="#<?php echo $blockid . '-' . $i; ?>"><?php echo $open_hour['department']; ?></a>
                    </h4>
                </div>
                <div id="<?php echo $blockid . '-' . $i; ?>" class="panel-collapse collapse">
                <?php foreach ($open_hour['open_hours'] as $i => $item) : ?>
                    <p><?php echo $item['facility-department-openhours-day']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $item['facility-department-openhours-time']; ?></p>
                <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
    <?php else : ?>
        <?php foreach ($open_hours as $open_hour) : ?>
            <h5><?php echo $open_hour['department']; ?></h5>
            <?php foreach ($open_hour['open_hours'] as $item) : ?>
            <p><?php echo $item['facility-department-openhours-day']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $item['facility-department-openhours-time']; ?></p>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>
