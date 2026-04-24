<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Disable file editor
if (get_option('bcs_fontawesome_enabled')) {
    add_action('wp_enqueue_scripts', 'bcs_enqueue_fontawesome');
} else {
    remove_action('wp_enqueue_scripts', 'bcs_enqueue_fontawesome');
}

// Enqueue Fontawesome for icons to work 
function bcs_enqueue_fontawesome() {

    // Enqueue latest fontawesome to fix bug with elementor overwriting internal files
    wp_enqueue_style('bcs-font-awesome', plugin_dir_url(__FILE__) . 'fontawesome/css/all.css', array(), '6.7.2');
    
}
