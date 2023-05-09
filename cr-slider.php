<?php

/**
 * Plugin Name: CR Slider
 * Plugin URI: https://www.wordpress.org/cr-slider
 * Description: A good plugin
 * Version: 1.0
 * Requires at least: 5.6
 * Author: Carlos Ramirez
 * Author URI: https://www.cjramirez.tech
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gol-2.0.html
 * Text Domain: cr-slider
 * Domain Path: /languages
 */

//  Makes sure the plugin files can't be access directly
if (!defined('ABSPATH')) {
    exit;
}

//Run this code if the class CR_Slider doesn't exist
if (!class_exists('CR_Slider')) {
    class CR_Slider
    {
        //Runs when class is created
        public function __construct()
        {
            $this->define_constants();

            //Creates menu
            add_action('admin_menu', array($this, 'add_menu'));

            //Requires the file
            require_once CR_SLIDER_PATH . 'post-types/class.cr-slider-cpt.php';
            //Creates a new instance of the class
            $CR_Slider_Post_Type = new CR_Slider_Post_Type();
        }

        public function define_constants()
        {
            //Sets CR_SLIDER_PATH = /home/www/your_site/wp-content/plugins/your-plugin/
            define('CR_SLIDER_PATH', plugin_dir_path(__FILE__));
            //Sets CR_SLIDER_URL = http://example.com/wp-content/plugins/cr-slider/
            define('CR_SLIDER_URL', plugin_dir_url(__FILE__));
            //Sets CR_SLIDDER_VERSION = 1.0.0
            define('CR_SLIDER_VERSION', '1.0.0');
        }

        //Methods have to be static so they can be accessed without creating a new instance of the object
        public static function activate()
        {
            //Clears out the rewite rules table in wp
            update_option('rewrite_rules', '');
        }

        public static function deactivate()
        {
            //Removes rewrite rules and then recreate rewrite rules.
            flush_rewrite_rules();

            //Removes cr-slider post type
            unregister_post_type('cr-slider');
        }

        public static function uninstall()
        {
            # code...
        }

        //Adds menu to the sidebar
        public function add_menu()
        {
            add_menu_page(
                //Title for menu page
                'CR Slider Options',
                //Menu title
                'CR Slider',
                //What kind of access is needed
                'manage_options',
                //Slug
                'cr_slider_admin',
                //Call back function to provide page
                array($this, 'cr_slider_settings_page'),
                //Adds an icon, this is optional
                'dashicons-images-alt2',
                //Position of the icon, also optional and better to leave as is
                // 10

            );
        }

        public function cr_slider_settings_page()
        {
            echo "This is a test page";
        }
    }
}

//Run this code if the class CR_Slider does exist
if (class_exists('CR_Slider')) {
    //Runs when plugin is activated
    register_activation_hook(__FILE__, array('CR_Slider', 'activate'));
    //Runs when plugin is deactivated
    register_deactivation_hook(__FILE__, array('CR_Slider', 'deactivate'));
    //Runs when plugin is uninstalled
    register_uninstall_hook(__FILE__, array('CR_Slider', 'uninstall'));

    //Create a new instance of the CR_Slider class and trigger the construct method
    $cr_slider = new CR_Slider();
}