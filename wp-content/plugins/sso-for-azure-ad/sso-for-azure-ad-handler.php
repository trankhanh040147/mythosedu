<?php
// SSO for Azure AD - Handler
// Handles requests to start login, OAuth callbacks.

// Die if not called from WordPress
if ( ! defined( 'WPINC' ) ) {
    die;
}


// SSO start: redirects to Microsoft's OAuth page

function sso_for_azure_ad_handler_start() {
    $client_id = get_option( 'sso_for_azure_ad_client_id', '' );
    $client_secret = get_option( 'sso_for_azure_ad_client_secret', '' ); // only to check if it is set
    $tenant_id = get_option( 'sso_for_azure_ad_tenant_id', '' );

    if (
	    $client_id == ''
	    || $client_secret == ''
	    || $tenant_id == ''
    ) {
  	    // Plugin is not fully configured, throw an error and stop.
        wp_die(
            sprintf(
                /* translators: Error message displayed when the login couldn't be started (before redirecting to consent screen). %s: More specific information on the cause of the error. */
                __('Cannot initiate login: %s', 'sso-for-azure-ad'),
                /* translators: Error message displayed when the plugin has not been fully configured (some required settings have not been set) */
                __('Plugin has not been fully configured.', 'sso-for-azure-ad')
            )
        );
        return true;
    }

    // The OAuth state is a JSON serialized array containing a WordPress nonce and, optionally, a URL to redirect to when the user has been logged in.
    $state_data = array();

    // Checking $_GET because redirect_to isn't available in WP_Query.
    if ( isset( $_GET['redirect_to'] ) ) {
        // There is a post-login redirect, therefore the nonce action must contain that URL and it must be a string.
        $state_data['redirect_to'] = esc_url_raw( $_GET['redirect_to'] );
        $state_data['nonce'] = wp_create_nonce( 'sso_for_azure_ad_login_' . $state_data['redirect_to'] );
    } else {
        // There is no post-login redirect, therefore the nonce action must be "sso_for_azure_ad_login".
        $state_data['nonce'] = wp_create_nonce( 'sso_for_azure_ad_login' );
    }
    
    $login_url = 'https://login.microsoftonline.com/' . urlencode( $tenant_id ) . '/oauth2/v2.0/authorize?' . http_build_query( array(
        'client_id'     => $client_id,
        'scope'         => 'https://graph.microsoft.com/User.Read',
        'redirect_uri'  => sso_for_azure_ad_endpoint_url( 'callback' ),
        'response_type' => 'code',
        'response_mode' => 'query',
        'state' => json_encode( $state_data )
    ) );

    // Stop if redirection was succesful
    return wp_redirect( $login_url );
}


// SSO callback: processes the response from Microsoft OAuth and logs the user in

function sso_for_azure_ad_handler_dologin( $user, $state_data ) {
    wp_set_current_user( $user->ID, $user->user_login );
    wp_set_auth_cookie( $user->ID, false );
    do_action( 'wp_login', $user->user_login, $user );

    // If a redirect parameter was set, then redirect to it, otherwise redirect to the default admin page.
    if ( $state_data['redirect_to'] ) {
        return wp_safe_redirect( esc_url_raw( $state_data['redirect_to'] ) );
    } else {
        return wp_safe_redirect( admin_url() );
    }
}

