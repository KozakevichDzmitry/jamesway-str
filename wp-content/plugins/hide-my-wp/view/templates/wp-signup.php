<div id="signup-content" class="widecolumn">
    <div class="mu_register wp-signup-container" role="main">
        <?php

        // Main.
        $active_signup = get_site_option( 'registration', 'none' );

        /**
         * Filters the type of site sign-up.
         *
         * @since 3.0.0
         *
         * @param string $active_signup String that returns registration type. The value can be
         *                              'all', 'none', 'blog', or 'user'.
         */
        $active_signup = apply_filters( 'wpmu_active_signup', $active_signup );

        if ( current_user_can( 'manage_network' ) ) {
            echo '<div class="mu_alert">';
            _e( 'Greetings Network Administrator!' );
            echo ' ';

            switch ( $active_signup ) {
                case 'none':
                    _e( 'The network currently disallows registrations.' );
                    break;
                case 'blog':
                    _e( 'The network currently allows site registrations.' );
                    break;
                case 'user':
                    _e( 'The network currently allows user registrations.' );
                    break;
                default:
                    _e( 'The network currently allows both site and user registrations.' );
                    break;
            }

            echo ' ';

            /* translators: %s: URL to Network Settings screen. */
            printf( __( 'To change or disable registration go to your <a href="%s">Options page</a>.' ), esc_url( network_admin_url( 'settings.php' ) ) );
            echo '</div>';
        }

        $newblogname = isset( $_GET['new'] ) ? strtolower( preg_replace( '/^-|-$|[^-a-zA-Z0-9]/', '', $_GET['new'] ) ) : null;

        $current_user = wp_get_current_user();
        if ( 'none' === $active_signup ) {
            _e( 'Registration has been disabled.' );
        } elseif ( 'blog' === $active_signup && !is_user_logged_in() ) {
            $login_url = wp_login_url( network_site_url( 'wp-signup.php' ) );
            /* translators: %s: Login URL. */
            printf( __( 'You must first <a href="%s">log in</a>, and then you can create a new site.' ), $login_url );
        } else {
            $stage = isset( $_POST['stage'] ) ? $_POST['stage'] : 'default';
            switch ( $stage ) {
                case 'validate-user-signup':
                    if ( 'all' === $active_signup
                        || ('blog' === $_POST['signup_for'] && 'blog' === $active_signup)
                        || ('user' === $_POST['signup_for'] && 'user' === $active_signup)
                    ) {
                        validate_user_signup();
                    } else {
                        _e( 'User registration has been disabled.' );
                    }
                    break;
                case 'validate-blog-signup':
                    if ( 'all' === $active_signup || 'blog' === $active_signup ) {
                        validate_blog_signup();
                    } else {
                        _e( 'Site registration has been disabled.' );
                    }
                    break;
                case 'gimmeanotherblog':
                    validate_another_blog_signup();
                    break;
                case 'default':
                default:
                    $user_email = isset( $_POST['user_email'] ) ? $_POST['user_email'] : '';
                    /**
                     * Fires when the site sign-up form is sent.
                     *
                     * @since 3.0.0
                     */
                    do_action( 'preprocess_signup_form' );
                    if ( is_user_logged_in() && ('all' === $active_signup || 'blog' === $active_signup) ) {
                        signup_another_blog( $newblogname );
                    } elseif ( !is_user_logged_in() && ('all' === $active_signup || 'user' === $active_signup) ) {
                        signup_user( $newblogname, $user_email );
                    } elseif ( !is_user_logged_in() && ('blog' === $active_signup) ) {
                        _e( 'Sorry, new registrations are not allowed at this time.' );
                    } else {
                        _e( 'You are logged in already. No need to register again!' );
                    }

                    if ( $newblogname ) {
                        $newblog = get_blogaddress_by_name( $newblogname );

                        if ( 'blog' === $active_signup || 'all' === $active_signup ) {
                            printf(
                            /* translators: %s: Site address. */
                                '<p>' . __( 'The site you were looking for, %s, does not exist, but you can create it now!' ) . '</p>',
                                '<strong>' . $newblog . '</strong>'
                            );
                        } else {
                            printf(
                            /* translators: %s: Site address. */
                                '<p>' . __( 'The site you were looking for, %s, does not exist.' ) . '</p>',
                                '<strong>' . $newblog . '</strong>'
                            );
                        }
                    }
                    break;
            }
        }
        ?>
    </div>
</div>