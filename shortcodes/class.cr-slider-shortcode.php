<?php

if (!class_exists('CR_Slider_Shortcode')) {
    class CR_Slider_Shortcode
    {
        public function __construct()
        {
            add_shortcode('cr_slider', array($this, 'add_shortcode'));
        }

        public function add_shortcode($atts = array(), $content = null, $tag = '')
        {
            //Makes the atts passed by the user to lower case
            $atts = array_change_key_case((array) $atts, CASE_LOWER);

            //extract makes the attributes into vars
            extract(shortcode_atts(
                //Sets default values for the atts

                array(
                    'id' => '',
                    'orderby' => 'date',
                ),
                //Where the arributes come from
                $atts,
                $tag
            ));

            //Allows user to input numbers seperated by commas and delete any none number inputs
            if (!empty($id)) {
                //absint convert a value to an int. explode creates an array seperating the input by commas
                $id = array_map('absint', explode(',', $id));
            }

            //Pushes the html into a buffer and then returns is
            ob_start();
            require CR_SLIDER_PATH . 'views/cr-slider_shortcode.php';
            wp_enqueue_script('cr-slider-main-jq');
            wp_enqueue_script('cr-slider-options-js');
            wp_enqueue_style('cr-slider-main-css');
            wp_enqueue_style('cr-slider-style-css');
            return ob_get_clean();
        }
    }

}
