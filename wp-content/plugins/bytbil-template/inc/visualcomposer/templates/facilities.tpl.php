<div class="bb-facilities <?php echo $css_classes; ?>">

    <h2><?php echo $headline ?></h2>

    <?php foreach($items as $key => $item) { ?>
        <div class="facility">
            <h5><?php echo $item['name']; ?></h5>
            <div class="facility-visiting-address">
                <?php echo $item['visiting_address_street']; ?><br>
                <?php echo $item['visiting_address_zip_postal']; ?>
            </div>

            <?php if($item['use_postal'] == true) { ?>
                <div class="facility-postal-address">
                    Postadress: <?php echo $item['postal_address']; ?>
                </div>
            <?php } ?>

            <?php if($item['phonenumbers'] != null) { ?>
                <div class="facility-phonenumbers">
                    <?php foreach($item['phonenumbers'] as $phonenumber) { ?>
                        <?php echo $phonenumber['facility-phonenumber-title'] != null ? $phonenumber['facility-phonenumber-title'] . ": " : ''; ?><a href="tel:<?php echo $phonenumber['facility-phonenumber-number']; ?>"><?php echo $phonenumber['facility-phonenumber-number']; ?></a><br>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if($item['emails'] != null) { ?>
                <div class="facility-emails">
                    <?php foreach($item['emails'] as $email) { ?>
                        <a href="mailto:<?php echo $email['facility-email-address']; ?>"><?php echo $email['facility-email-title'] == null ? $email['facility-email-address'] : $email['facility-email-title']; ?></a><br>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="facility-departments">
                <?php foreach($item['departments'] as $department) { ?>
                    <div class="facility-department">

                        <span class="facility-department-name"><?php echo $department['facility-department']; ?></span>
                        <ul>
                            <?php if($department['facility-department-phonenumber'] != null) { ?>
                                <li class="facility-department-phonenumber">Telefon: <?php echo $department['facility-department-phonenumber']; ?></li>
                            <?php } ?>

                            <?php if($department['facility-department-fax'] != null) { ?>
                                <li class="facility-department-fax">Fax: <?php echo $department['facility-department-fax']; ?></li>
                            <?php } ?>

                            <?php if($department['facility-department-email'] != null) { ?>
                                <li class="facility-department-email">E-post: <a href="mailto:<?php echo $department['facility-department-email']; ?>"><?php echo $department['facility-department-email']; ?></a></li>
                            <?php } ?>

                            <?php if($department['facility-department-openhours'] != null) { ?>
                                <li class="facility-department-openhours">
                                    Öppettider:
                                    <ul>
                                        <?php foreach($department['facility-department-openhours'] as $openhours) { ?>
                                            <li><span class="openhours-day"><?php echo $openhours['facility-department-openhours-day']; ?>:</span> <span class="openhours-time"><?php echo $openhours['facility-department-openhours-time']; ?></span></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>

                    </div>
                <?php } ?>
            </div>
        </div><br>
    <?php } ?>
</div>
