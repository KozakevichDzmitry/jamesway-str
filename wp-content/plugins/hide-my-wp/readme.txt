How to install - Youtube Video
https://www.youtube.com/watch?v=WEGTGC1iNb0

1. Install the Plugin

Log In as an Admin on your WordPress blog.
In the menu displayed on the left, there is a "Plugins" tab. Click it.
Now click "Add New".
There, you have the buttons: "Search | Upload | Featured | Popular | Newest". Click "Upload".
Upload the hide-my-wp.zip file.
After the upload it's finished, click Activate Plugin.


2. Setup the plugin

After you've installed the plugin you will be redirected to the Plugin Settings page (Settings > Hide My Wp)
You can now choose between 2 levels of security: Lite and Ninja
Once you choose the option, follow the instructions and you're done

3. CDN Enabler

If you have CDN Enabler installed, go to Settings > Hide My Wp > Advanced and switch to Late loading
In CDN Enabler choose the Hide My WordPress paths and not wp-content, wp-includes
Click Save and You're done.

4. Extra

If you have Apache Server on your hosting server, go to Settings > Hide My Wp > Vulnerability page
and install the Injection filter in .htaccess
This filter will protect you from SQL Injections and Script Intrusions


== Changelog ==
= 5.0.21 (15 May 2021)=
* Update - Add Login and Register templates option
* Update - Add support for the wp-register when WP multisite
* Fix - Get the user capabilities when use has multiple roles

= 5.0.20 (23 April 2021)=
* Update - Added compatibility with builders Oxygen, Elementor, Thrive, Bricks
* Update - Added extra security in backend
* Fix - Brute Force warning when blocks the IP in function get_blocked_ips
* Fix - Load filesystem without FTP access

= 5.0.19 (19 Feb 2021)=
* Update - Added 403 Error Code option for the wp-admin and wp-login.php redirects
* Update - new rules and tasks for Security Check
* Fix - Get the settings from Hide My WP Lite on plugin update
* Fix - Filesystem error when the library is not correctly loaded
* Fix - Change paths in Login page when Late Loading is active
* Fix - Change the WordPress login logo when Clean Login Page is active

= 5.0.18 (15 Feb 2021)=
* Update - Update Security for the last updates and WP requirements
* Update - Optimize JS library from third party plugins
* Fixed - Login with WP Defender PRO and 2 Factor Authentification
* Fixed - Text Mapping for classes and IDs
* Fixed - Paths replace in the JS cache files
* Fixed - Small Bugs and UI

= 5.0.17 (22 Ian 2021)=
* Update - Compatibility with SiteGround Cache plugin
* Update - Compatibility warning with W3 Total Cache Lazy Load
* Update - Security Check to hide readme.html, license.txt and other common files
* Update - Removed X-Frame-Options header because of the iframe issue in the popup window

= 5.0.16 (14 Dec 2020)=
* Update - Added Strict-Transport-Security header
* Update - Added Content-Security-Policy header
* Update - Added X-Frame-Options header
* Update - Added X-XSS-Protection header
* Update - Added X-Content-Type-Options header
* Update - Added compatibility for AppThemes Confirm Email
* Fixed - Compatibility with WordPress 5.6
* Fixed - Compatibility with PHP 8.0 with deprecated functions

= 5.0.15 (26 Nov 2020)=
* Update - The rules update on adding new plugin or theme
* Update - Added compatibility with PPress plugin for custom page login
* Fixed - Nginx URL Mapping rules to add the rules correctly in the config file
* Fixed - Rollback the settings when pressing the Abort button
* Fixed - Fixed Backup/Restore rules flash
* Fixed - Small bugs and typos

= 5.0.14 (13 Nov 2020)=
* Update - Compatibility with Manage WP plugin
* Update - Add the plugin as Must Use plugin for better security and compatibility with other plugins
* Update - Compatibility with Really Simple SSL plugin
* Update - New UX for better understanding of the redirects
* Update - Add compatibility with JetPack in XML-RPC option for Apache servers
* Update - Compatibility with WPML when setting custom wp-admin and admin-ajax
* Update - Compatibility with WPML when RTL languages are set in dashboard
* Update - Compatibility with bbPress plugin
* Update - Compatibility with Newspaper theme
* Update - Added Compatibility with WP 5.5.3

