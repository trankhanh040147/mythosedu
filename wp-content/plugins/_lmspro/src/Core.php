<?php
/**
 * Class Core
 *
 * @package  Tutor\Certificate\Builder
 * @author   Themeum <support@themeum.com>
 * @license  GPLv2 or later
 * @link     https://www.themeum.com/product/tutor-lms/
 * @since    1.0.0
 */

namespace Tutor\Certificate\Builder;

/**
 * Class Core
 *
 * @package Tutor\Certificate\Builder
 *
 * @since   1.0.0
 */
class Core {

	/**
	 * Core class constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_certificate_post_type' ] );
	}

	/**
	 * Register certificate post type
	 *
	 * @since 1.0.0
	 */
	public function register_certificate_post_type() {

		$certificate_post_type = Plugin::CERTIFICATE_POST_TYPE;
		$certificate_base_slug = apply_filters( 'tutor_certificate_base_slug', $certificate_post_type );

		$labels = [
			'name'               => __( 'Certificates', 'tutor-lms-certificate-builder' ),
			'singular_name'      => __( 'Certificate', 'tutor-lms-certificate-builder' ),
			'menu_name'          => __( 'Certificates', 'tutor-lms-certificate-builder' ),
			'name_admin_bar'     => __( 'Certificate', 'tutor-lms-certificate-builder' ),
			'add_new'            => __( 'Add New Certificate', 'tutor-lms-certificate-builder' ),
			'add_new_item'       => __( 'Add New Certificate', 'tutor-lms-certificate-builder' ),
			'new_item'           => __( 'New Certificate', 'tutor-lms-certificate-builder' ),
			'edit_item'          => __( 'Edit Certificate', 'tutor-lms-certificate-builder' ),
			'view_item'          => __( 'View Certificate', 'tutor-lms-certificate-builder' ),
			'all_items'          => __( 'Certificates', 'tutor-lms-certificate-builder' ),
			'search_items'       => __( 'Search Certificates', 'tutor-lms-certificate-builder' ),
			'parent_item_colon'  => __( 'Parent Certificates:', 'tutor-lms-certificate-builder' ),
			'not_found'          => __( 'No Certificates found.', 'tutor-lms-certificate-builder' ),
			'not_found_in_trash' => __( 'No Certificates found in Trash.', 'tutor-lms-certificate-builder' ),
		];

		$args = [
			'labels'             => $labels,
			'description'        => __( 'Description.', 'tutor-lms-certificate-builder' ),
			'rewrite'            => [
				'slug' => $certificate_base_slug,
			],
			'capability_type'    => 'post',
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => false,
			'query_var'          => false,
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => [ 'title', 'editor' ],
		];

		register_post_type( $certificate_post_type, $args );
	}
}
