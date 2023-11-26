<?php
/*
Plugin Name: WooCommerce AJAX Cart
Plugin URI: https://wordpress.org/plugins/woocommerce-ajax-cart/
Description: Change the default behavior of WooCommerce Cart page, making AJAX requests when quantity field changes
Version: 1.3.5
Author: Moises Heberle, Alex Szilagyi (contributor)
Author URI: https://pluggablesoft.com/contact/
Text Domain: woocommerce-ajax-cart
Domain Path: /i18n/languages/
WC requires at least: 3.2
WC tested up to: 3.7.1
*/

if ( ! defined( 'ABSPATH' ) ) exit;

defined('WAC_BASE_FILE') || define('WAC_BASE_FILE', __FILE__);

if ( !function_exists('wac_init') ) {
    add_action('init', 'wac_init');
    add_filter('mh_wac_settings', 'wac_settings');
    add_filter('mh_wac_premium_url', 'wac_premium_url');
    add_action('woocommerce_before_cart_table', 'wac_enqueue_scripts');
    add_action('wp_enqueue_scripts', 'wac_enqueue_scripts' );
    add_filter('woocommerce_cart_item_quantity', 'wac_filter_woocommerce_cart_item_quantity', 10, 3);
    add_filter('wc_get_template', 'wac_get_template', 10, 5 );
    add_action('plugins_loaded', 'wac_load_plugin_textdomain');

    function wac_init() {
        // common lib init
        include_once( 'common/MHCommon.php' );
        MHCommon::initializeV2(
            'woocommerce-ajax-cart',
            'wac',
            WAC_BASE_FILE,
            __('WooCommerce Ajax Cart', 'woocommerce-ajax-cart')
        );
    
        // run legacy migrations
        if ( get_option('wac_show_qty_buttons') ) {
            wac_run_migration_01();
        }
    
        // plugin checks
        if ( !empty($_POST['is_wac_ajax']) && !defined( 'WOOCOMMERCE_CART' ) ) {
            define( 'WOOCOMMERCE_CART', true );
        }
    }
    
    function wac_settings($arr) {
        $arr['show_qty_buttons'] = array(
            'label' => __('Display -/+ buttons around product quantity input', 'woocommerce-ajax-cart'),
            'tab' => __('General', 'woocommerce-ajax-cart'),
            'type' => 'checkbox',
            'default' => 'yes',
        );
        $arr['qty_as_select'] = array(
            'label' => __('Show item quantity as select instead numeric field', 'woocommerce-ajax-cart'),
            'tab' => __('General', 'woocommerce-ajax-cart'),
            'type' => 'checkbox',
            'default' => 'no',
        );
        $arr['select_items'] = array(
            'label' => __('Items to show on select', 'woocommerce-ajax-cart'),
            'tab' => __('General', 'woocommerce-ajax-cart'),
            'type' => 'number',
            'default' => 5,
            'depends_on' => 'qty_as_select',
            'min' => 1,
            'max' => 1000,
        );
        $arr['confirmation_zero_qty'] = array(
            'label' => __('Show user confirmation when change item quantity to zero', 'woocommerce-ajax-cart'),
            'tab' => __('General', 'woocommerce-ajax-cart'),
            'type' => 'checkbox',
            'default' => 'no',
        );
        $arr['ajax_timeout'] = array(
            'label' => __('AJAX timeout in milliseconds to refresh the cart on change', 'woocommerce-ajax-cart'),
            'tab' => __('General', 'woocommerce-ajax-cart'),
            'type' => 'number',
            'default' => 800,
            'min' => 1,
            'max' => 5000,
        );
    
        return $arr;
    }
    
    function wac_premium_url() {
        return 'http://gum.co/wajaxcart';
    }
    
    function wac_option($name) {
        return apply_filters('mh_wac_setting_value', $name);
    }
    
    function wac_run_migration_01() {
        update_option('wac_settings', array(
            'show_qty_buttons' => get_option('wac_show_qty_buttons'),
            'confirmation_zero_qty' => get_option('wac_confirmation_zero_qty'),
            'qty_as_select' => get_option('wac_qty_as_select'),
            'select_items' => get_option('wac_select_items'),
        ));
        
        delete_option('wac_show_qty_buttons');
        delete_option('wac_confirmation_zero_qty');
        delete_option('wac_qty_as_select');
        delete_option('wac_select_items');
    }
    
    function wac_load_plugin_textdomain() {
        load_plugin_textdomain('woocommerce-ajax-cart', FALSE, basename( dirname(dirname( __FILE__ )) ) . '/languages/' );
    }

    function wac_enqueue_scripts() {
        $deps = array('jquery');

        if ( is_cart() ) {
            $deps[] = 'wc-cart';
        }

        wp_enqueue_style('wooajaxcart', plugins_url('assets/wooajaxcart.css', plugin_basename(WAC_BASE_FILE)));
        wp_enqueue_script('wooajaxcart', plugins_url('assets/wooajaxcart.js', plugin_basename(WAC_BASE_FILE)), $deps);
    
        $frontendData = apply_filters('wac_frontend_vars', array(
            'updating_text' => __( 'Updating...', 'woocommerce-ajax-cart' ),
            'warn_remove_text' => __( 'Are you sure you want to remove this item from cart?', 'woocommerce-ajax-cart' ),
            'ajax_timeout' => wac_option('ajax_timeout'),
            'confirm_zero_qty' => wac_option('confirmation_zero_qty'),
            'use_faster_ajax' => wac_option('use_faster_ajax'),
            'qty_buttons_lock_input' => wac_option('qty_buttons_lock_input'),
        ));
    
        wp_localize_script( 'wooajaxcart', 'wooajaxcart', $frontendData );
    }
    
    // define the woocommerce_cart_item_quantity callback
    // add the + and - buttons
    function wac_filter_woocommerce_cart_item_quantity( $inputDiv, $cart_item_key, $cart_item = null ) {
        // check config
        if ( ( wac_option('show_qty_buttons') == 'no' ) || preg_match('/type=\"hidden\"/', $inputDiv) ) {
            return $inputDiv;
        }
    
        // some users related duplication problem, so it avoid this
        if ( preg_match('/wac-qty-button/', $inputDiv) ) {
            return $inputDiv;
        }
    
        // add plus and minus buttons
        $minus = wac_button_div('-', 'sub');
        $plus = wac_button_div('+', 'inc');
    
        $input = str_replace(array('<div class="quantity">', '</div>'), array('', ''), $inputDiv);
        $newDiv = '<div class="quantity wac-quantity">' . $minus . $input . $plus . '</div>';
    
        return $newDiv;
    };
    
    function wac_button_div($label, $identifier) {
        $link = '<b><a href="" class="wac-btn-'.$identifier.'">'.$label.'</a></b>';
        $div = '<div class="wac-qty-button">' . $link . '</div>';
    
        return $div;
    }
    
    function wac_get_template( $located, $template_name, $args, $template_path, $default_path ) {
    
        // ignore if select disabled
        if ( wac_option('qty_as_select') != 'yes' ) {
            return $located;
        }
    
        // modify input template to use select
        if ( 'global/quantity-input.php' == $template_name ) {
            $located = plugin_dir_path(WAC_BASE_FILE) . '/templates/wac-qty-select.php';
        }
    
        return $located;
    }
}
