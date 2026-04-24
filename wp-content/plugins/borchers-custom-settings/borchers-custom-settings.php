<?php

/**
 * Plugin Name: Borchers Custom Settings
 * Plugin URI: https://wpwebdevelopment.com
 * Author: Joseph Shown
 * Author URI: https://wpwebdevelopment.com
 * Description: Automatically runs custom site settings on activation including: News-events-blog permalink structure.
 * Version: 3.0.0
 * Requires at least: 6.0
 * Tested up to: 6.8.3
 * Requires PHP: 7.4
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Security: block direct access.
}

// Define the plugin path
define( 'BCS_PATH', plugin_dir_path( __FILE__ ) );

// Include other plugin files
require_once BCS_PATH . 'admin-page.php';
require_once BCS_PATH . 'permalink-settings.php';
require_once BCS_PATH . 'custom-products.php';
require_once BCS_PATH . 'custom-products-filter.php';
require_once BCS_PATH . 'enable-coming-soon.php';
require_once BCS_PATH . 'enable-fontawesome.php';
require_once BCS_PATH . 'media-modal-shortcode.php';
require_once BCS_PATH . 'product-breadcrumbs-shortcode.php';
require_once BCS_PATH . 'news-events-blog-shortcode.php';
require_once BCS_PATH . 'blog-media-links-shortcode.php';
require_once BCS_PATH . 'blog-breadcrumbs-shortcode.php';
require_once BCS_PATH . 'info-center.php';

// Add the admin menu page
add_action( 'admin_menu', 'borchers_add_settings_page' );
function borchers_add_settings_page() {
    add_menu_page(
        __( 'Borchers Custom Settings', 'borchers-custom-settings' ), // Page title
        __( 'Borchers Settings', 'borchers-custom-settings' ),       // Menu title
        'manage_options',                                            // Required capability
        'borchers-custom-settings',                                  // Slug
        'borchers_render_settings_page',                             // Callback
        'dashicons-admin-generic',                                   // Icon
        81                                                           // Position
    );
}


// Enqueue javascript for product media modal shortcode
function register_borchers_product_media_modal_script() {
    wp_register_script(
        'borchers-product-media-modal-js',
        plugin_dir_url( __FILE__ ) . 'js/product-media-modal.js',
        array(),
        1.0,
        true
    );
    wp_register_script(
        'borchers-products-filter-js',
        plugin_dir_url( __FILE__ ) . 'js/products-filter.js',
        array(),
        1.0,
        true
    );

    // Add module to script for import/export
    add_filter('script_loader_tag', function($tag, $handle, $src) {
        if ( 'borchers-products-filter-js' === $handle ) {
            $tag = str_replace('<script', '<script type="module" ', $tag);
        }
        return $tag;
    }, 10, 3);

    wp_register_script( 
        'youtube-iframe-api', // 1. Handle (Unique ID for the script)
        'https://www.youtube.com/iframe_api', // 2. Source URL of the script
        array(), // 3. Dependencies (none needed for this script)
        null, // 4. Version number (null means no version)
        true // 5. Load in footer (true is recommended for performance)
    );

    wp_enqueue_style('borchers-custom-styles', plugin_dir_url(__FILE__) . 'css/borchers-custom-styles.css', array(), '1.0.0');
}
add_action( 'wp_enqueue_scripts', 'register_borchers_product_media_modal_script' );


// Apply admin-bar color (only when enabled)
add_action( 'admin_head', 'borchers_maybe_add_admin_bar_css' );
function borchers_maybe_add_admin_bar_css() {
    if ( '1' !== get_option( 'borchers_admin_bar_enabled' ) ) {
        return;
    }
    $color = get_option( 'borchers_admin_bar_color', '#619834' );
    $color = sanitize_hex_color( $color );
    if ( $color ) {
        echo '<style>#wpadminbar{background:' . esc_attr( $color ) . ' !important;}</style>';
    }
}


// Echo page/post ID in footer + console.log (only when enabled)
add_action( 'wp_footer', 'borchers_maybe_log_page_id' );
function borchers_maybe_log_page_id() {
    if ( '1' !== get_option( 'borchers_page_id_logger_enabled' ) ) {
        return;
    }
    $id = get_the_ID();
    if ( ! $id ) {
        return;
    }

    // Start output buffering
    ob_start();
    // Display html result and run script
    ?>
    <p style="text-align:center; font-size:12px; color:#777;">
        <?php echo esc_html__( 'Current Page/Post ID: ', 'borchers-custom-settings' ) . esc_html( $id ); ?>
    </p>
    <script>
        console.log("Current Page/Post ID: <?php echo esc_js( $id ); ?>");
    </script>
    <?php
    // Get buffered content and output it
    echo ob_get_clean();
}


// Set HTTP HEADERS for things like elementor to work properly and increase security
add_action( 'send_headers', 'borchers_send_security_headers' );

function borchers_send_security_headers() {
    // Only on frontend, not admin or REST/API
    if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
        return;
    }

    // HSTS
    if ( '1' === get_option( 'borchers_hsts_enabled' ) ) {
        $hsts = 'max-age=31536000; includeSubDomains';
        header( 'Strict-Transport-Security: ' . $hsts );
    }

    // CSP
    $csp = get_option( 'borchers_csp', '' );
    if ( ! empty( $csp ) ) {
        header( 'Content-Security-Policy: ' . sanitize_text_field( $csp ) );
    }

    // X-Frame-Options
    if ( '1' === get_option( 'borchers_xframe_enabled' ) ) {
        header( 'X-Frame-Options: SAMEORIGIN' );
    }

    // X-Content-Type-Options
    if ( '1' === get_option( 'borchers_xcontent_enabled' ) ) {
        header( 'X-Content-Type-Options: nosniff' );
    }
}


// Rewrite urls for the products page to receive them and go to the preset category
function custom_products_rewrite_rules() {
    // creates a placeholder to be used with query_var or localized to javascript passing the url parameters
    add_rewrite_tag( '%product_category%', '([^/]+)' );
    // use rewrite rule to intercept urls containing /products/category/ then route to products page with our placeholder
    add_rewrite_rule(
        '^products/category/([^/]+)/?$',
        'index.php?pagename=products&product_category=$matches[1]',
        'top'
    );
}

add_action( 'init', 'custom_products_rewrite_rules' );


//add_action('wp_footer', 'debug_current_template_info');
function debug_current_template_info() {
    if (!current_user_can('manage_options')) return; // Only show for admins

    global $template;
    $is_cart = is_cart() ? 'YES' : 'NO';
    $is_checkout = is_checkout() ? 'YES' : 'NO';
    $is_search = is_search() ? 'YES' : 'NO';
    $template_file = basename($template);

    echo '<div style="position:fixed; bottom:0; left:0; width:100%; background:#000; color:#0f0; z-index:99999; font-family:monospace; padding:10px; font-size:12px; border-top:2px solid #0f0;">';
    echo "FILE: $template_file | IS_CART: $is_cart | IS_CHECKOUT: $is_checkout | IS_SEARCH: $is_search | DISPLAYED ONLY FOR LOGGED IN ADMINS";
    echo '</div>';
}


// Run code on cart page to set all prices to display none
add_action('wp_head', 'remove_cart_prices');
function remove_cart_prices() {
    if ( is_cart() ) {
        echo '<style>
        .wp-block-woocommerce-cart .wc-block-cart-items__header-total,
        .wp-block-woocommerce-cart .wc-block-cart-item__total,
        .wp-block-woocommerce-cart .wc-block-cart-item__prices,
        .wp-block-woocommerce-cart .wp-block-woocommerce-cart-order-summary-block {
            display: none!important;
        }
        </style>';
    }
}


// Run code on checkout page to set all prices to display none
add_action('wp_head', 'remove_checkout_prices');
function remove_checkout_prices() {
    if ( is_checkout() ) {
        echo '<style>
        .woocommerce .woocommerce-form-coupon-toggle,
        .woocommerce .product-total,
        .woocommerce .cart-subtotal,
        .woocommerce .woocommerce-checkout-review-order-table tfoot {
            display: none!important;
        }
        .woocommerce .woocommerce-checkout-payment #place_order {
            background-color: #00378c!important;
        }
        </style>';
    }
}


// Cart widget
add_action('wp_head', 'remove_cart_widget_prices');
function remove_cart_widget_prices()  {
    echo '<style>
    .widget_shopping_cart_content .woocommerce-Price-amount, .widget_shopping_cart_content .elementor-menu-cart__subtotal {
        display: none!important;
    }
    </style>';
}


// Search function shortcode
add_shortcode('borchers_custom_search', 'render_borchers_custom_search');
function render_borchers_custom_search() {
    ob_start();
    ?>

    <style>
        #borchers-search-container form {
                display: flex;
        }

        #borchers-search-container input {
            border: 1px solid #2187b4;
            font-size: .8rem;
            font-style: italic;
            border-radius: 0;
        }

        #borchers-search-container input:active, #borchers-search-container input:focus {
            border: 1px solid #2187b4;
            outline: none;
        }

        #borchers-search-container input[type=submit] {
            background-image: url('https://borchers.com/wp-content/themes/borchers-theme/dist/images/srch.png');
            display: inline-block;
            color: transparent;
            height: 42px;
            width: 40px;
            background-color: #2187b4;
            background-size: 16px;
            background-repeat: no-repeat;
            background-position: 50%;
            padding: 0;
            margin: 0;
            border-color: #2187b4;
            border-radius: 0;
            margin-left: -2px;
        }
    </style>
    <div id="borchers-search-container">
        <form role="search" id="borchers-custom-search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" placeholder="Search..." name="s">
            <input type="submit">
        </form>
    </div>

    <?php
    return ob_get_clean();
}


// Include custom search template to theme using page builder
add_filter( 'template_include', 'borchers_force_search_template', 9999 );
function borchers_force_search_template( $template ) {
    if ( is_search() ) {
        $search_template = locate_template( 'search.php' );
        if ( $search_template ) {
            return $search_template;
        }
    }
    return $template;
}


// Redirect a specific old URL to a new URL
// /meko-free => /products/category/meko-free
function custom_redirect_oxime_meko_free() {
    
    // Get the current URL path (without domain)
    $current_url = $_SERVER['REQUEST_URI'];
    
    // Redirect oxime free
    if ( $current_url === '/oxime-free/' || $current_url === '/oxime-free' ) {
        wp_redirect( home_url( '/products/category/oxime-free/' ), 301 );  // 301 = Permanent redirect
        exit;  // Always use exit after wp_redirect
    }

    // Redirect meko free
    if ( $current_url === '/meko-free/' || $current_url === '/meko-free' ) {
        wp_redirect( home_url( '/products/category/meko-free/' ), 301 );  // 301 = Permanent redirect
        exit;  // Always use exit after wp_redirect
    }
    
}

add_action( 'template_redirect', 'custom_redirect_oxime_meko_free' );