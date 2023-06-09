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

            require_once CR_SLIDER_PATH . 'functions/functions.php';

            //Creates menu
            add_action('admin_menu', array($this, 'add_menu'));

            //Requires the file
            require_once CR_SLIDER_PATH . 'post-types/class.cr-slider-cpt.php';
            //Creates a new instance of the class
            $CR_Slider_Post_Type = new CR_Slider_Post_Type();

            //Requires the file
            require_once CR_SLIDER_PATH . 'class.cr-slider-settings.php';
            //Creates a new instance of the class
            $CR_Slider_Settings = new CR_Slider_Settings();

            //Requires the file
            require_once CR_SLIDER_PATH . 'shortcodes/class.cr-slider-shortcode.php';
            //Creates a new instance of the class
            $CR_Slider_Shortcode = new CR_Slider_Shortcode();

            //Enqueing js and css
            add_action('wp_enqueue_scripts', array($this, 'register_scripts'), 999);

            //Enqueing backend js and css
            add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'), 999);

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

        //Runs when plugin is uninstalled
        public static function uninstall()
        {
            //Deletes from options table
            delete_option('cr_slider_options');
            //Gets all cr-slider posts
            $posts = get_posts(
                array(
                    'post' => 'cr-slider',
                    'number_post' => -1,
                    'post_status' => 'any',
                )
            );

            //Loops through the posts and deletes them
            foreach ($posts as $post) {
                wp_delete_post('$post->ID', true);
            }
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

            //Creates a submenu option for manage slides that points back to the Slider page
            add_submenu_page(
                //Slug of the parent menu
                'cr_slider_admin',
                //Page title
                'Manage Slides',
                //Menu title
                'Manage Slides',
                //What kind of access is needed
                'manage_options',
                //Slug for sub menu, in this case it is the url of the Slider page
                'edit.php?post_type=cr-slider',
                //The call back function to provide page, in this case using null because we are using the slider page
                null,
                //Position of the icon, also optional and better to leave as is
                null
            );

            add_submenu_page(
                //Slug of the parent menu
                'cr_slider_admin',
                //Page title
                'Add New Slide',
                //Menu title
                'Add New Slide',
                //What kind of access is needed
                'manage_options',
                //Slug for sub menu, in this case it is the url of the Add New page
                'post-new.php?post_type=cr-slider',
                //The call back function to provide page, in this case using null because we are using the add new page
                null,
                //Position of the icon, also optional and better to leave as is
                null

            );

        }

        public function cr_slider_settings_page()
        {
            //Checks the user permissions before getting page
            if (!current_user_can('manage_options')) {
                return;
            }

            //Checks if settings were saved and shows success message
            if (isset($_GET['settings-updated'])) {
                add_settings_error('cr_slider_options', 'cr_slider_message', 'Setting Saved', 'success');
            }
            settings_errors('cr_slider_options');

            require CR_SLIDER_PATH . "views/settings-page.php";
        }

        public function register_scripts()
        {
            wp_register_script('cr-slider-main-jq', CR_SLIDER_URL . 'vendor/flexslider/jquery.flexslider-min.js', array('jquery'), CR_SLIDER_VERSION, true);
            wp_register_script('cr-slider-options-js', CR_SLIDER_URL . 'vendor/flexslider/flexslider.js', array('jquery'), CR_SLIDER_VERSION, true);
            wp_register_style('cr-slider-main-css', CR_SLIDER_URL . 'vendor/flexslider/flexslider.css', array(), CR_SLIDER_VERSION, 'all');
            wp_register_style('cr-slider-style-css', CR_SLIDER_URL . 'assets/css/frontend.css', array(), CR_SLIDER_VERSION, 'all');
        }

        public function register_admin_scripts()
        {
            //Gets the type of the current post
            global $typenow;
            //Eneques the css only for post type cr-slider
            if ($typenow == 'cr-slider') {
                wp_enqueue_style('cr-slider-admin', CR_SLIDER_URL . 'assets/css/admin.css');

            }
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
