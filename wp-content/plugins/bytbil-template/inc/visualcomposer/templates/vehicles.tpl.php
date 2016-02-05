<?php if (!empty($vehicles)) : ?>
    <div class="row bb-vehicles">
        
        <div class="shuffle-grid-<?php echo $blockid; ?> shuffle--container shuffle--fluid shuffle">
        <?php if ($load_more_button) {
            $counter = 0;
        } ?>
        <?php foreach ($vehicles as $vehicle) : ?>
            <?php
            $counter++;
            if ($load_more_button && $counter >= $row_amount) {
                $load_more_class = 'load-hidden hidden';
            } ?>
            <div class="picture-item bb-vehicle-card-<?php echo $blockid; ?> col-sm-<?php echo $row_amount; ?> <?php echo $load_more_class; ?>">
                <figure>
                    <div class="vehicle-card">
                        <div class="vehicle-image">
                            <img src="<?php echo $vehicle['image']; ?>">
                        </div>
                        <div class="vehicle-info">
                            <h4 class="vehicle-name">
                                <?php echo $vehicle['name']; ?>
                            </h4>
                            <p class="vehicle-description">
                                <?php echo $vehicle['description']; ?>
                            </p>
                            <?php
                            if (isset($vehicle['links']) && $vehicle['links'] !== '') {
                                ?>
                                <div class="vehicle-links">
                                    <?php
                                    foreach($vehicle['links'] as $link) {
                                        $target = (self::Exists($link['vehicle-link-type']) == 'internal') ? '_self' : '_blank';
                                        if($link['vehicle-link-type'] == 'external' || $link['vehicle-link-type'] == 'file') {
                                            $target = '_blank';
                                            if($link['vehicle-link-type'] == 'external') {
                                                $href = $link['vehicle-link-external'];
                                            }
                                            else {
                                                $href = $link['vehicle-link-file'];
                                            }
                                        }
                                        else {
                                            $target = '_self';
                                            $href = $link['vehicle-link-internal'];
                                        }
                                    ?>
                                    <a href="<?php echo $href; ?>" class="btn <?php echo $link['vehicle-link-style']; ?>" target="<?php echo $target; ?>"><?php echo $link['vehicle-link-text']; ?></a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </figure>
            </div>
            
        <?php endforeach; ?>
        
        </div>
        <div class="clearfix"></div>

        <?php if ($load_more_button) : ?>
            
            <script>
            jQuery(document).ready(function() {
                
                $('.load-more-button').on('click',function() {
                    $('.load-hidden').toggleClass('hidden');
                    $(this).remove();
                });
            });
            </script>
        
            <button class="load-more-button btn btn-blue">Ladda in fler modeller</button>


        <?php endif; ?>
        
    </div>

    

<?php endif; ?>