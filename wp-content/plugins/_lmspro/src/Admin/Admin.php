<?php
/**
 * Class Admin
 *
 * @package  Tutor\Certificate\Builder
 * @author   Themeum <support@themeum.com>
 * @license  GPLv2 or later
 * @link     https://www.themeum.com/product/tutor-lms/
 * @since    1.0.0
 */

namespace Tutor\Certificate\Builder\Admin;

use \Tutor\Certificate\Builder\Admin\Certificate_List;
use \Tutor\Certificate\Builder\Helper;

/**
 * Class Admin
 *
 * @package Tutor\Certificate\Builder\Admin
 *
 * @since   1.0.0
 */
class Admin {

	/**
	 * Admin constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
	}

	/**
	 * Add plugin page in WordPress menu.
	 *
	 * @since 1.0.0
	 */
	public function add_admin_menu() {
		add_submenu_page(
			'tutor',
			__( 'Certificate Templates', 'tutor-lms-certificate-builder' ),
			__( 'Certificates Builder', 'tutor-lms-certificate-builder' ),
			'manage_tutor_instructor',
			'tutor-certificate-templates',
			[
				$this,
				'page_options',
			]
		);

		add_action('admin_init', array($this, 'tutor_delete_certificate_init'));
	}

	/**
	 * Plugin page callback.
	 *
	 * @since 1.0.0
	 */
	public function page_options() {
		include_once TUTOR_CB_PLUGIN_PATH . 'templates/admin/certificates.php';
	}


	/**
	 * Delete Certificate 
	 *
	 * @since 1.0.0
	 */
	public function tutor_delete_certificate_init() {

		if ( false === Helper::on_delete_certificate() ) {
			return;
		}

		$certificates = new Certificate_List();
		$certificates->delete_certificate();

		$wp_redirect_url = admin_url( 'admin.php?page=tutor-certificate-templates' );
		wp_redirect($wp_redirect_url, 302, true);
		exit();
	}
}
