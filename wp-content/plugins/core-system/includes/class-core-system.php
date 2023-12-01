<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Core_System
 * @subpackage Core_System/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Core_System
 * @subpackage Core_System/includes
 * @author     Richard <nguyenkha252@gmail.com>
 */

namespace CoreSystem;

use CoreSystem\Front\Core_System_Front;
use CoreSystem\Admin\Core_System_Admin;
use CoreSystem\Core_System_Loader AS Core_System_Loader;
use CoreSystem\Core_System_i18n AS Core_System_i18n;
use CoreSystem\Includes\Cores_AJAX;

class Core_System {

    static $instance = null;

    public $ajax = null;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Core_System_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CORE_SYSTEM_VERSION' ) ) {
			$this->version = CORE_SYSTEM_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'core-system';

		$this->init();
		//$this->switch_blog();
		$this->load_dependencies();
		$this->set_locale();
		if( is_admin() ) {
            $this->define_admin_hooks();
        }
		$this->define_public_hooks();

	}
    function access_denied(){
        if( is_multisite() && !current_user_can( 'manage_network_users' ) && !is_main_site() && !wp_doing_ajax() ) {
            $message = "<div style='margin-bottom:20px;'>" . __('Không tìm thấy', CORES_LANG_DOMAIN) . "</div>";
            _default_wp_die_handler($message);
        }
    }

    function after_switch_blog($new_blog, $prev_blog_id) {
        global $wpdb;
        if ( isset($_REQUEST['action']) && 'add-site' == $_REQUEST['action'] ) {
        } else {
            if( $new_blog < 2 ) {
                $prefix = $wpdb->base_prefix;
            } else {
                $prefix = $wpdb->get_blog_prefix($new_blog);
            }
            $wpdb->users = "{$prefix}users";
            $wpdb->usermeta = "{$prefix}usermeta";

        }
    }

	function switch_blog(){
	    global $wp_version;

        if( version_compare($wp_version, '5.0.0', '>=') ){
            if ( ( !is_main_site() && !is_admin() ) || wp_doing_ajax() ) {
                global $wpdb;
                $prefix = $wpdb->get_blog_prefix(get_current_blog_id());
                $wpdb->users = "{$prefix}users";
                $wpdb->usermeta = "{$prefix}usermeta";
            }
        }
        add_action('switch_blog', function($new_blog, $prev_blog_id = 0) {
            if( ( !is_main_site() && !is_admin() ) || wp_doing_ajax() ) {
                $this->after_switch_blog($new_blog, $prev_blog_id);
            }
        }, 100, 2);
    }

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

	function init(){
        $this->register_autoloader();
        Autoloader::run();
        $this->ajax = new Cores_AJAX();
        \CoreSystem\Includes\Module::instance();
    }

    private function register_autoloader() {
        require_once CORES_DIR . '/helpers/helpers.php';

        require_once CORES_DIR . '/includes/class-autoloader.php';

        require_once CORES_DIR . '/includes/class-module.php';

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once CORES_DIR . '/includes/class-core-system-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once CORES_DIR . '/includes/class-core-system-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once CORES_DIR . '/admin/class-core-system-admin.php';


        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once CORES_DIR . '/front/class-core-system-front.php';

    }

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Core_System_Loader. Orchestrates the hooks of the plugin.
	 * - Core_System_i18n. Defines internationalization functionality.
	 * - Core_System_Admin. Defines all hooks for the admin area.
	 * - Core_System_Front. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$this->loader = new Core_System_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Core_System_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Core_System_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

        require_once CORES_DIR . '/admin/sites/new-site.php';

		$plugin_admin = new Core_System_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_filter('upload_mimes', $plugin_admin, 'upload_mimes', 100, 2);

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Core_System_Front( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Core_System_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