= 5.0.13 (24 Oct 2020)=
* Update - Added more CMSs emulators to confuse the Theme Detectors
* Update - Extra caching in htaccess when "Optimize CSS and JS Files" is activated
* Update - Do not cache if already cached by WP-Rocket or WP Fastest Cache
* Update - Added Login and Logout redirects for each user role
* Fix - 404 error on Nxing server when updating the settings

= 5.0.12 (30 Sept 2020)=
* Update - Added compatibility with Pro Theme by Themeco
* Update - Added _HMWP_CONFIGPATH to specify the config root file. ABSPATH by default.
* Fixed - Redirect errors for some themes
* Update - Added compatibility for Smush Pro plugin by WPMU DEV
* Update - Added compatibility for WP Client plugin by WP-Client.com

= 5.0.11 (03 Sept 2020)=
* Update - Added a fix for noredirect param on infinite loops
* Update - Compatibility with WPRentals theme
* Update - Compatibility with last version WP Fastest Cache plugin
* Update - Remove version parameter from CSS and JS URLs containing the plus sign
* Update - Added {rand} in Text Mapping to show random string on change
* Update - Added {blank} in Text Mapping to show an empty string on change
* Update - Added Compatibility with WP 5.5.1
* Fix - Load the 404 not found files correctly

= 5.0.10 (27 Aug 2020)=
* Update - Added the version hook to remove the versions from CSS and JS
* Update - Load the login on WPEngine server with PHP7.4 when the login is set as /login
* Update - Detect Flywheel server and add the rules accordingly
* Update - Compatibility with Oxygen theme
* Update - Compatibility with IThemes Security on custom login

= 5.0.09 (03 Aug 2020)=
* Update - Added the option to hide /login and /wp-login individually
* Update - Added the option to select the file extensions for the option Hide WP Common Paths
* Update - Added the option to redirect to a custom URL on logout

= 5.0.08 (08 July 2020)=
* Update - Compatibility with WPEngine + PHP 7
* Update - Compatibility with Absolutely Glamorous Custom Admin plugin
* Update - Compatibility with Admin Menu Editor Pro plugin
* Fix - Small CSS & Warning issues

= 5.0.07 (19 June 2020)=
* Update - Added HMW_RULES_IN_CONFIG and HMW_RULES_IN_WP_RULES to control the rules in the config file
* Update - Change the rewrite hook to make sure the rules are added in the WordPress rewrites before flushing them
* Update - Compatible with iThemes Security latest update
* HMW_RULES_IN_CONFIG will add the rules in the top of the config file (default true)
* HMW_RULES_IN_WP_RULES will add the ruls in the WordPress config area  (default true)
* Updated the security in the plugin to work well to SiteGround

= 5.0.05 (04 June 2020)=
* Update - Compatibility with Hummingbird Cache plugin
* Update - Compatibility with Cachify plugin
* Update - Added RTL Support in the plugin
* Update - Added Debug Log for faster debugging
* Fix - Show option Change Paths in Cache Files for all cache plugins compatible with Hide My WP Ghost
* CSS Fixes for the latest Bootstrap version and WordPress version

= 5.0.04 (15 May 2020)=
* Fixed the Text Mapping in CSS and JS to not load while in admin
* Removed some old params that are not used anymore
* Flush the rewrites changed on Plugins and Themes updates
* Remove all rewrites on plugin deactivation
* Remoce the option to write in the cache files if there is not a cache plugin installed
* Show Change Paths in Cache files only when a Cache plugin is installed

= 5.0.02 (01 May 2020) =
* Update - Show the Hide My WP menu only on Network if WP Multisite
* Update - New option to hide both active and inactive Plugins on WP Multisite
* Update - Prevent from loading the style from wp-admin in the custom login page
* Update - WPEngine 2020 rewrites compatibility
* Update - Added option to hide only the IDs and Classes in Hide My WP > Text Mapping
* Update - Added the option to remove the WordPress common paths in /robots.txt file
* Update - Compatibility with the most populat plugins and WordPress 5.4.1
* Update - Compatibility with Litespeed Cache plugin
* Update - Compatibility with WordFence
* Fix - login redirect for nginx server
* Fix - constant warning NONCE_KEY in confi.php
* Fix - URL Mapping for WPEngine
* Fix - Show 404 files in case the rewrites are not working or Allowoverride is OFF
* Fix - Detect correct https or http sheme for Login Preview and validation
* Fix - Save the Hide My WP rewrites when other plugin are updating the config file to prevent rewrite error

