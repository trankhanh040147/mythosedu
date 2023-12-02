<?php
/*
    Plugin Name: SSO for Azure AD
    Plugin URI: https://gitlab.com/qlcvea/wp-sso-for-azure-ad
    Description: Enable Single Sign On with Azure AD on your site.
    Version: 2.1.0
    Author: Marco Benzoni
    Author URI: https://qlcvea.com
    License: GPLv2 or later
*/

// Die if not called from WordPress
if ( ! defined( 'WPINC' ) ) {
    die;
}

// A function that returns a URL for a plugin function (see handler.php) which varies depending on whether URL rewrites are supported/enabled or not
// (This function is defined here because it is needed in multiple files)
function sso_for_azure_ad_endpoint_url($parameter, $enforce_https = null) {
    $result = '';

    if (
        get_option('sso_for_azure_ad_enable_rewrites', false)
    ) {
        // Rewrites are enabled
        $result = site_url( '/sso_for_azure_ad/' . urlencode( $parameter ) . '/', $enforce_https ? 'https' : null );
    } else {
        // Rewrites are disabled
        $result = site_url( '?sso_for_azure_ad=' . urlencode( $parameter ), $enforce_https ? 'https' : null );
    }

    if (
        $enforce_https === null &&
        $parameter === 'callback' &&
        ($scheme = parse_url( $result, PHP_URL_HOST )) !== 'localhost' &&
        $scheme !== '127.0.0.1'
    ) {
        // Require HTTPS if the URL being generated is a callback URL and the host is not localhost
        return sso_for_azure_ad_endpoint_url($parameter, true);
    } else {
        return $result;
    }
}

include( 'sso-for-azure-ad-handler.php' );
include( 'sso-for-azure-ad-login-form.php' );
include( 'sso-for-azure-ad-options.php' );
include( 'sso-for-azure-ad-plugin-management.php' );