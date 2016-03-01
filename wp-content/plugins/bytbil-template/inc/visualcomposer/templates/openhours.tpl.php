<?php if ($open_hours) : ?>
    <div class="container-fluid">
    <?php foreach ($open_hours as $open_hour) : ?>
        <div class="col-xs-12 col-sm-<?php echo $bootstrap; ?>">
            <div class="plug">
                <div class="plug-contents align-center">
                    <h3><?php echo $open_hour['department']; ?></h3>
                    <ul class="vertical-list">
                    <?php foreach ($open_hour['open_hours'] as $item) : ?>
                        <li><strong><?php echo $item['facility-department-openhours-day']; ?>:</strong> <?php echo $item['facility-department-openhours-time']; ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>
