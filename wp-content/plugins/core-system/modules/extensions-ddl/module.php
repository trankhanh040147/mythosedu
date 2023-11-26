<?php

/**
 * Plugin Name: Extension Element of DDL
 * Plugin URI: #
 * Description: Admin panel for creating custom post types and custom taxonomies in WordPress
 * Author: #
 * Version: 1.7.4
 * Author URI: #
 * Text Domain: extddl-lang
 * Domain Path: /languages
 * License: GPL-2.0+
 */

namespace CoreSystem\Modules\ExtensionsDDL;

// phpcs:disable #.All.RequireAuthor

// Exit if accessed directly.
use CoreSystem\Modules\ExtensionsDDL\Inc\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Module{

    public static $instance = null;

    public function __construct()
    {
        $this->define();
        #$this->init_hooks();
        $this->autoloader();
    }

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function define(){
        define( 'ETSDDL_VERSION', '1.0' );
        define( 'ETSDDL_DIR', __DIR__ );
        define( 'ETSDDL_URL', \CoreSystem\Includes\Module::get_url_module('extensions-ddl') );
        define( 'ETSDLL_SCRIPT_SUFFIX', defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        define( 'ETSDDL_LANG', 'extddl-lang' );
    }

    function autoloader(){
        require_once ETSDDL_DIR . '/inc/plugin.php';
    }

    public function init_hooks(){
        add_action( 'plugins_loaded', [$this, 'load_textdomain'] );

        #add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue_scripts'] );
    }

    public function load_textdomain(){
        load_plugin_textdomain( ETSDDL_LANG );
    }

    function admin_enqueue_scripts() {
        if ( wp_doing_ajax() ) {
            return;
        }
    }
}
