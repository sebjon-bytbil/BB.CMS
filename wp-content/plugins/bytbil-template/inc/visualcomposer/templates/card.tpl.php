<div class="card white-bg <?php echo $css_classes; ?>">
    <div class="card-header">
        <span class="card-icon">
            <?php if ($use_picture == "0"): ?>
                <i class="<?php echo $icon_bytbil ?>"></i>
            <?php else: ?>
                <img src="<?php echo wp_get_attachment_url($icon_image) ?>">
            <?php endif ?>
            
        </span>
        <h5 class="card-title"><?php echo $headline ?></h5>
    </div>
    <div class="card-body">
        <?php echo apply_filters( 'the_content', $blockcontent ); ?>
        <ul class="card-list">

            <?php
            if($links) {
                foreach($links as $link) { ?>
                <li><a href="<?php echo $link['href']; ?>"><?php echo $link['text']; ?></a></li>
            <?php
                                         } 
            }?>
        </ul>
    </div>
</div>