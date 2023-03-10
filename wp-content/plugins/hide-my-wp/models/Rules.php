<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class HMWP_Models_Rules {
    public $root_path;
    public $config_file;
    public $config_chmod;

    public function __construct() {
        $this->root_path = HMWP_Classes_Tools::getRootPath();

        if ( HMWP_Classes_Tools::isNginx() ) {
            $this->config_file = $this->root_path . 'hidemywp.conf';
        } elseif ( HMWP_Classes_Tools::isIIS() ) {
            $this->config_file = $this->root_path . 'web.config';
        } elseif ( HMWP_Classes_Tools::isApache() || HMWP_Classes_Tools::isLitespeed() ) {
            $this->config_file = $this->root_path . '.htaccess';
        } else {
            $this->config_file = false;
        }
    }

    public function getConfFile() {
        return $this->config_file;
    }

    /**
     * Check if the config file is writable
     *
     * @param string $config_file
     *
     * @return bool
     */
    public function isConfigWritable( $config_file = null ) {
        //get the global config file if not specified
        if ( !isset( $config_file ) ) {
            $config_file = $this->getConfFile();
        }

        if ( $config_file ) {
            if ( !file_exists( $config_file ) ) {
                if ( !is_writable( dirname( $config_file ) ) ) {
                    return false;
                }
                if ( !touch( $config_file ) ) {
                    return false;
                }
            } elseif ( !is_writeable( $config_file ) ) {
                return false;
            }
        }

        return true;
    }


    /**
     * Write to config file
     *
     * @param $rules
     * @param string $header
     *
     * @return bool
     * @throws Exception
     */
    public function writeToFile( $rules, $header = 'HMWP_RULES' ) {
        if ( $this->getConfFile() ) {
            if ( HMWP_Classes_Tools::isNginx() ) {
                return $this->writeInNginx( $rules, $header );
            } elseif ( HMWP_Classes_Tools::isIIS() && !HMWP_Classes_Tools::getOption( 'logout' ) ) {
                return HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->flushRewrites();
            } elseif ( HMWP_Classes_Tools::isApache() || HMWP_Classes_Tools::isLitespeed() ) {
                return $this->writeInHtaccess( $rules, $header );
            }
        }

        return false;
    }

    /**
     * Replace text in file
     *
     * @param $old
     * @param $new
     * @param $file
     *
     * @return bool
     */
    public function setReplace( $old, $new, $file ) {
        if ( !$this->isConfigWritable( $file ) ) {
            return false;
        }

        $found = false;
        $lines = file( $file );

        foreach ( (array)$lines as $line ) {
            if ( preg_match( "/$old/", $line ) ) {
                $found = true;
                break;
            }
        }


        if ( $found ) {
            $fd = fopen( $file, 'w' );
            foreach ( (array)$lines as $line ) {
                if ( !preg_match( "/$old/", $line ) ) {
                    fputs( $fd, $line );
                } elseif ( $new <> '' ) {
                    fputs( $fd, $new );
                }
            }
            fclose( $fd );
        } elseif ( $new <> '' ) {
            $fd = fopen( $file, 'w' );
            foreach ( (array)$lines as $line ) {
                fputs( $fd, $line );

                if ( !$found && preg_match( '/\$table_prefix/', $line ) ) {
                    fputs( $fd, $new );
                    $found = true;
                }
            }
            fclose( $fd );
        }

        return $found;
    }

    public function writeInNginx( $rules, $header = 'HMWP_RULES' ) {
        return $this->insertWithMarkers( $header, $rules );
    }

    public function writeInHtaccess( $rules, $header = 'HMWP_RULES' ) {
        if ( HMWP_Classes_Tools::isModeRewrite() ) {
            return $this->insertWithMarkers( $header, $rules );
        }

        return false;
    }


    /**
     * Inserts an array of strings into a file (.htaccess ), placing it between
     * BEGIN and END markers.
     *
     * Replaces existing marked info. Retains surrounding
     * data. Creates file if none exists.
     *
     * @param string $marker The marker to alter.
     * @param array|string $insertion The new content to insert.
     *
     * @return bool True on write success, false on failure.
     */
    public function insertWithMarkers( $marker, $insertion ) {

        if ( !$this->isConfigWritable() ) {
            if ( !$this->forceOpenConfigFile( $this->getConfFile() ) ) {
                return false;
            }
        }

        $start_marker = "# BEGIN {$marker}";
        $end_marker = "# END {$marker}";

        if ( $insertion == '' ) { //delete the marker if there is no data to add in it

            $wp_filesystem = HMWP_Classes_Tools::initFilesystem();

            if ( method_exists( $wp_filesystem, 'get_contents' ) && method_exists( $wp_filesystem, 'put_contents' ) ) {
                try {
                    $htaccess = $wp_filesystem->get_contents( $this->getConfFile() );
                    $htaccess = preg_replace( "/$start_marker.*$end_marker/s", "", $htaccess );
                    $htaccess = preg_replace( "/\n+/", "\n", $htaccess );
                    $wp_filesystem->put_contents( $this->getConfFile(), $htaccess );

                    return true;
                } catch ( Exception $e ) {
                }
            }
        }


        if ( !is_array( $insertion ) ) {
            $insertion = explode( "\n", $insertion );
        }

        $fp = fopen( $this->getConfFile(), 'r+' );
        if ( !$fp ) {
            return false;
        }

        // Attempt to get a lock. If the filesystem supports locking, this will block until the lock is acquired.
        flock( $fp, LOCK_EX );

        $lines = array();
        while ( !feof( $fp ) ) {
            $lines[] = rtrim( fgets( $fp ), "\r\n" );
        }

        // Split out the existing file into the preceding lines, and those that appear after the marker
        $pre_lines = $post_lines = $existing_lines = array();
        $found_marker = $found_end_marker = false;
        foreach ( $lines as $line ) {
            if ( !$found_marker && false !== strpos( $line, $start_marker ) ) {
                $found_marker = true;
                continue;
            } elseif ( !$found_end_marker && false !== strpos( $line, $end_marker ) ) {
                $found_end_marker = true;
                continue;
            }
            if ( !$found_marker ) {
                $pre_lines[] = $line;
            } elseif ( $found_marker && $found_end_marker ) {
                $post_lines[] = $line;
            } else {
                $existing_lines[] = $line;
            }
        }

        // Check to see if there was a change
        if ( $existing_lines === $insertion ) {
            flock( $fp, LOCK_UN );
            fclose( $fp );

            //Set the chmod back on file close
            $this->closeConfigFile( $this->getConfFile() );

            return true;
        }

        // Generate the new file data
        if ( !$found_marker ) {
            $new_file_data = implode( "\n", array_merge(
                array($start_marker),
                $insertion,
                array($end_marker),
                $pre_lines
            ) );
        } else {
            $new_file_data = implode( "\n", array_merge(
                $pre_lines,
                array($start_marker),
                $insertion,
                array($end_marker),
                $post_lines
            ) );
        }

        // Write to the start of the file, and truncate it to that length
        fseek( $fp, 0 );
        $bytes = fwrite( $fp, $new_file_data );
        if ( $bytes ) {
            ftruncate( $fp, ftell( $fp ) );
        }
        fflush( $fp );
        flock( $fp, LOCK_UN );
        fclose( $fp );

        //Set the chmod back on file close
        $this->closeConfigFile( $this->getConfFile() );

        return (bool)$bytes;
    }

    /**
     * Force opening the file
     *
     * @param $config_file
     *
     * @return bool
     */
    public function forceOpenConfigFile( $config_file ) {
        $this->config_chmod = false;
        if ( !HMWP_Classes_Tools::isWindows() && file_exists( $config_file ) ) {

            $wp_filesystem = HMWP_Classes_Tools::initFilesystem();

            if ( isset( $wp_filesystem ) && method_exists( $wp_filesystem, 'getchmod' ) && method_exists( $wp_filesystem, 'chmod' ) ) {
                $this->config_chmod = $wp_filesystem->getchmod( $config_file );
                $wp_filesystem->chmod( $config_file, 0664 );

                if ( is_writeable( $config_file ) ) {
                    if ( method_exists( $wp_filesystem, 'copy' ) ) {
                        $wp_filesystem->copy( $config_file, $config_file . '_' . substr( md5( date( 'd' ) ), 0, 5 ) );
                    }

                    return true;
                }
            }
        }

        return false;
    }

    /**
     *  Set the chmod back on file close
     *
     * @param $config_file
     */
    public function closeConfigFile( $config_file ) {

        $wp_filesystem = HMWP_Classes_Tools::initFilesystem();

        if ( $this->config_chmod && isset( $wp_filesystem ) ) {
            if ( $this->config_chmod == '400' ) {
                $wp_filesystem->chmod( $config_file, 0400 );
            } elseif ( $this->config_chmod == '440' ) {
                $wp_filesystem->chmod( $config_file, 0440 );
            } else {
                $wp_filesystem->chmod( $config_file, 0444 );
            }
        }
    }

    /**
     * Hide the Old Paths like /hmwp_wp-content_url, /hmwp_wp-includes_url
     */
    public function getHideOldPathRewrite() {
        $rules = '';
        $home_root = parse_url( home_url() );
        $wp_content = HMWP_Classes_Tools::$default['hmwp_wp-content_url'];
        $wp_includes = HMWP_Classes_Tools::$default['hmwp_wp-includes_url'];

        $extensions = array();
        $types = (array)HMWP_Classes_Tools::getOption( 'hmwp_hide_oldpaths_types' );
        if ( in_array( 'css', $types ) ) {
            array_push( $extensions, '\.css' );
            array_push( $extensions, '\.scss' );
        }
        if ( in_array( 'js', $types ) ) {
            array_push( $extensions, '\.js' );
        }
        if ( in_array( 'php', $types ) ) {
            array_push( $extensions, '\.php' );
        }
        if ( in_array( 'html', $types ) ) {
            array_push( $extensions, '\.htm' );
            array_push( $extensions, '\.html' );
        }
        if ( in_array( 'txt', $types ) ) {
            array_push( $extensions, '\.rtf' );
            array_push( $extensions, '\.rtx' );
            array_push( $extensions, '\.txt' );
        }
        if ( in_array( 'xml', $types ) ) {
            array_push( $extensions, '\.xsd' );
            array_push( $extensions, '\.xml' );
        }

        if ( isset( $home_root['path'] ) ) {
            $home_root = trailingslashit( $home_root['path'] );
        } else {
            $home_root = '/';
        }

        if ( HMWP_Classes_Tools::isNginx() ) {
            if ( HMWP_Classes_Tools::$default['hmwp_wp-content_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_wp-content_url' ) ) {
                $rules .= 'if ($http_cookie !~* "wordpress_logged_in_|' . HMWP_LOGGED_IN_COOKIE . '|wp-postpass_|wptouch_switch_toggle|comment_author_|comment_author_email_" ) {  set $cond cookie; }' . "" . PHP_EOL;
                $rules .= 'if ($request_uri ~* ^' . $home_root . $wp_content . '/?$) { set $cond "${cond}+deny_uri"; }' . "" . PHP_EOL;
                $rules .= 'if ($request_uri ~* ^' . $home_root . $wp_content . '/[^\.]+/?$) { set $cond "${cond}+deny_uri"; }' . "" . PHP_EOL;
                if ( !empty( $extensions ) ) {
                    $rules .= 'if ($request_uri ~* ^' . $home_root . '' . HMWP_Classes_Tools::$default['hmwp_plugin_url'] . '/[^\.]+(' . join( '|', $extensions ) . ')) { set $cond "${cond}+deny_uri"; }' . "" . PHP_EOL;
                    $rules .= 'if ($request_uri ~* ^' . $home_root . $wp_content . '/' . HMWP_Classes_Tools::$default['hmwp_themes_url'] . '/[^\.]+(' . join( '|', $extensions ) . ')) { set $cond "${cond}+deny_uri"; }' . "" . PHP_EOL;
                }
                if ( HMWP_Classes_Tools::$default['hmwp_wp-includes_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_wp-includes_url' ) ) {
                    $rules .= 'if ($request_uri ~* ^' . $home_root . $wp_includes . '(/.*)?) { set $cond "${cond}+deny_uri"; }' . "" . PHP_EOL;
                }
                $rules .= 'if ($cond = "cookie+deny_uri") {  return 404; } ' . "" . PHP_EOL;
            }
        } elseif ( HMWP_Classes_Tools::isApache() || HMWP_Classes_Tools::isLitespeed() ) {
            $rules .= "<IfModule mod_rewrite.c>" . PHP_EOL;
            $rules .= "RewriteEngine On" . PHP_EOL;
            $rules .= "RewriteBase $home_root" . PHP_EOL;
            $rules .= "RewriteCond %{HTTP:Cookie} !(wordpress_logged_in_|" . HMWP_LOGGED_IN_COOKIE . "|wp-postpass_|wptouch_switch_toggle|comment_author_|comment_author_email_) [NC]" . PHP_EOL;
            if ( defined( 'WP_ROCKET_MINIFY_CACHE_URL' ) ) { //If WP-Rocket is installed
                $rules .= "RewriteCond %{REQUEST_URI} !" . str_replace( array(home_url() . '/', HMWP_Classes_Tools::$default['hmwp_wp-content_url']), '', ltrim( WP_ROCKET_MINIFY_CACHE_URL, '/' ) ) . " [NC]" . PHP_EOL;
            }
            if ( HMWP_Classes_Tools::$default['hmwp_wp-content_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_wp-content_url' ) ) {
                $rules .= "RewriteCond %{REQUEST_URI} ^" . $home_root . $wp_content . "/$ [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{REQUEST_URI} ^" . $home_root . $wp_content . "/[^\.]+/?$ [NC,OR]" . PHP_EOL;
            }
            if ( !empty( $extensions ) ) {
                if ( HMWP_Classes_Tools::$default['hmwp_plugin_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_plugin_url' ) ) {
                    $rules .= "RewriteCond %{THE_REQUEST} " . $home_root . "" . HMWP_Classes_Tools::$default['hmwp_plugin_url'] . "/[^\.]+(" . join( '|', $extensions ) . ") [NC,OR]" . PHP_EOL;
                }
                if ( HMWP_Classes_Tools::$default['hmwp_themes_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_themes_url' ) ) {
                    $rules .= "RewriteCond %{THE_REQUEST} " . $home_root . $wp_content . "/" . HMWP_Classes_Tools::$default['hmwp_themes_url'] . "/[^\.]+(" . join( '|', $extensions ) . ")    [NC,OR]" . PHP_EOL;
                }
            }
            if ( HMWP_Classes_Tools::$default['hmwp_wp-includes_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_wp-includes_url' ) ) {
                $rules .= "RewriteCond %{THE_REQUEST} " . $home_root . $wp_includes . "(/.*)? [NC,OR]" . PHP_EOL;
            }
            $rules .= "RewriteCond %{THE_REQUEST} /([_0-9a-zA-Z-]+/)?(upgrade\\.php|install\\.php) [NC]" . PHP_EOL;
            $rules .= "RewriteRule ^(.*)$ - [L,R=404]" . PHP_EOL;
            $rules .= "</IfModule>" . PHP_EOL . PHP_EOL;

            //disable the xmlrpc in .htaccess only for Apache servers
            //Compatibility with JetPack and other plugins
            if ( HMWP_Classes_Tools::getOption( 'hmwp_disable_xmlrpc' ) && HMWP_Classes_Tools::isApache() ) {
                $rules .= "<Files xmlrpc.php>" . PHP_EOL;
                $rules .= "Order deny,allow" . PHP_EOL;
                $rules .= "Deny from all" . PHP_EOL;
                $rules .= "Allow from 127.0.0.1" . PHP_EOL;
                $rules .= "Allow from *.wordpress.com" . PHP_EOL;
                $rules .= "Allow from 192.0.64.0/18" . PHP_EOL;
                $rules .= "Allow from 185.64.140.0/22" . PHP_EOL;
                $rules .= "Allow from 2a04:fa80::/29" . PHP_EOL;
                $rules .= "Allow from 76.74.255.0/22" . PHP_EOL;
                $rules .= "Allow from 192.0.65.0/22" . PHP_EOL;
                $rules .= "Allow from 192.0.80.0/22" . PHP_EOL;
                $rules .= "Allow from 192.0.96.0/22" . PHP_EOL;
                $rules .= "Allow from 192.0.123.0/22" . PHP_EOL;
                $rules .= "Satisfy All " . PHP_EOL;
                $rules .= "ErrorDocument 404 /" . PHP_EOL;
                $rules .= "</Files>" . PHP_EOL . PHP_EOL;
            }

        } elseif ( HMWP_Classes_Tools::isIIS() ) {
            if ( HMWP_Classes_Tools::$default['hmwp_wp-content_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_wp-content_url' ) ) {
                $rules .= '
                    <rule name="HideMyWp: block_oldpaths_content" stopProcessing="true">
                        <match url="^' . $wp_content . '/?$" ignoreCase="false" />
                         <conditions>
                          <add input="{HTTP_COOKIE}" pattern="(wordpress_logged_in_|' . HMWP_LOGGED_IN_COOKIE . '|wp-postpass_|wptouch_switch_toggle|comment_author_|comment_author_email_)" negate="true" />
                         </conditions>
                        <action type="CustomResponse" statusCode="404" statusReason="File Not Found" statusDescription="The requested path was not found" />
                    </rule>';
                $rules .= '
                    <rule name="HideMyWp: block_oldpaths_content_paths" stopProcessing="true">
                        <match url="^' . $wp_content . '/[^\.]+/?$" ignoreCase="false" />
                         <conditions>
                          <add input="{HTTP_COOKIE}" pattern="(wordpress_logged_in_|' . HMWP_LOGGED_IN_COOKIE . '|wp-postpass_|wptouch_switch_toggle|comment_author_|comment_author_email_)" negate="true" />
                         </conditions>
                        <action type="CustomResponse" statusCode="404" statusReason="File Not Found" statusDescription="The requested path was not found" />
                    </rule>';
            }
            if ( !empty( $extensions ) ) {
                if ( HMWP_Classes_Tools::$default['hmwp_plugin_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_plugin_url' ) ) {
                    $rules .= '
                    <rule name="HideMyWp: block_oldpaths_plugin" stopProcessing="true">
                        <match url="^' . HMWP_Classes_Tools::$default['hmwp_plugin_url'] . '/[^\.]+(' . join( '|', $extensions ) . ')' . '" ignoreCase="false" />
                         <conditions>
                          <add input="{HTTP_COOKIE}" pattern="(wordpress_logged_in_|' . HMWP_LOGGED_IN_COOKIE . '|wp-postpass_|wptouch_switch_toggle|comment_author_|comment_author_email_)" negate="true" />
                         </conditions>
                        <action type="CustomResponse" statusCode="404" statusReason="File Not Found" statusDescription="The requested path was not found" />
                    </rule>';
                }
                if ( HMWP_Classes_Tools::$default['hmwp_themes_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_themes_url' ) ) {
                    $rules .= '
                    <rule name="HideMyWp: block_oldpaths_themes" stopProcessing="true">
                        <match url="^' . HMWP_Classes_Tools::$default['hmwp_themes_url'] . '/[^\.]+(' . join( '|', $extensions ) . ')' . '" ignoreCase="false" />
                         <conditions>
                          <add input="{HTTP_COOKIE}" pattern="(wordpress_logged_in_|' . HMWP_LOGGED_IN_COOKIE . '|wp-postpass_|wptouch_switch_toggle|comment_author_|comment_author_email_)" negate="true" />
                         </conditions>
                        <action type="CustomResponse" statusCode="404" statusReason="File Not Found" statusDescription="The requested path was not found" />
                    </rule>';
                }
            }
            if ( false && HMWP_Classes_Tools::$default['hmwp_wp-includes_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_wp-includes_url' ) ) {
                $rules .= '
                    <rule name="HideMyWp: block_oldpaths_includes" stopProcessing="true">
                        <match url="^' . $wp_includes . '(/.*)?" ignoreCase="false" />
                         <conditions>
                          <add input="{HTTP_COOKIE}" pattern="(wordpress_logged_in_|' . HMWP_LOGGED_IN_COOKIE . '|wp-postpass_|wptouch_switch_toggle|comment_author_|comment_author_email_)" negate="true" />
                         </conditions>
                        <action type="CustomResponse" statusCode="404" statusReason="File Not Found" statusDescription="The requested path was not found" />
                    </rule>';
            }
            $rules .= '
                    <rule name="HideMyWp: block_upgrade" stopProcessing="true">
                        <match url="^([_0-9a-zA-Z-]+/)?(upgrade.php|install.php)" ignoreCase="false" />
                         <conditions>
                          <add input="{HTTP_COOKIE}" pattern="(wordpress_logged_in_|' . HMWP_LOGGED_IN_COOKIE . '|wp-postpass_|wptouch_switch_toggle|comment_author_|comment_author_email_)" negate="true" />
                         </conditions>
                        <action type="CustomResponse" statusCode="404" statusReason="File Not Found" statusDescription="The requested path was not found" />
                    </rule>';
        }

        return $rules;
    }

    /**
     * Add rules to protect the website from sql injection
     * @return string
     */
    public function getInjectionRewrite() {
        $rules = '';
        if ( HMWP_Classes_Tools::isNginx() ) {
            if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_commonfiles' ) ) {
                $rules .= 'location ~ ^/(error_log|wp-config-sample.php|readme.html|readme.txt|license.txt|install.php|wp-config.php|php.ini|bb-config.php) { return 404; }' . "" . PHP_EOL;
            }

            if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_authors' ) ) {
                $rules .= 'if ($request_uri ~* author=\d+$) { set $cond "author_uri"; }' . "" . PHP_EOL;
                $rules .= 'if ($cond = "author_uri") {  return 404; } ' . "" . PHP_EOL;
            }

            if ( HMWP_Classes_Tools::getOption( 'hmwp_disable_browsing' ) ) {
                $rules .= 'autoindex off;' . "" . PHP_EOL;
            }
        } elseif ( HMWP_Classes_Tools::isApache() || HMWP_Classes_Tools::isLitespeed() ) {
            $home_root = parse_url( home_url() );
            if ( isset( $home_root['path'] ) ) {
                $home_root = trailingslashit( $home_root['path'] );
            } else {
                $home_root = '/';
            }

            if ( HMWP_Classes_Tools::getOption( 'hmwp_sqlinjection' ) ) {
                $rules .= "<IfModule mod_rewrite.c>" . PHP_EOL;
                $rules .= "RewriteEngine On" . PHP_EOL;
                $rules .= "RewriteBase $home_root" . PHP_EOL;
                // Prevent -f checks on index.php.
                //$rules .= "RewriteCond %{HTTP_USER_AGENT} (havij|libwww-perl|wget|python|nikto|curl|scan|java|winhttp|clshttp|loader) [NC,OR]". PHP_EOL;
                $rules .= "RewriteCond %{HTTP_USER_AGENT} (%0A|%0D|%3C|%3E|%00) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{HTTP_USER_AGENT} (;|<|>|'|\\\"|\\)|\\(|%0A|%0D|%22|%28|%3C|%3E|%00).*(libwww-perl|wget|python|nikto|curl|scan|java|winhttp|HTTrack|clshttp|archiver|loader|email|harvest|extract|grab|miner) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{THE_REQUEST} (\\?|\\*|%2a)+(%20+|\\s+|%20+\\s+|\\s+%20+|\\s+%20+\\s+)HTTP(:/|/) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{THE_REQUEST} etc/passwd [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{THE_REQUEST} cgi-bin [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{THE_REQUEST} (%0A|%0D|\\r|\\n) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{REQUEST_URI} owssvr\\.dll [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{HTTP_REFERER} (%0A|%0D|%3C|%3E|%00) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{HTTP_REFERER} \\.opendirviewer\\. [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{HTTP_REFERER} users\\.skynet\\.be.* [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} [a-zA-Z0-9_]=http:// [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} [a-zA-Z0-9_]=(\\.\\.//?)+ [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} [a-zA-Z0-9_]=/([a-z0-9_.]//?)+ [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} \\=PHP[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12} [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (\\.\\./|%2e%2e%2f|%2e%2e/|\\.\\.%2f|%2e\\.%2f|%2e\\./|\\.%2e%2f|\\.%2e/) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} ftp\\: [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} \\=\\|w\\| [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} ^(.*)/self/(.*)$ [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} ^(.*)cPath=http://(.*)$ [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (\\<|%3C).*script.*(\\>|%3E) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (<|%3C)([^s]*s)+cript.*(>|%3E) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (\\<|%3C).*embed.*(\\>|%3E) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (<|%3C)([^e]*e)+mbed.*(>|%3E) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (\\<|%3C).*object.*(\\>|%3E) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (<|%3C)([^o]*o)+bject.*(>|%3E) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (\\<|%3C).*iframe.*(\\>|%3E) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (<|%3C)([^i]*i)+frame.*(>|%3E) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} base64_encode.*\\(.*\\) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} base64_(en|de)code[^(]*\\([^)]*\\) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} GLOBALS(=|\\[|\\%[0-9A-Z]{0,2}) [OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} _REQUEST(=|\\[|\\%[0-9A-Z]{0,2}) [OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} ^.*(\\(|\\)|<|>|%3c|%3e).* [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} ^.*(\\x00|\\x04|\\x08|\\x0d|\\x1b|\\x20|\\x3c|\\x3e|\\x7f).* [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (NULL|OUTFILE|LOAD_FILE) [OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (\\.{1,}/)+(motd|etc|bin) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (localhost|loopback|127\\.0\\.0\\.1) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (<|>|'|%0A|%0D|%3C|%3E|%00) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} concat[^\\(]*\\( [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} union([^s]*s)+elect [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} union([^a]*a)+ll([^s]*s)+elect [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} \\-[sdcr].*(allow_url_include|allow_url_fopen|safe_mode|disable_functions|auto_prepend_file) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (;|<|>|'|\"|\\)|%0A|%0D|%22|%27|%3C|%3E|%00).*(/\\*|union|select|insert|drop|delete|cast|create|char|convert|alter|declare|script|set|md5|benchmark|encode) [NC,OR]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} (sp_executesql) [NC]" . PHP_EOL;
                $rules .= "RewriteRule ^(.*)$ - [F]" . PHP_EOL;
                $rules .= "</IfModule>" . PHP_EOL . PHP_EOL;
                $rules .= "<IfModule mod_headers.c>" . PHP_EOL;
                $rules .= "Header unset X-Powered-By" . PHP_EOL;
                $rules .= "Header unset Server" . PHP_EOL;
                $rules .= "</IfModule>" . PHP_EOL . PHP_EOL;
            }
            if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_commonfiles' ) ) {
                $rules .= "<IfModule mod_rewrite.c>" . PHP_EOL;
                $rules .= "RewriteEngine On" . PHP_EOL;
                $rules .= "RewriteCond %{REQUEST_URI} /(error_log|wp-config-sample\\.php|readme\\.html|readme\\.txt|license\\.txt|install\\.php|wp-config\\.php|php\\.ini|php5\\.ini|bb-config\\.php) [NC]" . PHP_EOL;
                $rules .= "RewriteRule ^(.*)$ - [L,R=404]" . PHP_EOL;
                $rules .= "</IfModule>" . PHP_EOL . PHP_EOL;
            }
            if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_authors' ) ) {
                $rules .= "<IfModule mod_rewrite.c>" . PHP_EOL;
                $rules .= "RewriteEngine On" . PHP_EOL;
                $rules .= "RewriteCond %{REQUEST_URI} !/wp-admin [NC]" . PHP_EOL;
                $rules .= "RewriteCond %{QUERY_STRING} ^author=\d+ [NC]" . PHP_EOL;
                $rules .= "RewriteRule ^(.*)$ - [L,R=404]" . PHP_EOL;
                $rules .= "</IfModule>" . PHP_EOL . PHP_EOL;
            }
            if ( HMWP_Classes_Tools::getOption( 'hmwp_disable_browsing' ) ) {
                $rules .= "Options -Indexes" . PHP_EOL;
            }

            if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_header' ) ) {
                $rules .= "<IfModule mod_headers.c>" . PHP_EOL;
                $rules .= 'Header unset X-Powered-By' . "" . PHP_EOL;
                $rules .= 'Header unset Server' . "" . PHP_EOL;
                $rules .= 'ServerSignature Off' . "" . PHP_EOL;
                $rules .= "</IfModule>" . PHP_EOL . PHP_EOL;
            }


            if ( HMWP_Classes_Tools::getOption( 'hmwp_security_header' ) ) {
                $rules .= "<IfModule mod_headers.c>" . PHP_EOL;
                $rules .= 'Header set Strict-Transport-Security "max-age=63072000; preload"' . "" . PHP_EOL;
                $rules .= 'Header set Content-Security-Policy "object-src \'none\'"' . "" . PHP_EOL;
                $rules .= 'Header set X-XSS-Protection "1; mode=block"' . "" . PHP_EOL;
                $rules .= 'Header set X-Content-Type-Options nosniff' . "" . PHP_EOL;
                $rules .= "</IfModule>" . PHP_EOL . PHP_EOL;
            }

        } elseif ( HMWP_Classes_Tools::isIIS() ) {
            if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_commonfiles' ) ) {

                $rules .= '
                    <rule name="HideMyWp: block_commonfiles" stopProcessing="true">
                        <match url="^(error_log|wp-config-sample.php|readme.html|license.txt|install.php|wp-config.php|php.ini|bb-config.php)" ignoreCase="false" />
                        <action type="CustomResponse" statusCode="404" statusReason="File Not Found" statusDescription="The requested path was not found" />
                    </rule>';
            }
            if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_authors' ) ) {
                $rules .= '
                    <rule name="HideMyWp: block_author_id" stopProcessing="true">
                        <match url="(.*)"/>
                        <conditions logicalGrouping="MatchAny">
                          <add input="{QUERY_STRING}" pattern="^author=\d+" negate="false" />
                        </conditions>
                        <action type="CustomResponse" statusCode="404" statusReason="File Not Found" statusDescription="The requested path was not found" />
                    </rule>';
            }
        }

        // Add in the rules
        return $rules . "" . PHP_EOL;
    }

    /**
     * Check if the ADMIN_COOKIE_PATH is present in wp-config.php
     * @return bool
     */
    public function isConfigAdminCookie() {
        $config_file = HMWP_Classes_Tools::getConfigFile();

        $lines = file( $config_file );

        foreach ( (array)$lines as $line ) {
            if ( preg_match( "/ADMIN_COOKIE_PATH/", $line ) && !preg_match( "/^\/\//", trim( $line ) ) ) {
                return true;
            }
        }

        return false;
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
