<?php
/**
 * Plugin Name: Tutor LMS Certificate Builder
 * Plugin URI: https://www.themeum.com/product/tutor-lms/
 * Description: Tutor Drag and Drop Certificate Builder
 * Version: 1.0.1
 * Author: Themeum
 * Author URI: https://themeum.com/
 * Text Domain: tutor-lms-certificate-builder
 * Domain Path: /languages/
 * Requires at least: 5.4
 * Requires PHP: 7.0
 *
 * @package Tutor\Certificate\Builder
 * @subpackage Tutor\Certificate\Builder
 */

defined( 'ABSPATH' ) || exit;

/**
 * Define the required plugin constants
 */
define( 'TUTOR_CB_VERSION', '1.0.1');
define( 'TUTOR_CB_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'TUTOR_CB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TUTOR_CB_BASENAME', plugin_basename( __FILE__ ) );

include 'src/Init.php';
(new \Tutor\Certificate\Builder\Init); //Load initializer