function sso_for_azure_ad_handler_callback() {
    global $wp_query;

    $client_id = get_option( 'sso_for_azure_ad_client_id', '' );
    $client_secret = get_option( 'sso_for_azure_ad_client_secret', '' );
    $tenant_id = get_option( 'sso_for_azure_ad_tenant_id', '' );

    if (
	    $client_id == ''
	    || $client_secret == ''
	    || $tenant_id == ''
    ) {
  	    // Plugin is not fully configured, throw an error and stop.
        wp_die(
            sprintf(
                /* translators: Error message displayed when the login couldn't be completed (after redirecting to consent screen). %s: More specific information on the cause of the error. */
                __('Cannot complete login: %s', 'sso-for-azure-ad'),
                __('Plugin has not been fully configured.', 'sso-for-azure-ad')
            )
        );
        return true;
    }

    $error_query = $wp_query->get( 'error', null );
    $error_desc_query = $wp_query->get( 'error_description', null );
    if ( $error_query != null && $error_desc_query != null ) {
        // Received an error from Azure AD, throw an error and stop.
        wp_die(
            sprintf(
                __('Cannot complete login: %s', 'sso-for-azure-ad'),
                sprintf(
                    /* translators: Error message displayed when the OAuth response contains an error. %s: More specific information on the cause of the error. */
                    __('OAuth error. (%s)', 'sso-for-azure-ad'),
                    $error_query . ': ' . $error_desc_query
                )
            )
        );
        return true;
    }

    // This bypasses the WP_Query class and its sanitization.
    // It is needed because WP_Query does some sanitization, while here the raw values passed to query parameters must be used.
    $real_query_params = array();
    parse_str( $_SERVER['QUERY_STRING'], $real_query_params );

    if ( ! isset( $real_query_params['state'] ) ) {
        // Did not receive a state, throw an error and stop.
        wp_die(
            sprintf(
                __('Cannot complete login: %s', 'sso-for-azure-ad'),
                /* translators: Error message displayed when the "state" GET parameter is missing. */
                __('Missing state data.', 'sso-for-azure-ad')
            )
        );
        return true;
    }

    if ( ! isset( $real_query_params['code'] ) ) {
        // Did not receive an authorization code, throw an error and stop.
        wp_die(
            sprintf(
                __('Cannot complete login: %s', 'sso-for-azure-ad'),
                /* translators: Error message displayed when the "code" GET parameter is missing. */
                __('Missing authorization code.', 'sso-for-azure-ad')
            )
        );
        return true;
    }

    $state_query = $real_query_params['state'];
    $code_query = $real_query_params['code'];

    $state_data = json_decode( $state_query, true );

    if ( $state_data == null ) {
        // State is not valid JSON, throw an error and stop.
        wp_die(
            sprintf(
                __('Cannot complete login: %s', 'sso-for-azure-ad'),
                sprintf(
                    /* translators: Error message displayed when the data in the "state" GET parameter is not valid. %s: More specific information on the cause of the error. */
                    __('Invalid state data. (%s)', 'sso-for-azure-ad'),
                    /* translators: Error message displayed when the data in the "state" GET parameter is not valid JSON. */
                    __('Invalid JSON', 'sso-for-azure-ad')
                )
            )
        );
        return true;
    }

    if ( ! isset( $state_data['nonce'] ) ) {
        // State does not contain a nonce, throw an error and stop.
        wp_die(
            sprintf(
                __('Cannot complete login: %s', 'sso-for-azure-ad'),
                sprintf(
                    __('Invalid state data. (%s)', 'sso-for-azure-ad'),
                    /* translators: Error message displayed when the nonce in the "state" GET parameter is missing. */
                    __('Missing nonce', 'sso-for-azure-ad')
                )
            )
        );
        return true;
    }

    if ( ! is_string( $state_data['nonce'] ) ) {
        // The nonce is not a string, throw an error and stop.
        wp_die(
            sprintf(
                __('Cannot complete login: %s', 'sso-for-azure-ad'),
                sprintf(
                    __('Invalid state data. (%s)', 'sso-for-azure-ad'),
                    /* translators: Error message displayed when the nonce in the "state" GET parameter could not be verified. */
                    __('Invalid nonce', 'sso-for-azure-ad')
                )
            )
        );
        return true;
    }

    $nonce_verification = false;

    if ( isset( $state_data['redirect_to'] ) ) {
        // There is a post-login redirect, therefore the nonce action must contain that URL and it must be a string.

        if ( ! is_string( $state_data['redirect_to'] ) ) {
            wp_die(
                sprintf(
                    __('Cannot complete login: %s', 'sso-for-azure-ad'),
                    sprintf(
                        __('Invalid state data. (%s)', 'sso-for-azure-ad'),
                        /* translators: Error message displayed when the redirect URL in the "state" GET parameter is not a string. */
                        __('Invalid redirect', 'sso-for-azure-ad')
                    )
                )
            );
            return true;
        }

        $state_data['redirect_to'] = esc_url_raw( $state_data['redirect_to'] );

        $nonce_verification = wp_verify_nonce( $state_data['nonce'], 'sso_for_azure_ad_login_' . $state_data['redirect_to'] );
    } else {
        // There is no post-login redirect, therefore the nonce action must be "sso_for_azure_ad_login".
        $nonce_verification = wp_verify_nonce( $state_data['nonce'], 'sso_for_azure_ad_login' );
    }

    if ( ! $nonce_verification ) {
        // Nonce verification failed, throw an error and stop.
        wp_die(
            sprintf(
                __('Cannot complete login: %s', 'sso-for-azure-ad'),
                sprintf(
                    __('Invalid state data. (%s)', 'sso-for-azure-ad'),
                    __('Invalid nonce', 'sso-for-azure-ad')
                )
            )
        );
        return true;
    }

    // Response is valid, exchange authorization_code for an access_token
    $token_response = wp_remote_post( 'https://login.microsoftonline.com/' . urlencode( $tenant_id ) . '/oauth2/v2.0/token', array(
        'body' => http_build_query( array(
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
            'scope'         => 'https://graph.microsoft.com/User.Read',
            'redirect_uri'  => sso_for_azure_ad_endpoint_url( 'callback' ),
            'grant_type'    => 'authorization_code',
            'code'          => $code_query
        ) )
    ) );

    if ( is_wp_error( $token_response ) ) {
        // Throw the response and stop.
        wp_die( $token_response );
        return true;
    }

    $token_data = json_decode( $token_response['body'] );

    if (
        $token_data === null
        || ! isset( $token_data->access_token )
        || ! is_string( $token_data->access_token )
    ) {
        // Received invalid response from Azure AD, throw an error and stop.
        wp_die(
            sprintf(
                __('Cannot complete login: %s', 'sso-for-azure-ad'),
                /* translators: Error message displayed when the response from the Azure AD OAuth token endpoint does not contain an access token. */
                __('Invalid response from Azure AD while getting token.', 'sso-for-azure-ad')
            )
        );
        return true;
    }

    $user_endpoint = 'https://graph.microsoft.com/v1.0/me?$select=userPrincipalName';

    // Get the user's email address
    $user_response = wp_remote_get( $user_endpoint, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $token_data->access_token
        )
    ) );

    if ( is_wp_error( $user_response ) ) {
        // Throw the response and stop.
        wp_die( $user_response );
        return true;
    }

    $user_data = json_decode( $user_response['body'] );

    if (
        $user_data === null
    ) {
        // Received invalid response from Azure AD, throw an error and stop.
        wp_die(
            sprintf(
                __('Cannot complete login: %s', 'sso-for-azure-ad'),
                __('Invalid response while getting user information.', 'sso-for-azure-ad')
            )
        );
        return true;
    }

    if (
        isset( $user_data->mail )
        && is_string( $user_data->mail )
    ) {
        $email = $user_data->mail;
    } elseif (
        isset( $user_data->userPrincipalName )
        && is_string( $user_data->userPrincipalName )
    ) {
        $email = $user_data->userPrincipalName;
    } else {
        // Azure AD response contains neither an email nor a UPN, throw an error and stop.
        wp_die(
            sprintf(
                __('Cannot complete login: %s', 'sso-for-azure-ad'),
                __('Invalid response while getting user information.', 'sso-for-azure-ad')
            )
        );
        return true;
    }

    $email = $user_data->userPrincipalName;

    $user = get_user_by( 'email', $email ); 
    if( $user ) {
        return sso_for_azure_ad_handler_dologin( $user, $state_data );
    } else {
        if ( get_option( 'sso_for_azure_ad_create_users', false ) ) {
            // Automatic user creation is enabled: create the user and log them in.

            $new_user = array(
                'user_email' => $email,
                'user_login' => $email
            );

            if ( get_option( 'sso_for_azure_ad_new_usernames_no_domain', false ) ) {
                $new_user['user_login'] = strtok( $email, '@' );
            }

            if ( get_option( 'sso_for_azure_ad_populate_new_profiles', false ) ) {
                // Get additional profile information from Graph to populate the new profile
                $profile_response = wp_remote_get( 'https://graph.microsoft.com/v1.0/me?$select=displayName,givenName,surname', array(
                    'headers' => array(
                        'Authorization' => 'Bearer ' . $token_data->access_token
                    )
                ) );

                if ( is_wp_error( $profile_response ) ) {
                    // Throw the response and stop.
                    wp_die( $user_response );
                    return true;
                }
            
                $profile_data = json_decode( $profile_response['body'] );

                if ( $profile_data !== null ) {

                    if (
                        isset( $profile_data->displayName )
                        && is_string( $profile_data->displayName )
                    ) {
                        $new_user['display_name'] = $profile_data->displayName;
                    }

                    if (
                        isset( $profile_data->givenName )
                        && is_string( $profile_data->givenName )
                    ) {
                        $new_user['first_name'] = $profile_data->givenName;
                    }

                    if (
                        isset( $profile_data->surname )
                        && is_string( $profile_data->surname )
                    ) {
                        $new_user['last_name'] = $profile_data->surname;
                    }

                }
            }

            $new_user['user_pass'] = wp_generate_password();

            $user_id = wp_insert_user( $new_user );

            update_user_meta( $user_id, 'default_password_nag', 1 );

            $user = get_userdata( $user_id ); 
            return sso_for_azure_ad_handler_dologin( $user, $state_data );
        } else {
            // Automatic user creation is disabled: display an error message.
            /* translators: Error message displayed when the user who is trying to log in does not have a corresponding user on the WordPress site and automatic user creation is disabled. */
            wp_die( __( 'Your account has not been registered on this site. Please contact your administrator.', 'sso-for-azure-ad' ) );
            return true;
        }
    }
}


