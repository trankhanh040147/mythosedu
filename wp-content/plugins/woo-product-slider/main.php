<?php
/**
 * Plugin Name:     Product Slider for WooCommerce
 * Plugin URI:      https://shapedplugin.com/plugin/woocommerce-product-slider-pro
 * Description:     Slide your WooCommerce Products in a tidy and professional slider or carousel with an easy-to-use and intuitive Shortcode Generator. Highly customizable and No coding required!
 * Version:         2.1.16
 * Author:          ShapedPlugin
 * Author URI:      http://shapedplugin.com/
 * License:         GPLv3
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * WC requires at least: 2.6.0
 * WC tested up to: 3.8.0
 * Text Domain:     woo-product-slider
 * Domain Path:     /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Handles core plugin hooks and action setup.
 *
 * @package woo-product-slider
 * @since 2.0
 */
if ( ! class_exists( 'SP_WooCommerce_Product_Slider' ) ) {
	class SP_WooCommerce_Product_Slider {
		/**
		 * Plugin version
		 *
		 * @var string
		 */
		public $version = '2.1.16';

		/**
		 * @var SP_WPS_MetaBox $metabox
		 */
		public $metabox;

		/**
		 * @var SP_WPS_ShortCodes $shortcode
		 */
		public $shortcode;

		/**
		 * @var SP_WPS_Router $router
		 */
		public $router;

		/**
		 * @var null
		 * @since 2.0
		 */
		protected static $_instance = null;

		/**
		 * @return SP_WooCommerce_Product_Slider
		 * @since 2.0
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new SP_WooCommerce_Product_Slider();
			}

			return self::$_instance;
		}

		/**
		 * SP_WooCommerce_Product_Slider constructor.
		 */
		function __construct() {
			// Define constants.
			$this->define_constants();

			// Required class file include.
			spl_autoload_register( array( $this, 'autoload' ) );

			// Include required files.
			$this->includes();

			// instantiate classes.
			$this->instantiate();

			// Initialize the filter hooks.
			$this->init_filters();

			// Initialize the action hooks.
			$this->init_actions();
		}

		/**
		 * Initialize WordPress filter hooks
		 *
		 * @return void
		 */
		function init_filters() {
			add_filter( 'plugin_action_links', array( $this, 'add_plugin_action_links' ), 10, 2 );
			add_filter( 'manage_sp_wps_shortcodes_posts_columns', array( $this, 'add_shortcode_column' ) );
			add_filter( 'plugin_row_meta', array( $this, 'after_woo_product_slider_row_meta' ), 10, 4 );
		}

		/**
		 * Initialize WordPress action hooks
		 *
		 * @return void
		 */
		function init_actions() {
			add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );
			add_action( 'manage_sp_wps_shortcodes_posts_custom_column', array( $this, 'add_shortcode_form' ), 10, 2 );
			add_action( 'activated_plugin', array( $this, 'redirect_help_page' ) );
			if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				add_action( 'admin_notices', array( $this, 'error_admin_notice' ) );
			}
			// wqv plugin is not installed notice.
			if ( empty( get_option( 'sp-wqv-notice-dismissed' ) ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice' ) );
			}
			add_action( 'wp_ajax_dismiss_wqv_notice', array( $this, 'dismiss_wqv_notice' ) );
		}

		/**
		 * Define constants
		 *
		 * @since 2.0
		 */
		public function define_constants() {
			$this->define( 'SP_WPS_NAME', 'woo-product-slider' );
			$this->define( 'SP_WPS_VERSION', $this->version );
			$this->define( 'SP_WPS_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'SP_WPS_URL', plugin_dir_url( __FILE__ ) );
			$this->define( 'SP_WPS_BASENAME', plugin_basename( __FILE__ ) );
		}

		/**
		 * Define constant if not already set
		 *
		 * @since 2.0
		 *
		 * @param  string      $name
		 * @param  string|bool $value
		 */
		public function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Load TextDomain for plugin.
		 *
		 * @since 2.0
		 */
		public function load_text_domain() {
			load_textdomain( 'woo-product-slider', WP_LANG_DIR . '/woo-product-slider/languages/woo-product-slider-' . apply_filters( 'plugin_locale', get_locale(), 'woo-product-slider' ) . '.mo' );
			load_plugin_textdomain( 'woo-product-slider', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Add plugin action menu
		 *
		 * @param array  $links
		 * @param string $file
		 *
		 * @return array
		 */
		public function add_plugin_action_links( $links, $file ) {

			if ( $file == SP_WPS_BASENAME ) {
				$new_links = sprintf( '<a href="%s">%s</a>', admin_url( 'post-new.php?post_type=sp_wps_shortcodes' ), __( 'Create Slider', 'woo-product-slider' ) );

				array_unshift( $links, $new_links );

				$links['go_pro'] = sprintf( '<a target="_blank" href="%1$s" style="color: #35b747; font-weight: 700;">Go Premium!</a>', 'https://shapedplugin.com/plugin/woocommerce-product-slider-pro' );
			}

			return $links;
		}

		/**
		 * Add plugin row meta link
		 *
		 * @since 2.0
		 *
		 * @param $plugin_meta
		 * @param $file
		 *
		 * @return array
		 */

		function after_woo_product_slider_row_meta( $plugin_meta, $file ) {
			if ( $file == SP_WPS_BASENAME ) {
				$plugin_meta[] = '<a href="https://shapedplugin.com/demo/woocommerce-product-slider-pro/" target="_blank">' . __( 'Live Demo', 'woo-product-slider' ) . '</a>';
			}

			return $plugin_meta;
		}

		/**
		 * Autoload class files on demand
		 *
		 * @param string $class requested class name
		 */
		function autoload( $class ) {
			$name = explode( '_', $class );
			if ( isset( $name[2] ) ) {
				$class_name = strtolower( $name[2] );
				$filename   = SP_WPS_PATH . '/class/' . $class_name . '.php';

				if ( file_exists( $filename ) ) {
					require_once $filename;
				}
			}
		}

		/**
		 * Instantiate all the required classes
		 *
		 * @since 2.0
		 */
		function instantiate() {

			$this->metabox   = SP_WPS_MetaBox::getInstance();
			$this->shortcode = SP_WPS_ShortCodes::getInstance();

			do_action( 'sp_wps_instantiate', $this );
		}

		/**
		 * page router instantiate
		 *
		 * @since 2.0
		 */
		function page() {
			$this->router = SP_WPS_Router::instance();

			return $this->router;
		}

		/**
		 * Include the required files
		 *
		 * @return void
		 */
		function includes() {
			$this->page()->sp_wps_function();
			$this->router->includes();
		}

		/**
		 * ShortCode Column
		 *
		 * @param $columns
		 *
		 * @return array
		 */
		function add_shortcode_column() {
			$new_columns['cb']        = '<input type="checkbox" />';
			$new_columns['title']     = __( 'Slider Title', 'woo-product-slider' );
			$new_columns['shortcode'] = __( 'Shortcode', 'woo-product-slider' );
			$new_columns['']          = '';
			$new_columns['date']      = __( 'Date', 'woo-product-slider' );

			return $new_columns;
		}

		/**
		 * @param $column
		 * @param $post_id
		 */
		function add_shortcode_form( $column, $post_id ) {

			switch ( $column ) {

				case 'shortcode':
					$column_field = '<input style="width: 270px;padding: 6px;" type="text" onClick="this.select();" readonly="readonly" value="[woo_product_slider ' . 'id=&quot;' . $post_id . '&quot;' . ']"/>';
					echo $column_field;
					break;
				default:
					break;

			} // end switch

		}

		/**
		 * Redirect after active
		 *
		 * @param $plugin
		 */
		function redirect_help_page( $plugin ) {
			if ( $plugin == SP_WPS_BASENAME ) {
				exit( wp_redirect( admin_url( 'edit.php?post_type=sp_wps_shortcodes&page=wps_help' ) ) );
			}
		}

		/**
		 * WooCommerce not installed error message
		 */
		public function error_admin_notice() {
			$outline = '<div class="error"><p>' . __( 'Please install and activate <strong>WooCommerce</strong> plugin to make the <strong>Product Slider for WooCommerce</strong> work.', 'woo-product-slider' ) . '</p></div>';
			echo $outline;
		}

		/**
		 * Show notice if WQV plugin is not installed
		 *
		 * @since 2.1.11
		 *
		 * @return void
		 */
		public function admin_notice() {
			if ( current_user_can( 'install_plugins' ) ) {

				$action = empty( $_GET['sp-wqv'] ) ? '' : \sanitize_text_field( $_GET['sp-wqv'] );
				$plugin = 'woo-quickview/woo-quick-view.php';
				require_once SP_WPS_PATH . 'class/wqv.php';
				$wqv_install = new SP_WPS_WQV();

				if ( $action === 'install' ) {
					$wqv_install->install_plugin( 'https://downloads.wordpress.org/plugin/woo-quickview.zip' );
				} elseif ( $action === 'activate' ) {
					$wqv_install->activate_wqv_plugin( $plugin );
				}

				if ( ! class_exists( 'SP_Woo_Quick_View_Pro' ) ) {
					if ( \file_exists( WP_PLUGIN_DIR . '/' . $plugin ) ) {
						if ( ! \is_plugin_active( $plugin ) ) {
							$this->wqv_notice_message( 'activate' );
						}
					} else {
						$this->wqv_notice_message( 'install' );
					}
				}
			}
		}

		/**
		 * WQV notice message
		 *
		 * @since 2.1.11
		 *
		 * @param String $type
		 *
		 * @return void
		 */
		public function wqv_notice_message( $type ) {
			$actual_link = esc_url( ( isset( $_SERVER['HTTPS'] ) ? 'https' : 'http' ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" );
			$sign        = empty( $_GET ) ? '?' : '&';

			echo '<div class="updated notice is-dismissible notice-wqv"><p>';
			echo __( 'Please ' . $type . ' <a href="' . $actual_link . $sign . 'sp-wqv=' . $type . '">WooCommerce Quick View</a> plugin to get the Quick View feature.', 'woo-product-slider' );
			echo '</p></div>';
		}

		/**
		 * Dismiss WQV notice message
		 *
		 * @since 2.1.11
		 *
		 * @return void
		 */
		public function dismiss_wqv_notice() {
			update_option( 'sp-wqv-notice-dismissed', 1 );
		}

	}
}

/**
 * Returns the main instance.
 *
 * @since 2.0
 * @return SP_WooCommerce_Product_Slider
 */
function sp_woo_product_slider() {
	return SP_WooCommerce_Product_Slider::instance();
}

// sp_post_carousel instance.
sp_woo_product_slider();
