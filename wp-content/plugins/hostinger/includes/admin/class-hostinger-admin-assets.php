<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Hostinger_Admin_Assets {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
	}

	public function admin_styles(): void {
		$helper = new Hostinger_Helper();
		wp_enqueue_style( 'hostinger_main_styles', HOSTINGER_ASSETS_URL . '/css/main.css', [], HOSTINGER_VERSION );

		if( $helper->is_preview_domain() && is_user_logged_in() ) {
			wp_enqueue_style( 'hostinger-preview-styles', HOSTINGER_ASSETS_URL . '/css/hts-preview.css', [], HOSTINGER_VERSION );
		}
	}

	public function admin_scripts(): void {
		wp_enqueue_script( 'hostinger_main_scripts', HOSTINGER_ASSETS_URL . '/js/main.js', array( 'jquery', 'wp-i18n' ), HOSTINGER_VERSION, false );
		
		wp_localize_script('hostinger_main_scripts', 'ajax_var', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('hts-ajax-nonce')
		));
	}
}

new Hostinger_Admin_Assets();
