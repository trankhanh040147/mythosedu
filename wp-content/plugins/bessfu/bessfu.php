<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 8/27/18
 * Time: 10:03 AM
 */

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           BESSFU
 *
 * @wordpress-plugin
 * Plugin Name:       BESSFU
 * Plugin URI:        #
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Richard
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       #
 * Text Domain:       bessfu
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */

define('BESSFU_VERSION', '1.0.0');
define('BESSFU_NAME', 'bessfu');
define('BESSFU_LANG_DOMAIN', 'bessfu');
define('BESSFU_LANGUAGE_PATH', __DIR__ . '/languages/');
define('BESSFU_MODULE_DIR', __DIR__ );
define('BESSFU_MODULE_URL', plugin_dir_url(__FILE__) );

if(is_admin()) {
    require_once BESSFU_MODULE_DIR . '/admin/hooks.php';
    require_once BESSFU_MODULE_DIR . '/admin/settings.php';
}

#public for front-end
require_once BESSFU_MODULE_DIR . '/public/bessfu-public.php';



