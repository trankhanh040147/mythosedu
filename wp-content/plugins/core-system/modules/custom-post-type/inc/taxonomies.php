<?php
/**
 * Custom Post Type Taxonomy Settings.
 *
 * @package CPT
 * @subpackage Taxonomies
 * @author #
 * @since 1.0.0
 * @license GPL-2.0+
 */

// phpcs:disable #.All.RequireAuthor

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add our cpt.js file, with dependencies on jQuery and jQuery UI.
 *
 * @since 1.0.0
 *
 * @internal
 */
function cpt_taxonomies_enqueue_scripts() {

	$current_screen = get_current_screen();

	if ( ! is_object( $current_screen ) || 'cpt_page_cpt_manage_taxonomies' !== $current_screen->base ) {
		return;
	}

	if ( wp_doing_ajax() ) {
		return;
	}

	wp_enqueue_script( 'cpt' );
	wp_enqueue_style( 'cpt-css' );

	$core                  = get_taxonomies( [ '_builtin' => true ] );
	$public                = get_taxonomies( [
		'_builtin' => false,
		'public'   => true,
	] );
	$private               = get_taxonomies( [
		'_builtin' => false,
		'public'   => false,
	] );
	$registered_taxonomies = array_merge( $core, $public, $private );
	wp_localize_script( 'cpt', 'cpt_tax_data',
		[
			'confirm'             => esc_html__( 'Are you sure you want to delete this? Deleting will NOT remove created content.', CPT_LANG ),
			'no_associated_type'  => esc_html__( 'Please select a post type to associate with.', CPT_LANG ),
			'existing_taxonomies' => $registered_taxonomies,
		]
	);
}
add_action( 'admin_enqueue_scripts', 'cpt_taxonomies_enqueue_scripts' );

/**
 * Register our tabs for the Taxonomy screen.
 *
 * @since 1.3.0
 *
 * @internal
 *
 * @param array  $tabs         Array of tabs to display. Optional.
 * @param string $current_page Current page being shown. Optional. Default empty string.
 * @return array Amended array of tabs to show.
 */
function cpt_taxonomy_tabs( $tabs = [], $current_page = '' ) {

	if ( 'taxonomies' === $current_page ) {
		$taxonomies = cpt_get_taxonomy_data();
		$classes    = [ 'nav-tab' ];

		$tabs['page_title']  = get_admin_page_title();
		$tabs['tabs']        = [];
		$tabs['tabs']['add'] = [ // Start out with our basic "Add new" tab.
			'text'          => esc_html__( 'Add New Taxonomy', CPT_LANG ),
			'classes'       => $classes,
			'url'           => cpt_admin_url( 'admin.php?page=cpt_manage_' . $current_page ),
			'aria-selected' => 'false',
		];

		$action = cpt_get_current_action();
		if ( empty( $action ) ) {
			$tabs['tabs']['add']['classes'][]     = 'nav-tab-active';
			$tabs['tabs']['add']['aria-selected'] = 'true';
		}

		if ( ! empty( $taxonomies ) ) {

			if ( ! empty( $action ) ) {
				$classes[] = 'nav-tab-active';
			}
			$tabs['tabs']['edit'] = [
				'text'          => esc_html__( 'Edit Taxonomies', CPT_LANG ),
				'classes'       => $classes,
				'url'           => esc_url( add_query_arg( [ 'action' => 'edit' ], cpt_admin_url( 'admin.php?page=cpt_manage_' . $current_page ) ) ),
				'aria-selected' => ! empty( $action ) ? 'true' : 'false',
			];

			$tabs['tabs']['view'] = [
				'text'          => esc_html__( 'View Taxonomies', CPT_LANG ),
				'classes'       => [ 'nav-tab' ], // Prevent notices.
				'url'           => esc_url( cpt_admin_url( 'admin.php?page=cpt_listings#taxonomies' ) ),
				'aria-selected' => 'false',
			];

			$tabs['tabs']['export'] = [
				'text'          => esc_html__( 'Import/Export Taxonomies', CPT_LANG ),
				'classes'       => [ 'nav-tab' ], // Prevent notices.
				'url'           => esc_url( cpt_admin_url( 'admin.php?page=cpt_tools&action=taxonomies' ) ),
				'aria-selected' => 'false',
			];
		}
	}

	return $tabs;
}

add_filter( 'cpt_get_tabs', 'cpt_taxonomy_tabs', 10, 2 );

/**
 * Create our settings page output.
 *
 * @since 1.0.0
 *
 * @internal
 */
