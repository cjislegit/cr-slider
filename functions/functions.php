<?php

if (!function_exists('cr_slider_options')) {
    function cr_slider_options()
    {
        //Checks the cr slider bullets option and saves is to var
        $show_bullets = isset(CR_SLIDER_SETTINGS::$options['cr_slider_bullets']) && CR_Slider_settings::$options['cr_slider_bullets'] == 1 ? true : false;

        //Enques the flexslider js file
        wp_enqueue_script('cr-slider-options-js', CR_SLIDER_URL . 'vendor/flexslider/flexslider.js', array('jquery'), CR_SLIDER_VERSION, true);

        //Injects the value of $show_bullets to the cr-slider-options-js file
        wp_localize_script('cr-slider-options-js', 'SLIDER_OPTIONS', array('controlNav' => $show_bullets));
    }
}
