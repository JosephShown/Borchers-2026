<?php

// Activation and configuration
register_activation_hook( __FILE__, 'bcs_set_blog_permalink_prefix_on_activation' );
register_deactivation_hook( __FILE__, 'bcs_set_blog_permalink_prefix_on_deactivation' );

function bcs_set_blog_permalink_prefix_on_activation() {
    // Only proceed if permalink structure is not already set
    $current_structure = get_option('permalink_structure');
    $desired_structure = '/news-events-blog/%postname%/';
    // Save original structure for restoration on deactivation
    if (get_option('bcs_permalink_structure_backup') === false) {
        $original_structure = add_option('bcs_permalink_structure_backup', $current_structure);
    }

    if ( $current_structure !== $desired_structure ) {
        update_option( 'permalink_structure', $desired_structure );
        flush_rewrite_rules( true ); // true = hard flush, regenerates .htaccess rules
        set_transient ('bcs_activation_notice', true, 30);
    }
}

function bcs_set_blog_permalink_prefix_on_deactivation() {
    // Only proceed if permalink structure is not already set
    $current_structure = get_option('permalink_structure');
    $original_structure = get_option('bcs_permalink_structure_backup');

    if ( $current_structure !== $original_structure ) {
        update_option( 'permalink_structure', $original_structure );
        delete_option('bcs_permalink_structure_backup');
        flush_rewrite_rules( true ); // true = hard flush, regenerates .htaccess rules
    }
}

add_action( 'admin_notices', 'bcs_show_admin_notices' );
// Admin notices
function bcs_show_admin_notices() {
    // Only show to admins
    if (! current_user_can( 'manage_options' )) {
        return;
    }

    // Activation notice
    if ( get_transient( 'bcs_activation_notice')) {
        error_log('in transient if admin');
        ?>
        <div class="notice notice-success is-dismissible">
            <p>Borchers custom settings plugin activated.</p>
        </div>
        <?php
        delete_transient( 'bcs_activation_notice' );
    }

}