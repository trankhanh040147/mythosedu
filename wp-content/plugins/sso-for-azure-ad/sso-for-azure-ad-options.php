<?php
// SSO for Azure AD - Options page

// Die if not called from WordPress
if ( ! defined( 'WPINC' ) ) {
    die;
}

// A function that outputs a <p> tag containing the option description as registered with register_setting.
function sso_for_azure_ad_options_description( $option ) {
    global $wp_registered_settings;

    if ( !isset( $wp_registered_settings[$option] ) ) {
        throw 'Option not registered';
    }

    $option_args = $wp_registered_settings[$option];

    if (
        isset( $option_args['description'] )
        && is_string( $option_args['description'] )
    ) {
        ?><p class="description"><?php print( esc_html( $option_args['description'] ) ); ?></p><?php
    }
}

// A callback function for settings that just need to output <input type="text">.
function sso_for_azure_ad_options_textinput( $option, $size = 30, $password = false ) {
    $setting = get_option( $option );

    ?>
        <input type="<?php print( esc_attr( $password ? 'password' : 'text' ) ); ?>" id="<?php print( esc_attr( $option ) ); ?>" name="<?php print( esc_attr( $option ) ); ?>" size="<?php print( esc_attr( $size ) ); ?>" value="<?php print( esc_attr( $setting ) ); ?>" />
    <?php

    sso_for_azure_ad_options_description( $option );
}

// A callback function for settings that just need to output <input type="checkbox">.
function sso_for_azure_ad_options_checkbox( $option ) {
    $setting = get_option( $option );

    ?>
        <input type="checkbox" id="<?php print( esc_attr( $option ) ); ?>" name="<?php print( esc_attr( $option ) ); ?>" <?php checked( $setting ) ?> />
    <?php

    sso_for_azure_ad_options_description( $option );
}


// Section: sso_for_azure_ad_options_endpoints

function sso_for_azure_ad_options_endpoints() {
    ?>
        <table style="border: none;">
            <tr>
                <td> <?php esc_html_e( 'Redirect URL', 'sso-for-azure-ad' ); ?> </td>
                <td> <code><?php print( esc_html( sso_for_azure_ad_endpoint_url( 'callback' ) ) ); ?></code> </td>
            </tr>
            <tr>
                <td> <?php esc_html_e( 'Homepage/Login URL', 'sso-for-azure-ad' ); ?> </td>
                <td> <code><?php print( esc_html( sso_for_azure_ad_endpoint_url( 'start' ) ) ); ?></code> </td>
            </tr>
        </table>
    <?php
}

function sso_for_azure_ad_options_endpoints_enable_rewrites() {
    $current_value = get_option( 'sso_for_azure_ad_enable_rewrites', false );

    ?>
        <input type="checkbox" id="sso_for_azure_ad_enable_rewrites" name="sso_for_azure_ad_enable_rewrites" <?php checked( $current_value ) ?> <?php disabled( !got_url_rewrite() ) ?> />
    <?php

    sso_for_azure_ad_options_description( 'sso_for_azure_ad_enable_rewrites' );
}


// Section: sso_for_azure_ad_options_oauth

function sso_for_azure_ad_options_oauth() {
    /* translators: Description for the "OAuth options" section in the plugin options page. */
    print( '<p>' . esc_html__( 'Configure your OAuth application properties.', 'sso-for-azure-ad' ) . '</p>' );
}

function sso_for_azure_ad_options_oauth_client_id() {
    sso_for_azure_ad_options_textinput( 'sso_for_azure_ad_client_id', 50 );
}

function sso_for_azure_ad_options_oauth_client_secret() {
    sso_for_azure_ad_options_textinput( 'sso_for_azure_ad_client_secret', 50, true );
}

function sso_for_azure_ad_options_oauth_tenant_id() {
    sso_for_azure_ad_options_textinput( 'sso_for_azure_ad_tenant_id', 50 );
}


// Section: sso_for_azure_ad_options_login

function sso_for_azure_ad_options_login() {
    /* translators: Description for the "Login options" section in the plugin options page. */
    print( '<p>' . esc_html__( 'Configure login behavior for your site.', 'sso-for-azure-ad' ) . '</p>' );
}

