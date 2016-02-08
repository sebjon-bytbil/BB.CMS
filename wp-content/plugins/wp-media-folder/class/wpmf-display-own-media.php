<?php
require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/class-media-folder.php' );
class Wpmf_Display_Own_Media {

    function __construct() {
        add_action('admin_head', array($this, 'wpmf_admin_head'));
        add_action( 'admin_enqueue_scripts', array($this, 'wpmf_load_custom_wp_admin_script') );
        add_action('wp_ajax_display_media', array($this, 'wpmf_display_media') );
    }
    
    public function wpmf_load_custom_wp_admin_script() {
            wp_register_script('wpmf-filter-display-media', plugins_url( '/assets/js/wpmf-display-media.js', dirname(__FILE__) ),array('plupload'),WPMF_VERSION);
            wp_enqueue_script('wpmf-filter-display-media');
            global $pagenow;
            if($pagenow == 'customize.php'){
                $this->wpmf_admin_head();
            }
    }
    
    function wpmf_admin_head() {
        $wpmfdisplay_media = array('yes' => 'Yes');
        if(isset($_SESSION['wpmf_display_media'])){
            $display = $_SESSION['wpmf_display_media'];
        }else{
            $display = '';
        }
        ?>
        <script type="text/javascript">
            var wpmf_display_media = <?php echo json_encode($wpmfdisplay_media); ?>;
            var no_media_label = '<?php _e('No','wpmf') ?>';
            var yes_media_label = '<?php _e('Yes','wpmf') ?>';
            var wpmf_selected_dmedia = '<?php echo $display; ?>';
            var display_only_media_label = '<?php _e('Display only my own media','wpmf') ?>';
        </script>
        <?php
    }
    
    function wpmf_display_media(){
        if(isset($_POST['wpmf_display_media'])){
            $_SESSION['wpmf_display_media'] = $_POST['wpmf_display_media'];
        }
    }
}
?>