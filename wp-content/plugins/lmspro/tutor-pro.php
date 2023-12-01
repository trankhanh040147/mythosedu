<?php
/*
Plugin Name: LMS Content
Description: Power up LMS plugins by LMS Content
Author: Be
Version: 2.0.3
Requires at least: 5.3
Tested up to: 5.9
Text Domain: lms-pro
Domain Path: /languages/
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

update_option( 'tutor_license_info', [ 'activated' => true, 'license_to' => $_SERVER['SERVER_NAME'] ] );

/**
 * Defined the tutor main file
 */
define( 'TUTOR_PRO_VERSION', '2.0.3' );
define( 'TUTOR_PRO_FILE', __FILE__ );

/**
 * Tutor Pro dependency on Tutor core
 *
 * Define Tutor core version on that Tutor Pro is dependent to run,
 * without require version pro will just show admin notice to install require core version.
 *
 * @since v2.0.0
 */
define( 'TUTOR_CORE_REQ_VERSION', '2.0.0' );
/**
 * Load tutor-pro text domain for translation
 */
add_action(
	'init',
	function () {
		load_plugin_textdomain( 'tutor-pro', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
);

if ( ! function_exists( 'tutor_pro' ) ) {
	function tutor_pro() {
		if(isset($GLOBALS['tutor_pro_plugin_info'])) {
			return $GLOBALS['tutor_pro_plugin_info'];
		}

		$path = plugin_dir_path( TUTOR_PRO_FILE );
		$info = array(
			'path'         => $path,
			'url'          => plugin_dir_url( TUTOR_PRO_FILE ),
			'icon_dir'     => plugin_dir_url( TUTOR_PRO_FILE ) . 'assets/images/',
			'basename'     => plugin_basename( TUTOR_PRO_FILE ),
			'version'      => TUTOR_PRO_VERSION,
			'nonce_action' => 'tutor_pro_nonce_action',
			'nonce'        => '_wpnonce',
		);

		$GLOBALS['tutor_pro_plugin_info'] = (object) $info;
		return $GLOBALS['tutor_pro_plugin_info'];
	}
}

require 'classes/init.php';

$tutorPro = new \TUTOR_PRO\init();
$tutorPro->run(); // Boom