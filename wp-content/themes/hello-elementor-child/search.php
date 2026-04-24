<?php
// Search template

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function is_img_placeholder($post) {
    $picture_id = get_post_thumbnail_id($post);
    $picture_url = wp_get_attachment_url($picture_id);
    $placeholder = str_contains($picture_url, 'placeholder');

    if ($placeholder == 1) {
        return false;
    } else {
        return true;
    }

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

get_header();
?>

<style>
    #search-hero-container {
        background-image: url('/wp-content/uploads/2025/05/redPaint-bg.jpg');
        background-size: cover;
        background-position: center;
        padding: 1% 20%;
        min-height: 256px;
        display: flex;
        justify-content: space-between;
        flex-direction: column;
    }

    #search-results h2 {
        color: #777;
        font-weight: bold;
    }

    #search-results h3 {
        font-weight: 400;
    }

    #search-results a {
        color: #0a58ca;
    }

    #search-hero-container span, #search-hero-container a, #search-hero-container h1 {
        color: white;
    }

    #search-results {
        padding: 1% 20%;
    }

    .search-result {
        border-bottom: 1px solid #d0d0d0;
        padding: 2% 0;
        margin: 2% 0;
    }

    .search-result img {
        max-width: 600px;
    }

    .search-result button {
        background-color: #2187b4;
        border: none;
        color: white;
    }

    .search-result button:hover {
        background-color: #0a58ca;
        border: none;
        color: white;
    }

    @media screen and (max-width: 768px) {
        .search-result img {
            max-width: 100%;
        }

        #search-results {
            padding: 1% 10%;
        }
    }
</style>

<div id='search-hero-container'>
    <span><a href='<?php echo home_url('/'); ?>'>Home</a> | Search</span>
    <div><h1>Search results for "<?php echo get_search_query(); ?>"</h1></div>
</div>

<main id="search-results">
<h2>SEARCH RESULTS FOR: "<?php echo get_search_query(); ?>"</h2>
<?php

global $query_string;
query_posts( $query_string . '&posts_per_page=-1' ); 

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        $placeholder_img = is_img_placeholder($post);
        try {
            $stripped_excerpt = modify_description($post->post_content);
        } 
        
        catch(Exception $e) {
            error_log('Error stripping excerpt');
        }
        
        ?>
            <div class="search-result">
                <?php
                    if($placeholder_img === true) {
                        the_post_thumbnail( 'large' );
                    }
                ?>
                <h3><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></h3>
                <p><?php echo $stripped_excerpt; ?></p>
                <a href="<?php echo the_permalink(); ?>"><button>Read More</button></a>
            </div>
            

        <?php
    endwhile;
else :
    echo '<p>No results.</p>';
endif;

?>
</main>
<?php

get_footer();
?>