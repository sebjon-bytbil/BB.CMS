<?php
    /**
    * @param $vcMap - array according to https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
    */
    class ShortcodeBase
    {

        public $vcMap;
        public $tpl;

        function __construct($vcMap)
        {
            $this->vcMap = $vcMap;
            $this->SetTemplate();
            $this->SetDefaultTab();
            //crate shortcode
            add_shortcode( $this->vcMap['base'], array($this, "CreateShortCode") );

            //add map
            add_action( "init", array($this, "SetMap"), 10, 1);

            // Enqueue scripts
            add_action('wp_enqueue_scripts', array($this, 'RegisterScripts'), 10, 1);
        }

        public function SetMap(){
            // Innan här
            if (function_exists('vc_map')) {
                vc_map($this->vcMap);
            }

        }

        public function SetDefaultTab()
        {
            foreach ($this->vcMap["params"] as $key => $param) {
                if(!isset($param['group'])){
                    $param['group'] = 'Innehåll';
                }
            }
        }

        public function RegisterScripts()
        {
            // Nothing to see here, move along.
            // Inherit this in class.
        }

        public function EnqueueScripts()
        {
            // Nothing to see here, move along.
            // Inherit this in class.
        }

        public function ProcessData($atts){
            // This comment is self explanatory.
            return $atts;
        }

        // Move this
        /*add_filter('vc-process-data-i,aagesöoder', 'funktionen', 10, 1);
        function funktionen($atts)
        {

            $atts['slider_effect'] = 'fade';
            $atts['slider_animation_speed'] = '200';
            return $atts;
        }*/

        public function CreateShortCode($atts){
            $atts['blockid'] = $this->GenerateId();
            $atts = $this->ProcessData($atts);
            $atts = apply_filters("vc-process-data-" . $this->vcMap['base'], $atts);
            $this->EnqueueScripts();
            ob_start();
            extract($atts);
            $data = $atts;
            include($this->vcMap["html_template"]);
            return ob_get_clean();
        }

        /**
         * @param var
         * @param string - return value if not exists
         *
         * return var or string
         */
        public function Exists($var, $val = false)
        {
            if (isset($var) && $var !== '') {
                return $var;
            }
            return $val;
        }

        public function hex2rgba($color, $opacity = false)
        {
            $default = 'rgb(0,0,0)';

            //Return default if no color provided
            if (empty($color))
                return $default;

            //Sanitize $color if "#" is provided
            if ($color[0] == '#') {
                $color = substr($color, 1);
            }

            //Check if color has 6 or 3 characters and get values
            if (strlen($color) == 6) {
                $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
            } elseif (strlen($color) == 3) {
                $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
            } else {
                return $default;
            }

            //Convert hexadec to rgb
            $rgb = array_map('hexdec', $hex);

            //Check if opacity is set(rgba or rgb)
            if ($opacity) {
                if (abs($opacity) > 1)
                    $opacity = 1.0;
                $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
            }
            elseif ($opacity == '0') {
                $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
            }else {
                $output = 'rgb(' . implode(",", $rgb) . ')';
            }

            //Return rgb(a) color string
            return $output;
        }

        protected function GenerateId(){
            return uniqid($this->vcMap['base'] . "_");
        }

        protected function SetTemplate(){
            $base = $this->vcMap['base'];
            $tpl = '';
            $currentTheme = get_stylesheet_directory();

            if (file_exists($currentTheme . "/vc_templates/" . $base . ".tpl.php")) {
                $tpl = $currentTheme . "/vc_templates/" . $base . ".tpl.php";
            }else{
                $tpl = VCADMINPATH . "templates/" . $base . ".tpl.php";
            }

            $this->vcMap["html_template"] = $tpl;

        }

    }
?>