function sso_for_azure_ad_options_login_create_users() {
    sso_for_azure_ad_options_checkbox( 'sso_for_azure_ad_create_users' );
}

function sso_for_azure_ad_options_login_populate_new_profiles() {
    sso_for_azure_ad_options_checkbox( 'sso_for_azure_ad_populate_new_profiles' );
}

function sso_for_azure_ad_options_login_new_usernames_no_domain() {
    sso_for_azure_ad_options_checkbox( 'sso_for_azure_ad_new_usernames_no_domain' );
}

function sso_for_azure_ad_options_login_login_button_text() {
    sso_for_azure_ad_options_textinput( 'sso_for_azure_ad_login_button_text' );
}


// Action: admin_init

// General sanitizer for UUIDs
function sso_for_azure_ad_options_sanitizeuuid( $option = '', $also_valid = array() ) {
    // The $also_valid variable contains extra values that, while not UUIDs, should still be accepted by the sanitizer.
    // These values must be in lowercase, otherwise they will never match.

    $sanitized = $option;

    if ( ! is_string( $sanitized ) ) {
        $sanitized = '';
    }

    $sanitized = strtolower( $sanitized );

    if ( in_array( $sanitized, $also_valid ) ) {
        return $sanitized;
    }

    if (
        substr( $sanitized, 0, 1 ) == '{'
        && substr( $sanitized, -1, 1 ) == '}'
    ) {
        // Sometimes UUIDs are typed with curly brackets around them, like {xxxx}
        // If this is the case, these brackets must be removed.
        $sanitized = substr(
            $sanitized,
            1, // Remove the first character
            strlen( $sanitized ) - 2 // Remove the last character (subtracting two because the first character is also removed)
        );
    }

    if ( wp_is_uuid( $sanitized ) ) {
        return $sanitized;
    } else {
        // Value is invalid, return an empty string.
        return '';
    }
}

function sso_for_azure_ad_options_sanitize_enable_rewrites( $option ) {
    // If rewrites are not supported the only acceptable value for this option is false

    if ( got_url_rewrite() ) {
        return filter_var( $option, FILTER_VALIDATE_BOOLEAN );
    } else {
        return false;
    }
}

function sso_for_azure_ad_options_sanitize_client_id( $option ) {
    return sso_for_azure_ad_options_sanitizeuuid( $option );
}

function sso_for_azure_ad_options_sanitize_client_secret( $option ) {
    if ( is_string( $option ) ) {
        return $option;
    } else {
        return '';
    }
}

function sso_for_azure_ad_options_sanitize_tenant_id( $option ) {
    return sso_for_azure_ad_options_sanitizeuuid( $option , array(
        'common', 'organizations', 'consumers'
    ) );
}

function sso_for_azure_ad_options_sanitize_create_users( $option ) {
    return filter_var( $option, FILTER_VALIDATE_BOOLEAN );
}

function sso_for_azure_ad_options_sanitize_populate_new_profiles( $option ) {
    return filter_var( $option, FILTER_VALIDATE_BOOLEAN );
}

function sso_for_azure_ad_options_sanitize_new_usernames_no_domain( $option ) {
    return filter_var( $option, FILTER_VALIDATE_BOOLEAN );
}

function sso_for_azure_ad_options_sanitize_login_button_text( $option ) {
    global $wp_registered_settings;

    if ( is_string( $option ) ) {
        $sanitized = sanitize_text_field( $option );
        if ( $sanitized == '' ) {
            return $wp_registered_settings['sso_for_azure_ad_login_button_text']['default'];
        } else {
            return $sanitized;
        }
    } else {
        return $wp_registered_settings['sso_for_azure_ad_login_button_text']['default'];
    }
}

