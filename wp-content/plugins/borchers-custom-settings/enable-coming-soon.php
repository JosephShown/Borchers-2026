<?php
if ( ! defined( 'ABSPATH' )  ) {
    exit;
}

if ( get_option( 'bcs_enable_coming_soon' ) ) {
    add_filter( 'template_include', 'bcs_redirect_non_logged_users_to_coming_soon', 999 );
}

function bcs_redirect_non_logged_users_to_coming_soon( $template ) {
    return $template;
    if ( is_user_logged_in() ) {
        return $template;
    }

    // Go up 1 level from inc/php/ → plugin root
    $plugin_root = plugin_dir_path(__FILE__);
    $coming_soon_template = $plugin_root . '/templates/coming-soon.php';

    if ( file_exists( $coming_soon_template ) ) {
        define( 'BCS_COMING_SOON', true );
        return $coming_soon_template;
    } else {
        wp_die( 'Coming Soon template missing: ' . $coming_soon_template, 'Error', [ 'response' => 503 ] );
    }
}