// Action hooks

function sso_for_azure_ad_handler_template_include( $template ) {
    global $wp_query;

    $should_stop = false;
    $sso_for_azure_ad_query = $wp_query->get( 'sso_for_azure_ad' );

    if ( $sso_for_azure_ad_query == 'start' ) {
        $should_stop = sso_for_azure_ad_handler_start();
    } elseif ( $sso_for_azure_ad_query == 'callback' ) {
        $should_stop = sso_for_azure_ad_handler_callback();
    }

    if ( $should_stop ) {
        exit;
    } else {
        return $template;
    }
}

function sso_for_azure_ad_handler_query_vars( $query_vars ) {
    // Register sso_for_azure_ad query variable
    $query_vars[] = 'sso_for_azure_ad';

    // Register error, error_description query variables for OAuth callbacks.
    $query_vars[] = 'error';
    $query_vars[] = 'error_description';

    return $query_vars;
}

function sso_for_azure_ad_handler_init() {
    add_rewrite_endpoint( 'sso_for_azure_ad', EP_ROOT );
}

add_filter( 'template_include', 'sso_for_azure_ad_handler_template_include', 10, 1 );
add_filter( 'query_vars', 'sso_for_azure_ad_handler_query_vars', 10, 1 );
add_action( 'init', 'sso_for_azure_ad_handler_init' );