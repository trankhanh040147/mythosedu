<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access

/**
 * Scripts and styles
 */
class SP_WPS_Admin_Scripts {

	/**
	 * @var null
	 * @since 2.0
	 */
	protected static $_instance = null;

	/**
	 * @return null|SP_WPS_Admin_Scripts
	 * @since 2.0
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Initialize the class
	 */
	public function __construct() {

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Enqueue all styles for the meta boxes
	 */
	public function admin_scripts() {
		if ( 'sp_wps_shortcodes' === get_current_screen()->id ) {
			// CSS Files.
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'sp-wps-admin-meta-style', SP_WPS_URL . 'admin/assets/css/admin-meta.min.css', array(), SP_WPS_VERSION );
			wp_enqueue_style( 'sp-wps-google-font', 'https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800' );

			// JS Files.
			wp_enqueue_script( 'sp-wps-admin-meta-js', SP_WPS_URL . 'admin/assets/js/admin-meta.min.js', array( 'jquery', 'wp-color-picker' ), SP_WPS_VERSION, true );

		}

		wp_enqueue_style( 'sp-wps-admin-style', SP_WPS_URL . 'admin/assets/css/admin.min.css', array(), SP_WPS_VERSION );
		wp_enqueue_style( 'sp-wps-font-awesome', SP_WPS_URL . 'public/assets/css/font-awesome.min.css', array(), SP_WPS_VERSION );

		wp_enqueue_script( 'jquery-masonry', array( 'jquery' ), SP_WPS_VERSION, false );
		wp_enqueue_script( 'sp-wps-admin', SP_WPS_URL . 'admin/assets/js/admin.min.js', array( 'jquery' ), SP_WPS_VERSION, false );
	}

}

new SP_WPS_Admin_Scripts();
