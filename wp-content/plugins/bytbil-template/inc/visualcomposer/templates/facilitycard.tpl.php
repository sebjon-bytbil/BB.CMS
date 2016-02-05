<div class="bb-facility-card">
    <div id="map-<?php echo $blockid; ?>"
        class="bb-google-map"
        data-defaults="false"
        data-lat="<?php echo $coordinates['lat']; ?>"
        data-lng="<?php echo $coordinates['lng']; ?>"
        data-zoom="<?php echo $zoom; ?>"
        data-panby="0,-225"
        data-preventscroll="1"
        data-controls="0"
        style="height:650px;width:100%"></div>
    <div class="map-overlay bg-overlay dotted-black"></div>
    <div class="facility-card-content">
        <h1><?php echo $title; ?></h1>
        <?php echo $facility_content; ?>
        <?php foreach ($buttons as $button) : ?>
            <a class="btn btn-<?php echo $button['color']; ?>" href="<?php echo $button['link_to']; ?>"><?php echo $button['text']; ?></a>
        <?php endforeach; ?>
    </div>
</div>
