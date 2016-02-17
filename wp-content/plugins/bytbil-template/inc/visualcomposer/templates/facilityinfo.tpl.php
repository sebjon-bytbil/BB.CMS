<?php if ($bool) : ?>
<div class="bb-facility-card">
    <div class="facility-card-content">
        <h1><?php echo $title; ?></h1>
        <?php if ($alt_address) : ?>
            <p><?php echo $address; ?></p>
        <?php else : ?>
            <p><?php echo $address; ?></p>
            <p><?php echo $city; ?></p>
        <?php endif; ?>
        <?php if ($phonenumber) : ?>
            <p><strong>Telefon</strong> <a href="tel:<?php echo $phonenumber; ?>"><?php echo $phonenumber; ?></a></p>
        <?php endif; ?>
        <?php if ($email) : ?>
            <p><strong>E-post</strong> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
        <?php endif; ?>
        <?php if ($open_hours) : ?>
            <?php foreach ($open_hours as $open_hour) : ?>
                <h4><?php echo $open_hour['department']; ?></h4>
                <ul class="vertical-list">
                <?php foreach ($open_hour['open_hours'] as $item) : ?>
                    <li><strong><?php echo $item['facility-department-openhours-day']; ?>:</strong> <?php echo $item['facility-department-openhours-time']; ?></li>
                <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