function sso_for_azure_ad_options_admin_init() {
    register_setting(
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_enable_rewrites',
        array(
            'type'              => 'string',
            /* translators: Description for the "Use rewrites" option. */
            'description'       => __( 'Use URLs with rewrites instead of URLs with query strings.', 'sso-for-azure-ad' ),
            'sanitize_callback' => 'sso_for_azure_ad_options_sanitize_enable_rewrites',
            'default'           => ''
        )
    );
    register_setting(
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_client_id',
        array(
            'type'              => 'string',
            /* translators: Description for the "Application (client) ID" option. */
            'description'       => __( 'Application (client) ID of your app registration in Azure AD.', 'sso-for-azure-ad' ),
            'sanitize_callback' => 'sso_for_azure_ad_options_sanitize_client_id',
            'default'           => ''
        )
    );
    register_setting(
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_client_secret',
        array(
            'type'              => 'string',
            /* translators: Description for the "Client secret" option. */
            'description'       => __( 'A client secret for your app registration in Azure AD.', 'sso-for-azure-ad' ),
            'sanitize_callback' => 'sso_for_azure_ad_options_sanitize_client_secret',
            'default'           => '',
            'show_in_rest'      => false
        )
    );
    register_setting(
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_tenant_id',
        array(
            'type'              => 'string',
            /* translators: Description for the "Directory (tenant) ID" option. Do not translate the values in double quotes ("common", "organizations", "consumers"). */
            'description'       => __( 'The ID of your Azure tenant, or one of the following values: "common", "organizations", "consumers".', 'sso-for-azure-ad' ),
            'sanitize_callback' => 'sso_for_azure_ad_options_sanitize_tenant_id',
            'default'           => ''
        )
    );
    register_setting(
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_create_users',
        array(
            'type'              => 'boolean',
            /* translators: Description for the "Create new users if they don't already exist" option. */
            'description'       => __( 'If enabled, users that attempt to log in with Azure SSO will be created if they don\'t exist on this site. They will be assigned the default WordPress role for new signups.', 'sso-for-azure-ad' ),
            'sanitize_callback' => 'sso_for_azure_ad_options_sanitize_create_users',
            'default'           => false
        )
    );
    register_setting(
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_populate_new_profiles',
        array(
            'type'              => 'boolean',
            /* translators: Description for the "Generate user profile automatically" option. */
            'description'       => __( 'If enabled, new site accounts created by the plugin will be populated with the user\'s details from their Microsoft profile.', 'sso-for-azure-ad' ),
            'sanitize_callback' => 'sso_for_azure_ad_options_sanitize_populate_new_profiles',
            'default'           => false
        )
    );
    register_setting(
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_new_usernames_no_domain',
        array(
            'type'              => 'boolean',
            /* translators: Description for the "Create usernames without domain name" option. */
            'description'       => __( 'If enabled, the username for new site accounts created by the plugin will not include the domain name. Enabling this feature may cause conflicts, only enable if you only use one domain.', 'sso-for-azure-ad' ),
            'sanitize_callback' => 'sso_for_azure_ad_options_sanitize_new_usernames_no_domain',
            'default'           => false
        )
    );
    register_setting(
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_login_button_text',
        array(
            'type'              => 'boolean',
            /* translators: Description for the "Login button text" option. */
            'description'       => __( 'Text for the button on the login form to login with Azure AD. Leave empty to reset the default value.', 'sso-for-azure-ad' ),
            'sanitize_callback' => 'sso_for_azure_ad_options_sanitize_login_button_text',
            /* translators: Default text for the login button */
            'default'           => __( 'Sign in with Azure AD', 'sso-for-azure-ad' )
        )
    );

    add_settings_section(
        'sso_for_azure_ad_options_endpoints',
        /* translators: Title of the "Endpoints" section in the plugin options page. */
        __( 'Endpoints', 'sso-for-azure-ad' ),
        'sso_for_azure_ad_options_endpoints',
        'sso_for_azure_ad_options'
    );
    add_settings_field(
        'sso_for_azure_ad_enable_rewrites',
        /* translators: Label for the "Use rewrites" option. */
        __( 'Use rewrites', 'sso-for-azure-ad' ),
        'sso_for_azure_ad_options_endpoints_enable_rewrites',
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_options_endpoints',
        [
            'label_for' => 'sso_for_azure_ad_enable_rewrites'
        ]
    );

    add_settings_section(
        'sso_for_azure_ad_options_oauth',
        /* translators: Title of the "OAuth options" section in the plugin options page. */
        __( 'OAuth options', 'sso-for-azure-ad' ),
        'sso_for_azure_ad_options_oauth',
        'sso_for_azure_ad_options'
    );
    add_settings_field(
        'sso_for_azure_ad_client_id',
        /* translators: Label for the "Application (client) ID" option. */
        __( 'Application (client) ID', 'sso-for-azure-ad' ),
        'sso_for_azure_ad_options_oauth_client_id',
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_options_oauth',
        [
            'label_for' => 'sso_for_azure_ad_client_id'
        ]
    );
    add_settings_field(
        'sso_for_azure_ad_client_secret',
        /* translators: Label for the "Client secret" option. */
        __( 'Client secret', 'sso-for-azure-ad' ),
        'sso_for_azure_ad_options_oauth_client_secret',
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_options_oauth',
        [
            'label_for' => 'sso_for_azure_ad_client_secret'
        ]
    );
    add_settings_field(
        'sso_for_azure_ad_tenant_id',
        /* translators: Label for the "Directory (tenant) ID" option. */
        __( 'Directory (tenant) ID', 'sso-for-azure-ad' ),
        'sso_for_azure_ad_options_oauth_tenant_id',
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_options_oauth',
        [
            'label_for' => 'sso_for_azure_ad_tenant_id'
        ]
    );

    add_settings_section(
        'sso_for_azure_ad_options_login',
        /* translators: Title of the "Login options" section in the plugin options page. */
        __( 'Login options', 'sso-for-azure-ad' ),
        'sso_for_azure_ad_options_login',
        'sso_for_azure_ad_options'
    );
    add_settings_field(
        'sso_for_azure_ad_create_users',
        /* translators: Label for the "Create new users if they don't already exist" option. */
        __( 'Create new users if they don\'t already exist', 'sso-for-azure-ad' ),
        'sso_for_azure_ad_options_login_create_users',
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_options_login',
        [
            'label_for' => 'sso_for_azure_ad_create_users'
        ]
    );
    add_settings_field(
        'sso_for_azure_ad_populate_new_profiles',
        /* translators: Label for the "Generate user profiles automatically" option. */
        __( 'Generate user profiles automatically', 'sso-for-azure-ad' ),
        'sso_for_azure_ad_options_login_populate_new_profiles',
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_options_login',
        [
            'label_for' => 'sso_for_azure_ad_populate_new_profiles'
        ]
    );
    add_settings_field(
        'sso_for_azure_ad_new_usernames_no_domain',
        /* translators: Label for the "Create usernames without domain name" option. */
        __( 'Create usernames without domain name', 'sso-for-azure-ad' ),
        'sso_for_azure_ad_options_login_new_usernames_no_domain',
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_options_login',
        [
            'label_for' => 'sso_for_azure_ad_options_login_new_usernames_no_domain'
        ]
    );
    add_settings_field(
        'sso_for_azure_ad_login_button_text',
        /* translators: Label for the "Login button text" option. */
        __( 'Login button text', 'sso-for-azure-ad' ),
        'sso_for_azure_ad_options_login_login_button_text',
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_options_login',
        [
            'label_for' => 'sso_for_azure_ad_login_button_text'
        ]
    );
}


// Action: admin_menu

function sso_for_azure_ad_options_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    settings_errors( 'wporg_messages' );

    ?>
        <div class="wrap">
        <h1><?php print( esc_html( get_admin_page_title() ) ); ?></h1>
        <form action="options.php" method="post">
    <?php

    settings_fields( 'sso_for_azure_ad_options' );
    do_settings_sections( 'sso_for_azure_ad_options' );
    submit_button();

    ?>
        </form>
        </div>
    <?php
}

function sso_for_azure_ad_options_admin_menu() {
    add_options_page(
        /* translators: Title of the options page. */
        __( 'SSO for Azure AD options', 'sso-for-azure-ad' ),
        __( 'SSO for Azure AD', 'sso-for-azure-ad' ),
        'manage_options',
        'sso_for_azure_ad_options',
        'sso_for_azure_ad_options_page'
    );
}


// Register actions

if ( is_admin() ) {
    add_action( 'admin_init', 'sso_for_azure_ad_options_admin_init' );
    add_action( 'admin_menu', 'sso_for_azure_ad_options_admin_menu' );
}