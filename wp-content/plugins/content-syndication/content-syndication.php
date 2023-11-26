<?php
/**
 * The plugin content syndication
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              facebook.com/khangtran94
 * @since             1.0.0
 * @package           content_syndication
 *
 * @wordpress-plugin
 * Plugin Name:       Content Syndication
 * Plugin URI:        #
 * Description:       A plugin syndicate contents
 * Version:           1.0.0
 * Author:            Khangtran
 * Author URI:        facebook.com/khangtran94
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       content_syndication
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'BCM_PRODUCTS_PRODUCT_CHILDREN' ) ) {
    define('BCM_PRODUCTS_PRODUCT_CHILDREN', 'bc_product');
}

if ( ! defined( 'BCM_PRODUCTS_PRODUCT' ) ) {
    define('BCM_PRODUCTS_PRODUCT', 'b_product');
}

define('PLUGIN_NAME_VERSION', '1.0.0');
define('PG_LANG', 'content-syndication');
define('PLUGIN_CS_DIR', plugin_dir_path( __FILE__ ) );

include_once PLUGIN_CS_DIR . '/helper.php';
include_once PLUGIN_CS_DIR . '/action-hooks.php';
include_once PLUGIN_CS_DIR . '/filter-hooks.php';