<?php
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_styles' );
function hello_elementor_child_enqueue_styles() {
    // The 'hello-elementor' dependency ensures the parent loads first.
    wp_enqueue_style( 
        'hello-elementor-child-style', 
        get_stylesheet_directory_uri() . '/style.css', 
        array( 'hello-elementor' ), 
        '1.0.0' 
    );
	wp_enqueue_style('info-center-style', get_stylesheet_directory_uri() . '/css/info-center.css');
	if ( !is_page('checkout')) {
		wp_enqueue_style('bootstrap-style', get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
		wp_enqueue_script('bootstrap-script', get_stylesheet_directory_uri() . '/js/bootstrap.min.js');
	}
	
}

add_action( 'wp_enqueue_scripts', 'custom_scripts' );
function custom_scripts() {
	if ( is_page('info-center') || is_page('info-center-2')) {
		wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom-2.js');
	}
	if (is_page('application')) {
		header("Location: /applications-solutions/");
		exit();
	}
	if (str_contains($_SERVER["REQUEST_URI"], "/application/")) {
		header("Location: " . str_replace("/application/", "/applications-solutions/", $_SERVER["REQUEST_URI"]));
		exit();
	}
}

// Add this to your theme's functions.php or a small custom plugin
function my_admin_css() {
    echo '<style>
        #leadin-disconnected-banner, .e-notice--dismissible, .is-dismissible {
            display: none !important;
        }
    </style>';
}
add_action('admin_head', 'my_admin_css');

// adding this filter to allow the current year for our email template
add_filter( 'woocommerce_email_footer_text', function( $footer_text ) {
    return str_replace( '{current_year}', date( 'Y' ), $footer_text );
} );

// Taken from headers and footers plugin does not seem to function
//add_action('wp_footer', 'add_custom_scripts_to_footer');
function add_custom_scripts_to_footer() {
?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.filter-toggle-header').forEach(header => {
        header.addEventListener('click', function () {
        const content = header.nextElementSibling;
        header.classList.toggle('active');
        content.classList.toggle('active');
        });
    });
    });
</script>
<?php
}

add_action( 'wp_enqueue_scripts', 'cookie_set' );
function cookie_set() {
	$utm_source = $_GET['utm_source'];
	//setcookie("utm_source", $utm_source, time() + (86400 * 30), "/", "wordpress-1545457-5979331.cloudwaysapps.com");
	//echo '<script>document.cookie="utm_source=' . $utm_source . '; path=/; expires=' .  gmdate("r",  time() + (86400 * 30)) . ';";</script>';
	$utm_medium = $_GET['utm_medium'];
	//echo '<script>console.log("medium: ' . $utm_medium . '");</script>';
	//setcookie("utm_medium", $utm_medium,  time() + (86400 * 30), "");
	//echo '<script>document.cookie="utm_medium=' . $utm_medium . '; path=/; expires=Mon, 27 Apr 2026 22:13:11 GMT";</script>';
	$utm_campaign = $_GET['utm_campaign'];
	//setcookie("utm_campaign", $utm_campaign, time() + (86400 * 30));
	//echo '<script>document.cookie="utm_source=' . $utm_source . '; path=/; expires=' . time() + (86400 * 30) . '";</script>';
	$utm_content = $_GET['utm_content'];
	//setcookie("utm_content", $utm_content, time() + (86400 * 30));
	//echo '<script>document.cookie="utm_source=' . $utm_source . '; path=/; expires=' . time() + (86400 * 30) . '";</script>';
	$utm_term = $_GET['utm_term'];
	//setcookie("utm_term", $utm_term, time() + (86400 * 30));
	//echo '<script>document.cookie="utm_source=' . $utm_source . '; path=/; expires=' . time() + (86400 * 30) . '";</script>';
	$utm_source_cookie_code = ($utm_source !== null) ? "document.cookie=\"utm_source=" . $utm_source . "; path=/; expires=" .  gmdate('r',  time() + (86400 * 30)) . ";\";" : "";
	$utm_medium_cookie_code = ($utm_medium !== null) ? "document.cookie=\"utm_medium=" . $utm_medium . "; path=/; expires=" .  gmdate('r',  time() + (86400 * 30)) . ";\";" : "";
	$utm_campaign_cookie_code = ($utm_campaign !== null) ? "document.cookie=\"utm_campaign=" . $utm_campaign . "; path=/; expires=" .  gmdate('r',  time() + (86400 * 30)) . ";\";" : "";
	$utm_content_cookie_code = ($utm_content !== null) ? "document.cookie=\"utm_content=" . $utm_content . "; path=/; expires=" .  gmdate('r',  time() + (86400 * 30)) . ";\";" : "";
	$utm_term_cookie_code = ($utm_term !== null) ? "document.cookie=\"utm_term=" . $utm_term . "; path=/; expires=" .  gmdate('r',  time() + (86400 * 30)) . ";\";" : "";
	echo "<script>window.addEventListener('load', (event) => {
	" . $utm_source_cookie_code . "
	" . $utm_medium_cookie_code . "
	" . $utm_campaign_cookie_code . "
	" . $utm_content_cookie_code . "
	" . $utm_term_cookie_code . "

	})</script>";
}

add_action( 'wp_enqueue_scripts', 'mobile_nav_fix' );
function mobile_nav_fix() {
	echo "<script>window.addEventListener('load', (event) => {
	document.getElementsByClassName('mobile-nav')[0].getElementsByTagName('nav')[0].firstChild.firstChild.firstChild.addEventListener('click', function() {
		document.getElementsByClassName('mobile-nav')[0].getElementsByTagName('a')[0].click();
	});
	document.getElementsByClassName('mobile-nav')[0].getElementsByTagName('nav')[0].firstChild.firstChild.firstChild.addEventListener('touchstart', function() {
		document.getElementsByClassName('mobile-nav')[0].getElementsByTagName('a')[0].click();
	})
	document.getElementById('popupsearchbtn').addEventListener('click', function() {
		 if (jQuery('#borchers-search-container').css('display') == 'none') {
		 	jQuery('#borchers-search-container').show();
			document.getElementById('borchers-search-container').firstElementChild.firstElementChild.focus().focus();
		 }
		 else jQuery('#borchers-search-container').hide();
	})
})</script>";
}
