<?php
if ( ! defined( 'ABSPATH' )  ) {
    exit;
}

// Breadcrumbs shortcodes
add_shortcode( 'borchers_add_blog_breadcrumbs', 'borchers_render_blog_breadcrumbs');
function borchers_render_blog_breadcrumbs() {

    ob_start();

        ?>
        <style>
            .blog-breadcrumbs, .blog-breadcrumbs a {
                color: white;
                font-size: .75rem;
                font-weight: bold;
            }

            .blog-breadcrumbs a:hover {
                color: #007bff;
            }

        </style>

            <span class="blog-breadcrumbs"><a href="<?php echo site_url(); ?>">Home</a> | <a href="<?php echo get_post_type_archive_link( 'post' ); ?>">News, Events, & Blog</a> | <a><?php echo get_the_title(); ?></a>
            </span>
        <?php

    return ob_get_clean();

}