<?php

/**
 * Class Editor
 *
 * @package  Tutor\Certificate\Builder
 * @author   Themeum <support@themeum.com>
 * @license  GPLv2 or later
 * @link     https://www.themeum.com/product/tutor-lms/
 * @since    1.0.0
 */

namespace Tutor\Certificate\Builder;

use \Tutor\Certificate\Builder\Plugin;

/**
 * Class Editor
 *
 * @package Tutor\Certificate\Builder\Admin
 *
 * @since   1.0.0
 */
class Editor
{

	/**
	 * Editor post id.
	 * 
	 * @since 1.0.0
	 */
	private $_post_id;

	/**
	 * Editor constructor.
	 * 
	 * @since 1.0.0
	 */
	public function __construct()
	{
		add_action('init', [$this, 'init_builder']);
	}

	/**
	 * Enqueue script for admin panel.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts()
	{
		// if (false === Helper::is_open_editor()) {
		// 	return;
		// }

		$post 		= array(
			"ID" =>  0,
			"post_title" =>  "",
			"post_status" => "draft",
		);

		$post_id 		= absint($_REQUEST['post']);
		$post_data 		= get_post($post_id, ARRAY_A);
		if ($post_data) {
			$post["ID"] 			= isset($post_data["ID"]) ? $post_data["ID"] : 0;
			$post["post_title"] 	= isset($post_data["post_title"]) ? $post_data["post_title"] : "";
			$post["post_status"] 	= isset($post_data["post_status"]) ? $post_data["post_status"] : "draft";
		}

		wp_enqueue_media();

		wp_enqueue_script(
			'tutor-lms-certificate-builder-editor-script',
			TUTOR_CB_PLUGIN_URL . 'assets/editor/dist/main.min.js',
			array(
				'wp-i18n',
				'wp-auth-check',
			),
			TUTOR_CB_VERSION,
			true
		);


		wp_enqueue_style(
			'wp-admin-common-css',
			admin_url() . 'css/common.css',
			false,
			TUTOR_CB_VERSION
		);
		
		// Localize the script with data.
		wp_localize_script(
			'tutor-lms-certificate-builder-editor-script',
			'tutor_object_cb',
			[
				'ajaxUrl'  => admin_url('admin-ajax.php'),
				'siteUrl'  => site_url(),
				'userId'  => get_current_user_id(),
				'nonce'  => wp_create_nonce('tutor-lms-certificate-builder'),
				'assetUrl' => TUTOR_CB_PLUGIN_URL . 'assets',
				'homeUrl' => get_home_url(),
				'tutor_certificate' => $post,
			]
		);

		do_action('tutor_certificate_builder_enqueue_script');
	}

	/**
	 * Register styles for front.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles()
	{
		if (false === Helper::is_open_editor()) {
			return;
		}

		wp_enqueue_style(
			'tutor-lms-certificate-builder-editor-styles',
			TUTOR_CB_PLUGIN_URL . 'assets/editor/dist/main.min.css',
			array(
				'wp-auth-check',
			),
			TUTOR_CB_VERSION
		);

		do_action('tutor_certificate_builder_enqueue_style');
	}

	/**
	 * Initialize builder editor.
	 *
	 * @since 1.0.0
	 */
	public function init_builder()
	{
		if (false === Helper::is_open_editor()) {
			return;
		}

		if (!Helper::has_editor_access()) {
			wp_die(__('Sorry, you are not allowed to access this page.'), 403);
		}

		$post_id = absint($_REQUEST['post']);

		if (0 === $post_id) {
			$post_id = wp_insert_post([
				'post_title' => __('Untitled Template', 'tutor-lms-certificate-builder'),
				'post_type'  => Plugin::CERTIFICATE_POST_TYPE,
				'post_status' => 'draft',
			]);

			$new_url = add_query_arg([
				'post' => $post_id,
			]);

			wp_redirect($new_url);
			die();
		} else {
			$get_post = get_post($post_id);
			if ('auto-draft' === $get_post->post_status) {
				wp_update_post([
					'ID' => $post_id,
					'post_status' => 'draft',
				]);
			}
		}

		$this->_post_id = $post_id;

		// Send MIME Type header like WP admin-header.
		@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));

		query_posts([
			'p'         => $this->_post_id,
			'post_type' => get_post_type($this->_post_id)
		]);

		Helper::setup_post_data($this->_post_id);

		// Remove all WordPress actions
		remove_all_actions('wp_head');
		remove_all_actions('wp_print_styles');
		remove_all_actions('wp_print_head_scripts');
		remove_all_actions('wp_footer');

		// Handle `wp_head`
		add_action('wp_head', 'wp_enqueue_scripts', 1);
		add_action('wp_head', 'wp_print_styles', 8);
		add_action('wp_head', 'wp_print_head_scripts', 9);
		add_action('wp_head', 'wp_site_icon');

		// Handle `wp_footer`
		add_action('wp_footer', 'wp_print_footer_scripts', 20);
		add_action('wp_footer', 'wp_auth_check_html', 30);

		// Handle `wp_enqueue_scripts`
		remove_all_actions('wp_enqueue_scripts');

		// Also remove all scripts hooked into after_wp_tiny_mce.
		remove_all_actions('after_wp_tiny_mce');

		add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts'], 999999);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_styles'], 999999);

		do_action('tutor_certificate_builder_init');

		// Print the panel
		include_once TUTOR_CB_PLUGIN_PATH . 'templates/editor.php';
		die;
	}
}
