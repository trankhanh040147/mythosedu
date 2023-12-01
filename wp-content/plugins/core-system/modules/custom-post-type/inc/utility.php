<?php
/**
 * Custom Post Type Utility Code.
 *
 * @package CPT
 * @subpackage Utility
 * @author #
 * @since 1.3.0
 * @license GPL-2.0+
 */

// phpcs:disable #.All.RequireAuthor

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Returns SVG icon for custom menu icon
 *
 * @since 1.2.0
 *
 * @return string
 */
function cpt_menu_icon() {
	return 'dashicons-forms';
}

/**
 * Return boolean status depending on passed in value.
 *
 * @since 0.5.0
 *
 * @param mixed $bool_text text to compare to typical boolean values.
 * @return bool Which bool value the passed in value was.
 */
function get_disp_boolean( $bool_text ) {
	$bool_text = (string) $bool_text;
	if ( empty( $bool_text ) || '0' === $bool_text || 'false' === $bool_text ) {
		return false;
	}

	return true;
}

/**
 * Return string versions of boolean values.
 *
 * @since 0.1.0
 *
 * @param string $bool_text String boolean value.
 * @return string standardized boolean text.
 */
function disp_boolean( $bool_text ) {
	$bool_text = (string) $bool_text;
	if ( empty( $bool_text ) || '0' === $bool_text || 'false' === $bool_text ) {
		return 'false';
	}

	return 'true';
}

/**
 * Conditionally flushes rewrite rules if we have reason to.
 *
 * @since 1.3.0
 */
function cpt_flush_rewrite_rules() {

	if ( wp_doing_ajax() ) {
		return;
	}

	/*
	 * Wise men say that you should not do flush_rewrite_rules on init or admin_init. Due to the nature of our plugin
	 * and how new post types or taxonomies can suddenly be introduced, we need to...potentially. For this,
	 * we rely on a short lived transient. Only 5 minutes life span. If it exists, we do a soft flush before
	 * deleting the transient to prevent subsequent flushes. The only times the transient gets created, is if
	 * post types or taxonomies are created, updated, deleted, or imported. Any other time and this condition
	 * should not be met.
	 */
	if ( 'true' === ( $flush_it = get_transient( 'cpt_flush_rewrite_rules' ) ) ) {
		flush_rewrite_rules( false );
		// So we only run this once.
		delete_transient( 'cpt_flush_rewrite_rules' );
	}
}
add_action( 'admin_init', 'cpt_flush_rewrite_rules' );

/**
 * Return the current action being done within CPT context.
 *
 * @since 1.3.0
 *
 * @return string Current action being done by CPT
 */
function cpt_get_current_action() {
	$current_action = '';
	if ( ! empty( $_GET ) && isset( $_GET['action'] ) ) {
		$current_action .= esc_textarea( $_GET['action'] );
	}

	return $current_action;
}

/**
 * Return an array of all post type slugs from Custom Post Type.
 *
 * @since 1.3.0
 *
 * @return array CPT post type slugs.
 */
function cpt_get_post_type_slugs() {
	$post_types = get_option( 'cpt_post_types' );
	if ( ! empty( $post_types ) ) {
		return array_keys( $post_types );
	}
	return [];
}

/**
 * Return an array of all taxonomy slugs from Custom Post Type.
 *
 * @since 1.3.0
 *
 * @return array CPT taxonomy slugs.
 */
function cpt_get_taxonomy_slugs() {
	$taxonomies = get_option( 'cpt_taxonomies' );
	if ( ! empty( $taxonomies ) ) {
		return array_keys( $taxonomies );
	}
	return [];
}

/**
 * Return the appropriate admin URL depending on our context.
 *
 * @since 1.3.0
 *
 * @param string $path URL path.
 * @return string
 */
function cpt_admin_url( $path ) {
	if ( is_multisite() && is_network_admin() ) {
		return network_admin_url( $path );
	}

	return admin_url( $path );
}

/**
 * Construct action tag for `<form>` tag.
 *
 * @since 1.3.0
 *
 * @param object|string $ui CPT Admin UI instance. Optional. Default empty string.
 * @return string
 */
function cpt_get_post_form_action( $ui = '' ) {
	/**
	 * Filters the string to be used in an `action=""` attribute.
	 *
	 * @since 1.3.0
	 */
	return apply_filters( 'cpt_post_form_action', '', $ui );
}

