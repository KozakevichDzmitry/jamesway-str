<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class HMWP_Controllers_Log extends HMWP_Classes_FrontController {

	public function __construct() {
		parent::__construct();
		//Hook the login process
		add_filter( 'authenticate', array( $this, 'hmwp_authenticate' ), 99, 1 );
		apply_filters( 'woocommerce_process_login_errors', array( $this, 'hmwp_authenticate' ), 99, 1 );

		//Hook all actions
		add_action( 'wp_loaded', array( $this, 'hmwp_log' ), 9 );
	}

	/**
	 * Admin actions
	 */
	public function action() {
		parent::action();

		switch ( HMWP_Classes_Tools::getValue( 'action' ) ) {
			case 'hmwp_logsettings':
				HMWP_Classes_Tools::saveOptions( 'hmwp_bruteforce_log', HMWP_Classes_Tools::getValue( 'hmwp_bruteforce_log', 0 ) );
				HMWP_Classes_Tools::saveOptions( 'hmwp_activity_log', HMWP_Classes_Tools::getValue( 'hmwp_activity_log', 0 ) );
				HMWP_Classes_Tools::saveOptions( 'hmwp_activity_log_roles', HMWP_Classes_Tools::getValue( 'hmwp_activity_log_roles', array() ) );

				break;
		}
	}

	/**
	 * Function called on login process
	 *
	 * @param null $user
	 *
	 * @return null
	 */
	public function hmwp_authenticate( $user = null ) {
		if ( empty( $_POST ) ) {
			return $user;
		}

		//set default action name
		$action = 'login';

		if ( is_wp_error( $user ) ) {
			if ( method_exists( $user, 'get_error_codes' ) ) {
				$codes = $user->get_error_codes();
				if ( ! empty( $codes ) ) {
					foreach ( $codes as $action ) {
						//Log the authenticate process
						$this->model->hmwp_log_actions( $action );//log the login process
					}
				}
			}

			return $user;
		}

		//Log the success authenticate process
		$this->model->hmwp_log_actions( $action );//log the login process

		return $user;
	}

	/**
	 * Function called on user events
	 */
	public function hmwp_log() {
		try {
			//Log user activity
			if ( HMWP_Classes_Tools::getValue( 'action', false ) ) {
				if ( empty( $_POST ) && empty( $_GET ) ) {
					return;
				}

				$current_user = wp_get_current_user();
				if ( isset( $current_user->user_login ) ) {
					//If there is use role restriction
					$user_roles   = ( array ) $current_user->roles;
					$option_roles = HMWP_Classes_Tools::getOption( 'hmwp_activity_log_roles' );

					if ( ! empty( $option_roles ) && ! empty( $user_roles ) ) {
						foreach ( $user_roles as $role ) {
							if ( ! in_array( $role, $option_roles ) ) {
								return;
							}
						}
					}
					$values = array(
						'username' => $current_user->user_login,
						'role'     => ( ! empty( $user_roles ) ? $user_roles[0] : '' ),
					);

					$this->model->hmwp_log_actions( HMWP_Classes_Tools::getValue( 'action' ), $values );
				}
			}
		} catch ( Exception $e ) {
		}

	}

}