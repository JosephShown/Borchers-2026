<?php

// Render the settings page + handle form POST
function borchers_render_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'Insufficient permissions.', 'borchers-custom-settings' ) );
    }

    // ---------- SAVE ----------
    if ( isset( $_POST['borchers_save'] ) ) {
        check_admin_referer( 'borchers_save_settings' );

        // Ternary to check if option was just turned on or off and update the option
        // Admin bar
        $admin_bar_enabled = isset( $_POST['borchers_admin_bar_enabled'] ) ? '1' : '0';
        update_option( 'borchers_admin_bar_enabled', $admin_bar_enabled );

        $admin_bar_color = isset( $_POST['borchers_admin_bar_color'] )
            ? sanitize_hex_color( $_POST['borchers_admin_bar_color'] )
            : '#619834';
        update_option( 'borchers_admin_bar_color', $admin_bar_color );

        // Page ID logger
        $logger_enabled = isset( $_POST['borchers_page_id_logger_enabled'] ) ? '1' : '0';
        update_option( 'borchers_page_id_logger_enabled', $logger_enabled );

        // HTTP Headers
        $hsts_enabled = isset( $_POST['borchers_hsts_enabled'] ) ? '1' : '0';
        update_option( 'borchers_hsts_enabled', $hsts_enabled );

        $csp_value = isset( $_POST['borchers_csp'] )
            ? sanitize_text_field( wp_unslash( $_POST['borchers_csp'] ) )
            : '';
        update_option( 'borchers_csp', $csp_value );

        $xframe_enabled = isset( $_POST['borchers_xframe_enabled'] ) ? '1' : '0';
        update_option( 'borchers_xframe_enabled', $xframe_enabled );

        $xcontent_enabled = isset( $_POST['borchers_xcontent_enabled'] ) ? '1' : '0';
        update_option( 'borchers_xcontent_enabled', $xcontent_enabled );

        $coming_soon_enabled = isset( $_POST['bcs_enable_coming_soon'] ) ? '1' : '0';
        update_option( 'bcs_enable_coming_soon', $coming_soon_enabled );

        $fontawesome_enabled = isset( $_POST['bcs_fontawesome_enabled'] ) ? '1' : '0';
        update_option( 'bcs_fontawesome_enabled', $fontawesome_enabled );

        echo '<div class="updated"><p>' . esc_html__( 'Settings saved.', 'borchers-custom-settings' ) . '</p></div>';
    }

    // Load current values
    $admin_bar_enabled = get_option( 'borchers_admin_bar_enabled', '0' );
    $admin_bar_color   = get_option( 'borchers_admin_bar_color', '#619834' );
    $logger_enabled    = get_option( 'borchers_page_id_logger_enabled', '0' );

    $hsts_enabled      = get_option( 'borchers_hsts_enabled', '0' );
    $csp_value         = get_option( 'borchers_csp', '' );
    $xframe_enabled    = get_option( 'borchers_xframe_enabled', '0' );
    $xcontent_enabled  = get_option( 'borchers_xcontent_enabled', '0' );
    $coming_soon_enabled = get_option( 'bcs_enable_coming_soon', '0' );
    $fontawesome_enabled = get_option( 'bcs_fontawesome_enabled', '0');

    // Start output buffer for clean HTML
    ob_start();
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Borchers Custom Settings', 'borchers-custom-settings' ); ?></h1>

        <form method="post" action="">
            <?php wp_nonce_field( 'borchers_save_settings' ); ?>

            <h2><?php esc_html_e( 'Appearance & Debug', 'borchers-custom-settings' ); ?></h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><?php esc_html_e( 'Admin Bar Color', 'borchers-custom-settings' ); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="borchers_admin_bar_enabled"
                                   value="1" <?php checked( $admin_bar_enabled, '1' ); ?> />
                            <?php esc_html_e( 'Enable custom admin bar color', 'borchers-custom-settings' ); ?>
                        </label>
                        <p>
                            <input type="text" name="borchers_admin_bar_color"
                                   value="<?php echo esc_attr( $admin_bar_color ); ?>"
                                   class="regular-text" placeholder="#619834" />
                            <span class="description"><?php esc_html_e( 'Hex color, e.g. #619834', 'borchers-custom-settings' ); ?></span>
                        </p>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php esc_html_e( 'Page ID Logger', 'borchers-custom-settings' ); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="borchers_page_id_logger_enabled"
                                   value="1" <?php checked( $logger_enabled, '1' ); ?> />
                            <?php esc_html_e( 'Show page/post ID in footer & console', 'borchers-custom-settings' ); ?>
                        </label>
                    </td>
                </tr>
            </table>

            <hr>

            <h2><?php esc_html_e( 'Security HTTP Headers', 'borchers-custom-settings' ); ?></h2>
            <table class="form-table" role="presentation">

                <!-- HSTS -->
                <tr>
                    <th scope="row">Strict-Transport-Security (HSTS)</th>
                    <td>
                        <label>
                            <input type="checkbox" name="borchers_hsts_enabled"
                                   value="1" <?php checked( $hsts_enabled, '1' ); ?> />
                            <?php esc_html_e( 'Enable HSTS', 'borchers-custom-settings' ); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e( 'Recommended: max-age=31536000; includeSubDomains', 'borchers-custom-settings' ); ?>
                        </p>
                    </td>
                </tr>

                <!-- CSP -->
                <tr>
                    <th scope="row">Content-Security-Policy</th>
                    <td>
                        <textarea name="borchers_csp" rows="3" class="large-text" placeholder="default-src 'self'; script-src 'self' https://apis.google.com"><?php echo esc_textarea( $csp_value ); ?></textarea>
                        <p class="description">
                            <?php esc_html_e( 'Leave blank to disable. Example: default-src \'self\'', 'borchers-custom-settings' ); ?>
                        </p>
                    </td>
                </tr>

                <!-- X-Frame-Options -->
                <tr>
                    <th scope="row">X-Frame-Options</th>
                    <td>
                        <label>
                            <input type="checkbox" name="borchers_xframe_enabled"
                                   value="1" <?php checked( $xframe_enabled, '1' ); ?> />
                            <?php esc_html_e( 'Enable (SAMEORIGIN)', 'borchers-custom-settings' ); ?>
                        </label>
                        <p class="description"><?php esc_html_e( 'Prevents clickjacking.', 'borchers-custom-settings' ); ?></p>
                    </td>
                </tr>

                <!-- X-Content-Type-Options -->
                <tr>
                    <th scope="row">X-Content-Type-Options</th>
                    <td>
                        <label>
                            <input type="checkbox" name="borchers_xcontent_enabled"
                                   value="1" <?php checked( $xcontent_enabled, '1' ); ?> />
                            <?php esc_html_e( 'Enable (nosniff)', 'borchers-custom-settings' ); ?>
                        </label>
                        <p class="description"><?php esc_html_e( 'Prevents MIME-sniffing.', 'borchers-custom-settings' ); ?></p>
                    </td>
                </tr>

                <!-- Coming soon page -->
                <tr>
                    <th scope="row">Coming Soon Page</th>
                    <td>
                        <label>
                            <input type="checkbox" name="bcs_enable_coming_soon"
                                   value="1" <?php checked( $coming_soon_enabled, '1' ); ?> />
                            <?php esc_html_e( 'Enable Coming Soon Page', 'borchers-custom-settings' ); ?>
                        </label>
                        <p class="description"><?php esc_html_e( 'Shows coming soon page for logged out users.', 'borchers-custom-settings' ); ?></p>
                    </td>
                </tr>

                <!-- Fontawesome -->
                <tr>
                    <th scope="row">Enable Fontawesome</th>
                    <td>
                        <label>
                            <input type="checkbox" name="bcs_fontawesome_enabled"
                                   value="1" <?php checked( $fontawesome_enabled, '1' ); ?> />
                            <?php esc_html_e( 'Enable Fontawesome Icons', 'borchers-custom-settings' ); ?>
                        </label>
                        <p class="description"><?php esc_html_e( 'Adds fontawesome styles to site.', 'borchers-custom-settings' ); ?></p>
                    </td>
                </tr>

            </table>

            <p class="submit">
                <input type="submit" name="borchers_save" class="button-primary"
                       value="<?php esc_attr_e( 'Save Changes', 'borchers-custom-settings' ); ?>" />
            </p>
        </form>
    </div>
    <?php
    echo ob_get_clean();
}