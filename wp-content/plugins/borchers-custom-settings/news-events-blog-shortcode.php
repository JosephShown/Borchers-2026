<?php
if ( ! defined( 'ABSPATH' )  ) {
    exit;
}

add_shortcode('news_events_check', 'bcs_news_events_blog_check_shortcode');
// News category shortcode
function bcs_news_events_blog_check_shortcode() {
    // Get current post/page object
    $current_post = get_queried_object();

    $is_news_events_blog = false;

    // Get current page name to check if in the right place
    $current_page_name = $current_post->post_name;

    if ($current_page_name === 'news-events-blog') {
        $is_news_events_blog = true;
    }

    // If on the target page, output JavaScript
    if ($is_news_events_blog) {
        ob_start(); ?>
        <div id="news-events-blog-shortcode">
            <h2 id="news-events-blog-text">News</h2>
        </div>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                
                // Get element for showing the text
                let categoryTextElement = document.querySelector('#news-events-blog-text');
                // Return if our element does not exist
                if (!categoryTextElement) {
                    return;
                }

                // Update text for which category is selected
                function updateActiveCategory() {
                    // Find the button with aria-pressed = true
                    const activeButton = document.querySelector('.e-filter-item[aria-pressed="true"]');

                    if (activeButton) {
                        const filterValue = activeButton.getAttribute('data-filter');
                        if (filterValue === 'news') {
                            categoryTextElement.textContent = 'News';
                        } 
                        
                        if (filterValue === 'blog') {
                            categoryTextElement.textContent = 'Blog';
                        }

                        if (filterValue === 'events') {
                            categoryTextElement.textContent = 'Events';
                        }

                        if (filterValue === '__all') {
                            categoryTextElement.textContent = 'News, Events, & Blog';
                        }
                    }
                }

                // Run once on load
                updateActiveCategory();

                // Listen for clicks after page load and update text
                document.querySelectorAll('.e-filter-item').forEach( button => {
                    button.addEventListener('click', function() {
                        // Small delay to make sure it runs
                        setTimeout(updateActiveCategory, 50);
                    })
                })
            });
        </script>
        <?php
        return ob_get_clean();
    } else {
        ob_start(); ?>
        <div id="news-events-blog-detected">
            News, Events, & Blog text shortcode.
        </div>
        <?php
        return ob_get_clean();
    }

    
}
