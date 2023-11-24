<?php
/**
 * Plugin main class
 *
 * @package  Tutor\Certificate\Builder
 * @author   Themeum <support@themeum.com>
 * @license  GPLv2 or later
 * @link     https://www.themeum.com/product/tutor-lms/
 * @since    1.0.0
 */

namespace Tutor\Certificate\Builder;

use \Tutor\Certificate\Builder\Admin\Admin;

/**
 * Class Plugin
 *
 * @package Tutor\Certificate\Builder
 *
 * @since   1.0.0
 */
class Plugin {

	/**
	 * Plugin slug
	 *
	 * @since 1.0.0
	 */
	const SLUG = 'tutor-certificate-builder';

	/**
	 * Plugin editor action
	 *
	 * @since 1.0.0
	 */
	const EDITOR_ACTION = 'tutor_certificate_builder';

	/**
	 * Plugin post delete action
	 *
	 * @since 1.0.0
	 */
	const DELETE_ACTION = 'tutor_certificate_builder_delete';

	/**
	 * Certificate post type
	 *
	 * @since 1.0.0
	 */
	const CERTIFICATE_POST_TYPE = 'tutor_certificate';

	/**
	 * Certificate post type
	 *
	 * @since 1.0.0
	 */
	const CERTIFICATE_TEMPLATE_DIR = 'tutor-certificate-builder';
	

	/**
	 * Certificate preview meta key
	 *
	 * @since 1.0.0
	 */
	const CERTIFICATE_PREVIEW_META_KEY = 'tutor_cb_template_preview_name';
	
	/**
	 * Plugin constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		add_filter('posts_where', array($this, 'restrict_media' ) );
	}

	/**
	 * Load textdomain
	 *
	 * @since 1.0.0
	 */
	public function i18n() {
		load_plugin_textdomain( self::SLUG );
	}

	/**
	 * Run plugin
	 *
	 * @since 1.0.0
	 */
	public function run() {

		new Core();
		new Editor();

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			new Ajax();
		}

		if ( is_admin() ) {
			new Admin();
		}
		
		require_once( dirname( __DIR__ ). '/updater/update.php');
		new \TutorCB\ThemeumUpdater\Update(array(
			'product_title' => 'Tutor Certificate Builder',
			'product_slug' => 'tutor-lms-certificate-builder',
			'product_basename' => TUTOR_CB_BASENAME,
			'product_type' => 'plugin',
			'current_version' => TUTOR_CB_VERSION,
			'is_product_free' => true,

			'menu_title' => 'Tutor CB License',
			'parent_menu' => 'tutor',
			'menu_capability' => 'manage_tutor',
			'license_option_key' => 'tutor_cb_license_info',

			'updater_url' => TUTOR_CB_PLUGIN_URL . 'updater/',
			'header_content' => ''
		));
	}

	/**
	 * Media Query Filter on query-attachments action
	 * 
	 * @since 1.0.0
	 */
	function restrict_media( $where ){
        
        if( isset( $_POST['action'] ) && $_POST['action'] == 'query-attachments' && tutor_utils()->is_instructor()){
            if(!tutor_utils()->has_user_role(array('administrator', 'editor'))) {
                $where .= ' AND post_author=' . get_current_user_id();
            }
        }
    
        return $where;
    }
}
