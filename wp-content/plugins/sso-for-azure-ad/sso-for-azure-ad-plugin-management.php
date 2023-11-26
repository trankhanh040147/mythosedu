<?php
// SSO for Azure AD - Plugin management
// General functionality relating to plugin activation, deactivation, and uninstallation.

// Die if not called from WordPress
if ( ! defined( 'WPINC' ) ) {
    die;
}

function sso_for_azure_ad_plugin_management_activate() {
    // Erase settings from previous versions
    delete_option( 'sso_for_azure_ad_scope' );

    if (got_url_rewrite()) {
        add_rewrite_endpoint( 'sso_for_azure_ad', EP_ROOT );
        flush_rewrite_rules();
    }
}

function sso_for_azure_ad_plugin_management_deactivate() {
    // Erase settings from previous versions
    delete_option( 'sso_for_azure_ad_scope' );

    if (got_url_rewrite()) {
        flush_rewrite_rules();
    }
}

function sso_for_azure_ad_plugin_management_uninstall() {
    // Delete all options on uninstall
    delete_option( 'sso_for_azure_ad_client_id' );
    delete_option( 'sso_for_azure_ad_client_secret' );
    delete_option( 'sso_for_azure_ad_tenant_id' );
    delete_option( 'sso_for_azure_ad_create_users' );
    delete_option( 'sso_for_azure_ad_populate_new_profiles' );
    delete_option( 'sso_for_azure_ad_new_usernames_no_domain' );
    delete_option( 'sso_for_azure_ad_login_button_text' );
}

register_activation_hook( basename( dirname( __FILE__ ) )  . '/sso-for-azure-ad.php', 'sso_for_azure_ad_plugin_management_activate' );
register_deactivation_hook( basename( dirname( __FILE__ ) )  . '/sso-for-azure-ad.php', 'sso_for_azure_ad_plugin_management_deactivate' );
register_uninstall_hook( basename( dirname( __FILE__ ) ) . '/sso-for-azure-ad.php', 'sso_for_azure_ad_plugin_management_uninstall' );