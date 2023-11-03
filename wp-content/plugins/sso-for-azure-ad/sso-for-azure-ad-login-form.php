<?php
// SSO for Azure AD - Login form
// Adds the "Login with Azure AD" button to the login form.

// Die if not called from WordPress
if ( ! defined( 'WPINC' ) ) {
    die;
}

function sso_for_azure_ad_login_form() {
    $client_id = get_option( 'sso_for_azure_ad_client_id', '' );
    $client_secret = get_option( 'sso_for_azure_ad_client_secret', '' ); // only to check if it is set
    $tenant_id = get_option( 'sso_for_azure_ad_tenant_id', '' );

    $button_text = get_option( 'sso_for_azure_ad_login_button_text', __( 'Sign in with Azure AD', 'sso-for-azure-ad' ) );

    if (
	    $client_id == ''
	    || $client_secret == ''
	    || $tenant_id == ''
    ) {
  	    // Plugin is not fully configured, don't do anything.
	    return;
    }

    $query_values = array(
        'sso_for_azure_ad' => 'start'
    );

    // Checking $_REQUEST because redirect_to isn't available in WP_Query and it may be set either in GET or POST.
    if ( isset( $_REQUEST['redirect_to'] ) ) {
        $query_values['redirect_to'] = esc_url_raw( $_REQUEST['redirect_to'] );
    }

    ?>
        <a href="<?php print( esc_html( site_url( '?' . http_build_query( $query_values ) ) ) ); ?>" style="width: 100%; text-align: center;" class="button button-primary button-large" width="100%"><?php print( esc_html( $button_text ) ); ?></a>
        <div style="clear: both; padding-top: 5px;"></div>
    <?php
}

add_action( 'login_form', 'sso_for_azure_ad_login_form' );