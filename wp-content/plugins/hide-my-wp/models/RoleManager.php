<?php

class HMWP_Models_RoleManager {

	public $roles;

	public function __construct() {
		add_action( 'admin_init', array( $this, 'addHMWPRoles' ), PHP_INT_MAX );
	}

	/**
	 * Get all the  Caps
	 *
	 * @param $role
	 *
	 * @return array
	 */
	public function getHMWPCaps( $role = '' ) {
		$caps = array();

		$caps['hmwp_admin'] = array(
			'hmwp_manage_settings' => true,
		);

		$caps = array_filter( $caps );

		if ( isset( $caps[ $role ] ) ) {
			return $caps[ $role ];
		}

		return $caps;
	}

	/**
	 * Register Hide My WP Roles and Caps
	 * in case they don't exists
	 */
	public function addHMWPRoles() {
		/** @var $wp_roles WP_Roles */
		global $wp_roles;

		//$this->removeHMWPCaps();
		if ( function_exists( 'wp_roles' ) ) {
			$allroles = wp_roles()->get_names();
			if ( ! empty( $allroles ) ) {
				$allroles = array_keys( $allroles );
			}

			if ( ! empty( $allroles ) ) {
				foreach ( $allroles as $role ) {
					if ( $role == 'administrator' || $role == 'hmwp_admin' ) {
						$this->updateHMWPCap( 'hmwp_admin', $role );
						continue;
					}
				}
			}

			if ( ! $wp_roles || ! isset( $wp_roles->roles ) || ! method_exists( $wp_roles, 'is_role' ) ) {
				return;
			}

			if ( HMWP_Classes_Tools::getOption( 'hmwp_userroles' ) ) {
				if ( ! $wp_roles->is_role( 'hmwp_admin' ) ) {
					//get all Hide My WP  roles and caps
					$this->addHMWPRole( 'hmwp_admin', __( 'HideMyWP Setup', _HMWP_PLUGIN_NAME_ ), 'editor' );

				}
			}

		}
	}

	/**
	 * Remove Hide My WP Roles and Caps
	 */
	public function removeHMWPRoles() {
		global $wp_roles;

		//get all Hide My WP roles and caps
		$hmwpcaps = $this->getHMWPCaps();

		if ( ! empty( $hmwpcaps ) ) {
			foreach ( array_keys( $hmwpcaps ) as $role ) {
				if ( $wp_roles->is_role( $role ) ) {
					$this->removeRole( $role );
				}

			}
		}

	}

	public function removeHMWPCaps() {
		if ( function_exists( 'wp_roles' ) ) {
			$allroles = wp_roles()->get_names();
			$caps     = $this->getHMWPCaps( 'hmwp_admin' );

			if ( ! empty( $allroles ) ) {
				$allroles = array_keys( $allroles );
			}

			if ( ! empty( $allroles ) && ! empty( $caps ) ) {
				foreach ( $allroles as $role ) {
					$this->removeCap( $role, $caps );
				}
			}
		}

	}

	/**
	 * Add Hide My WP Role and Caps
	 *
	 * @param $hmwprole
	 * @param $title
	 * @param $wprole
	 */
	public function addHMWPRole( $hmwprole, $title, $wprole ) {
		$wpcaps   = $this->getWpCaps( $wprole );
		$hmwpcaps = $this->getHMWPCaps( $hmwprole );

		$this->addRole( $hmwprole, $title, array_merge( $wpcaps, $hmwpcaps ) );
	}

	/**
	 * Update the Hide My WP Caps into WP Roles
	 *
	 * @param $hmwprole
	 * @param $wprole
	 */
	public function updateHMWPCap( $hmwprole, $wprole ) {
		$hmwpcaps = $this->getHMWPCaps( $hmwprole );

		$this->addCap( $wprole, $hmwpcaps );
	}

	/**
	 * Add a role into WP
	 *
	 * @param $name
	 * @param $title
	 * @param $capabilities
	 */
	public function addRole( $name, $title, $capabilities ) {
		add_role( $name, $title, $capabilities );
	}

	/**
	 * Add a cap into WP for a role
	 *
	 * @param $name
	 * @param $capabilities
	 */
	public function addCap( $name, $capabilities ) {
		$role = get_role( $name );

		if ( ! $role || ! method_exists( $role, 'add_cap' ) ) {
			return;
		}

		foreach ( $capabilities as $capability => $grant ) {
			if ( ! $role->has_cap( $capability ) ) {
				$role->add_cap( $capability, $grant );
			}
		}
	}

	/**
	 * Remove the caps for a role
	 *
	 * @param $name
	 * @param $capabilities
	 */
	public function removeCap( $name, $capabilities ) {
		$role = get_role( $name );

		if ( ! $role || ! method_exists( $role, 'remove_cap' ) ) {
			return;
		}

		if ( $role ) {
			foreach ( $capabilities as $capability => $grant ) {
				if ( $role->has_cap( $capability ) ) {
					$role->remove_cap( $capability );
				}
			}
		}
	}

	/**
	 * Remove the role
	 *
	 * @param $name
	 */
	public function removeRole( $name ) {
		remove_role( $name );
	}

	public function getWpCaps( $role ) {

		if ( $wprole = get_role( $role ) ) {
			return $wprole->capabilities;
		}

		return array();
	}

}