= 4.4.04 (03 April 2020) =
* Update - Compatibility and Security for WordPress 5.4
* Fix - Activation process with Token

= 4.4.03 (23 March 2020) =
* Update - Compatibility and Security for WordPress 5.4
* Update - Added compatibility with Asset CleanUp: Page Speed Booster
* Update - Added CMS simulator for Drupal 8
* Update - Added the option to hide both active and deactivated plugins

= 4.4.01 (06 Feb 2020) =
* Update - Added the option to map the text only in classes and ids
* Update - Secure the Robots.txt file and remove the common paths
* Update - Correct the Logout URL if invalid
* Update - Compatibility with Squirrly SEO plugin
* Update - Compatibility with Woocommerce, JetPack and Elementor
* Update - Removed HMW_DYNAMIC_THEME_STYLE and added the file text mapping
* Update - Change text from Text Mapping in JS and CSS files
* Update - Change text from Text Mapping in cached files created by cache plugins
* Fix - Remove the Save button until the Frontend is checked
* Fix - Corrected the backup file name on Settings Backup action
* Fix - Clear the cache for Elementor CSS files on Mapping update

= 4.3.04 (31 Ian 2020) =
* Update - Compatibility with other security plugins
* Update - Check the frontend on paths update
* Update - Write the rules in Nginx and IIS files before relogin to be able to check the frontend before logout
* Update - Hide wp-login.php is now disable is the login path is unchanged
* Fix - rewrite rules in htaccess when other plugins are removing rge rewrites
* Fix - update the new api path on change

= 4.3.02 (21 Ian 2020) =
* Fixed - Compatibility with Contact Form Block plugin
* Fixed - Redirect compatibility with other plugins
* Update - Compatibility and Security for WordPress 5.3.2

= 4.3.01 (28 Dec 2019) =
* Update - Compatibility with Flatsome theme
* Update - Compatibility check and update with the most common plugins and themes
* Fix - Prevent from removing capabilities from admin on plugin deactivation
* Fix - Popup face fade fix on Backup restore

= 4.3.00 (4 Dec 2019) =
* Update - Compatibility and Security for WordPress 5.3
* Fix - Login path and process for themes like ClassiPress, WPML, OneSocial
* Fix - Compatibility with OpenLiteSpeed servers
* Fix - HideMyWP User Role will be added only on Dev Mode
* Fix - User Role witll be removed on plugin update in case is already created

= 4.2.12 =
* Update - Replace admin ajax path in JS cached files
* Update - Add Hide My WP Role to setup the plugin
* Fix - Fix the temporary extention names in Safe Mode
* Fix - Fix the Brute Force login with Woocommerce paths

= 4.2.09 =
* Update - Working with custom wordpress cookie names
* Update - Included the debug log feature
* Fix - Add the hmwp cookie in the config to work with custom cookies on hidden paths
* Fix - Compatibility with more plugin and themes
* Hide My WP Ghost is compatible with WP 5.2.3

= 4.2.07 =
* Update - Add X-Content-Type-Options and X-XSS-Protection
* Update - Remove X-Powered-By and Server Signature from header
* Update - Checked and Updated compatibility with other plugins
* Update - Remove the Notice bar
* Fix - Plugin Menu for WP Mmultisite while configure it from network

= 4.2.06 =
* Update - Change WP paths in cache file is compatible with more cache plugins
* Update - Security filter in config file
* Update - Fix initial settings for Safe and Ninja modes
* Update - Compatibility style with Autoptimizer
* Update - Compatibility with Godaddy Hosting
* Update - Added support for webp files
* Update - Updated the plugin menu and fields typo
* Fixed - wp-admin issue on Godaddy hostin plan
* Fixed - Cache issue with Autoptimizer plugin

