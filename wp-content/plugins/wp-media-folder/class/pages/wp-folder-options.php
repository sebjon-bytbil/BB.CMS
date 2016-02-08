<h2><?php _e('Media Folder Settings','wpmf') ?></h2>


<form name="form1" id="form_list_size" action="" method="post">
    
    <!--------------------------------------- Advanced params ----------------------------------->
    <div class="tab-header">
        <div class="wpmf-tabs">
            <div class="wpmf-tab-header active" data-label="wpmf-general" ><?php _e('General','wpmf'); ?></div>
            <div class="wpmf-tab-header" data-label="wpmf-gallery" ><?php _e('Gallery','wpmf'); ?></div>
            <div class="wpmf-tab-header" data-label="wpmf-media-access" ><?php _e('Media access','wpmf'); ?></div>
            <div class="wpmf-tab-header" data-label="wpmf-ftp-import" ><?php _e('FTP import','wpmf'); ?></div>
        </div>
    </div>

    <div class="content-box content-wpmf-general content-active">
        <div class="btnoption">
            <h3 class="title"><?php _e('Advanced parameters','wpmf'); ?></h3>
            <a href="#" class="button <?php if($btn_import_categories && $btn_import_categories == 'yes') echo 'button-primary'; ?>" id="wmpfImpoBtn"><?php _e('Import WP media categories', 'wpmf') ?></a>
            <span class="spinner" style="float: left;display:none"></span>
            <span class="wpmf_info_update"><?php _e('Settings saved.', 'wpmf') ?></span>
        </div>
        <p style="margin-left: 10px;" class="description"><?php _e('Import current media and post categories as media folders','wpmf'); ?></p>
    </div>
    
    <!--------------------------------------- Override image ----------------------------------->
    
    <div class="content-box content-wpmf-general">
        <div class="cboption">
            <h3 class="title"><?php _e('Replace image function','wpmf'); ?></h3>
            <p><input data-label="wpmf_option_override" type="checkbox" name="cb_option_override" class="cb_option" id="cb_option_override" <?php if ($option_override == 1) echo 'checked' ?> value="<?php echo @$option_override ?>">
                <?php _e('Override image', 'wpmf') ?>
            </p>
            <p class="description"><?php _e('Possibility to replace an existing image by another one.','wpmf'); ?></p>
            <input type="hidden" name="wpmf_option_override" value="<?php echo $option_override; ?>">
        </div>
    </div>
    <!--------------------------------------- End Override image ----------------------------------->
    
    <!---------------------------------------  Fillter and order ----------------------------------->
    
    <div class="content-box useorder content-wpmf-general">
        <div class="box-useorder">
            <label class="title" style="float: left;"><?php _e('Fillter and order feature','wpmf'); ?></label>
            <input type="checkbox" class="btnuseorder cb_option" data-label="wpmf_useorder" <?php if(isset($useorder) && $useorder== 1) echo 'checked' ?>>
            <label style="float: left;"><?php _e('Enable the fillter and order feature','wpmf'); ?></label>
            <input type="hidden" name="wpmf_useorder" value="<?php echo $useorder; ?>">
        </div>
    </div>
    
    <div class="content-box wpmf-config-gallery content-wpmf-general">
        <div class="box-select">
            <div id="wpmf_fillterdimension" class="div_list">
                <ul class="wpmf_fillterdimension">
                    <li class="div_list_child accordion-section control-section control-section-default open">
                        <h3 class="accordion-section-title wpmf-section-title dimension_title" data-title="filldimension" tabindex="0"><?php _e('List default fillter size','wpmf') ?></h3>
                        <ul class="content_list_filldimension">
                            <?php
                                if(count($a_dimensions) > 0):
                                    foreach ($a_dimensions as $a_dimension):
                            ?>
                            <li class="customize-control customize-control-select item_dimension" style="display: list-item;" data-value="<?php echo $a_dimension; ?>">
                                <input type="checkbox" name="dimension[]" value="<?php echo $a_dimension ?>" <?php if(in_array($a_dimension, $array_s_de)== true) echo 'checked' ?> >
                                <span><?php echo $a_dimension; ?></span>
                                <i class="md md-delete wpmf-delete" data-label="dimension" data-value="<?php echo $a_dimension; ?>" title="<?php _e('Remove dimension','wpmf'); ?>"></i>
                                <i class="md md-edit wpmf-md-edit" data-label="dimension" data-value="<?php echo $a_dimension; ?>" title="<?php _e('Edit dimension','wpmf'); ?>"></i>
                            </li>
                            <?php
                                    endforeach;
                                endif;
                            ?>
                            
                            <li class="customize-control customize-control-select dimension" style="display: list-item;">
                                <div style="width: 100%;float: left;">
                                    <span><?php _e('Width'); ?></span>
                                    <input name="wpmf_width_dimension" min="0" class="small-text wpmf_width_dimension" type="number">
                                    <span><?php _e('Height'); ?></span>
                                    <input name="wpmf_height_dimension" min="0" class="small-text wpmf_height_dimension" type="number">
                                </div>
                                    <span><?php _e('(unit : px)'); ?></span>
                            </li>
                            
                            <li style="display: list-item;margin:10px 0px 0px 0px">
                                <span name="add_dimension" id="add_dimension" class="button add_dimension"><?php _e('Add new size','wpmf'); ?></span>
                                <span name="edit_dimension" data-label="dimension" id="edit_dimension" class="button wpmfedit edit_dimension" style="display: none;"><?php _e('Save','wpmf'); ?></span>
                                <span id="can_dimension" class="button wpmf_can" data-label="dimension" style="display: none;"><?php _e('Cancel','wpmf'); ?></span>
                            </li>
                        </ul>
                        <p class="description"><?php _e('Image dimension filtering available in filter. Display image with a dimension and above.','wpmf'); ?></p>
                    </li>
                </ul>
            </div>
            
            <div id="wpmf_fillterweights" class="div_list">
                <ul class="wpmf_fillterweight">
                    <li class="div_list_child accordion-section control-section control-section-default open">
                        <h3 class="accordion-section-title wpmf-section-title sizes_title" data-title="fillweight" tabindex="0"><?php _e('List default fillter weight','wpmf') ?></h3>
                        <ul class="content_list_fillweight">
                            <?php
                                if(count($a_weights) > 0):
                                    foreach ($a_weights as $a_weight):
                                    $labels = explode('-', $a_weight[0]);
                                    if($a_weight[1] == 'kB'){
                                        $label = ($labels[0]/1024).' kB-'.($labels[1]/1024).' kB';
                                    }else{
                                        $label = ($labels[0]/(1024*1024)).' MB-'.($labels[1]/(1024*1024)).' MB';
                                    }
                                        
                            ?>
                            <li class="customize-control customize-control-select item_weight" style="display: list-item;" data-value="<?php echo $a_weight[0]; ?>" data-unit="<?php echo $a_weight[1]; ?>">
                                <input type="checkbox" name="weight[]" value="<?php echo $a_weight[0].','.$a_weight[1] ?>" data-unit="<?php echo $a_weight[1]; ?>" <?php if(in_array($a_weight, $array_s_we)== true) echo 'checked' ?> >
                                <span><?php echo $label; ?></span>
                                <i class="md md-delete wpmf-delete" data-label="weight" data-value="<?php echo $a_weight[0]; ?>" data-unit="<?php echo $a_weight[1]; ?>" title="<?php _e('Remove weight','wpmf'); ?>"></i>
                                <i class="md md-edit wpmf-md-edit" data-label="weight" data-value="<?php echo $a_weight[0]; ?>" data-unit="<?php echo $a_weight[1]; ?>" title="<?php _e('Edit weight','wpmf'); ?>"></i>
                            </li>
                            <?php
                                    endforeach;
                                endif;
                            ?>
                            
                            <li class="customize-control customize-control-select weight" style="display: list-item;">
                                <div style="width: 100%;float: left;">
                                    <span><?php _e('Min'); ?></span>
                                    <input name="wpmf_min_weight" min="0" class="small-text wpmf_min_weight" type="number">
                                    <span><?php _e('Max'); ?></span>
                                    <input name="wpmf_max_weight" min="0" class="small-text wpmf_max_weight" type="number">
                                </div>
                                <span style="margin-top: 10px;float: left;"><?php _e('Unit :'); ?>
                                    <select class="wpmfunit" data-label="weight">
                                            <option value="kB"><?php _e('kB','wpmf'); ?></option>
                                            <option value="MB"><?php _e('MB','wpmf'); ?></option>
                                        </select>
                                    </span>
                                    
                            </li>
                            
                            <li style="display: list-item;margin:10px 0px 0px 0px;float: left;">
                                <span name="add_weight" id="add_weight" class="button add_weight"><?php _e('Add weight','wpmf'); ?></span>
                                <span name="edit_weight" data-label="weight" id="edit_weight" class="button wpmfedit edit_weight" style="display: none;"><?php _e('Save','wpmf'); ?></span>
                                <span id="can_dimension" class="button wpmf_can" data-label="weight" style="display: none"><?php _e('Cancel','wpmf'); ?></span>
                            </li>
                        </ul>
                        <p class="description"><?php _e('Select weight range which you would like to display in media library filter','wpmf'); ?></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!--------------------------------------- End Fillter and order ----------------------------------->
    
    <!--------------------------------------- End advanced params ----------------------------------->
    
    <!--------------------------------------- Media access ----------------------------------->
    
    <div class="content-box content-wpmf-media-access">
        <div class="cboption">
            <h3 class="title"><?php _e('Access management','wpmf'); ?></h3>
            <p><input data-label="wpmf_folder_option1" type="checkbox" name="cb_option_1" class="cb_option" id="cb_option_1" <?php if ($option1 == 1) echo 'checked' ?> value="<?php echo @$option1 ?>">
                <?php _e('Auto create one folder per editor', 'wpmf'); ?></p>
            
            <p><input data-label="wpmf_active_media" type="checkbox" name="cb_option_active_media" class="cb_option" id="cb_option_active_media" <?php if ($wpmf_active_media == 1) echo 'checked' ?> value="<?php echo @$wpmf_active_media ?>">
                <?php _e('Show only own user media (an option will be added for admin in the media manager)', 'wpmf'); ?>
            </p>
            
            <input type="hidden" name="wpmf_folder_option1" value="<?php echo $option1; ?>">
            <input type="hidden" name="wpmf_active_media" value="<?php echo $wpmf_active_media; ?>">
        </div>
    </div>
    
    <!--------------------------------------- End Media access ----------------------------------->
    
    <!--------------------------------------- Gallery ----------------------------------->
    
    <div class="content-box usegellery content-wpmf-gallery">
        <div class="box-usegellery" style="width: 100%;float: left;">
            <label class="title" style="float: left;"><?php _e('Gallery feature','wpmf'); ?></label>
            <input type="checkbox" class="btngallery cb_option" data-label="wpmf_usegellery" <?php if(isset($usegellery) && $usegellery== 1) echo 'checked' ?>>
            <label style="float: left;"><?php _e('Enable the gallery feature','wpmf'); ?></label>
            <input type="hidden" name="wpmf_usegellery" value="<?php echo $usegellery; ?>">
        </div>
        <p style="float: left;margin-left: 10px;" class="description"><?php _e('Enhance the WordPress default gallery system by adding themes and additional parameters in the gallery manager','wpmf'); ?></p>
    </div>
    
    <!--    setting sizes     -->
    <div class="content-box wpmf-config-gallery content-wpmf-gallery">
        <div class="box-select">
            <div id="gallery_image_size" class="div_list">
                <ul class="image_size">
                    <li class="div_list_child accordion-section control-section control-section-default open">
                        <h3 class="accordion-section-title wpmf-section-title sizes_title" data-title="sizes" tabindex="0"><?php _e('Gallery image sizes available','wpmf') ?></h3>
                        <ul class="content_list_sizes">
                            <?php
                            //global $_wp_additional_image_sizes;
                                $sizes = apply_filters( 'image_size_names_choose',array(
                                    'thumbnail' => __('Thumbnail'),
                                    'medium'    => __('Medium'),
                                    'large'     => __('Large'),
                                    'full'      => __('Full Size'),
                                ) );
                            foreach ($sizes as $key => $size):
                            ?>

                            <li class="customize-control customize-control-select" style="display: list-item;">
                                <input type="checkbox" name="size_value[]" value="<?php echo $key ?>" <?php if(in_array($key, $size_selected )) echo 'checked' ?> >
                                <span><?php echo $size ?></span>
                            </li>
                            <?php endforeach; ?>

                        </ul>
                        <p class="description"><?php _e('Select the image size you can load in galleries. Custom image size available here can be generated by 3rd party plugins','wpmf'); ?></p>
                    </li>
                </ul>
            </div>

            <!--    setting padding     -->
            <div id="gallery_image_padding" class="div_list">
                <ul class="image_size">
                    <li class="div_list_child accordion-section control-section control-section-default open">
                        <h3 class="accordion-section-title wpmf-section-title padding_title" data-title="padding" tabindex="0"><?php _e('Gallery themes settings','wpmf') ?></h3>
                        <ul class="content_list_padding">
                            <li class="customize-control customize-control-select" style="display: list-item;">
                                <span><?php _e('Masonry Theme','wpmf'); ?></span>
                                <label><?php _e('Space between images (padding)','wpmf') ?></label>
                                <input name="padding_gallery[wpmf_padding_masonry]" class="padding_gallery small-text" type="number" min="0" max="30" value="<?php echo $padding_masonry ?>" >
                                <label><?php _e('px','wpmf') ?></label>
                            </li>

                            <li class="customize-control customize-control-select" style="display: list-item;">
                                <span><?php _e('Portfolio Theme','wpmf'); ?></span>
                                <label><?php _e('Space between images (padding)','wpmf') ?></label>
                                <input name="padding_gallery[wpmf_padding_portfolio]" class="padding_gallery small-text" type="number" min="0" max="30" value="<?php echo $padding_portfolio ?>" >
                                <label><?php _e('px','wpmf') ?></label>
                            </li>
                        </ul>
                        <p class="description"><?php _e('Determine the space between images','wpmf'); ?></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <?php if(in_array('nextgen-gallery/nggallery.php',get_option( 'active_plugins' )) || (defined('NGG_PLUGIN_VERSION'))): ?>
    <div class="content-box content-wpmf-gallery">
        <div class="btnoption">
            <input type="button" id="btn_import_gallery" class="button btn_import_gallery button-primary" value="<?php _e('Sync/Import NextGEN galleries','wpmf'); ?>">
            <span class="spinner" style="float: left;display:none"></span>
            <span class="wpmf_info_update"><?php _e('Settings saved.', 'wpmf') ?></span>
        </div>
        <p style="margin-left:10px;" class="description"><?php _e('Import nextGEN albums as image in folders in the media manager. You can then create new galleries from WordPress media manager','wpmf'); ?></p>
    </div>
    <?php endif; ?>
    
    <!--------------------------------------- End Gallery ----------------------------------->
        
    <!--------------------------------------- FTP Import ----------------------------------->
    
    <div class="content-box content-box content-wpmf-ftp-import">
        <div class="btnoption">
            <div id="wpmf_foldertree"></div>
            <input type="button" id="import_button" name="import_folder" value="<?php _e('Import Folder','wpmf'); ?>" class="button" style="margin: 10px 0px 10px 10px;">    
            <span class="spinner" style="float: left;margin: 15px 10px 15px 6px;"></span>
            <span class="info_import"><?php _e('Imported !','wpmf'); ?></span>
        </div>
        <p style="margin-left:10px;" class="description"><?php _e('Import folder structure and media from your server in the standard WordPress media manager','wpmf'); ?></p>
    </div>
    <!--------------------------------------- End FTP Import ----------------------------------->
    
    
    <div class="btn_wpmf_saves">
        <input type="submit" name="btn_wpmf_save" id="btn_wpmf_save" class="button btn_wpmf_save button-primary" value="<?php _e('Save Changes','wpmf'); ?>">
    </div>
        
</form>