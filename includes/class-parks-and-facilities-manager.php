<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Parks_Manager
{
    public function __construct()
    {
        add_action('init', [$this, 'register_park_post_type']);
        add_action('init', [$this, 'register_facilities_taxonomy']);
        add_action('add_meta_boxes', [$this, 'add_park_meta_boxes']);
        add_action('save_post', [$this, 'save_park_meta']);
        add_shortcode('park_list', [$this, 'display_parks_shortcode']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
    }

    public function register_park_post_type()
    {
        $labels = [
            'name'               => __('Parks', 'parks-manager'),
            'singular_name'      => __('Park', 'parks-manager'),
            'add_new'            => __('Add New Park', 'parks-manager'),
            'add_new_item'       => __('Add New Park', 'parks-manager'),
            'edit_item'          => __('Edit Park', 'parks-manager'),
            'new_item'           => __('New Park', 'parks-manager'),
            'view_item'          => __('View Park', 'parks-manager'),
            'search_items'       => __('Search Parks', 'parks-manager'),
            'not_found'          => __('No parks found', 'parks-manager'),
            'not_found_in_trash' => __('No parks found in Trash', 'parks-manager'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'rewrite'            => ['slug' => 'parks'],
            'supports'           => ['title', 'editor', 'thumbnail'],
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-palmtree',
            'show_in_rest'       => true,
        ];

        register_post_type('park', $args);
    }

    public function register_facilities_taxonomy()
    {
        $labels = [
            'name'              => __('Facilities', 'parks-manager'),
            'singular_name'     => __('Facility', 'parks-manager'),
            'search_items'      => __('Search Facilities', 'parks-manager'),
            'all_items'         => __('All Facilities', 'parks-manager'),
            'edit_item'         => __('Edit Facility', 'parks-manager'),
            'update_item'       => __('Update Facility', 'parks-manager'),
            'add_new_item'      => __('Add New Facility', 'parks-manager'),
            'new_item_name'     => __('New Facility Name', 'parks-manager'),
            'menu_name'         => __('Facilities', 'parks-manager'),
        ];

        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'facility'],
            'show_in_rest'      => true,
        ];

        register_taxonomy('facility', ['park'], $args);
    }

    public function add_park_meta_boxes()
    {
        add_meta_box(
            'park_meta_box',
            __('Park Details', 'parks-manager'),
            [$this, 'render_park_meta_box'],
            'park',
            'normal',
            'high'
        );
    }

    public function render_park_meta_box($post)
    {
        wp_nonce_field('save_park_meta', 'park_meta_nonce');

        $location = get_post_meta($post->ID, 'location', true);
        $hours_weekday = get_post_meta($post->ID, 'hours_weekday', true);
        $hours_weekend = get_post_meta($post->ID, 'hours_weekend', true);

        echo '<p><label for="location">' . __('Location', 'parks-manager') . '</label></p>';
        echo '<input type="text" id="location" name="location" value="' . esc_attr($location) . '" style="width: 100%;" />';

        echo '<p><label for="hours_weekday">' . __('Hours (Weekdays)', 'parks-manager') . '</label></p>';
        echo '<input type="text" id="hours_weekday" name="hours_weekday" value="' . esc_attr($hours_weekday) . '" style="width: 100%;" />';

        echo '<p><label for="hours_weekend">' . __('Hours (Weekends)', 'parks-manager') . '</label></p>';
        echo '<input type="text" id="hours_weekend" name="hours_weekend" value="' . esc_attr($hours_weekend) . '" style="width: 100%;" />';
    }

    public function save_park_meta($post_id)
    {
        if (!isset($_POST['park_meta_nonce']) || !wp_verify_nonce($_POST['park_meta_nonce'], 'save_park_meta')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['location'])) {
            update_post_meta($post_id, 'location', sanitize_text_field($_POST['location']));
        }

        if (isset($_POST['hours_weekday'])) {
            update_post_meta($post_id, 'hours_weekday', sanitize_text_field($_POST['hours_weekday']));
        }

        if (isset($_POST['hours_weekend'])) {
            update_post_meta($post_id, 'hours_weekend', sanitize_text_field($_POST['hours_weekend']));
        }
    }

    public function display_parks_shortcode()
    {
        $parks = new WP_Query([
            'post_type'      => 'park',
            'posts_per_page' => -1,
        ]);

        if (! $parks->have_posts()) {
            return '<p>No parks available.</p>';
        }

        $output = '<div class="parks-list">';

        while ($parks->have_posts()) {
            $parks->the_post();

            $location = get_post_meta(get_the_ID(), 'location', true);
            $hours_weekday = get_post_meta(get_the_ID(), 'hours_weekday', true);
            $hours_weekend = get_post_meta(get_the_ID(), 'hours_weekend', true);
            $description = wp_trim_words(get_the_content(), 20);
            $featured_image = get_the_post_thumbnail(get_the_ID(), 'medium', ['style' => 'width: 100%; height: 250px; border-radius: 5px; object-fit: cover;']);

            $output .= '<div class="park-item">';
            $output .= $featured_image;
            $output .= '<div class="park-item--info">';
            $output .= '<a href="https://www.google.com/maps/search/' . urlencode($location) . '" target="_blank"><span class="park-item--location">' . esc_html($location) . '</span></a>';
            $output .= '<h3 class="park-item--title"><a href="' . get_the_permalink() . '">' . esc_html(get_the_title()) . '</a></h3>';
            $output .= '<p class="park-item--desc">' . wp_kses_post($description) . '</p>';
            $output .= '<p class="park-item--hours"><strong>Weekday Hours:</strong> ' . esc_html($hours_weekday) . '</p>';
            $output .= '</div>';
            $output .= '</div>';
        }

        wp_reset_postdata();

        $output .= '</div>';

        return $output;
    }

    public function enqueue_styles()
    {
        wp_enqueue_style(
            'parks-manager-style',
            plugin_dir_url(dirname(__FILE__)) . 'css/style.css',
            [],
            '1.0.0'
        );
    }
}
