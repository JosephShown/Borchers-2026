<?php

// Shortcode for borchers custom products on /products page

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Security: block direct access.
}
// Shortcode for borchers_products_filter
add_shortcode('borchers_products_filter', 'render_borchers_products_filter');

function render_borchers_products_filter() {

    if (!is_shop()) {
        return '';
    }

    function render_product_cats() {
        $args = array(
        'taxonomy'      =>  'product_cat',
        'hide_empty'    =>  false,
        'parent'        =>  0
        );

        // Get complete list of categories
        $product_categories_raw = get_terms( $args );

        if ( empty($product_categories_raw) || is_wp_error($product_categories_raw) ) {
            return '<p>No Product names found</p>';
        }

        // We use the categories setup in woocommerce and remove any unwanted terms such as uncategorized
        $categories_to_remove = ['uncategorized', 'rubber-adhesion-promoters', 'other-slug', 'floor-coatings'];
        forEach($product_categories_raw as $product_category_raw) {
            // If unwanted category is in the current loop then skip it
            $unwanted_categories = in_array($product_category_raw->slug, $categories_to_remove);
            if (!$unwanted_categories) {
                $filtered_categories[] = $product_category_raw;
            }
        }
        
        forEach($filtered_categories as $product_category) {
            // Get slug to match for javascript 
            $product_category_slug = $product_category->slug;
            // Get basic name for display
            $product_category_name = $product_category->name;

            ?>
            <!-- Product filter HTML template -->
            <li id="<?php echo $product_category_slug ?>" data-filter-category="<?php echo $product_category_slug ?>">
                <a href="javascript:;"><?php echo $product_category_name ?></a>
            </li>
            <?php
        }
    }

    // Takes a taxonomy name from product attributes or processes it into usable key value pairs for html
    function render_product_attributes($attributes) {
        $args = array(
            'taxonomy'      =>  $attributes,
            'hide_empty'    =>  true,
            'parent'        =>  0
        );

        $attribute_terms = get_terms($args);
        $data_filter_name = str_ireplace('pa_', '', $attributes);

        if ( empty($attribute_terms) || is_wp_error($attribute_terms) ) {
            return '<p>No Attribute values found.</p>';
        }

        // Loop through each attribute and create key value pairs
        forEach ( $attribute_terms as $attribute_term ) {
            $attribute_name = $attribute_term->name;
            $attribute_slug = $attribute_term->slug;
            if ( !empty($attribute_name) && !empty($attribute_slug) ) {
                $attributes_map[ $attribute_name ] = $attribute_slug;
            }
        }

        // We now have an associative array we need to process each pair to html
        forEach ( $attributes_map as $att_name => $att_slug ) {
            // Now we can output the html template list items with input checkboxes
            ?>
            
            <li id="<?php echo $att_slug ?>" data-filter-<?php echo $data_filter_name ?>="<?php echo $att_slug ?>" >
                <input type="checkbox"  data-filter-<?php echo $data_filter_name ?>="<?php echo $att_slug ?>" name="<?php echo $att_name; ?>" value="<?php echo $att_slug; ?>">
                <label for="<?php echo $att_slug; ?>" ><?php echo $att_name; ?></label>
            </li>
            <?php
        }
    }


    ob_start();
    ?>

    <style>
        #borchers-products-filter-container .hidden {
            display: none;
        }
        
        #borchers-products-filter-container h4 {
            font-size: 13px;
            color: #707070;
            cursor: pointer;
            text-transform: uppercase;
            margin: 0;
            position: relative;
            border-bottom: 1px solid #e6e6e6;
            padding: 20px 0;
        }

        #filter-hero-container {
            background-size: cover;
            background-position: center;
            padding: 0 20%;
            border-bottom: 4px solid #0a58c9;
        }

        #borchers-products-filter-container ul {
            list-style-type: none;
        }

        #borchers-products-filter-container h4 i {
            margin-left: 40px;
        }

        #borchers-products-filter-container i {
            transition: all .3s;
        }

        #borchers-products-filter-container .open-menu i {
            transform: rotate(180deg);
        }

        #borchers-products-filter-container #category-filter,
        #borchers-products-filter-container #application-filter,
        #borchers-products-filter-container #availability-filter,
        #borchers-products-filter-container #brand-filter,
        #borchers-products-filter-container #system-filter,
        #borchers-products-filter-container #chemistry-filter,
        #borchers-products-filter-container #metal-filter,
        #borchers-products-filter-container #removes-foam-from-filter,
        #borchers-products-filter-container #additional-tags-filter,
        #borchers-products-filter-container #fld-chemistry-filter,
        #borchers-products-filter-container #rheology-profile-filter,
        #borchers-products-filter-container #rlgy-application-method-filter,
        #borchers-products-filter-container #rheology-shear-rate-filter,
        #borchers-products-filter-container #wetting-inorganic-pigments-filter,
        #borchers-products-filter-container #wetting-organic-pigments-filter,
        #borchers-products-filter-container #wetting-pigments-filter  {
            max-height: 0px;
            transition: all .5s ease;
            overflow: hidden;
            opacity: 0;
        }

        #borchers-products-filter-container #category-filter.open-list,
        #borchers-products-filter-container #application-filter.open-list,
        #borchers-products-filter-container #availability-filter.open-list,
        #borchers-products-filter-container #brand-filter.open-list,
        #borchers-products-filter-container #system-filter.open-list,
        #borchers-products-filter-container #chemistry-filter.open-list,
        #borchers-products-filter-container #metal-filter.open-list,
        #borchers-products-filter-container #removes-foam-from-filter.open-list,
        #borchers-products-filter-container #additional-tags-filter.open-list,
        #borchers-products-filter-container #fld-chemistry-filter.open-list,
        #borchers-products-filter-container #rheology-profile-filter.open-list,
        #borchers-products-filter-container #rlgy-application-method-filter.open-list,
        #borchers-products-filter-container #rheology-shear-rate-filter.open-list,
        #borchers-products-filter-container #wetting-inorganic-pigments-filter.open-list,
        #borchers-products-filter-container #wetting-organic-pigments-filter.open-list,
        #borchers-products-filter-container #wetting-pigments-filter.open-list {
            max-height: 1000px;
            opacity: 1;
        }

        #borchers-products-filter-container .main-filter-arrow {
            position: absolute;
            top: 20px;
            right: 10px;
            display: block;
            height: 17px;
            width: 24px;
            background-image: url(/wp-content/uploads/2026/03/down-blue.png);
            background-position: 50%;
            background-size: 14px;
            transition: all .3s ease;
            background-color: #ededed;
            border-radius: 8px;
            background-repeat: no-repeat;
        }

        #borchers-products-filter-container li {
            display: flex;
            margin: 8px 0;
        }

        #borchers-products-filter-container li label {
            margin: 0px 50px 0px 8px;
        }

        #borchers-products-filter-container #reset-filter {
            font-size:  .7rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #818181;
            border-bottom: 1px solid #e6e6e6;
            padding-left: 0;
        }

        #borchers-products-filter-container #reset-filter i {
            background-color: #818181;
            color: white;
            padding: 4px;
            font-size: .5rem;
            margin-right: 8px;
            margin-left: 0;
        }

        #borchers-products-filter-container #top-products-cta, #borchers-products-filter-container #bottom-products-cta {
            text-align: center;
            margin: 2% 0;
        }

        /* Mobile media queries */
        @media only screen and (max-width: 767px) {

            #filter-hero-container {
                padding: 0 5%;
            }

            #borchers-products-container h3, #borchers-products-container h4 {
                font-size: 1.25rem;
            }

            #borchers-products-container p, #borchers-products-container span, #borchers-products-filter-container h4 {
                font-size: .8rem;
            }

        }

    </style>

    
    <div id="borchers-products-filter-container">

        <div id="top-products-cta" class="hide">
            <a href="" target="_blank" rel="noopener noreferrer">
                <img id="top-cta-image" src="" >
            </a>
        </div>

        <h4 id="filter-product-groups">Product Groups<span class="main-filter-arrow"></span></h4>

        <ul id="category-filter">
            <!-- This html needs to stay for proper filtration with the products-filter.js -->
            <?php render_product_cats(); ?>
            <!--
            <li><details><summary>Additives</summary><ul><?php //render_product_cats(); ?></ul></details></li>
            <li id="rubber-adhesion-promoters" data-filter-category="rubber-adhesion-promoters">
                <a href="javascript:;">Rubber Adhesion Promoters for Tires, Belts and Hoses</a>
            </li>
            <li id="catalysts" data-filter-category="catalysts">
                <a href="javascript:;">Catalysts</a>
            </li>
            -->
        </ul>

        <h4 id="filter-product-applications">Applications<span class="main-filter-arrow"></span></h4>

        <ul id="application-filter">
            <?php render_product_attributes('pa_application'); ?>
        </ul>

        <h4 id="filter-product-availability">Availability<span class="main-filter-arrow"></span></h4>

        <ul id="availability-filter">
            <?php render_product_attributes('pa_availability'); ?>
        </ul>

        <h4 id="filter-product-brand">Brand<span class="main-filter-arrow"></span></h4>

        <ul id="brand-filter">
            <?php render_product_attributes('pa_brand'); ?>
        </ul>

        <h4 id="filter-product-system">System<span class="main-filter-arrow"></span></h4>

        <ul id="system-filter">
            <?php render_product_attributes('pa_system'); ?>
        </ul>

        <h4 id="filter-product-chemistry">Chemistry<span class="main-filter-arrow"></span></h4>

        <ul id="chemistry-filter">
            <?php render_product_attributes('pa_dc-chemistry'); ?>
        </ul>

        <h4 id="filter-product-metal">Metal<span class="main-filter-arrow"></span></h4>

        <ul id="metal-filter">
            <?php render_product_attributes('pa_dc-metal'); ?>
        </ul>

        <h4 id="filter-product-removes-foam-from">Removes foam from<span class="main-filter-arrow"></span></h4>

        <ul id="removes-foam-from-filter">
            <?php render_product_attributes('pa_defms-removes-foam-from'); ?>
        </ul>

        <h4 id="filter-product-additional-tags">Additional Tags<span class="main-filter-arrow"></span></h4>

        <ul id="additional-tags-filter">
            <?php render_product_attributes('pa_fld-additional-tags'); ?>
        </ul>

        <h4 id="filter-product-fld-chemistry">Chemistry<span class="main-filter-arrow"></span></h4>

        <ul id="fld-chemistry-filter">
            <?php render_product_attributes('pa_fld-chemistry'); ?>
        </ul>

        <h4 id="filter-product-rheology-profile">Rheology Profile<span class="main-filter-arrow"></span></h4>

        <ul id="rheology-profile-filter">
            <?php render_product_attributes('pa_rheology-profile'); ?>
        </ul>

        <h4 id="filter-product-rlgy-application-method">Rheology Application Method<span class="main-filter-arrow"></span></h4>

        <ul id="rlgy-application-method-filter">
            <?php render_product_attributes('pa_rlgy-application-method'); ?>
        </ul>

        <h4 id="filter-product-rheology-shear-rate">Rheology Shear Rate<span class="main-filter-arrow"></span></h4>

        <ul id="rheology-shear-rate-filter">
            <?php render_product_attributes('pa_rheology-shear-rate'); ?>
        </ul>

        <h4 id="filter-product-wetting-inorganic-pigments">Inorganic Pigments<span class="main-filter-arrow"></span></h4>

        <ul id="wetting-inorganic-pigments-filter">
            <?php render_product_attributes('pa_wetting-inorganic-pigments'); ?>
        </ul>

        <h4 id="filter-product-wetting-organic-pigments">Organic Pigments<span class="main-filter-arrow"></span></h4>

        <ul id="wetting-organic-pigments-filter">
            <?php render_product_attributes('pa_wetting-organic-pigments'); ?>
        </ul>

        <h4 id="filter-product-wetting-pigments">Pigments<span class="main-filter-arrow"></span></h4>

        <ul id="wetting-pigments-filter">
            <?php render_product_attributes('pa_wetting-pigments'); ?>
        </ul>

        <h4 id="reset-filter"><i class="fa-solid fa-x"></i>Reset Filter</h4>

        <div id="bottom-products-cta">
            <a href="" target="_blank" rel="noopener noreferrer">
                <img id="bottom-cta-image" src="">
            </a>
        </div>

    </div>

    <?php
    return ob_get_clean();
}