function cpt_manage_taxonomies() {

	$tab       = ( ! empty( $_GET ) && ! empty( $_GET['action'] ) && 'edit' == $_GET['action'] ) ? 'edit' : 'new';
	$tab_class = 'cpt-' . $tab;
	$current   = null;
	?>

	<div class="wrap <?php echo esc_attr( $tab_class ); ?>">

	<?php
	/**
	 * Fires right inside the wrap div for the taxonomy editor screen.
	 *
	 * @since 1.3.0
	 */
	do_action( 'cpt_inside_taxonomy_wrap' );

	/**
	 * Filters whether or not a taxonomy was deleted.
	 *
	 * @since 1.4.0
	 *
	 * @param bool $value Whether or not taxonomy deleted. Default false.
	 */
	$taxonomy_deleted = apply_filters( 'cpt_taxonomy_deleted', false );

	// Create our tabs.
	cpt_settings_tab_menu( 'taxonomies' );

	/**
	 * Fires below the output for the tab menu on the taxonomy add/edit screen.
	 *
	 * @since 1.3.0
	 */
	do_action( 'cpt_below_taxonomy_tab_menu' );

	if ( 'edit' === $tab ) {

		$taxonomies = cpt_get_taxonomy_data();

		$selected_taxonomy = cpt_get_current_taxonomy( $taxonomy_deleted );

		if ( $selected_taxonomy && array_key_exists( $selected_taxonomy, $taxonomies ) ) {
			$current = $taxonomies[ $selected_taxonomy ];
		}
	}

	$ui = new cpt_admin_ui();

	// Will only be set if we're already on the edit screen.
	if ( ! empty( $taxonomies ) ) {
		?>
		<form id="cpt_select_taxonomy" method="post" action="<?php echo esc_url( cpt_get_post_form_action( $ui ) ); ?>">
			<label for="taxonomy"><?php esc_html_e( 'Select: ', CPT_LANG ); ?></label>
			<?php
			cpt_taxonomies_dropdown( $taxonomies );

			wp_nonce_field( 'cpt_select_taxonomy_nonce_action', 'cpt_select_taxonomy_nonce_field' );

			/**
			 * Filters the text value to use on the select taxonomy button.
			 *
			 * @since 1.0.0
			 *
			 * @param string $value Text to use for the button.
			 */
			?>
			<input type="submit" class="button-secondary" id="cpt_select_taxonomy_submit" name="cpt_select_taxonomy_submit" value="<?php echo esc_attr( apply_filters( 'cpt_taxonomy_submit_select', esc_attr__( 'Select', CPT_LANG ) ) ); ?>" />
		</form>
	<?php

		/**
		 * Fires below the taxonomy select input.
		 *
		 * @since 1.1.0
		 *
		 * @param string $value Current taxonomy selected.
		 */
		do_action( 'cpt_below_taxonomy_select', $current['name'] );
	}
	?>

	<form class="taxonomiesui" method="post" action="<?php echo esc_url( cpt_get_post_form_action( $ui ) ); ?>">
		<div class="postbox-container">
		<div id="poststuff">
			<div class="cpt-section postbox">
				<button type="button" class="handlediv button-link" aria-expanded="true">
					<span class="screen-reader-text"><?php esc_html_e( 'Toggle panel: Basic settings', CPT_LANG ); ?></span>
					<span class="toggle-indicator" aria-hidden="true"></span>
				</button>
				<h2 class="hndle">
					<span><?php esc_html_e( 'Basic settings', CPT_LANG ); ?></span>
				</h2>
				<div class="inside">
					<div class="main">
						<table class="form-table cpt-table">
							<?php
							echo $ui->get_tr_start() . $ui->get_th_start();
							echo $ui->get_label( 'name', esc_html__( 'Taxonomy Slug', CPT_LANG ) ) . $ui->get_required_span();

							if ( 'edit' === $tab ) {
								echo '<p id="slugchanged" class="hidemessage">' . esc_html__( 'Slug has changed', CPT_LANG ) . '<span class="dashicons dashicons-warning"></span></p>';
							}
							echo '<p id="slugexists" class="hidemessage">' . esc_html__( 'Slug already exists', CPT_LANG ) . '<span class="dashicons dashicons-warning"></span></p>';

							echo $ui->get_th_end() . $ui->get_td_start();

							echo $ui->get_text_input( [
								'namearray'   => 'cpt_custom_tax',
								'name'        => 'name',
								'textvalue'   => isset( $current['name'] ) ? esc_attr( $current['name'] ) : '',
								'maxlength'   => '32',
								'helptext'    => esc_attr__( 'The taxonomy name/slug. Used for various queries for taxonomy content.', CPT_LANG ),
								'required'    => true,
								'placeholder' => false,
								'wrap'        => false,
							] );

							echo '<p class="cpt-slug-details">';
							esc_html_e( 'Slugs should only contain alphanumeric, latin characters. Underscores should be used in place of spaces. Set "Custom Rewrite Slug" field to make slug use dashes for URLs.', CPT_LANG );
							echo '</p>';

							if ( 'edit' === $tab ) {
								echo '<p>';
								esc_html_e( 'DO NOT EDIT the taxonomy slug unless also planning to migrate terms. Changing the slug registers a new taxonomy entry.', CPT_LANG );
								echo '</p>';

								echo '<div class="cpt-spacer">';
								echo $ui->get_check_input( [
									'checkvalue' => 'update_taxonomy',
									'checked'    => 'false',
									'name'       => 'update_taxonomy',
									'namearray'  => 'update_taxonomy',
									'labeltext'  => esc_html__( 'Migrate terms to newly renamed taxonomy?', CPT_LANG ),
									'helptext'   => '',
									'default'    => false,
									'wrap'       => false,
								] );
								echo '</div>';
							}

							echo $ui->get_text_input( [
								'namearray' => 'cpt_custom_tax',
								'name'      => 'label',
								'textvalue' => isset( $current['label'] ) ? esc_attr( $current['label'] ) : '',
								'aftertext' => esc_html__( '(e.g. Actors)', CPT_LANG ),
								'labeltext' => esc_html__( 'Plural Label', CPT_LANG ),
								'helptext'  => esc_attr__( 'Used for the taxonomy admin menu item.', CPT_LANG ),
								'required'  => true,
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_custom_tax',
								'name'      => 'singular_label',
								'textvalue' => isset( $current['singular_label'] ) ? esc_attr( $current['singular_label'] ) : '',
								'aftertext' => esc_html__( '(e.g. Actor)', CPT_LANG ),
								'labeltext' => esc_html__( 'Singular Label', CPT_LANG ),
								'helptext'  => esc_attr__( 'Used when a singular label is needed.', CPT_LANG ),
								'required'  => true,
							] );
							echo $ui->get_td_end() . $ui->get_tr_end();


							$link_text = ( 'new' === $tab ) ?
									esc_html__( 'Populate additional labels based on chosen labels.', CPT_LANG ) :
									esc_html__( 'Populate missing labels based on chosen labels.', CPT_LANG );
							echo $ui->get_tr_end();
							echo $ui->get_th_start() . esc_html__( 'Auto-populate labels', CPT_LANG ) . $ui->get_th_end();
							echo $ui->get_td_start();

								?>
								<a href="#" id="auto-populate"><?php echo esc_html( $link_text ); ?></a>
								<?php

							echo $ui->get_td_end() . $ui->get_tr_end();

							echo $ui->get_tr_start() . $ui->get_th_start() . esc_html__( 'Attach to Post Type', CPT_LANG ) . $ui->get_required_span();
							echo $ui->get_p( esc_html__( 'Add support for available registered post types. At least one is required. Only public post types listed by default.', CPT_LANG ) );
							echo $ui->get_th_end() . $ui->get_td_start() . $ui->get_fieldset_start();

							echo $ui->get_legend_start() . esc_html__( 'Post type options', CPT_LANG ) . $ui->get_legend_end();

							/**
							 * Filters the arguments for post types to list for taxonomy association.
							 *
							 * @since 1.0.0
							 *
							 * @param array $value Array of default arguments.
							 */
							$args = apply_filters( 'cpt_attach_post_types_to_taxonomy', [ 'public' => true ] );

							// If they don't return an array, fall back to the original default. Don't need to check for empty, because empty array is default for $args param in get_post_types anyway.
							if ( ! is_array( $args ) ) {
								$args = [ 'public' => true ];
							}
							$output = 'objects'; // Or objects.

							/**
							 * Filters the results returned to display for available post types for taxonomy.
							 *
							 * @since 1.3.0
							 *
							 * @param array  $value  Array of post type objects.
							 * @param array  $args   Array of arguments for the post type query.
							 * @param string $output The output type we want for the results.
							 */
							$post_types = apply_filters( 'cpt_get_post_types_for_taxonomies', get_post_types( $args, $output ), $args, $output );

							foreach ( $post_types as $post_type ) {
								$core_label = in_array( $post_type->name, [
									'post',
									'page',
									'attachment',
								], true ) ? esc_html__( '(WP Core)', CPT_LANG ) : '';
								echo $ui->get_check_input( [
									'checkvalue' => $post_type->name,
									'checked'    => ( ! empty( $current['object_types'] ) && is_array( $current['object_types'] ) && in_array( $post_type->name, $current['object_types'], true ) ) ? 'true' : 'false',
									'name'       => $post_type->name,
									'namearray'  => 'cpt_post_types',
									'textvalue'  => $post_type->name,
									'labeltext'  => "{$post_type->label} {$core_label}",
									'wrap'       => false,
								] );
							}

							echo $ui->get_fieldset_end() . $ui->get_td_end() . $ui->get_tr_end();
							?>
						</table>
						<p class="submit">
							<?php
							wp_nonce_field( 'cpt_addedit_taxonomy_nonce_action', 'cpt_addedit_taxonomy_nonce_field' );
							if ( ! empty( $_GET ) && ! empty( $_GET['action'] ) && 'edit' === $_GET['action'] ) {

								/**
								 * Filters the text value to use on the button when editing.
								 *
								 * @since 1.0.0
								 *
								 * @param string $value Text to use for the button.
								 */
								?>
								<input type="submit" class="button-primary cpt-taxonomy-submit" name="cpt_submit" value="<?php echo esc_attr( apply_filters( 'cpt_taxonomy_submit_edit', esc_attr__( 'Save Taxonomy', CPT_LANG ) ) ); ?>" />
								<?php

								/**
								 * Filters the text value to use on the button when deleting.
								 *
								 * @since 1.0.0
								 *
								 * @param string $value Text to use for the button.
								 */
								?>
								<input type="submit" class="button-secondary cpt-delete-top" name="cpt_delete" id="cpt_submit_delete" value="<?php echo esc_attr( apply_filters( 'cpt_taxonomy_submit_delete', __( 'Delete Taxonomy', CPT_LANG ) ) ); ?>" />
							<?php } else { ?>
								<?php

								/**
								 * Filters the text value to use on the button when adding.
								 *
								 * @since 1.0.0
								 *
								 * @param string $value Text to use for the button.
								 */
								?>
								<input type="submit" class="button-primary cpt-taxonomy-submit" name="cpt_submit" value="<?php echo esc_attr( apply_filters( 'cpt_taxonomy_submit_add', esc_attr__( 'Add Taxonomy', CPT_LANG ) ) ); ?>" />
							<?php } ?>

							<?php if ( ! empty( $current ) ) { ?>
								<input type="hidden" name="tax_original" id="tax_original" value="<?php echo esc_attr( $current['name'] ); ?>" />
							<?php
							}

							// Used to check and see if we should prevent duplicate slugs.
							?>
							<input type="hidden" name="cpt_tax_status" id="cpt_tax_status" value="<?php echo esc_attr( $tab ); ?>" />
						</p>
					</div>
				</div>
			</div>
			<div class="cpt-section cpt-labels postbox">
				<button type="button" class="handlediv button-link" aria-expanded="true">
					<span class="screen-reader-text"><?php esc_html_e( 'Toggle panel: Additional labels', CPT_LANG ); ?></span>
					<span class="toggle-indicator" aria-hidden="true"></span>
				</button>
				<h2 class="hndle">
					<span><?php esc_html_e( 'Additional labels', CPT_LANG ); ?></span>
				</h2>
				<div class="inside">
					<div class="main">
						<table class="form-table cpt-table">

							<?php
							if ( isset( $current['description'] ) ) {
								$current['description'] = stripslashes_deep( $current['description'] );
							}
							echo $ui->get_textarea_input( [
								'namearray' => 'cpt_custom_tax',
								'name'      => 'description',
								'rows'      => '4',
								'cols'      => '40',
								'textvalue' => isset( $current['description'] ) ? esc_textarea( $current['description'] ) : '',
								'labeltext' => esc_html__( 'Description', CPT_LANG ),
								'helptext'  => esc_attr__( 'Describe what your taxonomy is used for.', CPT_LANG ),
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'menu_name',
								'textvalue' => isset( $current['labels']['menu_name'] ) ? esc_attr( $current['labels']['menu_name'] ) : '',
								'aftertext' => esc_attr__( '(e.g. Actors)', CPT_LANG ),
								'labeltext' => esc_html__( 'Menu Name', CPT_LANG ),
								'helptext'  => esc_html__( 'Custom admin menu name for your taxonomy.', CPT_LANG ),
								'data' => [
									'label'     => 'item', // Not localizing because it's isolated.
									'plurality' => 'plural',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'all_items',
								'textvalue' => isset( $current['labels']['all_items'] ) ? esc_attr( $current['labels']['all_items'] ) : '',
								'aftertext' => esc_attr__( '(e.g. All Actors)', CPT_LANG ),
								'labeltext' => esc_html__( 'All Items', CPT_LANG ),
								'helptext'  => esc_html__( 'Used as tab text when showing all terms for hierarchical taxonomy while editing post.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'All %s', CPT_LANG ), 'item' ),
									'plurality' => 'plural',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'edit_item',
								'textvalue' => isset( $current['labels']['edit_item'] ) ? esc_attr( $current['labels']['edit_item'] ) : '',
								'aftertext' => esc_attr__( '(e.g. Edit Actor)', CPT_LANG ),
								'labeltext' => esc_html__( 'Edit Item', CPT_LANG ),
								'helptext'  => esc_html__( 'Used at the top of the term editor screen for an existing taxonomy term.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'Edit %s', CPT_LANG ), 'item' ),
									'plurality' => 'singular',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'view_item',
								'textvalue' => isset( $current['labels']['view_item'] ) ? esc_attr( $current['labels']['view_item'] ) : '',
								'aftertext' => esc_attr__( '(e.g. View Actor)', CPT_LANG ),
								'labeltext' => esc_html__( 'View Item', CPT_LANG ),
								'helptext'  => esc_html__( 'Used in the admin bar when viewing editor screen for an existing taxonomy term.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'View %s', CPT_LANG ), 'item' ),
									'plurality' => 'singular',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'update_item',
								'textvalue' => isset( $current['labels']['update_item'] ) ? esc_attr( $current['labels']['update_item'] ) : '',
								'aftertext' => esc_attr__( '(e.g. Update Actor Name)', CPT_LANG ),
								'labeltext' => esc_html__( 'Update Item Name', CPT_LANG ),
								'helptext'  => esc_html__( 'Custom taxonomy label. Used in the admin menu for displaying taxonomies.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'Update %s name', CPT_LANG ), 'item' ),
									'plurality' => 'singular',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'add_new_item',
								'textvalue' => isset( $current['labels']['add_new_item'] ) ? esc_attr( $current['labels']['add_new_item'] ) : '',
								'aftertext' => esc_attr__( '(e.g. Add New Actor)', CPT_LANG ),
								'labeltext' => esc_html__( 'Add New Item', CPT_LANG ),
								'helptext'  => esc_html__( 'Used at the top of the term editor screen and button text for a new taxonomy term.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'Add new %s', CPT_LANG ), 'item' ),
									'plurality' => 'singular',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'new_item_name',
								'textvalue' => isset( $current['labels']['new_item_name'] ) ? esc_attr( $current['labels']['new_item_name'] ) : '',
								'aftertext' => esc_attr__( '(e.g. New Actor Name)', CPT_LANG ),
								'labeltext' => esc_html__( 'New Item Name', CPT_LANG ),
								'helptext'  => esc_html__( 'Custom taxonomy label. Used in the admin menu for displaying taxonomies.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'New %s name', CPT_LANG ), 'item' ),
									'plurality' => 'singular',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'parent_item',
								'textvalue' => isset( $current['labels']['parent_item'] ) ? esc_attr( $current['labels']['parent_item'] ) : '',
								'aftertext' => esc_attr__( '(e.g. Parent Actor)', CPT_LANG ),
								'labeltext' => esc_html__( 'Parent Item', CPT_LANG ),
								'helptext'  => esc_html__( 'Custom taxonomy label. Used in the admin menu for displaying taxonomies.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'Parent %s', CPT_LANG ), 'item' ),
									'plurality' => 'singular',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'parent_item_colon',
								'textvalue' => isset( $current['labels']['parent_item_colon'] ) ? esc_attr( $current['labels']['parent_item_colon'] ) : '',
								'aftertext' => esc_attr__( '(e.g. Parent Actor:)', CPT_LANG ),
								'labeltext' => esc_html__( 'Parent Item Colon', CPT_LANG ),
								'helptext'  => esc_html__( 'Custom taxonomy label. Used in the admin menu for displaying taxonomies.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'Parent %s:', CPT_LANG ), 'item' ),
									'plurality' => 'singular',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'search_items',
								'textvalue' => isset( $current['labels']['search_items'] ) ? esc_attr( $current['labels']['search_items'] ) : '',
								'aftertext' => esc_attr__( '(e.g. Search Actors)', CPT_LANG ),
								'labeltext' => esc_html__( 'Search Items', CPT_LANG ),
								'helptext'  => esc_html__( 'Custom taxonomy label. Used in the admin menu for displaying taxonomies.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'Search %s', CPT_LANG ), 'item' ),
									'plurality' => 'plural',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'popular_items',
								'textvalue' => isset( $current['labels']['popular_items'] ) ? esc_attr( $current['labels']['popular_items'] ) : null,
								'aftertext' => esc_attr__( '(e.g. Popular Actors)', CPT_LANG ),
								'labeltext' => esc_html__( 'Popular Items', CPT_LANG ),
								'helptext'  => esc_html__( 'Custom taxonomy label. Used in the admin menu for displaying taxonomies.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'Popular %s', CPT_LANG ), 'item' ),
									'plurality' => 'plural',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'separate_items_with_commas',
								'textvalue' => isset( $current['labels']['separate_items_with_commas'] ) ? esc_attr( $current['labels']['separate_items_with_commas'] ) : null,
								'aftertext' => esc_attr__( '(e.g. Separate Actors with commas)', CPT_LANG ),
								'labeltext' => esc_html__( 'Separate Items with Commas', CPT_LANG ),
								'helptext'  => esc_html__( 'Custom taxonomy label. Used in the admin menu for displaying taxonomies.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'Separate %s with commas', CPT_LANG ), 'item' ),
									'plurality' => 'plural',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'add_or_remove_items',
								'textvalue' => isset( $current['labels']['add_or_remove_items'] ) ? esc_attr( $current['labels']['add_or_remove_items'] ) : null,
								'aftertext' => esc_attr__( '(e.g. Add or remove Actors)', CPT_LANG ),
								'labeltext' => esc_html__( 'Add or Remove Items', CPT_LANG ),
								'helptext'  => esc_html__( 'Custom taxonomy label. Used in the admin menu for displaying taxonomies.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'Add or remove %s', CPT_LANG ), 'item' ),
									'plurality' => 'plural',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'choose_from_most_used',
								'textvalue' => isset( $current['labels']['choose_from_most_used'] ) ? esc_attr( $current['labels']['choose_from_most_used'] ) : null,
								'aftertext' => esc_attr__( '(e.g. Choose from the most used Actors)', CPT_LANG ),
								'labeltext' => esc_html__( 'Choose From Most Used', CPT_LANG ),
								'helptext'  => esc_html__( 'Custom taxonomy label. Used in the admin menu for displaying taxonomies.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'Choose from the most used %s', CPT_LANG ), 'item' ),
									'plurality' => 'plural',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'not_found',
								'textvalue' => isset( $current['labels']['not_found'] ) ? esc_attr( $current['labels']['not_found'] ) : null,
								'aftertext' => esc_attr__( '(e.g. No Actors found)', CPT_LANG ),
								'labeltext' => esc_html__( 'Not found', CPT_LANG ),
								'helptext'  => esc_html__( 'Custom taxonomy label. Used in the admin menu for displaying taxonomies.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'No %s found', CPT_LANG ), 'item' ),
									'plurality' => 'plural',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'no_terms',
								'textvalue' => isset( $current['labels']['no_terms'] ) ? esc_attr( $current['labels']['no_terms'] ) : null,
								'aftertext' => esc_html__( '(e.g. No actors)', CPT_LANG ),
								'labeltext' => esc_html__( 'No terms', CPT_LANG ),
								'helptext'  => esc_attr__( 'Used when indicating that there are no terms in the given taxonomy associated with an object.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( 'No %s', CPT_LANG ), 'item' ),
									'plurality' => 'plural',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'items_list_navigation',
								'textvalue' => isset( $current['labels']['items_list_navigation'] ) ? esc_attr( $current['labels']['items_list_navigation'] ) : null,
								'aftertext' => esc_html__( '(e.g. Actors list navigation)', CPT_LANG ),
								'labeltext' => esc_html__( 'Items List Navigation', CPT_LANG ),
								'helptext'  => esc_attr__( 'Screen reader text for the pagination heading on the term listing screen.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( '%s list navigation', CPT_LANG ), 'item' ),
									'plurality' => 'plural',
								],
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_tax_labels',
								'name'      => 'items_list',
								'textvalue' => isset( $current['labels']['items_list'] ) ? esc_attr( $current['labels']['items_list'] ) : null,
								'aftertext' => esc_html__( '(e.g. Actors list)', CPT_LANG ),
								'labeltext' => esc_html__( 'Items List', CPT_LANG ),
								'helptext'  => esc_attr__( 'Screen reader text for the items list heading on the term listing screen.', CPT_LANG ),
								'data' => [
									/* translators: Used for autofill */
									'label'     => sprintf( esc_attr__( '%s list', CPT_LANG ), 'item' ),
									'plurality' => 'plural',
								],
							] );
							?>
						</table>
					</div>
				</div>
			</div>
			<div class="cpt-section cpt-settings postbox">
				<button type="button" class="handlediv button-link" aria-expanded="true">
					<span class="screen-reader-text"><?php esc_html_e( 'Toggle panel: Settings', CPT_LANG ); ?></span>
					<span class="toggle-indicator" aria-hidden="true"></span>
				</button>
				<h2 class="hndle">
					<span><?php esc_html_e( 'Settings', CPT_LANG ); ?></span>
				</h2>
				<div class="inside">
					<div class="main">
						<table class="form-table cpt-table">
							<?php

							$select             = [
								'options' => [
									[
										'attr' => '0',
										'text' => esc_attr__( 'False', CPT_LANG ),
									],
									[
										'attr'    => '1',
										'text'    => esc_attr__( 'True', CPT_LANG ),
										'default' => 'true',
									],
								],
							];
							$selected           = isset( $current ) ? disp_boolean( $current['public'] ) : '';
							$select['selected'] = ! empty( $selected ) ? $current['public'] : '';
							echo $ui->get_select_input( [
								'namearray'  => 'cpt_custom_tax',
								'name'       => 'public',
								'labeltext'  => esc_html__( 'Public', CPT_LANG ),
								'aftertext'  => esc_html__( '(default: true) Whether a taxonomy is intended for use publicly either via the admin interface or by front-end users.', CPT_LANG ),
								'selections' => $select,
							] );

							$select             = [
								'options' => [
									[
										'attr' => '0',
										'text' => esc_attr__( 'False', CPT_LANG ),
									],
									[
										'attr'    => '1',
										'text'    => esc_attr__( 'True', CPT_LANG ),
										'default' => 'true',
									],
								],
							];
							$selected           = isset( $current ) ? disp_boolean( $current['publicly_queryable'] ) : '';
							$select['selected'] = ! empty( $selected ) ? $current['publicly_queryable'] : '';
							echo $ui->get_select_input( [
								'namearray'  => 'cpt_custom_tax',
								'name'       => 'publicly_queryable',
								'labeltext'  => esc_html__( 'Public Queryable', CPT_LANG ),
								'aftertext'  => esc_html__( '(default: value of "public" setting) Whether or not the taxonomy should be publicly queryable.', CPT_LANG ),
								'selections' => $select,
							] );

							$select             = [
								'options' => [
									[
										'attr'    => '0',
										'text'    => esc_attr__( 'False', CPT_LANG ),
										'default' => 'true',
									],
									[
										'attr' => '1',
										'text' => esc_attr__( 'True', CPT_LANG ),
									],
								],
							];
							$selected           = isset( $current ) ? disp_boolean( $current['hierarchical'] ) : '';
							$select['selected'] = ! empty( $selected ) ? $current['hierarchical'] : '';
							echo $ui->get_select_input( [
								'namearray'  => 'cpt_custom_tax',
								'name'       => 'hierarchical',
								'labeltext'  => esc_html__( 'Hierarchical', CPT_LANG ),
								'aftertext'  => esc_html__( '(default: false) Whether the taxonomy can have parent-child relationships.', CPT_LANG ),
								'selections' => $select,
							] );

							$select             = [
								'options' => [
									[
										'attr' => '0',
										'text' => esc_attr__( 'False', CPT_LANG ),
									],
									[
										'attr'    => '1',
										'text'    => esc_attr__( 'True', CPT_LANG ),
										'default' => 'true',
									],
								],
							];
							$selected           = isset( $current ) ? disp_boolean( $current['show_ui'] ) : '';
							$select['selected'] = ! empty( $selected ) ? $current['show_ui'] : '';
							echo $ui->get_select_input( [
								'namearray'  => 'cpt_custom_tax',
								'name'       => 'show_ui',
								'labeltext'  => esc_html__( 'Show UI', CPT_LANG ),
								'aftertext'  => esc_html__( '(default: true) Whether to generate a default UI for managing this custom taxonomy.', CPT_LANG ),
								'selections' => $select,
							] );

							$select             = [
								'options' => [
									[
										'attr' => '0',
										'text' => esc_attr__( 'False', CPT_LANG ),
									],
									[
										'attr'    => '1',
										'text'    => esc_attr__( 'True', CPT_LANG ),
										'default' => 'true',
									],
								],
							];
							$selected           = isset( $current ) ? disp_boolean( $current['show_in_menu'] ) : '';
							$select['selected'] = ! empty( $selected ) ? $current['show_in_menu'] : '';
							echo $ui->get_select_input( [
								'namearray'  => 'cpt_custom_tax',
								'name'       => 'show_in_menu',
								'labeltext'  => esc_html__( 'Show in menu', CPT_LANG ),
								'aftertext'  => esc_html__( '(default: value of show_ui) Whether to show the taxonomy in the admin menu.', CPT_LANG ),
								'selections' => $select,
							] );

							$select             = [
								'options' => [
									[
										'attr' => '0',
										'text' => esc_attr__( 'False', CPT_LANG ),
									],
									[
										'attr'    => '1',
										'text'    => esc_attr__( 'True', CPT_LANG ),
										'default' => 'true',
									],
								],
							];
							$selected           = ( isset( $current ) && ! empty( $current['show_in_nav_menus'] ) ) ? disp_boolean( $current['show_in_nav_menus'] ) : '';
							$select['selected'] = ! empty( $selected ) ? $current['show_in_nav_menus'] : '';
							echo $ui->get_select_input( [
								'namearray'  => 'cpt_custom_tax',
								'name'       => 'show_in_nav_menus',
								'labeltext'  => esc_html__( 'Show in nav menus', CPT_LANG ),
								'aftertext'  => esc_html__( '(default: value of public) Whether to make the taxonomy available for selection in navigation menus.', CPT_LANG ),
								'selections' => $select,
							] );

							$select             = [
								'options' => [
									[
										'attr' => '0',
										'text' => esc_attr__( 'False', CPT_LANG ),
									],
									[
										'attr'    => '1',
										'text'    => esc_attr__( 'True', CPT_LANG ),
										'default' => 'true',
									],
								],
							];
							$selected           = isset( $current ) ? disp_boolean( $current['query_var'] ) : '';
							$select['selected'] = ! empty( $selected ) ? $current['query_var'] : '';
							echo $ui->get_select_input( [
								'namearray'  => 'cpt_custom_tax',
								'name'       => 'query_var',
								'labeltext'  => esc_html__( 'Query Var', CPT_LANG ),
								'aftertext'  => esc_html__( '(default: true) Sets the query_var key for this taxonomy.', CPT_LANG ),
								'selections' => $select,
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_custom_tax',
								'name'      => 'query_var_slug',
								'textvalue' => isset( $current['query_var_slug'] ) ? esc_attr( $current['query_var_slug'] ) : '',
								'aftertext' => esc_attr__( '(default: taxonomy slug). Query var needs to be true to use.', CPT_LANG ),
								'labeltext' => esc_html__( 'Custom Query Var String', CPT_LANG ),
								'helptext'  => esc_html__( 'Sets a custom query_var slug for this taxonomy.', CPT_LANG ),
							] );

							$select             = [
								'options' => [
									[
										'attr' => '0',
										'text' => esc_attr__( 'False', CPT_LANG ),
									],
									[
										'attr'    => '1',
										'text'    => esc_attr__( 'True', CPT_LANG ),
										'default' => 'true',
									],
								],
							];
							$selected           = isset( $current ) ? disp_boolean( $current['rewrite'] ) : '';
							$select['selected'] = ! empty( $selected ) ? $current['rewrite'] : '';
							echo $ui->get_select_input( [
								'namearray'  => 'cpt_custom_tax',
								'name'       => 'rewrite',
								'labeltext'  => esc_html__( 'Rewrite', CPT_LANG ),
								'aftertext'  => esc_html__( '(default: true) Whether or not WordPress should use rewrites for this taxonomy.', CPT_LANG ),
								'selections' => $select,
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_custom_tax',
								'name'      => 'rewrite_slug',
								'textvalue' => isset( $current['rewrite_slug'] ) ? esc_attr( $current['rewrite_slug'] ) : '',
								'aftertext' => esc_attr__( '(default: taxonomy name)', CPT_LANG ),
								'labeltext' => esc_html__( 'Custom Rewrite Slug', CPT_LANG ),
								'helptext'  => esc_html__( 'Custom taxonomy rewrite slug.', CPT_LANG ),
							] );

							$select             = [
								'options' => [
									[
										'attr' => '0',
										'text' => esc_attr__( 'False', CPT_LANG ),
									],
									[
										'attr'    => '1',
										'text'    => esc_attr__( 'True', CPT_LANG ),
										'default' => 'true',
									],
								],
							];
							$selected           = isset( $current ) ? disp_boolean( $current['rewrite_withfront'] ) : '';
							$select['selected'] = ! empty( $selected ) ? $current['rewrite_withfront'] : '';
							echo $ui->get_select_input( [
								'namearray'  => 'cpt_custom_tax',
								'name'       => 'rewrite_withfront',
								'labeltext'  => esc_html__( 'Rewrite With Front', CPT_LANG ),
								'aftertext'  => esc_html__( '(default: true) Should the permastruct be prepended with the front base.', CPT_LANG ),
								'selections' => $select,
							] );

							$select             = [
								'options' => [
									[
										'attr'    => '0',
										'text'    => esc_attr__( 'False', CPT_LANG ),
										'default' => 'false',
									],
									[
										'attr' => '1',
										'text' => esc_attr__( 'True', CPT_LANG ),
									],
								],
							];
							$selected           = isset( $current ) ? disp_boolean( $current['rewrite_hierarchical'] ) : '';
							$select['selected'] = ! empty( $selected ) ? $current['rewrite_hierarchical'] : '';
							echo $ui->get_select_input( [
								'namearray'  => 'cpt_custom_tax',
								'name'       => 'rewrite_hierarchical',
								'labeltext'  => esc_html__( 'Rewrite Hierarchical', CPT_LANG ),
								'aftertext'  => esc_html__( '(default: false) Should the permastruct allow hierarchical urls.', CPT_LANG ),
								'selections' => $select,
							] );

							$select             = [
								'options' => [
									[
										'attr'    => '0',
										'text'    => esc_attr__( 'False', CPT_LANG ),
										'default' => 'true',
									],
									[
										'attr' => '1',
										'text' => esc_attr__( 'True', CPT_LANG ),
									],
								],
							];
							$selected           = isset( $current ) ? disp_boolean( $current['show_admin_column'] ) : '';
							$select['selected'] = ! empty( $selected ) ? $current['show_admin_column'] : '';
							echo $ui->get_select_input( [
								'namearray'  => 'cpt_custom_tax',
								'name'       => 'show_admin_column',
								'labeltext'  => esc_html__( 'Show Admin Column', CPT_LANG ),
								'aftertext'  => esc_html__( '(default: false) Whether to allow automatic creation of taxonomy columns on associated post-types.', CPT_LANG ),
								'selections' => $select,
							] );

							$select             = [
								'options' => [
									[
										'attr'    => '0',
										'text'    => esc_attr__( 'False', CPT_LANG ),
									],
									[
										'attr'    => '1',
										'text'    => esc_attr__( 'True', CPT_LANG ),
										'default' => 'true',
									],
								],
							];
							$selected           = isset( $current ) ? disp_boolean( $current['show_in_rest'] ) : '';
							$select['selected'] = ! empty( $selected ) ? $current['show_in_rest'] : '';
							echo $ui->get_select_input( [
								'namearray'  => 'cpt_custom_tax',
								'name'       => 'show_in_rest',
								'labeltext'  => esc_html__( 'Show in REST API', CPT_LANG ),
								'aftertext'  => esc_html__( '(Custom Post Type default: true) Whether to show this taxonomy data in the WP REST API.', CPT_LANG ),
								'selections' => $select,
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_custom_tax',
								'name'      => 'rest_base',
								'labeltext' => esc_html__( 'REST API base slug', CPT_LANG ),
								'helptext'  => esc_attr__( 'Slug to use in REST API URLs.', CPT_LANG ),
								'textvalue' => isset( $current['rest_base'] ) ? esc_attr( $current['rest_base'] ) : '',
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_custom_tax',
								'name'      => 'rest_controller_class',
								'labeltext' => esc_html__( 'REST API controller class', CPT_LANG ),
								'aftertext' => esc_attr__( '(default: WP_REST_Terms_Controller) Custom controller to use instead of WP_REST_Terms_Controller.', CPT_LANG ),
								'textvalue' => isset( $current['rest_controller_class'] ) ? esc_attr( $current['rest_controller_class'] ) : '',
							] );

							$select             = [
								'options' => [
									[
										'attr'    => '0',
										'text'    => esc_attr__( 'False', CPT_LANG ),
										'default' => 'false',
									],
									[
										'attr' => '1',
										'text' => esc_attr__( 'True', CPT_LANG ),
									],
								],
							];
							$selected           = ( isset( $current ) && ! empty( $current['show_in_quick_edit'] ) ) ? disp_boolean( $current['show_in_quick_edit'] ) : '';
							$select['selected'] = ! empty( $selected ) ? $current['show_in_quick_edit'] : '';
							echo $ui->get_select_input( [
								'namearray'  => 'cpt_custom_tax',
								'name'       => 'show_in_quick_edit',
								'labeltext'  => esc_html__( 'Show in quick/bulk edit panel.', CPT_LANG ),
								'aftertext'  => esc_html__( '(default: false) Whether to show the taxonomy in the quick/bulk edit panel.', CPT_LANG ),
								'selections' => $select,
							] );

							echo $ui->get_text_input( [
								'namearray' => 'cpt_custom_tax',
								'name'      => 'meta_box_cb',
								'textvalue' => isset( $current['meta_box_cb'] ) ? esc_attr( $current['meta_box_cb'] ) : '',
								'labeltext' => esc_html__( 'Metabox callback', CPT_LANG ),
								'helptext'  => esc_html__( 'Sets a callback function name for the meta box display. Hierarchical default: post_categories_meta_box, non-hierarchical default: post_tags_meta_box. To remove the metabox completely, use "false".', CPT_LANG ),
							] );
							?>
						</table>
					</div>
				</div>
			</div>

			<?php
			/**
			 * Fires after the default fieldsets on the taxonomy screen.
			 *
			 * @since 1.3.0
			 *
			 * @param cpt_admin_ui $ui Admin UI instance.
			 */
			do_action( 'cpt_taxonomy_after_fieldsets', $ui );
			?>

			<p class="submit">
				<?php
				wp_nonce_field( 'cpt_addedit_taxonomy_nonce_action', 'cpt_addedit_taxonomy_nonce_field' );
				if ( ! empty( $_GET ) && ! empty( $_GET['action'] ) && 'edit' === $_GET['action'] ) { ?>
					<?php

					/**
					 * Filters the text value to use on the button when editing.
					 *
					 * @since 1.0.0
					 *
					 * @param string $value Text to use for the button.
					 */
					?>
					<input type="submit" class="button-primary cpt-taxonomy-submit" name="cpt_submit" value="<?php echo esc_attr( apply_filters( 'cpt_taxonomy_submit_edit', esc_attr__( 'Save Taxonomy', CPT_LANG ) ) ); ?>" />
					<?php

					/**
					 * Filters the text value to use on the button when deleting.
					 *
					 * @since 1.0.0
					 *
					 * @param string $value Text to use for the button.
					 */
					?>
					<input type="submit" class="button-secondary cpt-delete-bottom" name="cpt_delete" id="cpt_submit_delete" value="<?php echo esc_attr( apply_filters( 'cpt_taxonomy_submit_delete', __( 'Delete Taxonomy', CPT_LANG ) ) ); ?>" />
				<?php } else { ?>
					<?php

					/**
					 * Filters the text value to use on the button when adding.
					 *
					 * @since 1.0.0
					 *
					 * @param string $value Text to use for the button.
					 */
					?>
					<input type="submit" class="button-primary cpt-taxonomy-submit" name="cpt_submit" value="<?php echo esc_attr( apply_filters( 'cpt_taxonomy_submit_add', esc_attr__( 'Add Taxonomy', CPT_LANG ) ) ); ?>" />
				<?php } ?>

				<?php if ( ! empty( $current ) ) { ?>
					<input type="hidden" name="tax_original" id="tax_original" value="<?php echo esc_attr( $current['name'] ); ?>" />
				<?php
				}

				// Used to check and see if we should prevent duplicate slugs.
				?>
				<input type="hidden" name="cpt_tax_status" id="cpt_tax_status" value="<?php echo esc_attr( $tab ); ?>" />
			</p>
		</div>
		</div>
	</form>
	</div><!-- End .wrap -->
<?php
}

/**
 * Construct a dropdown of our taxonomies so users can select which to edit.
 *
 * @since 1.0.0
 *
 * @param array $taxonomies Array of taxonomies that are registered. Optional.
 */
function cpt_taxonomies_dropdown( $taxonomies = [] ) {

	$ui = new cpt_admin_ui();

	if ( ! empty( $taxonomies ) ) {
		$select            = [];
		$select['options'] = [];

		foreach ( $taxonomies as $tax ) {
			$text                = ! empty( $tax['label'] ) ? esc_html( $tax['label'] ) : esc_html( $tax['name'] );
			$select['options'][] = [
				'attr' => $tax['name'],
				'text' => $text,
			];
		}

		$current            = cpt_get_current_taxonomy();
		$select['selected'] = $current;

		/**
		 * Filters the taxonomy dropdown options before rendering.
		 *
		 * @since 1.6.0
		 *
		 * @param array $select     Array of options for the dropdown.
		 * @param array $taxonomies Array of original passed in post types.
		 */
		$select = apply_filters( 'cpt_taxonomies_dropdown_options', $select, $taxonomies );

		echo $ui->get_select_input( [
			'namearray'  => 'cpt_selected_taxonomy',
			'name'       => 'taxonomy',
			'selections' => $select,
			'wrap'       => false,
		] );
	}
}

/**
 * Get the selected taxonomy from the $_POST global.
 *
 * @since 1.0.0
 *
 * @internal
 *
 * @param bool $taxonomy_deleted Whether or not a taxonomy was recently deleted. Optional. Default false.
 * @return bool|string False on no result, sanitized taxonomy if set.
 */
function cpt_get_current_taxonomy( $taxonomy_deleted = false ) {

	$tax = false;

	if ( ! empty( $_POST ) ) {
		if ( ! empty( $_POST['cpt_select_taxonomy_nonce_field'] ) ) {
			check_admin_referer( 'cpt_select_taxonomy_nonce_action', 'cpt_select_taxonomy_nonce_field' );
		}
		if ( isset( $_POST['cpt_selected_taxonomy']['taxonomy'] ) ) {
			$tax = sanitize_text_field( $_POST['cpt_selected_taxonomy']['taxonomy'] );
		} elseif ( $taxonomy_deleted ) {
			$taxonomies = cpt_get_taxonomy_data();
			$tax        = key( $taxonomies );
		} elseif ( isset( $_POST['cpt_custom_tax']['name'] ) ) {
			// Return the submitted value.
			if ( ! in_array( $_POST['cpt_custom_tax']['name'], cpt_reserved_taxonomies(), true ) ) {
				$tax = sanitize_text_field( $_POST['cpt_custom_tax']['name'] );
			} else {
				// Return the original value since user tried to submit a reserved term.
				$tax = sanitize_text_field( $_POST['tax_original'] );
			}
		}
	} elseif ( ! empty( $_GET ) && isset( $_GET['cpt_taxonomy'] ) ) {
		$tax = sanitize_text_field( $_GET['cpt_taxonomy'] );
	} else {
		$taxonomies = cpt_get_taxonomy_data();
		if ( ! empty( $taxonomies ) ) {
			// Will return the first array key.
			$tax = key( $taxonomies );
		}
	}

	/**
	 * Filters the current taxonomy to edit.
	 *
	 * @since 1.3.0
	 *
	 * @param string $tax Taxonomy slug.
	 */
	return apply_filters( 'cpt_current_taxonomy', $tax );
}

/**
 * Delete our custom taxonomy from the array of taxonomies.
 *
 * @since 1.0.0
 *
 * @internal
 *
 * @param array $data The $_POST values. Optional.
 * @return bool|string False on failure, string on success.
 */
function cpt_delete_taxonomy( $data = [] ) {

	if ( is_string( $data ) && taxonomy_exists( $data ) ) {
		$data = [
			'cpt_custom_tax' => [
				'name' => $data,
			],
		];
	}

	// Check if they selected one to delete.
	if ( empty( $data['cpt_custom_tax']['name'] ) ) {
		return cpt_admin_notices( 'error', '', false, esc_html__( 'Please provide a taxonomy to delete', CPT_LANG ) );
	}

	/**
	 * Fires before a taxonomy is deleted from our saved options.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of taxonomy data we are deleting.
	 */
	do_action( 'cpt_before_delete_taxonomy', $data );

	$taxonomies = cpt_get_taxonomy_data();

	if ( array_key_exists( strtolower( $data['cpt_custom_tax']['name'] ), $taxonomies ) ) {

		unset( $taxonomies[ $data['cpt_custom_tax']['name'] ] );

		/**
		 * Filters whether or not 3rd party options were saved successfully within taxonomy deletion.
		 *
		 * @since 1.3.0
		 *
		 * @param bool  $value      Whether or not someone else saved successfully. Default false.
		 * @param array $taxonomies Array of our updated taxonomies data.
		 * @param array $data       Array of submitted taxonomy to update.
		 */
		if ( false === ( $success = apply_filters( 'cpt_taxonomy_delete_tax', false, $taxonomies, $data ) ) ) {
			$success = update_option( 'cpt_taxonomies', $taxonomies );
		}
	}

	/**
	 * Fires after a taxonomy is deleted from our saved options.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of taxonomy data that was deleted.
	 */
	do_action( 'cpt_after_delete_taxonomy', $data );

	// Used to help flush rewrite rules on init.
	set_transient( 'cpt_flush_rewrite_rules', 'true', 5 * 60 );

	if ( isset( $success ) ) {
		return 'delete_success';
	}
	return 'delete_fail';
}

/**
 * Add to or update our CPT option with new data.
 *
 * @since 1.0.0
 *
 * @internal
 *
 * @param array $data Array of taxonomy data to update. Optional.
 * @return bool|string False on failure, string on success.
 */
function cpt_update_taxonomy( $data = [] ) {

	/**
	 * Fires before a taxonomy is updated to our saved options.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of taxonomy data we are updating.
	 */
	do_action( 'cpt_before_update_taxonomy', $data );

	// They need to provide a name.
	if ( empty( $data['cpt_custom_tax']['name'] ) ) {
		return cpt_admin_notices( 'error', '', false, esc_html__( 'Please provide a taxonomy name', CPT_LANG ) );
	}

	if ( empty( $data['cpt_post_types'] ) ) {
		add_filter( 'cpt_custom_error_message', 'cpt_empty_cpt_on_taxonomy' );
		return 'error';
	}

	if ( ! empty( $data['tax_original'] ) && $data['tax_original'] !== $data['cpt_custom_tax']['name'] ) {
		if ( ! empty( $data['update_taxonomy'] ) ) {
			add_filter( 'cpt_convert_taxonomy_terms', '__return_true' );
		}
	}

	foreach ( $data as $key => $value ) {
		if ( is_string( $value ) ) {
			$data[ $key ] = sanitize_text_field( $value );
		} else {
			array_map( 'sanitize_text_field', $data[ $key ] );
		}
	}

	if ( false !== strpos( $data['cpt_custom_tax']['name'], '\'' ) ||
		false !== strpos( $data['cpt_custom_tax']['name'], '\"' ) ||
		false !== strpos( $data['cpt_custom_tax']['rewrite_slug'], '\'' ) ||
		false !== strpos( $data['cpt_custom_tax']['rewrite_slug'], '\"' ) ) {

		add_filter( 'cpt_custom_error_message', 'cpt_slug_has_quotes' );
		return 'error';
	}

	$taxonomies = cpt_get_taxonomy_data();

	/**
	 * Check if we already have a post type of that name.
	 *
	 * @since 1.3.0
	 *
	 * @param bool   $value      Assume we have no conflict by default.
	 * @param string $value      Post type slug being saved.
	 * @param array  $post_types Array of existing post types from CPT.
	 */
	$slug_exists = apply_filters( 'cpt_taxonomy_slug_exists', false, $data['cpt_custom_tax']['name'], $taxonomies );
	if ( true === $slug_exists ) {
		add_filter( 'cpt_custom_error_message', 'cpt_slug_matches_taxonomy' );
		return 'error';
	}

	foreach ( $data['cpt_tax_labels'] as $key => $label ) {
		if ( empty( $label ) ) {
			unset( $data['cpt_tax_labels'][ $key ] );
		}
		$label                          = str_replace( '"', '', htmlspecialchars_decode( $label ) );
		$label                          = htmlspecialchars( $label, ENT_QUOTES );
		$label                          = trim( $label );
		$data['cpt_tax_labels'][ $key ] = stripslashes_deep( $label );
	}

	$label = ucwords( str_replace( '_', ' ', $data['cpt_custom_tax']['name'] ) );
	if ( ! empty( $data['cpt_custom_tax']['label'] ) ) {
		$label = str_replace( '"', '', htmlspecialchars_decode( $data['cpt_custom_tax']['label'] ) );
		$label = htmlspecialchars( stripslashes( $label ), ENT_QUOTES );
	}

	$name = trim( $data['cpt_custom_tax']['name'] );

	$singular_label = ucwords( str_replace( '_', ' ', $data['cpt_custom_tax']['name'] ) );
	if ( ! empty( $data['cpt_custom_tax']['singular_label'] ) ) {
		$singular_label = str_replace( '"', '', htmlspecialchars_decode( $data['cpt_custom_tax']['singular_label'] ) );
		$singular_label = htmlspecialchars( stripslashes( $singular_label ) );
	}
	$description           = stripslashes_deep( $data['cpt_custom_tax']['description'] );
	$query_var_slug        = trim( $data['cpt_custom_tax']['query_var_slug'] );
	$rewrite_slug          = trim( $data['cpt_custom_tax']['rewrite_slug'] );
	$rest_base             = trim( $data['cpt_custom_tax']['rest_base'] );
	$rest_controller_class = trim( $data['cpt_custom_tax']['rest_controller_class'] );
	$show_quickpanel_bulk  = ! empty( $data['cpt_custom_tax']['show_in_quick_edit'] ) ? disp_boolean( $data['cpt_custom_tax']['show_in_quick_edit'] ) : '';

	$meta_box_cb = trim( $data['cpt_custom_tax']['meta_box_cb'] );
	// We may or may not need to force a boolean false keyword.
	$maybe_false = strtolower( trim( $data['cpt_custom_tax']['meta_box_cb'] ) );
	if ( 'false' === $maybe_false ) {
		$meta_box_cb = $maybe_false;
	}

	$taxonomies[ $data['cpt_custom_tax']['name'] ] = [
		'name'                  => $name,
		'label'                 => $label,
		'singular_label'        => $singular_label,
		'description'           => $description,
		'public'                => disp_boolean( $data['cpt_custom_tax']['public'] ),
		'publicly_queryable'    => disp_boolean( $data['cpt_custom_tax']['publicly_queryable'] ),
		'hierarchical'          => disp_boolean( $data['cpt_custom_tax']['hierarchical'] ),
		'show_ui'               => disp_boolean( $data['cpt_custom_tax']['show_ui'] ),
		'show_in_menu'          => disp_boolean( $data['cpt_custom_tax']['show_in_menu'] ),
		'show_in_nav_menus'     => disp_boolean( $data['cpt_custom_tax']['show_in_nav_menus'] ),
		'query_var'             => disp_boolean( $data['cpt_custom_tax']['query_var'] ),
		'query_var_slug'        => $query_var_slug,
		'rewrite'               => disp_boolean( $data['cpt_custom_tax']['rewrite'] ),
		'rewrite_slug'          => $rewrite_slug,
		'rewrite_withfront'     => $data['cpt_custom_tax']['rewrite_withfront'],
		'rewrite_hierarchical'  => $data['cpt_custom_tax']['rewrite_hierarchical'],
		'show_admin_column'     => disp_boolean( $data['cpt_custom_tax']['show_admin_column'] ),
		'show_in_rest'          => disp_boolean( $data['cpt_custom_tax']['show_in_rest'] ),
		'show_in_quick_edit'    => $show_quickpanel_bulk,
		'rest_base'             => $rest_base,
		'rest_controller_class' => $rest_controller_class,
		'labels'                => $data['cpt_tax_labels'],
		'meta_box_cb'           => $meta_box_cb,
	];

	$taxonomies[ $data['cpt_custom_tax']['name'] ]['object_types'] = $data['cpt_post_types'];

	/**
	 * Filters final data to be saved right before saving taxoomy data.
	 *
	 * @since 1.6.0
	 *
	 * @param array  $taxonomies Array of final taxonomy data to save.
	 * @param string $name       Taxonomy slug for taxonomy being saved.
	 */
	$taxonomies = apply_filters( 'cpt_pre_save_taxonomy', $taxonomies, $name );

	/**
	 * Filters whether or not 3rd party options were saved successfully within taxonomy add/update.
	 *
	 * @since 1.3.0
	 *
	 * @param bool  $value      Whether or not someone else saved successfully. Default false.
	 * @param array $taxonomies Array of our updated taxonomies data.
	 * @param array $data       Array of submitted taxonomy to update.
	 */
	if ( false === ( $success = apply_filters( 'cpt_taxonomy_update_save', false, $taxonomies, $data ) ) ) {
		$success = update_option( 'cpt_taxonomies', $taxonomies );
	}

	/**
	 * Fires after a taxonomy is updated to our saved options.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of taxonomy data that was updated.
	 */
	do_action( 'cpt_after_update_taxonomy', $data );

	// Used to help flush rewrite rules on init.
	set_transient( 'cpt_flush_rewrite_rules', 'true', 5 * 60 );

	if ( isset( $success ) && 'new' === $data['cpt_tax_status'] ) {
		return 'add_success';
	}

	return 'update_success';
}

/**
 * Return an array of names that users should not or can not use for taxonomy names.
 *
 * @since 1.3.0
 *
 * @return array $value Array of names that are recommended against.
 */
function cpt_reserved_taxonomies() {

	$reserved = [
		'action',
		'attachment',
		'attachment_id',
		'author',
		'author_name',
		'calendar',
		'cat',
		'category',
		'category__and',
		'category__in',
		'category__not_in',
		'category_name',
		'comments_per_page',
		'comments_popup',
		'customize_messenger_channel',
		'customized',
		'cpage',
		'day',
		'debug',
		'error',
		'exact',
		'feed',
		'fields',
		'hour',
		'include',
		'link_category',
		'm',
		'minute',
		'monthnum',
		'more',
		'name',
		'nav_menu',
		'nonce',
		'nopaging',
		'offset',
		'order',
		'orderby',
		'p',
		'page',
		'page_id',
		'paged',
		'pagename',
		'pb',
		'perm',
		'post',
		'post__in',
		'post__not_in',
		'post_format',
		'post_mime_type',
		'post_status',
		'post_tag',
		'post_type',
		'posts',
		'posts_per_archive_page',
		'posts_per_page',
		'preview',
		'robots',
		's',
		'search',
		'second',
		'sentence',
		'showposts',
		'static',
		'subpost',
		'subpost_id',
		'tag',
		'tag__and',
		'tag__in',
		'tag__not_in',
		'tag_id',
		'tag_slug__and',
		'tag_slug__in',
		'taxonomy',
		'tb',
		'term',
		'theme',
		'type',
		'w',
		'withcomments',
		'withoutcomments',
		'year',
		'output',
	];

	/**
	 * Filters the list of reserved post types to check against.
	 * 3rd party plugin authors could use this to prevent duplicate post types.
	 *
	 * @since 1.0.0
	 *
	 * @param array $value Array of post type slugs to forbid.
	 */
	$custom_reserved = apply_filters( 'cpt_reserved_taxonomies', [] );

	if ( is_string( $custom_reserved ) && ! empty( $custom_reserved ) ) {
		$reserved[] = $custom_reserved;
	} elseif ( is_array( $custom_reserved ) && ! empty( $custom_reserved ) ) {
		foreach ( $custom_reserved as $slug ) {
			$reserved[] = $slug;
		}
	}

	return $reserved;
}

/**
 * Convert taxonomies.
 *
 * @since 1.3.0
 *
 * @internal
 *
 * @param string $original_slug Original taxonomy slug. Optional. Default empty string.
 * @param string $new_slug      New taxonomy slug. Optional. Default empty string.
 */
function cpt_convert_taxonomy_terms( $original_slug = '', $new_slug = '' ) {
	global $wpdb;

	$args = [
		'taxonomy'   => $original_slug,
		'hide_empty' => false,
		'fields'     => 'ids',
	];

	$term_ids = get_terms( $args );

	if ( is_int( $term_ids ) ) {
		$term_ids = (array) $term_ids;
	}

	if ( is_array( $term_ids ) && ! empty( $term_ids ) ) {
		$term_ids = implode( ',', $term_ids );

		$query = "UPDATE `{$wpdb->term_taxonomy}` SET `taxonomy` = %s WHERE `taxonomy` = %s AND `term_id` IN ( {$term_ids} )";

		$wpdb->query(
			$wpdb->prepare( $query, $new_slug, $original_slug )
		);
	}
	cpt_delete_taxonomy( $original_slug );
}

/**
 * Checks if we are trying to register an already registered taxonomy slug.
 *
 * @since 1.3.0
 *
 * @param bool   $slug_exists   Whether or not the post type slug exists. Optional. Default false.
 * @param string $taxonomy_slug The post type slug being saved. Optional. Default empty string.
 * @param array  $taxonomies    Array of CPT-registered post types. Optional.
 *
 * @return bool
 */
function cpt_check_existing_taxonomy_slugs( $slug_exists = false, $taxonomy_slug = '', $taxonomies = [] ) {

	// If true, then we'll already have a conflict, let's not re-process.
	if ( true === $slug_exists ) {
		return $slug_exists;
	}

	// Check if CPT has already registered this slug.
	if ( array_key_exists( strtolower( $taxonomy_slug ), $taxonomies ) ) {
		return true;
	}

	// Check if we're registering a reserved post type slug.
	if ( in_array( $taxonomy_slug, cpt_reserved_taxonomies() ) ) {
		return true;
	}

	// Check if other plugins have registered this same slug.
	$public  = get_taxonomies( [ '_builtin' => false, 'public' => true ] );
	$private = get_taxonomies( [ '_builtin' => false, 'public' => false ] );
	$registered_taxonomies = array_merge( $public, $private );
	if ( in_array( $taxonomy_slug, $registered_taxonomies ) ) {
		return true;
	}

	// If we're this far, it's false.
	return $slug_exists;
}
add_filter( 'cpt_taxonomy_slug_exists', 'cpt_check_existing_taxonomy_slugs', 10, 3 );

/**
 * Handle the save and deletion of taxonomy data.
 *
 * @since 1.4.0
 */
function cpt_process_taxonomy() {

	if ( wp_doing_ajax() ) {
		return;
	}

	if ( ! is_admin() ) {
		return;
	}

	if ( ! empty( $_GET ) && isset( $_GET['page'] ) && 'cpt_manage_taxonomies' !== $_GET['page'] ) {
		return;
	}

	if ( ! empty( $_POST ) ) {
		$result = '';
		if ( isset( $_POST['cpt_submit'] ) ) {
			check_admin_referer( 'cpt_addedit_taxonomy_nonce_action', 'cpt_addedit_taxonomy_nonce_field' );
			$result = cpt_update_taxonomy( $_POST );
		} elseif ( isset( $_POST['cpt_delete'] ) ) {
			check_admin_referer( 'cpt_addedit_taxonomy_nonce_action', 'cpt_addedit_taxonomy_nonce_field' );
			$result = cpt_delete_taxonomy( $_POST );
			add_filter( 'cpt_taxonomy_deleted', '__return_true' );
		}

		// @TODO Utilize anonymous function to admin_notice `$result` if it happens to error.
		if ( $result && is_callable( "cpt_{$result}_admin_notice" ) ) {
			add_action( 'admin_notices', "cpt_{$result}_admin_notice" );
		}

		if ( isset( $_POST['cpt_delete'] ) && empty( cpt_get_taxonomy_slugs() ) ) {
			wp_safe_redirect(
				add_query_arg(
					[ 'page' => 'cpt_manage_taxonomies' ],
					cpt_admin_url( 'admin.php?page=cpt_manage_taxonomies' )
				)
			);
		}
	}
}
add_action( 'init', 'cpt_process_taxonomy', 8 );

/**
 * Handle the conversion of taxonomy terms.
 *
 * This function came to be because we needed to convert AFTER registration.
 *
 * @since 1.4.3
 */
function cpt_do_convert_taxonomy_terms() {

	/**
	 * Whether or not to convert taxonomy terms.
	 *
	 * @since 1.4.3
	 *
	 * @param bool $value Whether or not to convert.
	 */
	if ( apply_filters( 'cpt_convert_taxonomy_terms', false ) ) {
		check_admin_referer( 'cpt_addedit_taxonomy_nonce_action', 'cpt_addedit_taxonomy_nonce_field' );

		cpt_convert_taxonomy_terms( sanitize_text_field( $_POST['tax_original'] ), sanitize_text_field( $_POST['cpt_custom_tax']['name'] ) );
	}
}
add_action( 'init', 'cpt_do_convert_taxonomy_terms' );

/**
 * Handles slug_exist checks for cases of editing an existing taxonomy.
 *
 * @since 1.5.3
 *
 * @param bool   $slug_exists   Current status for exist checks.
 * @param string $taxonomy_slug Taxonomy slug being processed.
 * @param array  $taxonomies    CPT taxonomies.
 * @return bool
 */
function cpt_updated_taxonomy_slug_exists( $slug_exists, $taxonomy_slug = '', $taxonomies = [] ) {
	if (
		( ! empty( $_POST['cpt_tax_status'] ) && 'edit' === $_POST['cpt_tax_status'] ) &&
		! in_array( $taxonomy_slug, cpt_reserved_taxonomies(), true ) &&
		( ! empty( $_POST['tax_original'] ) && $taxonomy_slug === $_POST['tax_original'] )
	) {
		$slug_exists = false;
	}
	return $slug_exists;
}
add_filter( 'cpt_taxonomy_slug_exists', 'cpt_updated_taxonomy_slug_exists', 11, 3 );
