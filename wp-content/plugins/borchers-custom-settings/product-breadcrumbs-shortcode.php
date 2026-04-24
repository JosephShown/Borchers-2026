<?php
if ( ! defined( 'ABSPATH' )  ) {
    exit;
}

add_shortcode( 'borchers_add_product_breadcrumbs', 'borchers_render_product_breadcrumbs' );
function borchers_render_product_breadcrumbs() {
    ob_start();

    ?>
    <style>
        .product-breadcrumbs, .product-breadcrumbs a {
                color: white;
                font-size: .75rem;
                font-weight: bold;
            }

            .product-breadcrumbs a:hover {
                color: #007bff;
            }
    </style>

    <span class="product-breadcrumbs"><a href="<?php echo site_url(); ?>">Home</a> | <a href="/Products">Products</a> | <a><?php echo get_the_title(); ?></a>

    <?php
    return ob_get_clean();
}