= 4.2.05 =
* Update - added new paths into the restricted list to avoid rewrite errors
* Update - compatibility style with Wordfence
* Update - compatibility style with IP2Location Country Blocker
* Update - compatibility style with Autoptimizer
* Update - compatibility style with Squirrly SEO
* Update - compatibility style with Yoast SEO
* Update - add login URL check in Security Checking tool
* Update - add admin URL check in Security Checking tool

= 4.2.04 =
* Fixed - Plugin license check and notification
* Fixed - Compatibility with LoginPress and Woocommerce on login hook
* Update Checked and fixed compatibility with the most popular plugins

= 4.2.02 =
* Update - Remove footer comments for W3 Total Cache and WP Super Cache
* Update - Fixed small bugs

= 4.2.01 =
* Update - Don't show HMW update when new plugins and themes are added if the themes names and plugins names are not changed
* Update - Show 100% security status if all the security tasks are completed
* Update - Don't show the speedometer if the security check didn't run yet
* Update - Added Dashboard Security Widget
* Update - Show the security level and the list of tasks to fix the security issues
* Update - Added the option to check the security after the settings are saved
* Update - Added help link for each plugin section
* Update - Prevent other plugins to load the style in Hide My Wp Ghost

= 4.2.00 =
* Added cache replace path feature for CSS files
* Cache replace is compatible with Elementor, WP-Rocket, Autoptimize, W3 Total Cache, WP Super Cache
* Changed the Hide Paths for Logged Users into Hide Admin Toolbar to reduce confusion
* Updated compatibility with more plugins

= 4.1.07 =
* Added ajax rewrite option in Hide My WP > Permalinks
* Added compatibility with Squirrly SEO plugin
* Added compatibility with more themes/plugin
* Updated the security for some plugins

= 4.1.06 =
* Fixed dynamic load content
* Fixed compatibility with the last version of Autoptimize plugin
* Fixed compatibility with Squirrly SEO plugin

= 4.1.05 =
* Added compatibility with other themes/plugins
* Fixed src pattern to identify all local URLs from source code
* Fixed comments removal to avoind removing the IE comments
* Fixed API saving issue in WP 5.2

= 4.1.00 =
* Fixed the Hide My WP > Advanced > Fix Relative URLs
* Fixed the wp-content rules when manually changed by the user
* Fixed the change paths in ajax calls

= 4.0.24 =
* Fixed API saving issue in WP 5.1
* Hide the old admin-ajax.php if required

= 4.0.22 =
* Fixed Cache Enabler late loading
* Force the Ajax path to show without admin path in all plugins and themes
* Change the paths in the Yoast SEO Local kml file
* Change paths in sitemap.xml files

= 4.0.20 (18 Jan 2019) =
* Hide My WP plugin file structure verification
* Added security updates for 2019
* Hide My WP is compatible with WP 5.0.3

= 4.0.19 (23 Dec 2018) =
* Update - Add HMW_DYNAMIC_THEME_STYLE to load the theme CSS dynamically and remove the theme details
* Fix - Compatible with Hummingbird Page Speed Optimization
* Fix - Login process on custom theme logins when captcha is not loaded
* Fix - Fix compatibility issues with Avada themes
* Fix - Fix combine JS and CSS issues with WP-Rocket
* Fix - When defining the UPLOADS constant in wp-config.php

= 4.0.17 (04 Dec 2018) =
* Fix - Warning: call_user_func_array() expects parameter 1 to be a valid callback, function 'return false;'
* Fix - Woocommerce frontpage login
* Fix - Multiple subfolders install issue
* Fix - Replacing the paths in javascript and styles
* Fix - Optimizing the rewrite rules when going in safe mode

= 4.0.16 (30 Nov 2018) =
* Update - Added new invalid path names in the path list
* Fix - Woocommerce updating the rewrites list on Hide My WP save
* Fix - PHP information in Security Check

= 4.0.15 (28 Nov 2018) =
* Update - Added the constant HMW_RULES_IN_CONFIG to pass the static files to WP
* Fix - 404 error on WP-Rocket busting paths when not minified
* Fix - Short custom paths name which cause errors

