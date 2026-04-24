<?php
if ( ! defined( 'ABSPATH' )  ) {
    exit;
}

// News media links shortcode
add_shortcode( 'add_blog_media_links', 'render_blog_media_links' );
function render_blog_media_links() {

    ob_start();

        ?>
        <style>
            .social-share-list {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                gap: 40px;
                align-items: center;
            }

            .social-share-list li {
                display: inline-block;
            }

            .social-share-list a {
                text-decoration: none;
                display: block;
                color: #b2b2b2;
                font-size: 1rem;
                transition: all .3s;
            }

            .social-share-list a:hover {
                color: #2187b4;
            }

            .share-text {
                font-size: .7rem;
                color: #515356!important;
                font-weight: bold;
            }

        </style>

        <div>
            <h4 class="share-text">SHARE</h4>
            <ul class="social-share-list">
            <li>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" 
                target="_blank" 
                title="Share on Facebook">
                    <div>
                        <i class="fab fa-facebook-f"></i>
                    </div>
                </a>
            </li>

            <li>
                <a href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&url=<?php echo get_permalink(); ?>" 
                target="_blank" 
                title="Share on Twitter">
                    <div>
                        <i class="fab fa-twitter"></i>
                    </div>
                </a>
            </li>

            <li>
                <a href="https://pinterest.com/pin/create/button/?url=<?php echo get_permalink();?>&media=<?php the_post_thumbnail_url(); ?>&description=<?php echo get_the_title(); ?>" 
                target="_blank" 
                title="Pin on Pinterest">
                    <div>
                        <i class="fab fa-pinterest-p"></i>
                    </div>
                </a>
            </li>

            <li>
                <a href="mailto:?subject=<?php echo get_the_title(); ?>&body=<?php echo get_the_permalink(); ?>" 
                title="Share via Email">
                    <div>
                        <i class="fas fa-envelope"></i>
                    </div>
                </a>
            </li>
        </ul>
        </div>

        <?php

        return ob_get_clean();
}