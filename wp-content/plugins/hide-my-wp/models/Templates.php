<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class HMWP_Models_Templates {


    /**
     * Return 404 page or redirect
     *
     * @param $url
     * @throws Exception
     */
    public function getURLTemplate() {
        if ( HMWP_Classes_Tools::getOption( 'error' ) || HMWP_Classes_Tools::getOption( 'logout' ) ) {
            return;
        }

        if ( !function_exists( 'is_user_logged_in' ) ) {
            return;
        }

        if ( !is_user_logged_in() ) {

            if ( isset( $_SERVER['SERVER_NAME'] ) ) {
                $url = untrailingslashit( strtok( $_SERVER["REQUEST_URI"], '?' ) );

                $paths = array(
                    home_url( 'wp-signup.php', 'relative' ),
                    site_url( 'wp-signup.php', 'relative' ),
                );

                if ( $this->searchInString( $url, $paths ) ) {
                    $this->getRegisterTemplate();
                }

            }
            if ( HMWP_Classes_Tools::getOption( 'hmwp_register_url' ) <> '' && $url == '/' . HMWP_Classes_Tools::getOption( 'hmwp_register_url' ) ) {
                $this->getRegisterTemplate();
            }
        }
    }

    /**
     * Get the register form for WP Multisite and singlesite
     */
    public function getRegisterTemplate() {

        if ( is_multisite() ) {

            //if a page is selected
//            if ( class_exists( 'WP_Query' ) && (int)HMWP_Classes_Tools::getOption( 'hmwp_signup_template' ) > 0 ) {
//                $query = new WP_Query( array('p' => (int)HMWP_Classes_Tools::getOption( 'hmwp_signup_template' ), 'post_type' => 'any') );
//                if ( $query->have_posts() ) {
//                    add_shortcode( 'hidemywp_signup', array($this, 'getWPSignup') );
//
//                    $query->the_post();
//
//                    $content = get_the_content();
//
//                    if ( strpos( $content, 'hidemywp_signup' ) !== false ) {
//                        echo do_shortcode( $content );
//                        die();
//                    }
//
//                }
//
//            }

            get_header();
            echo $this->getWPSignup();
            get_footer();
            die();
        }
    }

    /**
     * Get the Signup for for the WP Multisite
     * @return false|string
     */
    public function getWPSignup() {
        ob_start();

        $this->includeWpSignup();

        return ob_get_clean();
    }

    public function includeWpSignup() {

        if ( !function_exists( 'wpmu_signup_stylesheet' ) ) {
            if ( file_exists( HMWP_Classes_Tools::getRootPath() . 'wp-signup.php' ) ) {
                do_action( 'signup_header' );
                do_action( 'before_signup_header' );

                global $wp_query;
                include_once(HMWP_Classes_Tools::getRootPath() . 'wp-signup.php');
                wpmu_signup_stylesheet();
            }
        } else {
            include_once(_HMWP_TEMPLATES_DIR_ . 'wp-signup.php');
            wpmu_signup_stylesheet();
        }

    }

    /**
     * Search part of string in array
     *
     * @param $needle
     * @param $haystack
     *
     * @return bool
     */
    public function searchInString( $needle, $haystack ) {
        foreach ( $haystack as $value ) {
            if ( stripos( $needle . '/', $value . '/' ) !== false ) {
                return true;
            }
        }

        return false;
    }
}
