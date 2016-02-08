<?php

class Wpmf_replace_image {

    function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'wpmf_gallery_enqueue_admin_scripts'));
        add_filter("attachment_fields_to_edit", array($this, "wpmf_gallery_attachment_fields_to_edit"), 100, 2);
        add_action('wp_ajax_replace_image', array($this, 'wpmf_replace_image') );
        add_action('wp_ajax_noreplace_image', array($this, 'wpmf_noreplace_image') );
        
        global $pagenow;
        if($pagenow != 'media-new.php'){
            add_filter('wp_handle_upload_prefilter', array( $this,'wpmf_custom_upload_filter') );
        }
    }
    
    function wpmf_custom_upload_filter( $file ){
        if(!empty($_SESSION['wpmf_re']['wpmf_time'])){
            if((time() - (int)$_SESSION['wpmf_re']['wpmf_time']) > 120){
                unset($_SESSION['wpmf_re']);
            }
        }
        
        $info = pathinfo($file['name']);
        $ext  = empty($info['extension']) ? '' : '.' . $info['extension'];

        $_SESSION['wpmf_re']['same_file'] = 0;

        if(isset($_SESSION['wpmf_re']['wpmf_replace']) && $_SESSION['wpmf_re']['wpmf_replace'] == 1 && isset($_SESSION['wpmf_re']['wpmf_postselected'])){
            if($_SESSION['wpmf_re']['post_mime_type'] == 'image'){
                if($_SESSION['wpmf_re']['new_ext'] == $ext){
                    if(wp_delete_attachment( $_SESSION['wpmf_re']['wpmf_postselected'] ) != false){
                        $upload_dir = wp_upload_dir();
                        if($file['error'] == 0) {
                            $file['name'] = $_SESSION['wpmf_re']['old_name'];
                            add_filter( 'wp_generate_attachment_metadata', array($this, 'wpmf_after_upload'), 10, 2 );
                            return $file;
                        }else{
                            unset($_SESSION['wpmf_re']);
                        }
                    }
                }else{
                    if(isset($_SESSION['wpmf_re'])) unset($_SESSION['wpmf_re']);
                    $file['error'] = __('To replace a media and keep the link to this media working, it must be in the same format, ie. jpg > jpg, zip > zip… Thanks!','wpmf');
                }
            }
        }
        
        return $file;
    }
    
    
    public function update_meta_attachment($attachment_id){       
        $upload_dir = wp_upload_dir();
        if(isset($_SESSION['wpmf_re']['caption']) && isset($_SESSION['wpmf_re']['description']) && isset($_SESSION['wpmf_re']['post_parent'])){
            $my_post = array(
                'ID' => $attachment_id,
                'post_excerpt' => $_SESSION['wpmf_re']['caption'],
                'post_content' => $_SESSION['wpmf_re']['description'],
                'post_parent' => $_SESSION['wpmf_re']['post_parent'],
                'post_title' => $_SESSION['wpmf_re']['title'],
            );
            // Update the post into the database
            wp_update_post($my_post);
            if(isset($_SESSION['wpmf_re']['alt'])){
                update_post_meta($attachment_id, '_wp_attachment_image_alt', $_SESSION['wpmf_re']['alt']);
            }
            
            unset($_SESSION['wpmf_re']);
        }
    }
    
    function wpmf_gallery_enqueue_admin_scripts() {
        wp_register_script('replace-image', plugins_url('assets/js/replace-image.js', dirname(__FILE__)), array('jquery'), WPMF_VERSION, true);
        wp_enqueue_script('replace-image');
        wp_enqueue_style('replace-style', plugins_url('assets/css/style_replace_image.css', dirname(__FILE__)),array(), WPMF_VERSION);
    }
    
    public function wpmf_after_upload($metadata, $attachment_id) {
        if(!empty($attachment_id)){
            $this->update_meta_attachment($attachment_id);
        }
        
        return $metadata;
    }
    
    function wpmf_noreplace_image(){
        if(isset($_SESSION['wpmf_re'])){
            unset($_SESSION['wpmf_re']);
            wp_send_json(true);
        }else{
            wp_send_json(false);
        }
    }
    
    function wpmf_replace_image(){
        if(isset($_POST['wpmf_replace']) && isset($_POST['att_selected']) && isset($_POST['wpmf_caption']) && isset($_POST['wpmf_desc']) && isset($_POST['wpmf_alt'])){
            $stt = $_POST['wpmf_replace'];
            $post_selected = $_POST['att_selected'];
            $post = get_post($_POST['att_selected']);
            
            $_SESSION['wpmf_re']['wpmf_time'] = time();
            $_SESSION['wpmf_re']['wpmf_replace'] = 1;
            $_SESSION['wpmf_re']['wpmf_postselected'] = $post_selected;
            $_SESSION['wpmf_re']['caption'] = $_POST['wpmf_caption'];
            $_SESSION['wpmf_re']['description'] = $_POST['wpmf_desc'];
            $_SESSION['wpmf_re']['alt'] = $_POST['wpmf_alt'];
            $_SESSION['wpmf_re']['title'] = $_POST['wpmf_title'];
            
            if(!empty($post)){
                $filetype = wp_check_filetype($post->guid);
                $_SESSION['wpmf_re']['new_ext'] = '.'.$filetype['ext'];
                $_SESSION['wpmf_re']['post_parent'] = $post->post_parent;
                $_SESSION['wpmf_re']['post_mime_type'] = substr($post->post_mime_type, 0,5);
                
                $info_old = pathinfo($post->guid);
                $_SESSION['wpmf_re']['old_name'] = $info_old['basename'];
            }
            
            wp_send_json(true);
        }else{
            wp_send_json(false);
        }
    }
    
    function wpmf_gallery_attachment_fields_to_edit($form_fields, $post) {
        if(isset($_GET['action']) && $_GET['action'] == 'edit'){
            return $form_fields;
        }
        if(substr($post->post_mime_type,0,5) == 'image'){
            $btn_select = '<div class="replace_drag" style="display:none; margin-top:10px; text-align:center;width:96%;height:200px;border:4px dashed #b4b9be;position:relative;"><h3 style="margin-top:40px;" class="upload-instructions drop-instructions">'.__('Drop files here','wpmf').'</h3><p class="upload-instructions drop-instructions">'.__('or','wpmf').'</p><div style="position:absolute;left:50%;top:60%;margin-left:-45px;margin-top:-15px;" id="wpmf_upload" class="button">'.__('Select files','wpmf').'</div></div>';
            $btn_replace = '<div id="wpmfreplace" title="'.__('To replace a media and keep the link to this media working, it must be in the same format, ie. jpg > jpg, zip > zip… Thanks!','wpmf').'" class="button button-primary button-wpmfreplace noreplace" data-replace="0">
                                    '.__('Replace','wpmf').'
                                </div>';
            $form_fields['wpmfbtn_select'] = array(
                        'label' => __( '','wpmf' ) ,
                        'input'	=> 'html',
                        'html'	=> '<div class="replace_wrap">'.$btn_replace.$btn_select.'</div>'
                );
            
        }
        
        return $form_fields;
    }
}