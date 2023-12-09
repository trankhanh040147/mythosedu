<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://atlasaidev.com/
 * @since             1.0.0
 * @package           TTA
 *
 * @wordpress-plugin
 * Plugin Name:       Text To Speech TTS Accessibility
 * Plugin URI:        https://atlasaidev.com/
 * Description:       Add accessibility to WordPress site to read contents out loud in more than 20 languages.
 * Version:           1.4.19
 * Author:            Atlas AiDev
 * Author URI:        http://atlasaidev.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       text-to-audio
 * Domain Path:       /languages
 */
include 'vendor/autoload.php';

use TTA\TTA;
use TTA\TTA_Activator;
use TTA\TTA_Deactivator;
use TTA_Api\TTA_Api_Routes;
use TTA\TTA_Notices;
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Absolute path to the WordPress directory.
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */

if (!defined('TEXT_TO_AUDIO_NONCE')) {

    define('TEXT_TO_AUDIO_NONCE', 'TEXT_TO_AUDIO_NONCE');
}

if (!defined('TEXT_TO_AUDIO_TEXT_DOMAIN')) {

    define('TEXT_TO_AUDIO_TEXT_DOMAIN', 'text-to-audio');
}

if (!defined('TEXT_TO_AUDIO_ROOT_FILE')) {

    define('TEXT_TO_AUDIO_ROOT_FILE', __FILE__);
}

if (!defined('TTA_ROOT_FILE_NAME')) {
    $path = explode( DIRECTORY_SEPARATOR, TEXT_TO_AUDIO_ROOT_FILE);
    $file = end($path);
    define('TTA_ROOT_FILE_NAME', $file);
}

if (!defined('TTA_LIBS_PATH')) {

    define('TTA_LIBS_PATH', dirname(TEXT_TO_AUDIO_ROOT_FILE) . '/libs/');
}


if ( ! defined( 'TTA_PLUGIN_URL' ) ) {
    /**
     * Plugin Directory URL
     *
     * @var string
     * @since 1.2.2
     */
    define( 'TTA_PLUGIN_URL', trailingslashit( plugin_dir_url( TEXT_TO_AUDIO_ROOT_FILE ) ) );
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

class TTA_Init {

    public function __construct() {
        if (!defined('TEXT_TO_AUDIO_VERSION')) {
            define('TEXT_TO_AUDIO_VERSION', apply_filters('tts_version', '1.4.19'));
        }

        if (!defined('TEXT_TO_AUDIO_PLUGIN_NAME')) {
            define('TEXT_TO_AUDIO_PLUGIN_NAME', apply_filters('tts_plugin_name', 'Text To Speech TTS' ) );
        }

        $this->run();
    }

    public function run() {
        $plugin = new TTA();
        $plugin->run();
        new TTA_Api_Routes();
        new TTA_Notices();
        //add plugins action links.
        if( is_admin() ) {
            $basename = plugin_basename( __FILE__ );
            $prefix = is_network_admin() ? 'network_admin_' : '';
            add_filter( 
                "{$prefix}plugin_action_links_$basename", 
                array( $this,'add_action_links' ), 
                10, // priority
                4   // parameters
            );
        }
        

        //add button text
        set_initial_button_texts();

        
    }

    /**
     * add action list to plugin.
     */
    public function add_action_links( $actions, $plugin_file, $plugin_data, $context ) {
        $plugin_url = esc_url( admin_url() . 'admin.php?page=text-to-audio' );
        $doc_url    = esc_url( admin_url() . 'admin.php?page=text-to-audio#/docs' );
        $support    = esc_url( 'https://atlasaidev.com/contact-us/' );
        $review    = esc_url( 'https://wordpress.org/support/plugin/text-to-audio/reviews/' );
        $custom_actions = array(
            'settings' => sprintf( '<a href="%s" target="_blank">%s</a>', $plugin_url , __( 'Settings', 'text-to-audio' ) ),
            'docs'      => sprintf( '<a href="%s" target="_blank">%s</a>', $doc_url, __( 'Docs', 'text-to-audio' ) ),
            'support'   => sprintf( '<a href="%s" target="_blank">%s</a>', $support, __( 'Support', 'text-to-audio' ) ),
            'review'    => sprintf( '<a href="%s" target="_blank">%s</a>', $review, __( 'Write a Review', 'text-to-audio' ) ),
        );

        // add the links to the front of the actions list
        return array_merge( $custom_actions, $actions );

    }

}

add_action('init', function () {
    //Rest api init.
    new TTA_Init();
});

 /**
 * The code that runs during plugin activation.
 * This action is documented in includes/TTA_Activator.php
 */
register_activation_hook(__FILE__, function () {
        TTA_Activator::activate();
    });
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/TTA_Deactivator.php
 */
register_deactivation_hook(__FILE__, function() {
        TTA_Deactivator::deactivate();
    });




/**
 *
 * Create short code for qr code.
 * Example [tta_listen_btn]
 * @param $atts
 * @return string
 */
function tta_create_shortcode($atts) {

    return tta_get_button_content($atts);

}

add_shortcode('tta_listen_btn', 'tta_create_shortcode');


