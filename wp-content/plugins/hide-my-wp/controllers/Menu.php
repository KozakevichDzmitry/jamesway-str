<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class HMWP_Controllers_Menu extends HMWP_Classes_FrontController {

	public $alert = '';

	/**
	 * Hook the Admin load
	 * @throws Exception
	 */
	public function hookInit() {

		/* add the plugin menu in admin */
		if ( HMWP_Classes_Tools::userCan( 'hmwp_manage_settings' ) ) {

		    //Get the current page
			$page = HMWP_Classes_Tools::getValue( 'page' );

			//check if activated
			if ( get_transient( 'hmwp_activate' ) && strpos( $page, 'hmwp_settings' ) !== false ) {
				// Delete the redirect transient
				delete_transient( 'hmwp_activate' );

				//Check if there are expected upgrades
				HMWP_Classes_Tools::checkUpgrade();
			}

            //Make sure HideMyWP in the loading first
            HMWP_Classes_Tools::movePluginFirst();

			//Show Dashboard Box
			add_action( 'wp_dashboard_setup', array( $this, 'hookDashboardSetup' ) );

			if ( HMWP_Classes_Tools::getValue( 'page', false ) == 'hmwp_settings' ) {
				add_action( 'admin_enqueue_scripts', array( $this->model, 'fixEnqueueErrors' ), PHP_INT_MAX );
			}
		}

	}

	/**
	 * Creates the Setting menu in WordPress
	 * @throws Exception
	 */
	public function hookMenu() {
	    if(!is_multisite() ) {
            $this->model->addMenu( array(
                ucfirst( _HMWP_PLUGIN_NAME_ ),
                'Hide My WP' . $this->alert,
                'hmwp_manage_settings',
                'hmwp_settings',
                null,
                _HMWP_THEME_URL_ . 'img/logo_16.png'
            ) );

            /* add the Hide My WP admin menu */
            $this->model->addSubmenu( array(
                'hmwp_settings',
                __( 'Hide My WP Ghost - Customize Permalinks', _HMWP_PLUGIN_NAME_ ),
                __( 'Change Paths', _HMWP_PLUGIN_NAME_ ),
                'hmwp_manage_settings',
                'hmwp_settings',
                array(HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init')
            ) );

            $this->model->addSubmenu( array(
                'hmwp_settings',
                __( 'Hide My WP Ghost - Mapping', _HMWP_PLUGIN_NAME_ ),
                __( 'Mapping', _HMWP_PLUGIN_NAME_ ),
                'hmwp_manage_settings',
                'hmwp_settings-hmwp_mapping',
                array(HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init')
            ) );

            $this->model->addSubmenu( array(
                'hmwp_settings',
                __( 'Hide My WP Ghost - Tweaks', _HMWP_PLUGIN_NAME_ ),
                __( 'Tweaks', _HMWP_PLUGIN_NAME_ ),
                'hmwp_manage_settings',
                'hmwp_settings-hmwp_tweaks',
                array(HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init')
            ) );

            $this->model->addSubmenu( array(
                'hmwp_settings',
                __( 'Hide My WP Ghost - Brute Force Protection', _HMWP_PLUGIN_NAME_ ),
                __( 'Brute Force Protection', _HMWP_PLUGIN_NAME_ ),
                'hmwp_manage_settings',
                'hmwp_settings-hmwp_brute',
                array(HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init')
            ) );

            $this->model->addSubmenu( array(
                'hmwp_settings',
                __( 'Hide My WP Ghost - Log Events', _HMWP_PLUGIN_NAME_ ),
                __( 'Log Events', _HMWP_PLUGIN_NAME_ ),
                'hmwp_manage_settings',
                'hmwp_settings-hmwp_log',
                array(HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init')
            ) );

            /* add the security check in menu */
            $this->model->addSubmenu( array(
                'hmwp_settings',
                __( 'Hide My WP Ghost - Security Check', _HMWP_PLUGIN_NAME_ ),
                __( 'Security Check', _HMWP_PLUGIN_NAME_ ) . $this->alert,
                'hmwp_manage_settings',
                'hmwp_securitycheck',
                array(HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_SecurityCheck' ), 'show')
            ) );

            $this->model->addSubmenu( array(
                'hmwp_settings',
                __( 'Hide My WP Ghost - Recommended Plugins', _HMWP_PLUGIN_NAME_ ),
                __( 'Install Plugins', _HMWP_PLUGIN_NAME_ ),
                'hmwp_manage_settings',
                'hmwp_settings-hmwp_plugins',
                array(HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init')
            ) );

            $this->model->addSubmenu( array(
                'hmwp_settings',
                __( 'Hide My WP Ghost - Backup & Restore', _HMWP_PLUGIN_NAME_ ),
                __( 'Backup/Restore', _HMWP_PLUGIN_NAME_ ),
                'hmwp_manage_settings',
                'hmwp_settings-hmwp_backup',
                array(HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init')
            ) );

            $this->model->addSubmenu( array(
                'hmwp_settings',
                __( 'Hide My WP Ghost - Advanced Settings', _HMWP_PLUGIN_NAME_ ),
                __( 'Advanced Settings', _HMWP_PLUGIN_NAME_ ),
                'hmwp_manage_settings',
                'hmwp_settings-hmwp_advanced',
                array(HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init')
            ) );
        }
	}

	/**
	 * Load the dashboard widget
	 * @throws Exception
	 */
	public function hookDashboardSetup() {
		wp_add_dashboard_widget(
			'hmw_dashboard_widget',
			__( 'Hide My WP', _HMWP_PLUGIN_NAME_ ),
			array( HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Widget' ), 'dashboard' )
		);

		// Move our widget to top.
		global $wp_meta_boxes;

		$dashboard                                    = $wp_meta_boxes['dashboard']['normal']['core'];
		$ours                                         = array( 'hmw_dashboard_widget' => $dashboard['hmw_dashboard_widget'] );
		$wp_meta_boxes['dashboard']['normal']['core'] = array_merge( $ours, $dashboard );
	}


	/**
	 * Creates the Setting menu in Multisite WordPress
	 * @throws Exception
	 */
	public function hookMultisiteMenu() {

		$this->model->addMenu( array(
			ucfirst( _HMWP_PLUGIN_NAME_ ),
			'Hide My WP' . $this->alert,
			'hmwp_manage_settings',
			'hmwp_settings',
			null,
			_HMWP_THEME_URL_ . 'img/logo_16.png'
		) );

		/* add the Hide My WP admin menu */
		$this->model->addSubmenu( array(
			'hmwp_settings',
			__( 'Hide My WP Ghost - Customize Permalinks', _HMWP_PLUGIN_NAME_ ),
			__( 'Change Paths', _HMWP_PLUGIN_NAME_ ),
			'hmwp_manage_settings',
			'hmwp_settings',
			array( HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init' )
		) );

		$this->model->addSubmenu( array(
			'hmwp_settings',
			__( 'Hide My WP Ghost - Mapping', _HMWP_PLUGIN_NAME_ ),
			__( 'Mapping', _HMWP_PLUGIN_NAME_ ),
			'hmwp_manage_settings',
			'hmwp_settings-hmwp_mapping',
			array( HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init' )
		) );

		$this->model->addSubmenu( array(
			'hmwp_settings',
			__( 'Hide My WP Ghost - Tweaks', _HMWP_PLUGIN_NAME_ ),
			__( 'Tweaks', _HMWP_PLUGIN_NAME_ ),
			'hmwp_manage_settings',
			'hmwp_settings-hmwp_tweaks',
			array( HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init' )
		) );

		$this->model->addSubmenu( array(
			'hmwp_settings',
			__( 'Hide My WP Ghost - Brute Force Protection', _HMWP_PLUGIN_NAME_ ),
			__( 'Brute Force Protection', _HMWP_PLUGIN_NAME_ ),
			'hmwp_manage_settings',
			'hmwp_settings-hmwp_brute',
			array( HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init' )
		) );

		$this->model->addSubmenu( array(
			'hmwp_settings',
			__( 'Hide My WP Ghost - Log Events', _HMWP_PLUGIN_NAME_ ),
			__( 'Log Events', _HMWP_PLUGIN_NAME_ ),
			'hmwp_manage_settings',
			'hmwp_settings-hmwp_log',
			array( HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init' )
		) );


		/* add the security check in menu */
		$this->model->addSubmenu( array(
			'hmwp_settings',
			__( 'Hide My WP Ghost - Security Check', _HMWP_PLUGIN_NAME_ ),
			__( 'Security Check', _HMWP_PLUGIN_NAME_ ) . $this->alert,
			'hmwp_manage_settings',
			'hmwp_securitycheck',
			array( HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_SecurityCheck' ), 'show' )
		) );


		$this->model->addSubmenu( array(
			'hmwp_settings',
			__( 'Hide My WP Ghost - Recommended Plugins', _HMWP_PLUGIN_NAME_ ),
			__( 'Install Plugins', _HMWP_PLUGIN_NAME_ ),
			'hmwp_manage_settings',
			'hmwp_settings-hmwp_plugins',
			array( HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init' )
		) );

		$this->model->addSubmenu( array(
			'hmwp_settings',
			__( 'Hide My WP Ghost - Backup & Restore', _HMWP_PLUGIN_NAME_ ),
			__( 'Backup/Restore', _HMWP_PLUGIN_NAME_ ),
			'hmwp_manage_settings',
			'hmwp_settings-hmwp_backup',
			array( HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init' )
		) );

		$this->model->addSubmenu( array(
			'hmwp_settings',
			__( 'Hide My WP Ghost - Advanced Settings', _HMWP_PLUGIN_NAME_ ),
			__( 'Advanced Settings', _HMWP_PLUGIN_NAME_ ),
			'hmwp_manage_settings',
			'hmwp_settings-hmwp_advanced',
			array( HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init' )
		) );


	}
}