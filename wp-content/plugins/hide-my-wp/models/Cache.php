<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class HMWP_Models_Cache {

    protected $_replace = array();
    protected $_cachepath = '';
    protected $chmod = 644;

    public function __construct() {
        $this->setCachePath( WP_CONTENT_DIR . '/cache/' );

    }

    /**
     * Set the Cache Path
     *
     * @param $path
     */
    public function setCachePath( $path ) {
        $this->_cachepath = $path;
    }

    /**
     * Get the cache path
     * @return string
     */
    public function getCachePath() {
        $path = $this->_cachepath;

        if ( is_multisite() ) {
            if ( is_dir( $path . get_current_blog_id() . '/' ) ) {
                $path .= get_current_blog_id() . '/';
            }
        }

        if ( !is_dir( $path ) ) {
            return false;
        }

        return $path;
    }

    /**
     * Build the redirects array
     * @throws Exception
     */
    public function buildRedirect() {
        /** @var HMWP_Models_Rewrite $rewriteModel */
        $rewriteModel = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' );

        //build the rules paths to change back the hidden paths
        if ( empty( $this->_replace['from'] ) && empty( $this->_replace['to'] ) ) {
            if ( !isset( $rewriteModel->_replace['from'] ) && !isset( $rewriteModel->_replace['to'] ) ) {
                $rewriteModel->buildRedirect();
            }

            //Verify only the rewrites
            $rewrite = $rewriteModel->_replace['rewrite'];
            $rewrite_from = $rewriteModel->_replace['from'];
            $rewrite_to = $rewriteModel->_replace['to'];

            if ( !empty( $rewrite ) ) {
                foreach ( $rewrite as $index => $value ) {
                    //add only the paths or the design path
                    if ( ($index && isset( $rewrite_to[$index] ) && substr( $rewrite_to[$index], -1 ) == '/') ||
                        strpos( $rewrite_to[$index], '/' . HMWP_Classes_Tools::getOption( 'hmwp_themes_style' ) ) ) {
                        $this->_replace['from'][] = $rewrite_from[$index];
                        $this->_replace['to'][] = $rewrite_to[$index];
                    }
                }
            }

            //add the domain to rewrites
            $this->_replace['from'] = array_map( array(
                $rewriteModel,
                'addDomainUrl'
            ), (array)$this->_replace['from'] );
            $this->_replace['to'] = array_map( array(
                $rewriteModel,
                'addDomainUrl'
            ), (array)$this->_replace['to'] );
        }
    }

    /**
     * Replace the paths in CSS files
     * @throws Exception
     */
    public function changePathsInCss() {
        if ( HMWP_Classes_Tools::getOption( 'error' ) ) {
            return;
        }

        try {
            if ( $this->getCachePath() ) {

                $cssfiles = $this->rsearch( $this->getCachePath() . '*.css' );

                if ( !empty( $cssfiles ) ) {

                    //load the redirects into array
                    $this->buildRedirect();

                    /** @var HMWP_Models_Rewrite $rewriteModel */
                    $rewriteModel = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' );

                    foreach ( $cssfiles as $file ) {
                        //only if the file is writable
                        if ( !$content = $this->readFile( $file ) ) {
                            continue;
                        }

                        if ( $content <> '' ) {

                            if ( strpos( $content, HMWP_Classes_Tools::$default['hmwp_wp-content_url'] ) !== false || strpos( $content, HMWP_Classes_Tools::$default['hmwp_wp-includes_url'] ) !== false ) {

                                //fix the relative links before
                                if ( HMWP_Classes_Tools::getOption( 'hmwp_fix_relative' ) ) {
                                    $content = $rewriteModel->fixRelativeLinks( $content );
                                }

                                //replace the paths within css files
                                if ( isset( $this->_replace['from'] ) && isset( $this->_replace['to'] ) && !empty( $this->_replace['from'] ) && !empty( $this->_replace['to'] ) ) {
                                    $content = str_ireplace( $this->_replace['from'], $this->_replace['to'], $content );
                                }

                                //Text Mapping for all css files
                                if ( HMWP_Classes_Tools::getOption( 'hmwp_mapping_file' ) ) {
                                    $hmwp_text_mapping = json_decode( HMWP_Classes_Tools::getOption( 'hmwp_text_mapping' ), true );
                                    if ( isset( $hmwp_text_mapping['from'] ) && !empty( $hmwp_text_mapping['from'] ) &&
                                        isset( $hmwp_text_mapping['to'] ) && !empty( $hmwp_text_mapping['to'] ) ) {

                                        if ( HMWP_Classes_Tools::getOption( 'hmwp_mapping_classes' ) ) {

                                            foreach ( $hmwp_text_mapping['from'] as $index => $from ) {
                                                if ( strpos( $content, $from ) !== false ) {
                                                    $content = preg_replace( "'(?:([^/])" . addslashes( $from ) . "([^/]))'is", '$1' . $hmwp_text_mapping['to'][$index] . '$2', $content );
                                                }
                                            }

                                        } else {
                                            $content = str_ireplace( $hmwp_text_mapping['from'], $hmwp_text_mapping['to'], $content );
                                        }
                                    }
                                }

                                $this->writeFile( $file, $content );
                            }
                        }

                    }
                }
            }

        } catch ( Exception $e ) {
        }
    }

    /**
     * Replace the paths inHTML files
     *
     * @return void
     */
    public function changePathsInJs() {
        if ( HMWP_Classes_Tools::getOption( 'error' ) ) {
            return;
        }

        try {
            if ( $this->getCachePath() ) {
                $jsfiles = $this->rsearch( $this->getCachePath() . '*.js' );

                if ( !empty( $jsfiles ) ) {

                    //load the redirects into array
                    $this->buildRedirect();

                    /** @var HMWP_Models_Rewrite $rewriteModel */
                    $rewriteModel = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' );

                    foreach ( $jsfiles as $file ) {

                        //only if the file is writable
                        if ( !$content = $this->readFile( $file ) ) {
                            continue;
                        }

                        //if there is content in the file
                        if ( $content <> '' ) {


                            if ( strpos( $content, HMWP_Classes_Tools::$default['hmwp_admin_url'] ) !== false ) {
                                //replace the paths within js files
                                $jsfrom = $jsto = array();

                                //replace the paths within js files
                                if ( HMWP_Classes_Tools::$default['hmwp_admin_url'] . '/' . HMWP_Classes_Tools::$default['hmwp_admin-ajax_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_admin-ajax_url' ) &&
                                    HMWP_Classes_Tools::$default['hmwp_admin-ajax_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_admin-ajax_url' ) ) {
                                    $jsfrom[] = HMWP_Classes_Tools::$default['hmwp_admin_url'] . '/' . HMWP_Classes_Tools::$default['hmwp_admin-ajax_url'];
                                    $jsto[] = HMWP_Classes_Tools::getOption( 'hmwp_admin-ajax_url' );
                                }

                                if ( !empty( $jsfrom ) && !empty( $jsto ) ) {
                                    $content = str_ireplace( $jsfrom, $jsto, $content );
                                }
                            }

                            if ( strpos( $content, HMWP_Classes_Tools::$default['hmwp_wp-content_url'] ) !== false || strpos( $content, HMWP_Classes_Tools::$default['hmwp_wp-includes_url'] ) !== false ) {
                                //fix the relative links before
                                if ( HMWP_Classes_Tools::getOption( 'hmwp_fix_relative' ) ) {
                                    $content = $rewriteModel->fixRelativeLinks( $content );
                                }

                                //replace the paths within css files
                                if ( isset( $this->_replace['from'] ) && isset( $this->_replace['to'] ) && !empty( $this->_replace['from'] ) && !empty( $this->_replace['to'] ) ) {
                                    $content = str_ireplace( $this->_replace['from'], $this->_replace['to'], $content );
                                }
                            }

                            //Text Mapping for all js files
                            if ( HMWP_Classes_Tools::getOption( 'hmwp_mapping_file' ) ) {
                                $hmwp_text_mapping = json_decode( HMWP_Classes_Tools::getOption( 'hmwp_text_mapping' ), true );
                                if ( isset( $hmwp_text_mapping['from'] ) && !empty( $hmwp_text_mapping['from'] ) &&
                                    isset( $hmwp_text_mapping['to'] ) && !empty( $hmwp_text_mapping['to'] ) ) {

                                    if ( HMWP_Classes_Tools::getOption( 'hmwp_mapping_classes' ) ) {

                                        foreach ( $hmwp_text_mapping['from'] as $index => $from ) {
                                            if ( strpos( $content, $from ) !== false ) {
                                                $content = preg_replace( "'(?:([^/])" . addslashes( $from ) . "([^/]))'is", '$1' . $hmwp_text_mapping['to'][$index] . '$2', $content );
                                            }
                                        }

                                    } else {
                                        $content = str_ireplace( $hmwp_text_mapping['from'], $hmwp_text_mapping['to'], $content );
                                    }
                                }
                            }

                            $this->writeFile( $file, $content );
                        }

                    }
                }
            }
        } catch ( Exception $e ) {
        }
    }

    /**
     * Replace the paths inHTML files
     *
     * @return void
     */
    public function changePathsInHTML() {
        if ( HMWP_Classes_Tools::getOption( 'error' ) ) {
            return;
        }

        try {
            if ( $this->getCachePath() ) {
                $htmlfiles = $this->rsearch( $this->getCachePath() . '*.html' );

                if ( !empty( $htmlfiles ) ) {

                    //load the redirects into array
                    $this->buildRedirect();

                    /** @var HMWP_Models_Rewrite $rewriteModel */
                    $rewriteModel = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' );

                    foreach ( $htmlfiles as $file ) {
                        //only if the file is writable
                        if ( !is_writable( $file ) ) {
                            continue;
                        }

                        //get the file content
                        $content = @file_get_contents( $file );

                        //if there is content in the file
                        if ( $content <> '' ) {
                            //if the file has unchanged paths
                            if ( strpos( $content, HMWP_Classes_Tools::$default['hmwp_wp-content_url'] ) !== false || strpos( $content, HMWP_Classes_Tools::$default['hmwp_wp-includes_url'] ) !== false ) {

                                //fix the relative links before
                                if ( HMWP_Classes_Tools::getOption( 'hmwp_fix_relative' ) ) {
                                    $content = $rewriteModel->fixRelativeLinks( $content );
                                }

                                //replace the paths within css files
                                if ( isset( $this->_replace['from'] ) && isset( $this->_replace['to'] ) && !empty( $this->_replace['from'] ) && !empty( $this->_replace['to'] ) ) {
                                    $content = str_ireplace( $this->_replace['from'], $this->_replace['to'], $content );

                                    $jsfrom = $jsto = array();
                                    //replace the paths within css files
                                    if ( HMWP_Classes_Tools::$default['hmwp_admin_url'] . '/' . HMWP_Classes_Tools::$default['hmwp_admin-ajax_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_admin-ajax_url' ) &&
                                        HMWP_Classes_Tools::$default['hmwp_admin-ajax_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_admin-ajax_url' ) ) {
                                        $jsfrom[] = HMWP_Classes_Tools::$default['hmwp_admin_url'] . '/' . HMWP_Classes_Tools::$default['hmwp_admin-ajax_url'];
                                        $jsto[] = HMWP_Classes_Tools::getOption( 'hmwp_admin-ajax_url' );
                                    }

                                    if ( !empty( $jsfrom ) && !empty( $jsto ) ) {
                                        $content = str_ireplace( $jsfrom, $jsto, $content );
                                    }
                                }

                                //Text Mapping for all js files
                                if ( HMWP_Classes_Tools::getOption( 'hmwp_mapping_file' ) ) {
                                    $hmwp_text_mapping = json_decode( HMWP_Classes_Tools::getOption( 'hmwp_text_mapping' ), true );
                                    if ( isset( $hmwp_text_mapping['from'] ) && !empty( $hmwp_text_mapping['from'] ) &&
                                        isset( $hmwp_text_mapping['to'] ) && !empty( $hmwp_text_mapping['to'] ) ) {

                                        if ( HMWP_Classes_Tools::getOption( 'hmwp_mapping_classes' ) ) {

                                            foreach ( $hmwp_text_mapping['from'] as $index => $from ) {
                                                if ( strpos( $content, $from ) !== false ) {
                                                    $content = preg_replace( "'(?:([^/])" . addslashes( $from ) . "([^/]))'is", '$1' . $hmwp_text_mapping['to'][$index] . '$2', $content );
                                                }
                                            }

                                        } else {
                                            $content = str_ireplace( $hmwp_text_mapping['from'], $hmwp_text_mapping['to'], $content );
                                        }
                                    }
                                }

                                @file_put_contents( $file, $content );
                            }
                        }
                    }
                }
            }
        } catch ( Exception $e ) {
        }
    }


    /**
     * Get the files paths by extension
     *
     * @param $pattern
     * @param $flags
     *
     * @return array
     */
    public function rsearch( $pattern, $flags = 0 ) {
        $files = array();

        if ( function_exists( 'glob' ) ) {
            $files = glob( $pattern, $flags );
            foreach ( glob( dirname( $pattern ) . '/*', GLOB_ONLYDIR | GLOB_NOSORT ) as $dir ) {
                $files = array_merge( $files, $this->rsearch( $dir . '/' . basename( $pattern ), $flags ) );
            }
        }

        return $files;
    }

    /**
     * Read the file content
     *
     * @param $file
     *
     * @return bool
     */
    public function readFile( $file ) {

        if ( !HMWP_Classes_Tools::isWindows() ) {
            $wp_filesystem = HMWP_Classes_Tools::initFilesystem();

            if ( isset( $wp_filesystem ) && method_exists( $wp_filesystem, 'get_contents' ) ) {
                return $wp_filesystem->get_contents( $file );
            }

        } elseif ( is_writable( $file ) ) {
            return @file_get_contents( $file );
        }

        return false;
    }

    /**
     * Write the file content
     *
     * @param $file
     *
     * @return bool
     */
    public function writeFile( $file, $content ) {

        if ( !HMWP_Classes_Tools::isWindows() ) {
            $wp_filesystem = HMWP_Classes_Tools::initFilesystem();

            if ( isset( $wp_filesystem ) && method_exists( $wp_filesystem, 'put_contents' ) ) {
                $wp_filesystem->put_contents( $file, $content );
            }

        } elseif ( is_writable( $file ) ) {
            @file_put_contents( $file, $content );
        }

    }


}
