<?php

// Shortcode for borchers custom products on /products page

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Security: block direct access.
}

// Shortcode for borchers_products
add_shortcode('info_center_content', 'render_info_center_content');

function render_info_center_content() {
    // will eventually need js
    // Load javascript for modal
    //wp_enqueue_script( 'borchers-products-filter-js' );

    function render_info_center() {

        $args = array(
            'status'    =>  'publish',
            'limit'     =>  -1,
            'paginate'  =>  false,
            'orderby'   =>  'name',
            'order'     =>  'ASC',

            );
        // Get all woocommerce products
        $products = wc_get_products( $args ); 

        foreach ( $products as $product ) {
            echo '<hr><h2>Product: ' . $product->get_name() . ' (ID: ' . $product->get_id() . ')</h2>';
            // Paste the dump code from above here, but without re-defining $product
            // Assuming you're in a loop or have a product ID
            $product_id = $product->get_id(); // ← CHANGE THIS to your product ID, or get it dynamically

            $product = wc_get_product( $product_id );

            if ( ! $product ) {
                echo 'Product not found.';
                return;
            }

            $product_id = $product->get_id();

            echo '<h2>Start Formulations Data Only</h2>';

            // 1. Best way - Use ACF get_field() 
            echo '<h3>Using get_field() - Recommended</h3>';
            $start_formulations = get_field( 'start_formulations', $product_id );

            echo '<pre>';
            print_r( $start_formulations );
            echo '</pre>';

            // If it's a Repeater, Group, or Flexible Content field, loop through it nicely:
            if ( $start_formulations ) {
                if ( have_rows( 'start_formulations', $product_id ) ) {
                    echo '<h4>Repeater / Group Content:</h4>';
                    while ( have_rows( 'start_formulations', $product_id ) ) : the_row();
                        
                        // Replace these with your actual sub field names
                        $sub_field1 = get_sub_field( 'your_sub_field_name' );   // e.g. 'formulation_name'
                        $sub_field2 = get_sub_field( 'another_sub_field' );
                        
                        echo '<p><strong>Sub Field:</strong> ' . esc_html( $sub_field1 ) . '</p>';
                        // add more as needed
                    endwhile;
                } else {
                    // Not a repeater - just a normal field (text, number, image, etc.)
                    echo '<p><strong>Value:</strong> ' . esc_html( print_r( $start_formulations, true ) ) . '</p>';
                }
            } else {
                echo '<p>No data found for start_formulations.</p>';
            }

            // 2. Also show the raw meta keys related to it (for debugging)
            echo '<h3>Raw Meta Keys Containing "start_formulations"</h3>';
            $all_meta = get_post_meta( $product_id );

            echo '<pre>';
            foreach ( $all_meta as $key => $value ) {
                if ( stripos( $key, 'start_formulations' ) !== false ) {
                    echo $key . ' => ';
                    print_r( $value[0] ?? $value );
                    echo "\n\n";
                }
            }
            echo '</pre>';

        }
    }


    


    ob_start();
    ?>

    <style>


    </style>

    <div id="borchers-products-container">
        <p></p>
        <ul id="custom-products-list">
            <?php render_info_center(); ?>
        </ul>
        <div id="pagination-container">
            <ul id="pagination">
                <li>Page 1</li>
            </ul>
        </div>
        
    </div>

    <?php
    return ob_get_clean();

}