<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 8/27/18
 * Time: 10:12 AM
 */

add_filter( 'tiny_mce_before_init', 'bessfu_customize_add_editor_styles', 100 );
function bessfu_customize_add_editor_styles($init_array) {
    $add_more = [
        BESSFU_MODULE_URL . '/admin/assets/font-awesome/css/fontawesome-all.min.css',
        BESSFU_MODULE_URL . '/admin/assets/css/custom-editor-style.css',
    ];
    $css = implode(",", $add_more);
    if( !isset($init_array['content_css']) ){
        $init_array['content_css']  = '';
    }
    $init_array['content_css'] .= "," . $css;
    return $init_array;
}

add_action('admin_enqueue_scripts', 'bessfu_admin_enqueue_scripts');
function bessfu_admin_enqueue_scripts(){
    wp_enqueue_style( BESSFU_NAME, BESSFU_MODULE_URL . '/admin/assets/css/bessfu-admin.css', array(), BESSFU_VERSION, 'all' );
    wp_enqueue_script( BESSFU_NAME, BESSFU_MODULE_URL . '/admin/assets/js/bessfu-admin.js', array( 'jquery' ), BESSFU_VERSION, true );
}

add_action('plugins_loaded', 'bessfu_load_plugin_textdomain');
function bessfu_load_plugin_textdomain(){
    load_plugin_textdomain(
        BESSFU_LANG_DOMAIN,
        false,
        BESSFU_LANGUAGE_PATH
    );
}
