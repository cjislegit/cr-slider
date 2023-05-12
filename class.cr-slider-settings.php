<?php

if (!class_exists('CR_Slider_Settings')) {
    class CR_Slider_Settings
    {
        public static $options;

        public function __construct()
        {
            self::$options = get_option('cr_slider_options');
            add_action('admin_init', array($this, 'admin_init'));
        }

        public function admin_init()
        {
            register_setting('cr_slider_group', 'cr_slider_options');
            //Creates the first section
            add_settings_section(
                //Section ID
                'cr_slider_main_section',
                //Title of the section
                'How does it work?',
                //Call back function that can be used to add text with explantaiton below the section title, its optional
                null,
                //Name of the page
                'cr_slider_page1'
            );

            //Addes fields
            add_settings_field(
                //Id for the field that is used to get the field from the db table
                'cr_slider_shortcode',
                //Title of the field, just works to explain the field
                'Shortcode',
                //Creates the fields content, optional
                array($this, 'cr_slider_shortcode_callback'),
                //Id of the page where this field appears
                'cr_slider_page1',
                //ID of the section
                'cr_slider_main_section'
            );
        }

        public function cr_slider_shortcode_callback()
        {
            ?>
<span>Use the shortcode [cr_slider] to display the slider in any page/post/widget</span>
<?php
}
    }
}