/**
 * Display action tag for `<form>` tag.
 *
 * @since 1.3.0
 *
 * @param object $ui CPT Admin UI instance.
 */
function cpt_post_form_action( $ui ) {
	echo esc_attr( cpt_get_post_form_action( $ui ) );
}

/**
 * Fetch our CPT post types option.
 *
 * @since 1.3.0
 *
 * @return mixed
 */
function cpt_get_post_type_data() {
	return apply_filters( 'cpt_get_post_type_data', get_option( 'cpt_post_types', [] ), get_current_blog_id() );
}

/**
 * Fetch our CPT taxonomies option.
 *
 * @since 1.3.0
 *
 * @return mixed
 */
function cpt_get_taxonomy_data() {
	return apply_filters( 'cpt_get_taxonomy_data', get_option( 'cpt_taxonomies', [] ), get_current_blog_id() );
}

/**
 * Checks if a post type is already registered.
 *
 * @since 1.3.0
 *
 * @param string       $slug Post type slug to check. Optional. Default empty string.
 * @param array|string $data Post type data being utilized. Optional.
 * @return mixed
 */
function cpt_get_post_type_exists( $slug = '', $data = [] ) {

	/**
	 * Filters the boolean value for if a post type exists for 3rd parties.
	 *
	 * @since 1.3.0
	 *
	 * @param string       $slug Post type slug to check.
	 * @param array|string $data Post type data being utilized.
	 */
	return apply_filters( 'cpt_get_post_type_exists', post_type_exists( $slug ), $data );
}

/**
 * Checks if a taxonomy is already registered.
 *
 * @since 1.6.0
 *
 * @param string       $slug Taxonomy slug to check. Optional. Default empty string.
 * @param array|string $data Taxonomy data being utilized. Optional.
 *
 * @return mixed
 */
function cpt_get_taxonomy_exists( $slug = '', $data = [] ) {

	/**
	 * Filters the boolean value for if a taxonomy exists for 3rd parties.
	 *
	 * @since 1.6.0
	 *
	 * @param string       $slug Taxonomy slug to check.
	 * @param array|string $data Taxonomy data being utilized.
	 */
	return apply_filters( 'cpt_get_taxonomy_exists', taxonomy_exists( $slug ), $data );
}

/**
 * Secondary admin notices function for use with admin_notices hook.
 *
 * Constructs admin notice HTML.
 *
 * @since 1.4.0
 *
 * @param string $message Message to use in admin notice. Optional. Default empty string.
 * @param bool   $success Whether or not a success. Optional. Default true.
 * @return mixed
 */
function cpt_admin_notices_helper( $message = '', $success = true ) {

	$class   = [];
	$class[] = $success ? 'updated' : 'error';
	$class[] = 'notice is-dismissible';

	$messagewrapstart = '<div id="message" class="' . implode( ' ', $class ) . '"><p>';

	$messagewrapend = '</p></div>';

	$action = '';

	/**
	 * Filters the custom admin notice for CPT.
	 *
	 * @since 1.0.0
	 *
	 * @param string $value            Complete HTML output for notice.
	 * @param string $action           Action whose message is being generated.
	 * @param string $message          The message to be displayed.
	 * @param string $messagewrapstart Beginning wrap HTML.
	 * @param string $messagewrapend   Ending wrap HTML.
	 */
	return apply_filters( 'cpt_admin_notice', $messagewrapstart . $message . $messagewrapend, $action, $message, $messagewrapstart, $messagewrapend );
}

/**
 * Grab post type or taxonomy slug from $_POST global, if available.
 *
 * @since 1.4.0
 *
 * @internal
 *
 * @return string
 */
function cpt_get_object_from_post_global() {
	if ( isset( $_POST['cpt_custom_post_type']['name'] ) ) {
		return sanitize_text_field( $_POST['cpt_custom_post_type']['name'] );
	}

	if ( isset( $_POST['cpt_custom_tax']['name'] ) ) {
		return sanitize_text_field( $_POST['cpt_custom_tax']['name'] );
	}

	return esc_html__( 'Object', CPT_LANG );
}

/**
 * Successful add callback.
 *
 * @since 1.4.0
 */
