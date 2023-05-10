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
            //Adds columns to the slider table
            add_filter('manage_cr-slider_posts_columns', array($this, 'cr_slider_cpt_columns'));
            //Adds items to the new columns
            add_action('manage_cr-slider_posts_custom_column', array($this, 'cr_slider_custom_columns'), 10, 2);
            //Makes new columns sortable
            add_filter('manage_edit-cr-slider_sortable_columns', array($this, 'cr_slider_sortable_columns'));
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
                    //Set to false to hide in the menu since seperate menu item has already been created
                    'show_in_menu' => false,
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

        //Creates two columns in the slider table Link Text and Link URL
        public function cr_slider_cpt_columns($columns)
        {
            $columns['cr_slider_link_text'] = esc_html__('Link Text', 'cr-slider');
            $columns['cr_slider_link_url'] = esc_html__('Link URL', 'cr-slider');
            return $columns;
        }

        //Adds data to the custom columns
        public function cr_slider_custom_columns($column, $post_id)
        {
            switch ($column) {
                case 'cr_slider_link_text':
                    echo esc_html(get_post_meta($post_id, 'cr_slider_link_text', true));
                    break;

                case 'cr_slider_link_url':
                    echo esc_url(get_post_meta($post_id, 'cr_slider_link_url', true));
                    break;
            }
        }

        public function cr_slider_sortable_columns($columns)
        {
            $columns['cr_slider_link_text'] = 'cr_slider_link_text';
            $columns['cr_slider_link_url'] = 'cr_slider_link_url';

            return $columns;
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
            //Checks if nonce exists
            if (isset($_POST['cr_slider_nonce'])) {
                //Checks if the nonce is the correct one and if its not it ends the function
                if (!wp_verify_nonce($_POST['cr_slider_nonce'], 'cr_slider_nonce')) {
                    return;
                }
            }

            // Checks if WP is autosaving and ends the function if it is
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            //Checks if post type is set and if it is set to cr-slider
            if (isset($_POST['post_type']) && $_POST['post_type'] === 'cr-slider') {
                // Checks if the current user can edit pages  if they can't it ends the function
                if (!current_user_can('edit_post', $post_id)) {
                    return;
                    //Checks if the user can edit post and if they can't it ends the function
                } elseif (!current_user_can('edit_post', $post_id)) {
                    return;
                }
            }

            if (isset($_POST['action']) && $_POST['action'] == 'editpost') {
                $old_link_text = get_post_meta($post_id, 'cr_slider_link_text', true);
                $new_link_text = $_POST['cr_slider_link_text'];
                $old_link_url = get_post_meta($post_id, 'cr_slider_link_url', true);
                $new_link_url = $_POST['cr_slider_link_url'];

                if (empty($new_link_text)) {
                    update_post_meta($post_id, 'cr_slider_link_text', 'Add some text');
                } else {
                    //Sanatizes and pushes data to db
                    update_post_meta($post_id, 'cr_slider_link_text', sanitize_text_field($new_link_text), $old_link_text);
                }

                if (empty($new_link_url)) {
                    update_post_meta($post_id, 'cr_slider_link_url', '#');
                } else {
                    //Sanatizes and pushes data to db
                    update_post_meta($post_id, 'cr_slider_link_url', sanitize_text_field($new_link_url), $old_link_url);
                }
            }
        }
    }
}
