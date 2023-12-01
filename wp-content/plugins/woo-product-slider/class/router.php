<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product Slider for WooCommerce - route class
 *
 * @since 2.0
 */
class SP_WPS_Router {

	/**
	 * @var SP_WPS_Router single instance of the class
	 *
	 * @since 2.0
	 */
	protected static $_instance = null;


	/**
	 * Main SP_WPS_Router Instance
	 *
	 * @since 2.0
	 * @static
	 * @return self Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new SP_WPS_Router();
		}

		return self::$_instance;
	}

	/**
	 * Include the required files
	 *
	 * @since 1.0
	 * @return void
	 */
	function includes() {
		include_once SP_WPS_PATH . 'includes/free/loader.php';
	}

	/**
	 * SPPC function
	 *
	 * @since 1.0
	 * @return void
	 */
	function sp_wps_function() {
		include_once SP_WPS_PATH . 'includes/functions.php';
	}

}