function cpt_add_success_admin_notice() {
	echo cpt_admin_notices_helper(
		sprintf(
			esc_html__( '%s has been successfully added', CPT_LANG ),
			cpt_get_object_from_post_global()
		)
	);
}

/**
 * Fail to add callback.
 *
 * @since 1.4.0
 */
function cpt_add_fail_admin_notice() {
	echo cpt_admin_notices_helper(
		sprintf(
			esc_html__( '%s has failed to be added', CPT_LANG ),
			cpt_get_object_from_post_global()
		),
		false
	);
}

/**
 * Successful update callback.
 *
 * @since 1.4.0
 */
function cpt_update_success_admin_notice() {
	echo cpt_admin_notices_helper(
		sprintf(
			esc_html__( '%s has been successfully updated', CPT_LANG ),
			cpt_get_object_from_post_global()
		)
	);
}

/**
 * Fail to update callback.
 *
 * @since 1.4.0
 */
function cpt_update_fail_admin_notice() {
	echo cpt_admin_notices_helper(
		sprintf(
			esc_html__( '%s has failed to be updated', CPT_LANG ),
			cpt_get_object_from_post_global()
		),
		false
	);
}

/**
 * Successful delete callback.
 *
 * @since 1.4.0
 */
function cpt_delete_success_admin_notice() {
	echo cpt_admin_notices_helper(
		sprintf(
			esc_html__( '%s has been successfully deleted', CPT_LANG ),
			cpt_get_object_from_post_global()
		)
	);
}

/**
 * Fail to delete callback.
 *
 * @since 1.4.0
 */
function cpt_delete_fail_admin_notice() {
	echo cpt_admin_notices_helper(
		sprintf(
			esc_html__( '%s has failed to be deleted', CPT_LANG ),
			cpt_get_object_from_post_global()
		),
		false
	);
}

/**
 * Success to import callback.
 *
 * @since 1.5.0
 */
function cpt_import_success_admin_notice() {
	echo cpt_admin_notices_helper(
		esc_html__( 'Successfully imported data.', CPT_LANG )
	);
}

/**
 * Failure to import callback.
 *
 * @since 1.5.0
 */
function cpt_import_fail_admin_notice() {
	echo cpt_admin_notices_helper(
		esc_html__( 'Invalid data provided', CPT_LANG ),
		false
	);
}

function cpt_nonce_fail_admin_notice() {
	echo cpt_admin_notices_helper(
		esc_html__( 'Nonce failed verification', CPT_LANG ),
		false
	);
}

/**
 * Returns error message for if trying to register existing post type.
 *
 * @since 1.4.0
 *
 * @return string
 */
function cpt_slug_matches_post_type() {
	return sprintf(
		esc_html__( 'Please choose a different post type name. %s is already registered.', CPT_LANG ),
		cpt_get_object_from_post_global()
	);
}

/**
 * Returns error message for if trying to register existing taxonomy.
 *
 * @since 1.4.0
 *
 * @return string
 */
function cpt_slug_matches_taxonomy() {
	return sprintf(
		esc_html__( 'Please choose a different taxonomy name. %s is already registered.', CPT_LANG ),
		cpt_get_object_from_post_global()
	);
}

/**
 * Returns error message for if not providing a post type to associate taxonomy to.
 *
 * @since 1.6.0
 *
 * @return string
 */
function cpt_empty_cpt_on_taxonomy() {
	return esc_html__( 'Please provide a post type to attach to.', CPT_LANG );
}

/**
 * Returns error message for if trying to register post type with matching page slug.
 *
 * @since 1.4.0
 *
 * @return string
 */
function cpt_slug_matches_page() {
	return sprintf(
		esc_html__( 'Please choose a different post type name. %s matches an existing page slug, which can cause conflicts.', CPT_LANG ),
		cpt_get_object_from_post_global()
	);
}

/**
 * Returns error message for if trying to use quotes in slugs or rewrite slugs.
 *
 * @since 1.4.0
 *
 * @return string
 */
function cpt_slug_has_quotes() {
	return sprintf(
		esc_html__( 'Please do not use quotes in post type/taxonomy names or rewrite slugs', CPT_LANG ),
		cpt_get_object_from_post_global()
	);
}

/**
 * Error admin notice.
 *
 * @since 1.4.0
 */
function cpt_error_admin_notice() {
	echo cpt_admin_notices_helper(
		apply_filters( 'cpt_custom_error_message', '' ),
		false
	);
}

