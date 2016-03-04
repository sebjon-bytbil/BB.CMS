<?php if ($facilities) : ?>

    <div id="map-<?php echo $blockid; ?>"
         data-zoom="<?php echo $zoom; ?>"
         data-preventscroll="<?php echo $preventscroll; ?>"
         data-controls="<?php echo $controls; ?>"
         class="bb-map-canvas"
         style="height:<?php echo $height; ?>px;width:100%">
        <?php foreach ($facilities as $facility) : ?>
            <div style="display:none;" class="marker" data-lat="<?php echo $facility['coordinates']['lat']; ?>" data-lng="<?php echo $facility['coordinates']['lng']; ?>">
                <h3><?php echo $facility['name']; ?></h3>
                <p><?php echo $facility['address']; ?></p>
                <?php if ($facility['phonenumbers']) : ?>
                    <?php foreach ($facility['phonenumbers'] as $phonenumber) : ?>
                        <span class="facility_phonenumber_title">
                            <strong><?php echo $phonenumber['facility-phonenumber-title']; ?></strong>
                        </span>
                        <span class="facility_phonenumber_number">
                            <a href="tel:<?php echo $phonenumber['facility-phonenumber-number']; ?>"><?php echo $phonenumber['facility-phonenumber-number']; ?></a>
                        </span>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($facility['emails']) : ?>
                    <?php foreach ($facility['emails'] as $email) : ?>
                        <span class="facility_email_title">
                            <strong><?php echo $email['facility-email-title']; ?></strong>
                        </span>
                        <span class="facility_email_address">
                            <a href="mailto:<?php echo $email['facility-email-address']; ?>"><?php echo $email['facility-email-address']; ?></a>
                        </span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

<?php elseif ($map) : ?>

    <div id="map-<?php echo $blockid; ?>"
         data-zoom="<?php echo $zoom; ?>"
         data-preventscroll="<?php echo $preventscroll; ?>"
         data-controls="<?php echo $controls; ?>"
         class="bb-map-canvas"
         style="height:<?php echo $height; ?>px;width:100%;">
        <div style="display: none;" class="marker" data-lat="<?php echo $coordinates['lat']; ?>" data-lng="<?php echo $coordinates['lng']; ?>"></div>
    </div>

<?php endif; ?>