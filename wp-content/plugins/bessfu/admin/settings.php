<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 8/27/18
 * Time: 10:10 AM
 */

add_action('admin_menu', 'bessfu_menu_item');
function bessfu_menu_item() {
    include __DIR__ . '/views/options-panel.php';
    global $bessfu_settings_page_hook, $wpdb;
    $site_settings_title = __('Site Settings', BESSFU_LANG_DOMAIN);
    $bessfu_settings_page_hook = add_menu_page(
        $site_settings_title,
        $site_settings_title,
        'ure_manage_options',
        'bessfu_settings',
        'bessfu_render_settings_page'
    );
    #add_menu_page('Maps', 'Maps', 'ure_management_map_location', 'map-location', 'site_map_location_render');

    #add_submenu_page('bessfu_settings', $site_settings_title, $site_settings_title, 'manage_options', 'bessfu_config', 'bessfu_render_settings_page');
    #add_submenu_page('bessfu_config', __('Site Settings', bessfu_PRODUCT_LANG_DOMAIN),  __('Site Settings', bessfu_PRODUCT_LANG_DOMAIN), 'manage_options', 'bessfu_settings', [$this, 'bessfu_render_settings_page']);

}

add_filter('option_page_capability_bessfu_settings', 'bessfu_option_page_capability_bessfu_settings', 100);

function bessfu_option_page_capability_bessfu_settings($capability){
    #return 'ure_manage_options';
    return $capability;
}