/**
 * Mark site as not a new CPT install upon update to 1.5.0
 *
 * @since 1.5.0
 *
 * @param object $wp_upgrader WP_Upgrader instance.
 * @param array  $extras      Extra information about performed upgrade.
 */
function cpt_not_new_install( $wp_upgrader, $extras ) {

	if ( $wp_upgrader instanceof \Plugin_Upgrader ) {
		return;
	}

	if ( ! array_key_exists( 'plugins', $extras ) || ! is_array( $extras['plugins'] ) ) {
		return;
	}

	// If we are already known as not new, return.
	if ( cpt_is_new_install() ) {
		return;
	}

	// We need to mark ourselves as not new.
	cpt_set_not_new_install();
}
add_action( 'upgrader_process_complete', 'cpt_not_new_install', 10, 2 );

/**
 * Check whether or not we're on a new install.
 *
 * @since 1.5.0
 *
 * @return bool
 */
function cpt_is_new_install() {
	$new_or_not = true;
	$saved      = get_option( 'cpt_new_install', '' );

	if ( 'false' === $saved ) {
		$new_or_not = false;
	}

	/**
	 * Filters the new install status.
	 *
	 * Offers third parties the ability to override if they choose to.
	 *
	 * @since 1.5.0
	 *
	 * @param bool $new_or_not Whether or not site is a new install.
	 */
	return (bool) apply_filters( 'cpt_is_new_install', $new_or_not );
}

/**
 * Set our activation status to not new.
 *
 * @since 1.5.0
 */
function cpt_set_not_new_install() {
	update_option( 'cpt_new_install', 'false' );
}

/**
 * Returns saved values for single post type from CPT settings.
 *
 * @since 1.5.0
 *
 * @param string $post_type Post type to retrieve CPT object for.
 * @return string
 */
function cpt_get_cpt_post_type_object( $post_type = '' ) {
	$post_types = get_option( 'cpt_post_types' );

	if ( array_key_exists( $post_type, $post_types ) ) {
		return $post_types[ $post_type ];
	}
	return '';
}

/**
 * Returns saved values for single taxonomy from CPT settings.
 *
 * @since 1.5.0
 *
 * @param string $taxonomy Taxonomy to retrieve CPT object for.
 * @return string
 */
function cpt_get_cpt_taxonomy_object( $taxonomy = '' ) {
	$taxonomies = get_option( 'cpt_taxonomies' );

	if ( array_key_exists( $taxonomy, $taxonomies ) ) {
		return $taxonomies[ $taxonomy ];
	}
	return '';
}

/**
 * Checks if a requested post type has a custom CPT feature supported.
 *
 * @since 1.5.0
 *
 * @param string $post_type Post type slug.
 * @param string $feature   Feature to check for.
 * @return bool
 */
function cpt_post_type_supports( $post_type, $feature ) {

	$object = cpt_get_cpt_post_type_object( $post_type );

	if ( ! empty( $object ) ) {
		if ( array_key_exists( $feature, $object ) && ! empty( $object[ $feature ] ) ) {
			return true;
		}

		return false;
	}

	return false;
}

/**
 * Add missing post_format taxonomy support for CPT post types.
 *
 * Addresses bug wih previewing changes for published posts with post types that
 * have post-formats support.
 *
 * @since 1.5.8
 *
 * @param array $post_types Array of CPT post types.
 */
function cpt_published_post_format_fix( $post_types ) {
	foreach ( $post_types as $type ) {
		if ( in_array( 'post-formats', $type['supports'], true ) ) {
			add_post_type_support( $type['name'], 'post-formats' );
			register_taxonomy_for_object_type( 'post_format', $type['name'] );
		}
	}
}
add_action( 'cpt_post_register_post_types', 'cpt_published_post_format_fix' );

/**
 * Return a ready-to-use admin url for adding a new content type.
 *
 * @since 1.7.0
 *
 * @param string $content_type Content type to link to.
 * @return string
 */
function cpt_get_add_new_link( $content_type = '' ) {
	if ( ! in_array( $content_type, [ 'post_types', 'taxonomies' ] ) ) {
		return cpt_admin_url( 'admin.php?page=cpt_manage_post_types' );
	}

	return cpt_admin_url( 'admin.php?page=cpt_manage_' . $content_type );
}
