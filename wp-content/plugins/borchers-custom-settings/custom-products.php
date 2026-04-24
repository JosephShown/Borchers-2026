<?php

// Shortcode for borchers custom products on /products page

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Security: block direct access.
}

// Shortcode for borchers_products
add_shortcode('borchers_products', 'render_borchers_products');

function render_borchers_products() {

    if (!is_shop()) {
        return '';
    }

    // Load javascript for modal
    wp_enqueue_script( 'borchers-products-filter-js' );

    function process_slugs($product_id, $attribute_name) {
        $attributes = wc_get_product_terms( $product_id, $attribute_name );
        $attribute_slugs = array();
        
        if ( empty($attributes) || is_wp_error($attributes) ) {
            return '';
        }
        
        forEach ( $attributes as $attribute ) {
            $attribute_slugs[] = $attribute->slug;
        }

        $imp_attributes = implode( ' ', $attribute_slugs );
        return $imp_attributes;
    }

    function modify_description($description) {
        
        $word_count = str_word_count($description);

        if ($word_count <= 30) {
            // Strip tags
            $short_description = strip_tags($description);
            // HTML special chars decode
            $short_description = htmlspecialchars_decode($short_description);
            // Remove &nbsp
            $short_description = str_replace("&nbsp;", " ", $short_description);
            // Trim spacing
            $short_description = trim($short_description);

            return $short_description;
        } else {

            // Split description into an array based on space
            $description_array = preg_split('/\s+/', $description, -1, PREG_SPLIT_NO_EMPTY);
            // Slice the first 30 parts of the description array
            $short_array = array_slice($description_array, 0, 30);
            // Recombine the array back into one string
            $short_description = implode(' ', $short_array);

            // Strip tags
            $short_description = strip_tags($short_description);
            // HTML special chars decode
            $short_description = htmlspecialchars_decode($short_description);
            // Remove &nbsp
            $short_description = str_replace("&nbsp;", " ", $short_description);
            // Trim spacing
            $short_description = trim($short_description);
            // Add ... at the end
            $short_description .= "...";

            return $short_description;
        }
    }

    function renderProductLis() {
        $args = array(
        'status'    =>  'publish',
        'limit'     =>  -1,
        'paginate'  =>  false,
        'orderby'   =>  'name',
        'order'     =>  'ASC',

        );
        // Get all woocommerce products
        $products = wc_get_products( $args ); 

        // Count for debugging
        //$total_count = 1;

        if ($products) {
            forEach ($products as $product) {
                $product_id = $product->get_id();
                // Process slugs for categories to get names and slugs
                $product_categorys = $product->get_category_ids(); // Get array of ids associated with full categories
                $category_slugs = array();
                forEach ($product_categorys as $cat) {
                        $category = get_term($cat, 'product_cat'); // Get the product category text based on id
                        $category_slugs[] = $category->slug; // Add the category text to an array since it may be a different type
                }
                $categories = implode(' ', $category_slugs); // Combine the different category types into one string
                $category_slugs = array(); // Empty array so it will not carry over into next product
                $datasheet = get_field('data_sheet', $product_id); // Get acf field url for datasheet

                // Add logic for product tags 
                $product_tag_ids = $product->get_tag_ids(); // Get array of tag IDs
                $tag_slugs = array();
                foreach ($product_tag_ids as $tag_id) {
                    $tag = get_term($tag_id, 'product_tag'); // Fetch the term object for the tag
                    $tag_slugs[] = $tag->slug;
                }
                $tags_string = implode(' ', $tag_slugs); // Combine tags into a space-separated string
                
                // Process all the attribute slugs by sending attribute name to process slugs with product id
                $applications = process_slugs($product_id, 'pa_application');
                $availability = process_slugs($product_id, 'pa_availability');
                $brands = process_slugs($product_id, 'pa_brand');
                $systems = process_slugs($product_id, 'pa_system');
                $chemistry = process_slugs($product_id, 'pa_dc-chemistry');
                $metals = process_slugs($product_id, 'pa_dc-metal');
                $removes_foam_from = process_slugs($product_id, 'pa_defms-removes-foam-from');
                $additional_tags = process_slugs($product_id, 'pa_fld-additional-tags');
                $fld_chemistry = process_slugs($product_id, 'pa_fld-chemistry');
                $rheology_profilte = process_slugs($product_id, 'pa_rheology-profile');
                $rlgy_application_method = process_slugs($product_id, 'pa_rlgy-application-method');
                $rheology_shear_rate = process_slugs($product_id, 'pa_rheology-shear-rate');
                $wetting_inorganic_pigments = process_slugs($product_id, 'pa_wetting-inorganic-pigments');
                $wetting_organic_pigments = process_slugs($product_id, 'pa_wetting-organic-pigments');
                $wetting_pigments = process_slugs($product_id, 'pa_wetting-pigments');

                $product_availability = $product->get_attribute('pa_availability');
                error_log($product_availability);

                ?>

                <!-- Product list item HTML template -->
                <li id="<?php echo $product_id; ?>"
                    data-categories="<?php echo $categories; ?>"
                    data-applications="<?php echo $applications; ?>"
                    data-availability="<?php echo $availability; ?>"
                    data-brands="<?php echo $brands; ?>"
                    data-system="<?php echo $systems; ?>"
                    data-chemistry="<?php echo $chemistry; ?>"
                    data-metals="<?php echo $metals; ?>"
                    data-removes-foam-from="<?php echo $removes_foam_from; ?>"
                    data-additional-tags="<?php echo $additional_tags; ?>"
                    data-fld-chemistry="<?php echo $fld_chemistry; ?>"
                    data-rheology-profile="<?php echo $rheology_profilte; ?>"
                    data-rlgy-application-method="<?php echo $rlgy_application_method; ?>"
                    data-rheology-shear-rate="<?php echo $rheology_shear_rate; ?>"
                    data-wetting-inorganic-pigments="<?php echo $wetting_inorganic_pigments; ?>"
                    data-wetting-organic-pigments="<?php echo $wetting_organic_pigments; ?>"
                    data-wetting-pigments="<?php echo $wetting_pigments; ?>"
                    data-product-tags="<?php echo $tags_string; ?>"
                >
                    <div class="borchers-custom-product">
                        <div class="two-thirds-width">
                            <div class="borchers-product-header">

                                <div class="three-fourths-width">
                                    <?php if ($product_availability) {
                                    ?>
                                        <i class="fa-solid fa-earth-americas"></i><span><?php echo $product->get_attribute('pa_availability'); ?></span>

                                    
                                    <?php
                                }
                                ?>
                                </div>
                                

                                <div class="one-fourth-width">
                                    <span><a href="<?php echo site_url(); ?>/product/<?php echo $product->get_slug(); ?>">LEARN MORE >></a></span>
                                </div>
                            </div>
                            <h3><a href="<?php echo site_url(); ?>/product/<?php echo $product->get_slug(); ?>"><?php echo $product->get_name(); ?></a></h3>
                            <p><?php echo modify_description($product->get_description()); ?></p>
                        </div>

                        <div class="one-third-width">

                            <div class="one-half-width">
                                <a href="<?php echo $datasheet; ?>">
                                    <div><i class="fa-solid fa-download"></i></div>
                                    <span>Download Data Sheet</span>
                                </a>
                            </div>

                            <div class="one-half-width">
                                <a 
                                href="?add-to-cart=<?php echo $product_id; ?> "
                                data-quantity="1"
                                data-product_id="<?php echo $product_id; ?>"
                                class="button add_to_cart_button ajax_add_to_cart"
                                >
                                <div><i class="fa-solid fa-plus"></i></div>
                                <span>Add To Your Sample Order</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <?php
            } 
        } 
    }

    ob_start();
    ?>

    <style>

    #borchers-products-container .hide, #borchers-products-filter-container .hide {
        display: none;
    }

    #borchers-products-container .show-filtered-products {
        display: block;
    }

    #borchers-products-container ul {
        list-style: none;
        padding: 0;
    }

    #borchers-products-container ul li {
        margin: 2%;
    }

    #borchers-products-container span {
        font-size: .7rem;
        font-weight: bold;
    }

    #borchers-products-container h3 {
        color: #0a58ca;
    }

    #borchers-products-container .borchers-custom-product {
        display: flex;
        background-color: white;
        border: 1px solid #c7c7c7;
        box-shadow: #dedede 0px 3px 3px;
        padding: 2%;
    }

    #borchers-products-container .borchers-product-header {
        display: flex;
    }

    #borchers-products-container .borchers-product-header i {
        margin-right: 8px;
        color: #2187b4;
    }

    #borchers-products-container .borchers-product-header .three-fourths-width span {
        color: #2187b4;
    }

    #borchers-products-container .borchers-product-header .one-fourth-width span {
        color: #0a58ca;
    }

    #borchers-products-container .two-thirds-width {
        width: 66.6%;
        border-right: 1px solid #c7c7c7;
    }

    #borchers-products-container .one-third-width {
        width: 33.3%;
        padding-left: 2%;
        display: flex;
        text-align: center;
        align-items: center;
    }

    #borchers-products-container .three-fourths-width {
        width: 75%;
    }

    #borchers-products-container .one-fourth-width {
        width: 25%;
    }

    #borchers-products-container .one-half-width {
        width: 50%;
    }

    #borchers-products-container .one-half-width i {
        font-size: 1.5rem;
        color: #2187b4;
    }

    #borchers-products-container .one-half-width span {
        color: #707070;
    }

    #borchers-products-container #pagination-container #pagination {
        display: flex;
        overflow: auto;
        justify-content: flex-end;
    }

    #borchers-products-container #pagination-container #pagination li {
        background-color: #0a58cc;
        height: 28px;
        width: 28px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: background-color .2s ease-in-out;
    }

    #borchers-products-container #pagination-container #pagination li a {
        color: #f2f2f2;
        height: 100%;
        width: 100%;
        text-align: center;
        transition: color .2s ease-in-out;
    }

    #borchers-products-container #pagination-container #pagination li:hover {
        background-color: #f2f2f2;
    }

    #borchers-products-container #pagination-container #pagination li a:hover {
        color: #0a58cc; 
    }

    #borchers-products-container #pagination-container #pagination .previous-page, #borchers-products-container #pagination-container #pagination .next-page {
        background-color: initial!important;
    }

    #borchers-products-container #pagination-container #pagination .previous-page a i, #borchers-products-container #pagination-container #pagination .next-page a i {
        color: #0a58cc;
        font-size: 1.25rem;
    }

    #borchers-products-container #pagination-container #pagination .active {
        background-color: #f2f2f2;
    }

    #borchers-products-container #pagination-container #pagination .active a {
        color: #0a58cc;
    }

    #borchers-products-container p:empty {
        display: none;
    }

    </style>

    <div id="borchers-products-container">
        <p></p>
        <ul id="custom-products-list">
            <?php renderProductLis(); ?>
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