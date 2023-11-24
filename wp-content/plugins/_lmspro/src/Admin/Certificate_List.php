<?php
/**
 * Class Admin
 *
 * @package  Tutor\Certificate\Builder
 * @author   Themeum <support@themeum.com>
 * @license  GPLv2 or later
 * @link     https://www.themeum.com/product/tutor-lms/
 * @since    1.0.0
 */

namespace Tutor\Certificate\Builder\Admin;

use \Tutor\Certificate\Builder\Plugin;
use \Tutor\Certificate\Builder\Helper;
use \WP_List_Table;

/**
 * Class Admin
 *
 * @package Tutor\Certificate\Builder\Admin
 *
 * @since   1.0.0
 */
class Certificate_List extends WP_List_Table {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		// Set parent defaults.
		parent::__construct(
			[
				'singular' => 'Certificate',      // singular name of the listed records.
				'plural'   => 'Certificates',    // plural name of the listed records.
				'ajax'     => false,            // does this table support ajax?
			]
		);
	}

	/**
	 * Render a column when no column specific method exists.
	 *
	 * @param  object  $item row values.
	 * @param  string $column_name col name.
	 *
	 * @return mixed
	 *
	 * @since  1.0.0
	 */
	public function column_default( $item, $column_name ) {
		$edit_url = apply_filters( 'tutor_certificate_builder_url', $item->ID);
		
		$args = [
			'action' => Plugin::DELETE_ACTION,
			'post'   => $item->ID,
			// 'user' => get_current_user_id(),
			'_wpnonce'   => wp_create_nonce( 'tutor_delete_post-' . $item->ID),
		];

		$delete_query_arg = add_query_arg( $args, admin_url( 'admin.php?page=tutor-certificate-templates' ) );
        $delete_url = wp_nonce_url( $delete_query_arg, "tutor_delete_post-{$item->ID}" );

		switch ($column_name) {
			case 'post_title':
			case 'post_status':
				return $item->$column_name;
			case 'action':
				return '<a href="'.$edit_url.'" class="button button-primary">Edit</a> <a href="'.$delete_url.'" onclick="return confirm(\'' . __('Sure to Delete?', 'tutor-lms-certificate-builder') . '\');" class="button">Delete</a>';
			default:
				return print_r($item, true); //Show the whole array for troubleshooting purposes
		}
	}

	/**
	 * Associative array of columns
	 *
	 * @return array
	 *
	 * @since  1.0.0
	 */
	public function get_columns() {
		$columns = [
			'post_title'  => __( 'Template', 'tutor-lms-certificate-builder' ),
			'post_status' => __( 'Status', 'tutor-lms-certificate-builder' ),
			'action'      => '',
		];

		return $columns;
	}

	/**
	 * Get total items count
	 *
	 * @param  string $search_text search keyword.
	 *
	 * @return int
	 *
	 * @since  1.0.0
	 */
	public function get_total_items( $search_text = '' ) {
		global $wpdb;

		$certificate_post_type = Plugin::CERTIFICATE_POST_TYPE;

		$total_items = (int) $wpdb->get_var( $wpdb->prepare(
			"SELECT COUNT(ID)
            FROM    $wpdb->posts
            WHERE   post_type = %s
                    AND post_title LIKE %s",
			$certificate_post_type,
			$search_text
		) );

		return $total_items;
	}

	/**
	 * Get items data
	 * 
	 * @param  int    $start from row.
	 * @param  int    $limit total row limit.
	 * @param  string $search_text search keyword.
	 *
	 * @return array
	 *
	 * @since  1.0.0
	 */
	public function get_items( $start = 0, $limit = 10, $search_text = '', $author_id = null ) {
		global $wpdb;

		$certificate_post_type = Plugin::CERTIFICATE_POST_TYPE;
		$author_condition = $author_id ? ' AND post_author=' . $author_id : '';

		$results = $wpdb->get_results( $wpdb->prepare(
			"SELECT *
            FROM    $wpdb->posts
            WHERE   post_type = %s
                    AND post_title LIKE %s
					{$author_condition}
            LIMIT 	%d, %d;
            ",
			$certificate_post_type,
			$search_text,
			$start,
			$limit
		) );

		return $results;
	}

	/**
	 * Prepares the list of items for displaying.
	 *
	 * @since 1.0.0
	 */
	public function prepare_items() {
		global $wpdb;

		$author_id 			   = tutor_utils()->has_user_role('administrator') ? null : get_current_user_id();

		$per_page              = 10;
		$current_page          = $this->get_pagenum();
		$start                 = ( $current_page - 1 ) * $per_page;
		$search_text           = isset( $_REQUEST['s'] ) ? $_REQUEST['s'] : '';
		$search_text           = '%' . $wpdb->esc_like( $search_text ) . '%';

		$columns               = $this->get_columns();
		$total_items           = $this->get_total_items( $search_text );
		$items                 = $this->get_items( $start, $per_page, $search_text, $author_id );

		$this->_column_headers = [ $columns ];
		$this->items           = $items;

		$this->set_pagination_args([
			'total_items' => $total_items,                      // Calculate the total number of items
			'per_page'    => $per_page,                         // Determine how many items to show on a page
			'total_pages' => ceil( $total_items / $per_page )   // Calculate the total number of pages
		]);
	}



	/**
	 * Delete Certificate after validation
	 * 
	 * @since 1.0.0
	 * 
	 * @return 
	 */
	public function delete_certificate() {

		if ( false === Helper::on_delete_certificate() ) {
			return;
		}

		if ( false === Helper::has_editor_access() ) {
			return;
		}

		// Todo:: User ID base Deletion

		$post_id = absint( $_REQUEST['post'] );
		$_nonce = $_REQUEST['_wpnonce'];

		if ( ! Helper::is_nonce_valid($_nonce, "tutor_delete_post-".$post_id ) ) {
			return;
		}

		if ( false === Helper::has_user_permission($post_id, "delete_certificate") ) {
			return;
		}

		return !!wp_delete_post($post_id);

	}
}
