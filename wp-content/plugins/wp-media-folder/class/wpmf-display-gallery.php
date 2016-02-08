<?php

class Wpmf_Display_Gallery {

    function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'wpmf_gallery_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'wpmf_gallery_enqueue_admin_scripts'));
        add_filter('post_gallery', array($this, 'wpmf_gallery_shortcode'), 10, 3);
        add_action('print_media_templates', array($this, 'wpmf_gallery_print_media_templates'));
        add_filter("attachment_fields_to_edit", array($this, "wpmf_gallery_attachment_fields_to_edit"), 10, 2);
        add_filter("attachment_fields_to_save", array($this, "wpmf_gallery_attachment_fields_to_save"), 10, 2);
        add_action('wp_ajax_update_link', array($this, 'wpmf_update_link') );
        add_action( 'post_updated', array($this,'wpmf_update_post'), 10, 3 );
        add_filter( 'wp_generate_attachment_metadata', array($this, 'wpmf_upload_after'), 10, 2 );
        add_action( 'delete_post', array($this,'wpmf_delete_attachment' ));
        add_action('wp_ajax_move_attachment', array($this, 'wpmf_move_attachment') );
    }
    
    function wpmf_gallery_scripts() {
        
        wp_register_style('wpmf-flexslider-style', plugins_url('assets/css/display-gallery/flexslider.css', dirname(__FILE__)), array(), '2.4.0');
        wp_register_script('wordpresscanvas-imagesloaded', plugins_url('/assets/js/display-gallery/imagesloaded.pkgd.min.js', dirname(__FILE__)), array(), '3.1.5', true);
        wp_register_script( 'wpmf-gallery-popup', plugins_url( '/assets/js/display-gallery/jquery.magnific-popup.min.js',dirname(__FILE__)), array ( 'jquery' ), '0.9.9', true );
        wp_register_script('wpmf-gallery-flexslider', plugins_url('assets/js/display-gallery/flexslider/jquery.flexslider.js', dirname(__FILE__)), array('jquery'), '2.0.0', true);
        wp_register_script('wpmf-gallery', plugins_url('assets/js/display-gallery/site_gallery.js', dirname(__FILE__)), array('jquery', 'wordpresscanvas-imagesloaded'), WPMF_VERSION, true);
    }
    
    function wpmf_gallery_enqueue_admin_scripts() {
        $screen = get_current_screen();
        if ('post' == $screen->base) {
            wp_register_script('wpmf-gallery-admin-js', plugins_url('assets/js/display-gallery/admin_gallery.js', dirname(__FILE__)), array('jquery'), WPMF_VERSION, true);
            wp_enqueue_script('wpmf-gallery-admin-js');
        }
    }

    function wpmf_gallery_shortcode($blank, $attr) {
        $post = get_post();
        static $instance = 0;
        $instance++;

        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if (isset($attr['orderby'])) {
            $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
            if (!$attr['orderby'])
                unset($attr['orderby']);
        }

        extract(shortcode_atts(array(
            'order' => 'ASC', 'orderby' => 'menu_order ID', 'id' => $post ? $post->ID : 0,
            'columns' => 3, 'gutterwidth' => '5', 'link' => 'post',
            'size' => 'thumbnail', 'targetsize' => 'large', 'display' => 'default',
            'customlink' => 0, 'bottomspace' => 'default', 'hidecontrols' => 'false',
            'class' => '', 'include' => '', 'exclude' => '' ), $attr, 'gallery'));
        
        
        $custom_class = trim($class);
        $id = intval($id);
        if ('RAND' == $order) $orderby = 'none';

        if (!empty($include)) {
            $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
            $attachments = array();
            foreach ($_attachments as $key => $val) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        } elseif (!empty($exclude)) {
            $attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
        } else {
            $attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
        }

        if (empty($attachments)) return '';

        if (is_feed()) {
            $output = "\n";
            foreach ($attachments as $att_id => $attachment)
                $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
            return $output;
        }

        $columns = intval($columns);

        $selector = "gallery-{$instance}";
        $size_class = sanitize_html_class($size);
        $customlink = 1 == $customlink ? true : false;
        $class = array();
        $class[] = 'gallery';
        
        if($link == 'file' || $link == 'none'){
            $customlink = false;
        }else{
            $customlink = true;
        }
        if (!empty($custom_class)) $class[] = esc_attr($custom_class);
        if (!$customlink) $class[] = "gallery-link-{$link}";

        if ($link == 'file') {
            wp_enqueue_script('wpmf-gallery-popup');
        }
        
        wp_enqueue_script('jquery');
        wp_enqueue_style('wpmf-gallery-style', plugins_url('/assets/css/display-gallery/style-display-gallery.css', dirname(__FILE__)),array(),WPMF_VERSION);
        wp_enqueue_style('wpmf-material-design-iconic-font.min',plugins_url( '/assets/css/material-design-iconic-font.min.css', dirname(__FILE__) ));
        wp_enqueue_style( 'wpmf-gallery-popup-style', plugins_url('/assets/css/display-gallery/magnific-popup.css', dirname(__FILE__)), array( ), '0.9.9' );
        
        switch ($display){
       
            case "slider":
                require(WP_MEDIA_FOLDER_PLUGIN_DIR .'themes-gallery/gallery-slider.php');
                break;
   
            case "masonry":
                require(WP_MEDIA_FOLDER_PLUGIN_DIR .'themes-gallery/gallery-mansory.php');
                break;
            
            case "portfolio":
                require(WP_MEDIA_FOLDER_PLUGIN_DIR .'themes-gallery/gallery-portfolio.php');
                break;
            
            default:
                require(WP_MEDIA_FOLDER_PLUGIN_DIR .'themes-gallery/gallery-default.php');
                break;
        }
        return $output;
    }

    function wpmf_gallery_get_attachment_link($id = 0, $size = 'thumbnail', $permalink = false, $icon = false, $text = false, $targetsize = 'large', $customlink = false, $link_target = '_self') {
        $id = intval($id);
        $_post = get_post($id);

        if (empty($_post) || ( 'attachment' != $_post->post_type ) || !$url = wp_get_attachment_url($_post->ID))
            return __('Missing Attachment');
        
        $lightbox = 0;
        if ($customlink) {
            $url = get_post_meta($_post->ID, _WPMF_GALLERY_PREFIX . 'custom_image_link', true);
            if($url == '') $url = get_attachment_link($_post->ID);
        } else if ($permalink) {
            $url = get_attachment_link($_post->ID);
        } else if ($targetsize) {
            if ($img = wp_get_attachment_image_src($_post->ID, $targetsize))
                $url = $img[0];
            if(get_post_meta($id, _WPMF_GALLERY_PREFIX . 'custom_image_link', true) != ''){
                $lightbox = 0;
                $url = get_post_meta($_post->ID, _WPMF_GALLERY_PREFIX . 'custom_image_link', true);
            }else{
                $lightbox = 1;
                $url = $img[0];
            }
        }

        $post_title = esc_attr($_post->post_title);

        if ($text)
            $link_text = $text;
        elseif ($size && 'none' != $size)
            $link_text = wp_get_attachment_image($id, $size, $icon);
        else
            $link_text = '';

        if (trim($link_text) == '')
            $link_text = $_post->post_title;

        return apply_filters('wp_get_attachment_link', "<a data-lightbox='$lightbox' href='$url' title='$post_title' target='$link_target'>$link_text</a>", $id, $size, $permalink, $icon, $text);
    }

    function wpmf_gallery_print_media_templates() {
        $display_types = array(
            'default' => __('Default','wpmf'),
            'masonry' => __('Masonry', 'wpmf'),
            'portfolio' => __('Portfolio', 'wpmf'),
            'slider' => __('Slider', 'wpmf'),
        );
        ?>
        
        <script type="text/html" id="tmpl-wpmf-gallery-settings">
            <label class="setting">
                <span><?php _e('Gallery themes', 'wpmf'); ?></span>
            </label>
            
            <label class="setting">
                <select class="display" name="display" data-setting="display">
                    <?php foreach ($display_types as $key => $value) : ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($key, ''); ?>><?php echo esc_html($value); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            
            <label class="setting">
                <span><?php _e('Columns', 'wpmf'); ?></span>
            </label>
            
            <label class="setting">
                <select class="columns" name="columns" data-setting="columns">
                    <option value="1" >1</option>
                    <option value="2" >2</option>
                    <option value="3" selected >3</option>
                    <option value="4" >4</option>
                    <option value="5" >5</option>
                    <option value="6" >6</option>
                    <option value="7" >7</option>
                    <option value="8" >8</option>
                    <option value="9" >9</option>
                </select>
            </label>
            
            <label class="setting size">
               <span><?php _e( 'Gallery image size', 'wpmf' ); ?></span>
            </label>
            
            <label class="setting size">
                <select class="size" name="size" data-setting="size">
                        <?php
                        $sizes_value = json_decode(get_option('wpmf_gallery_image_size_value'));
                        $sizes = apply_filters( 'image_size_names_choose',array(
                                'thumbnail' => __('Thumbnail'),
                                'medium'    => __('Medium'),
                                'large'     => __('Large'),
                                'full'      => __('Full Size'),
                        ) );
                        ?>
                    
                        <?php foreach ( $sizes_value as $key  ) : ?>
                                <option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $sizes[$key] ); ?></option>
                        <?php endforeach; ?>
                    
                </select>
            </label>
            
            <label class="setting">
                <span><?php _e( 'Lightbox size', 'wpmf' ); ?></span>
            </label>
            
            <label class="setting">
                <select class="targetsize" name="targetsize" data-setting="targetsize">
                        <?php
                        $sizes = array(
                                'thumbnail' => __('Thumbnail'),
                                'medium'    => __('Medium'),
                                'large'     => __('Large'),
                                'full'      => __('Full Size'),
                        );
                        ?>

                        <?php foreach ( $sizes as $key => $name ) : ?>
                                <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, 'large' ); ?>><?php echo esc_html( $name ); ?></option>
                        <?php endforeach; ?>
                </select>
            </label>
            
            <label class="setting">
                <span><?php _e('Action on click', 'wpmf'); ?></span>
            </label>
            
            <label class="setting">
                <select class="link-to" name="link" data-setting="link">
                    <option value="file" selected><?php echo _e('Lightbox','wpmf'); ?></option>
                    <option value="post"  ><?php echo _e('Attachment Page','wpmf'); ?></option>
                    <option value="none" ><?php echo _e('None','wpmf'); ?></option>
                </select>
            </label>
            
            <label class="setting">
                <span><?php _e('Auto insert image in folder', 'wpmf'); ?></span>
            </label>
            
            <label class="setting">
                <select class="wpmf_autoinsert" name="wpmf_autoinsert" data-setting="wpmf_autoinsert">
                    <option value="0" selected><?php echo _e('No','wpmf'); ?></option>
                    <option value="1"  ><?php echo _e('Yes','wpmf'); ?></option>
                </select>
            </label>
            
            <input type="text" class="wpmf_folder_id"  data-setting="wpmf_folder_id" style="display: none">
        </script>
        <?php
    }
    
    function wpmf_gallery_attachment_fields_to_edit($form_fields, $post) {
        $form_fields['wpmf_gallery_custom_image_link'] = array(
            "label" => __('Link to'),
            "input" => "html",
            'html'  => '<input type="text" class="text" id="attachments-'.$post->ID.'-wpmf_gallery_custom_image_link" name="attachments['.$post->ID.'][wpmf_gallery_custom_image_link]" value="'.get_post_meta($post->ID, _WPMF_GALLERY_PREFIX . "custom_image_link", true).'"> <button role="presentation" type="button" class="link-btn"><i class="mce-ico mce-i-link"></i></button>'
        );
        
        $target_value = get_post_meta( $post->ID, '_gallery_link_target', true );
        $form_fields['gallery_link_target'] = array(
                'label' => __( 'Link target','wpmf' ) ,
                'input'	=> 'html',
                'html'	=> '
                        <select name="attachments['.$post->ID.'][gallery_link_target]" id="attachments['.$post->ID.'][gallery_link_target]">
                                <option value="">'.__( 'Same Window', 'wpmf' ).'</option>
                                <option value="_blank"'.($target_value == '_blank' ? ' selected="selected"' : '').'>'.__( 'New Window', 'wpmf' ).'</option>
                        </select>'
        );
        
        
        return $form_fields;
    }

    function wpmf_gallery_attachment_fields_to_save($post, $attachment) {
        if (isset($attachment['wpmf_gallery_custom_image_link'])) {
            update_post_meta($post['ID'], _WPMF_GALLERY_PREFIX . 'custom_image_link', esc_url_raw($attachment['wpmf_gallery_custom_image_link']));
        }
        
        if( isset( $attachment['gallery_link_target'] ) ) {
                update_post_meta( $post['ID'], '_gallery_link_target', $attachment['gallery_link_target'] );
        }
		
        return $post;
    }
    
    function wpmf_update_link(){
        $attachment_id = $_POST['id'];
        update_post_meta($attachment_id, '_wpmf_gallery_custom_image_link', esc_url_raw($_POST['link']));
        update_post_meta($attachment_id, '_gallery_link_target', $_POST['link_target']);
        //wp_update_post( array( 'ID' => $attachment_id,'post_title' => $_POST['title'] ) );
        $link = get_post_meta($attachment_id,'_wpmf_gallery_custom_image_link');
        $target = get_post_meta($attachment_id,'_gallery_link_target');
        //$title = get_post($attachment_id);
        wp_send_json(array('link' => $link , 'target' => $target ));
    }
    
    function wpmf_delete_attachment($pid){
        $post_type = get_post_type( $pid );
        $post_types = get_post_types(array('public' => true, 'exclude_from_search' => false));
        if(in_array($post_type, $post_types)){
            $this->update_gallery('delete',$pid);
        }
    }
    
    function wpmf_update_post($post_ID,$post_after, $post_before){
        $post_type = get_post_type( $post_ID );
        $post_types = get_post_types(array('public' => true, 'exclude_from_search' => false));
        if(in_array($post_type, $post_types)){
            $this->update_gallery('update',NULL);
        }
    }
    
    function wpmf_upload_after($metadata, $attachment_id){
        $this->update_gallery('upload',NULL);
        return $metadata;
    }
    
    function wpmf_move_attachment(){
        $this->update_gallery('move',$_POST['ids']);
    }
    
    function wpmf_auto_insert_gallery_folder_1($gallery) {
        global $wpdb;
        $table_term_relationships = $wpdb->prefix.'term_relationships';
        $sql = $wpdb->prepare("SELECT * FROM $table_term_relationships WHERE term_taxonomy_id IN (%s)",array($gallery['wpmf_folder_id']));
        $images = $wpdb->get_results($sql);
        $img_auto = array();
        foreach ($images as $image){
            $image_detail = get_post($image->object_id);
            if(substr($image_detail->post_mime_type,0,5) == 'image'){
                $img_auto[] = $image->object_id;
            }
        }
        return $img_auto;
    }
    
    function wpmf_auto_insert_gallery_folder_0() {
        global $wpdb;
        $img_folders = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix.'term_relationships' );
        $img_1 = array();
        $img_a = array();
        foreach ($img_folders as $img_folder){
            $img_1[] = $img_folder->object_id;
        }
        
        $all_images = get_posts(array('post_type' => 'attachment','numberposts' => -1));
        foreach ($all_images as $all_image){
            if(substr($all_image->post_mime_type,0,5) == 'image'){
                $img_a[] = $all_image->ID;
            }
        }
        
        $img_auto = array_diff($img_a,$img_1);
        return $img_auto;
    }
    
    function upload_update_post($gallery,$ids_old_array){
        $folder_ids = explode(',', $gallery['wpmf_folder_id']);
        $img_auto_0 = array();
        $img_auto_1 = array();
        $img_auto = array();
        foreach ($folder_ids as $folder_id){
            if(isset($folder_id) && $folder_id !='' ){
                if($folder_id !=0){
                    $imgs = get_objects_in_term( $folder_id, 'wpmf-category' );
                    foreach ($imgs as $img){
                        if(in_array($img, $img_auto_1) == false){
                            array_push($img_auto_1, $img);
                        }
                    }
                }else{
                    $img_auto_0 = $this->wpmf_auto_insert_gallery_folder_0();
                }
                
            }
        }
        
        $img_auto = array_merge($img_auto_1,$img_auto_0);
        $ids_new_array = array_merge($ids_old_array,array_diff($img_auto,$ids_old_array));
        return $ids_new_array;
    }
    
    function update_gallery($action,$pid) {
        global $wpdb;
        $post_types = get_post_types(array('public' => true, 'exclude_from_search' => false));
        $sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix. "posts WHERE post_content LIKE %s ",array('%wpmf_autoinsert="1"%'));
        $posts = $wpdb->get_results($sql);
       
        foreach ($posts as $post){
            if(in_array($post->post_type, $post_types)){
                $galleries = get_post_galleries( $post->ID,false);
                foreach ($galleries as $gallery){
                    $ids_old = 'ids="'.$gallery['ids'].'"';
                    $ids_old_array = explode(',', $gallery['ids']);
                    if(!empty($gallery['wpmf_folder_id']) && isset($gallery['wpmf_autoinsert']) && $gallery['wpmf_autoinsert'] == 1){
                        if($action == 'upload' || $action == 'update'){
                            $ids_new_array = $this->upload_update_post($gallery,$ids_old_array);
                            $ids_new = 'ids="'.trim(implode(',', $ids_new_array),',').'"';
                            if($ids_new_array != $ids_old_array){
                                $post_content = str_replace($ids_old, $ids_new, $post->post_content);
                                wp_update_post(array('ID' => $post->ID , 'post_content' => $post_content));
                            }
                        }else if($action == 'delete'){
                            if(in_array($pid, $ids_old_array) == true){
                                $key = array_search($pid, $ids_old_array);
                                unset($ids_old_array[$key]);
                            }
                            
                            $ids_new = 'ids="'.trim(implode(',', $ids_old_array),',').'"';
                            $post_content = str_replace($ids_old, $ids_new, $post->post_content);
                            wp_update_post(array('ID' => $post->ID , 'post_content' => $post_content));
                        }else{
                            // $action = 'move'
                            $ids = explode(',', $pid);
                            foreach ($ids as $id){
                                if(in_array($id, $ids_old_array) == true){
                                    $key = array_search($id, $ids_old_array);
                                    unset($ids_old_array[$key]);
                                }
                            }

                            $ids_new_array = $this->upload_update_post($gallery,$ids_old_array);
                            $ids_new = 'ids="'.trim(implode(',', $ids_new_array),',').'"';
                            $post_content = str_replace($ids_old, $ids_new, $post->post_content);
                            wp_update_post(array('ID' => $post->ID , 'post_content' => $post_content));
                        }
                    }
                }
            }
            
        }
    }
    
}
