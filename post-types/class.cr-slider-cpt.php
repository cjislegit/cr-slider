<?php

//Create class CR_Slider_Post_Type if it doesn't exist
if (!class_exists('CR_Slider_Post_Type')) {
    class CR_Slider_Post_Type
    {
        public function __construct()
        {
            add_action('init', array($this, 'create_post_type'));
            add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
            add_action('save_post', array($this, 'save_post'), 10, 2);
        }

        public function create_post_type()
        {
            //Create a cr-slider post type
            register_post_type(
                "cr-slider",
                array(
                    'label' => 'Slider',
                    'description' => 'Sliders',
                    'lables' => array(
                        'name' => 'Sliders',
                        'singular_name' => 'Slider',
                    ),
                    'public' => true,
                    'supports' => array(
                        'title',
                        'editor',
                        'thumbnail',
                    ),
                    'hierarchical' => false,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export' => true,
                    'has_archive' => false,
                    'exclude_from_search' => false,
                    'publicly_queryable' => true,
                    'show_in_rest' => true,
                    'menu_item' => 'dashicons-images-alt2',

                )
            );
        }

        public function add_meta_boxes()
        {
            add_meta_box(
                'cr_slider_meta_box',
                'Link Options',
                array($this, 'add_inner_meta_boxes'),
                'cr-slider',
                'normal',
                'high'
            );
        }

        public function add_inner_meta_boxes($post)
        {
            //Gets the html
            require_once CR_SLIDER_PATH . 'views/cr-slider_metabox.php';
        }

        public function save_post($post_id)
        {
            if (isset($_POST['action']) && $_POST['action'] == 'editpost') {
                $old_link_text = get_post_meta($post_id, 'cr_slider_text', true);
                $new_link_text = $_POST['cr_slider_link_text'];
                $old_link_url = get_post_meta($post_id, 'url', true);
                $new_link_url = $new_link_text = $_POST['cr_slider_link_url'];

                update_post_meta($post_id, 'cr_slider_text', $new_link_text, $old_link_text);
                update_post_meta($post_id, 'cr_slider_url', $new_link_url, $old_link_url);
            }
        }
    }
}
