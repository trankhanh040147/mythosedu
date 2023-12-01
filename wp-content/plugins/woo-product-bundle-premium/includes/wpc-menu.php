<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WPCleverMenu' ) ) {
	class WPCleverMenu {
		function __construct() {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}

		function admin_menu() {
			add_menu_page(
				'WPClever',
				'WPClever⚡',
				'manage_options',
				'wpclever',
				array( &$this, 'welcome_content' ),
				WPC_URI . 'assets/images/wpc-icon.png',
				26
			);
			add_submenu_page( 'wpclever', 'About', 'About', 'manage_options', 'wpclever' );
            remove_submenu_page('wpclever', 'wpclever');
		}

		function welcome_content() {
		}
	}

	new WPCleverMenu();
}
