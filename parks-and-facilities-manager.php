<?php

/**
 * Plugin Name: Parks and Facilities Manager
 * Description: A plugin to manage parks with a custom post type, taxonomy, and a shortcode to display parks.
 * Version: 1.0.0
 * Author: Rohan T George
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include the main class file
require_once plugin_dir_path(__FILE__) . 'includes/class-parks-and-facilities-manager.php';

// Initialize the plugin
new Parks_Manager();