= 4.0.14 (11 Nov 2018) =
* Update - Added the Text Mapping & URL Mapping option in Hide My WP menu
* Update - Added the CDN URL option in the Mapping Menu
* Fix - Compatibility with Wp-Rocket on 404 pages and excluded pages
* Fix - Login issue from frontend form when Woocommerce is activated
* Fix - Compatibility with more themes
* Fix - Wp Engine rewrite rules box to show on settings page

= 4.0.12 (02 Nov 2018) =
* Update - Rewrite option for Nginx, Apache and IIS without config
* Update - Added the Safe Mode option on rewrite errors
* Update - URL Mapping to work with paths
* Update - Text Mapping to change texts in source code
* Fix - URL Mapping to work on multisite

= 4.0.11 (22 Oct 2018) =
* Update - Increased security for not logged in users
* Update - Increased plugin speed and cache optimization
* Update - Compatibility with more themes and plugins
* Update - Hide more plugins from isitwp.com

= 4.0.10 (15 Oct 2018) =
* Fix - Compatibility with WP Fastest Cache
* Fix - Add decoded trail slash on plugin rewrites

= 4.0.09 (09 Oct 2018) =
* Fix - Memory check error when the memory is over 1G
* Fix - Htaccess error when the plugin has spaces in the name
* Update - Compatibility with Autoptimize 2.4
* Update - Compatible with Gutenberg 3.9

= 4.0.08 (21 Sept 2018) =
* Update - Compatible with Gutenberg 3.8
* Update - Compatible with WP Super Cache 1.6
* Update - Compatible with All In One WP Security & Firewall 4.3
* Update - Compatible with iThemes Security 7.1
* Update - Compatible with Beaver Builder 2.1
* Update - Compatible with Elementor Editor 2.2
* Update - Compatible with Thrive Architect 2
* Update - Compatible with Woocommerce 3.4
* Fix - Compatibility with WP-Rocket
* Fix - Rewrite paths when moving from Ghost mode to Default in Apache, Nginx and IIS
* Fix - Restore settings didn't save the config rewrites


= 4.0.07 (04 Sept 2018) =
* Update - Remove Admin Cookies from wp-config left by other plugins when Hide My WP is installed.
* Fix - Don't create the activate rewrite in case the URL isn't changed
* Fix - Compatibility with other plugins was checked
* Fix - Compatibility with WP-Lazy-Load

= 4.0.06 (24 Aug 2018) =
* Update - Added URL Mapping option
* Update - Change internal URL to new ones. Works for CSS, JS and Images
* Fix - Corrected the root path to config files
* Fix - Upgrade from Free version to Ghost

= 4.0.05 (17 Aug 2018) =
* Update - Compatible with Gutenberg plugin
* Update - Compatible with Wp Hide plugin
* Fixed - Corrected the hide paths in Apache, IIS and Nginx
* Fixed - NGINX change alerts to be more visible
* Fixed - Rules for install.php not to include plugin-install.php too

= 4.0.04 (16 Aug 2018) =
* Update - Added security filter when a logged user's IP address is changed
* Update - Added security alerts for failed login attempts
* Update - Added security alerts when a user has login attempts from different IP addresses
* Update - Added security alerts when a plugin is deleted
* Update - Added security alerts when a post is deleted
* Update - Remove inline style ids option
* Fixed - Log username when a plugin is deleted

= 4.0.03 (14 Aug 2018) =
* Fixed - Comments removal in source code
* Fixed - Corrected Typos on Security Check
* Update - Compatibility with more WordPress Themes

= 4.0.02 (10 Aug 2018) =
* Update - Compatibility with the last version of WP-Rocket
* Fixed - Prevent showing blank page on content removal
* Fixed - The ajax error on Security Check Fix button

= 4.0.01 (02 Aug 2018) =
* Update - New Settings design
* Update - Firewall Against Script Injection
* Update - Customize the Hide My Wp safe link
* Update - Log events for specified user roles
* Update - WordPress Security Alerts
* Update - Security Check and options to fix the issues
* Update - New Ghost Mode option to hide and protect the themes and plugins
* Update - Google Captcha for login page and Woocommerce login page
* Update - Install and Activate recommended plugins



Enjoy Hide My WP!
John
