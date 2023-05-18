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

            add_settings_section(
                //Section ID
                'cr_slider_second_section',
                //Title of the section
                'Other Plugin Options',
                //Call back function that can be used to add text with explantaiton below the section title, its optional
                null,
                //Name of the page
                'cr_slider_page2'
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

            //Addes fields
            add_settings_field(
                //Id for the field that is used to get the field from the db table
                'cr_slider_title',
                //Title of the field, just works to explain the field
                'Slider Title',
                //Creates the fields content, optional
                array($this, 'cr_slider_title_callback'),
                //Id of the page where this field appears
                'cr_slider_page2',
                //ID of the section
                'cr_slider_second_section'
            );

            //Addes fields
            add_settings_field(
                //Id for the field that is used to get the field from the db table
                'cr_slider_bullets',
                //Title of the field, just works to explain the field
                'Display Bullets',
                //Creates the fields content, optional
                array($this, 'cr_slider_bullets_callback'),
                //Id of the page where this field appears
                'cr_slider_page2',
                //ID of the section
                'cr_slider_second_section'
            );

            //Addes fields
            add_settings_field(
                //Id for the field that is used to get the field from the db table
                'cr_slider_style',
                //Title of the field, just works to explain the field
                'Slider Style',
                //Creates the fields content, optional
                array($this, 'cr_slider_style_callback'),
                //Id of the page where this field appears
                'cr_slider_page2',
                //ID of the section
                'cr_slider_second_section'
            );

        }

        public function cr_slider_shortcode_callback()
        {
            ?>
<span>Use the shortcode [cr_slider] to display the slider in any page/post/widget</span>
<?php
}

        public function cr_slider_title_callback()
        {
            ?>
<input type='text' name="cr_slider_options[cr_slider_title]" id='cr_slider_title'
    value="<?php echo isset(self::$options['cr_slider_title']) ? esc_attr(self::$options['cr_slider_title']) : ''; ?>" <?php
}

        public function cr_slider_bullets_callback()
        {
            ?> <input type='checkbox' name='cr_slider_options[cr_slider_bullets]' id='cr_slider_bullets' value='1' <?php
if (isset(self::$options['cr_slider_bullets'])) {
                checked('1', self::$options['cr_slider_bullets'], true);
            }
            ?> />
<label for='cr_slider_bullets'>Display Bullets</label>

<?php
}

        public function cr_slider_style_callback()
        {
            ?>
<select id='cr_slider_style' name='cr_slider_options[cr_slider_style]'>
    <option value='style-1'
        <?php isset(self::$options['cr_slider_style']) ? selected('style-1', self::$options['cr_slider_style'], true) : '';?>>
        Style-1</option>
    <option value='style-2'
        <?php isset(self::$options['cr_slider_style']) ? selected('style-2', self::$options['cr_slider_style'], true) : '';?>>
        Style-2</option>

    <?php
}

    }
}