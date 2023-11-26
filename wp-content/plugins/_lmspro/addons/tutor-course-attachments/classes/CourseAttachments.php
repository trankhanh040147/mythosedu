<?php
/**
 * Tutor Course attachments Main Class
 */

namespace TUTOR_CA;

use TUTOR\Tutor_Base;

class CourseAttachments extends Tutor_Base {

	private $open_mode = 'tutor_pro_attachment_open_type';

	public function __construct() {
		parent::__construct();
		add_action( 'add_meta_boxes', array( $this, 'register_meta_box' ) );
		add_action( 'tutor/frontend_course_edit/after/course_builder', array( $this, 'register_meta_box_in_frontend' ), 12 );

		add_filter( 'tutor_course/single/nav_items', array( $this, 'add_course_nav_item' ), 10, 2 );

		/**
		 * listen only save_post will hook for every post type
		 * course / lesson / quizz etc
		 * removed save_post_courses hook to avoid redundancy
		 *
		 * @since 1.8.9
		*/
		add_action( 'save_post', array( $this, 'save_course_meta' ) );
		add_action( 'save_tutor_course', array( $this, 'save_course_meta' ) );

		add_filter( 'tutor/options/extend/attr', array( $this, 'add_option' ) );
		add_filter( 'tutor_pro_attachment_open_mode', array( $this, 'set_open_open_mode' ) );
	}

	public function set_open_open_mode() {
		return tutor_utils()->get_option( $this->open_mode );
	}

	public function add_option( $attr ) {

		$attr['course']['blocks']['block_course']['fields'][] = array(
			'key'     => $this->open_mode,
			'type'    => 'radio_horizontal_full',
			'label'   => __( 'Attachment Open Mode', 'tutor-pro' ),
			'default' => 'download',
			'options' => array(
				'download' => __( 'Download', 'tutor-pro' ),
				'view'     => __( 'View in new tab', 'tutor-pro' ),
			),
			'desc'    => __( 'How you want users to view attached files.', 'tutor-pro' ),
		);

		return $attr;
	}

	public function add_course_nav_item( $items, $course_id ) {
		if ( is_single() && $course_id ) {
			$items['resources'] = array(
				'title'             => __( 'Resources', 'tutor-pro' ),
				'method'            => array( $this, 'load_resource_tab_content' ),
				'require_enrolment' => true,
			);
		}

		return $items;
	}

	public function load_resource_tab_content( $course_id ) {
		get_tutor_posts_attachments();
	}

	public function register_meta_box() {
		$coursePostType = tutor()->course_post_type;

		/**
		 * Check is allow private file upload
		 */
		tutor_meta_box_wrapper(
			'tutor-course-attachments',
			__( 'Attachments (private files)', 'tutor-pro' ),
			array( $this, 'course_attachments_metabox' ),
			$coursePostType,
			'advanced',
			'high',
			'tutor-admin-post-meta'
		);
	}

	public function register_meta_box_in_frontend() {
		course_builder_section_wrap( $this->course_attachments_metabox( $echo = false ), __( 'Course Attachments', 'tutor-pro' ) );
	}

	public function course_attachments_metabox( $echo = true ) {
		ob_start();
		include TUTOR_CA()->path . 'views/metabox/course-attachments-metabox.php';
		$content = ob_get_clean();

		if ( $echo ) {
			echo $content;
		} else {
			return $content;
		}
	}

	/**
	 * upload attachment only if $_POST[tutor_attachments]
	 * is not empty else delete
	 * it will remove empty data in db
	 *
	 * @since 1.8.9
	 */
	public function save_course_meta( $post_ID ) {
		// Attachments
		$attachments           = array();
		$attachments_main_edit = tutor_utils()->avalue_dot( '_tutor_attachments_main_edit', $_POST );

		// Make sure it is post editor
		if ( ! tutor_utils()->avalue_dot( '_tutor_attachments_main_edit', $_POST ) ) {
			return;
		}

		// Get unique attachment ID. User might add single media multiple times
		if ( ! empty( $_POST['tutor_attachments'] ) ) {
			$attachments = tutor_utils()->sanitize_array( $_POST['tutor_attachments'] );
			$attachments = array_unique( $attachments );
		}

		// Update assignment meta if at least one exist
		// Otherwise delete the meta
		if ( ! empty( $attachments ) ) {
			update_post_meta( $post_ID, '_tutor_attachments', $attachments );
		} else {
			delete_post_meta( $post_ID, '_tutor_attachments' );
		}
	}
}
