<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Core_System
 * @subpackage Core_System/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Core_System
 * @subpackage Core_System/public
 * @author     Richard <nguyenkha252@gmail.com>
 */

namespace CoreSystem\Front;

class Core_System_Front {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	private $suffix;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->suffix                = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Core_System_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Core_System_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/core-system-front.css', array(), $this->version, 'all' );
		wp_register_style('bootstrap', plugin_dir_url( __FILE__ ) . 'libs/bootstrap/css/bootstrap' . $this->suffix . '.css');
		wp_register_style('bootstrap-daterangepicker', plugin_dir_url( __FILE__ ) . 'libs/bootstrap/css/daterangepicker' . $this->suffix . '.css', ['bootstrap']);
		wp_register_style('bootstrap-datetimepicker', plugin_dir_url( __FILE__ ) . 'libs/bootstrap/css/bootstrap-datetimepicker' . $this->suffix . '.css', ['bootstrap']);
		wp_register_style('bootstrap-material', plugin_dir_url( __FILE__ ) . 'libs/bootstrap/css/bootstrap-material-design' . $this->suffix . '.css', ['bootstrap']);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Core_System_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Core_System_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/core-system-front.js', array( 'jquery' ), $this->version, false );
        wp_register_script('jquery-ui-block', plugin_dir_url( __FILE__ ) . 'libs/jquery/js/jquery.blockui.js', $this->version, 'all');


        wp_register_script('popper', plugin_dir_url( __FILE__ ) . 'libs/bootstrap/js/popper' . $this->suffix .'.js', ['jquery'], $this->version, 'all');
        wp_register_script('moment-with-locales', plugin_dir_url( __FILE__ ) . 'libs/bootstrap/js/moment-with-locales' . $this->suffix .'.js', ['jquery'], $this->version, 'all');
        wp_register_script('bootstrap', plugin_dir_url( __FILE__ ) . 'libs/bootstrap/js/bootstrap' . $this->suffix .'.js', ['jquery'], $this->version, 'all');
        wp_register_script('jquery-validate', plugin_dir_url( __FILE__ ) . 'libs/jquery/js/jquery.validate' . $this->suffix .'.js', ['jquery', 'jquery-form'], $this->version, 'all');
        wp_register_script('additional-methods', plugin_dir_url( __FILE__ ) . 'libs/jquery/js/additional-methods' . $this->suffix .'.js', ['jquery', 'jquery-validate'], $this->version, 'all');

        wp_register_script('bootstrap-daterangepicker', plugin_dir_url( __FILE__ ) . 'libs/bootstrap/js/daterangepicker' . $this->suffix .'.js', ['jquery', 'bootstrap', 'popper', 'moment-with-locales'], $this->version, 'all');
        wp_register_script('bootstrap-datetimepicker', plugin_dir_url( __FILE__ ) . 'libs/bootstrap/js/bootstrap-datetimepicker' . $this->suffix .'.js', ['jquery', 'bootstrap', 'popper', 'moment-with-locales'], $this->version, 'all');

        wp_register_script('bootstrap-material', plugin_dir_url( __FILE__ ) . 'libs/bootstrap/js/bootstrap-material-design' . $this->suffix .'.js', ['bootstrap'],$this->version, 'all');

	}

}
