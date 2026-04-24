<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Product multimedia modal shortcode
add_shortcode( 'product_multimedia_info', 'bcs_render_product_multimedia_info' );
function bcs_render_product_multimedia_info() {

    // Check to make sure we are on a product page otherwise return
    if ( ! function_exists( 'is_product' ) || ! is_product() ) {
        return '';
    }
    
    // Get the global product data
    global $product;

    // Product type check
    if ( ! is_a( $product, 'WC_Product') ) {
        // Fallback product assignment
        $product = wc_get_product( get_the_ID() );
    }

    // Failsafe product check and return if empty
    if ( ! $product ) {
        return '';
    }

    // Load javascript for modal
    wp_enqueue_script( 'borchers-product-media-modal-js' );
    wp_enqueue_script( 'youtube-iframe-api' );

    // Use ACF to get start formulation array
    $media_url = get_field('media');
    $image_url = get_field('placeholder_image');


    // If either is empty return
    if (empty($media_url) || empty($image_url)) {
        return '';
    }

    ob_start();

        ?>
        <style>
            #multimedia-shortcode-container #multimedia-container {
                background-image: <?php echo esc_url($image_url); ?>;
                position: relative;
            }

            #multimedia-shortcode-container #open-modal span {
                position: absolute;
                top: 50%;
                left: 50%;
                color: #c7c7c7;
                background-color: #e8e8e8;
                border-radius: 50%;
                width: 100px;
                height: 100px;
                transform: translate(-50%, -50%);
                display: flex; 
                justify-content: center;
                align-items: center;
                font-size: 40px;
            }

            #multimedia-shortcode-container .modal {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0,0,0,0.6);
            }

            #multimedia-shortcode-container .modal-content {
                width: 80%;
                margin: 0 auto;
                padding-top: 5%;
                position: relative;
            }

            #multimedia-shortcode-container .close-btn {
                cursor: pointer;
                font-size: 24px;
                background-color: #828282;
                color: white;
                position: absolute;
                right: 0;
                padding: 8px;
            }

        </style>

        <div id="multimedia-shortcode-container">
            <h6 style="font-weight: bold;">Multimedia</h6>

            <div id="multimedia-container">
                <a id="open-modal" href="#"><img src="<?php echo esc_url($image_url); ?>" alt="product-multimedia-image" />
                    <span>
                        <i class="fas fa-play" aria-hidden="true"></i>
                    </span>
                </a>
                
            </div>

            <div class="modal">
                <div class="modal-content">
                    <span class="close-btn"><i class="fa-solid fa-x"></i></span>
                    <iframe
                        id="youtube-player"
                        title="Borchers Multimedia Video"
                        width="100%"
                        height="600px"
                        frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        src="<?php echo esc_url($media_url); ?>&enablejsapi=1&amp;origin=<?php echo site_url(); ?>">
                    </iframe>
                </div>
            </div>
                
        </div>

        <?php

        return ob_get_clean();
}