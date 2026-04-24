<?php
/**
 * Template Name: Coming Soon
 * Description: Displays a simple "Coming Soon" page for non-logged-in users.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Optional: Prevent direct access (extra security)
if ( ! defined( 'BCS_COMING_SOON' ) ) {
    wp_die( 'Direct access not allowed.' );
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo( 'name' ); ?> - Coming Soon</title>
    <?php wp_head(); // Allows plugins (like SEO) to inject code ?>
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #004d9f;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
        }
        .coming-soon {
            max-width: 600px;
        }
        h1 {
            font-size: 3.5rem;
            margin: 0 0 1rem;
            font-weight: 700;
            color: white;
        }
        p {
            font-size: 1.2rem;
            color: white;
        }
    </style>
</head>
<body>
    <div class="coming-soon">
        <h1>COMING SOON</h1>
        <p>We're working hard to launch something amazing. Stay tuned!</p>
    </div>
    <?php wp_footer(); // Required for many plugins (analytics, etc.) ?>
</body>
</html>