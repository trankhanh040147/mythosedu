<?php

/**
 * Plugin Name: Hostinger
 * Plugin URI: https://hostinger.com
 * Description: Hostinger WordPress plugin.
 * Version: 1.8.6
 * Requires at least: 5.6
 * Requires PHP: 7.4
 * Author: Hostinger
 * License: GPL v3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Author URI: https://www.hostinger.com
 * Text Domain: hostinger
 * Domain Path: /languages
 *
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'HOSTINGER_VERSION' ) ) {
	define( 'HOSTINGER_VERSION', '1.8.6' );
}

if ( ! defined( 'HOSTINGER_ABSPATH' ) ) {
	define( 'HOSTINGER_ABSPATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'HOSTINGER_PLUGIN_FILE' ) ) {
	define( 'HOSTINGER_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'HOSTINGER_PLUGIN_URL' ) ) {
	define( 'HOSTINGER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'HOSTINGER_ASSETS_URL' ) ) {
	define( 'HOSTINGER_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets' );
}

if ( ! defined( 'HOSTINGER_WP_CONFIG_PATH' ) ) {
	define( 'HOSTINGER_WP_CONFIG_PATH', ABSPATH . '/.private/config.json' );
}

if ( ! defined( 'HOSTINGER_WP_TOKEN' ) ) {
	$path = explode('/', __DIR__);
	$serverRootPath = '/' . $path[1] . '/' . $path[2];
	define( 'HOSTINGER_WP_TOKEN', $serverRootPath . '/.api_token' );
}

if ( ! defined( 'HOSTINGER_REST_URI' ) ) {
	define( 'HOSTINGER_REST_URI', 'https://rest-hosting.hostinger.com' );
}

function activate_hostinger(): void {
	require_once HOSTINGER_ABSPATH . 'includes/class-hostinger-activator.php';
	Hostinger_Activator::activate();
}

function deactivate_hostinger(): void {
	require_once HOSTINGER_ABSPATH . 'includes/class-hostinger-deactivator.php';
	Hostinger_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_hostinger' );
register_deactivation_hook( __FILE__, 'deactivate_hostinger' );
require_once HOSTINGER_ABSPATH . '/vendor/autoload.php';
require_once HOSTINGER_ABSPATH . 'includes/class-hostinger.php';

$plugin = new Hostinger();
$plugin->run();
