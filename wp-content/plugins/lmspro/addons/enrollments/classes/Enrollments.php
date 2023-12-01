<?php
/**
 * Enrollments class
 *
 * @author: themeum
 * @author_uri: https://themeum.com
 * @package Tutor
 * @since v.1.4.0
 */

namespace TUTOR_ENROLLMENTS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Enrollments {

	protected $success_msgs = '';

	public function __construct() {
		add_action( 'tutor_admin_register', array( $this, 'register_menu' ) );

		add_action( 'wp_ajax_tutor_json_search_students', array( $this, 'tutor_json_search_students' ) );
		add_action( 'tutor_action_enrol_student', array( $this, 'enrol_student' ) );
	}

	public function register_menu() {
		add_submenu_page( 'tutor', __( 'Enrolment', 'tutor-pro' ), __( 'Enrolment', 'tutor-pro' ), 'manage_tutor', 'enrollments', array( $this, 'enrollments' ) );
	}

	/**
	 * View the page of
	 */
	public function enrollments() {
		$sub_page = tutor_utils()->array_get( 'sub_page', $_GET );
		if ( $sub_page ) {
			include TUTOR_ENROLLMENTS()->path . "views/{$sub_page}.php";
		} else {
			include TUTOR_ENROLLMENTS()->path . 'views/enrollments.php';
		}
	}




	public function tutor_json_search_students() {
		tutor_utils()->checking_nonce();

		global $wpdb;

		$term = sanitize_text_field( tutor_utils()->array_get( 'term', $_POST ) );
		$term = '%' . $term . '%';

		$student_res = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->users} WHERE display_name LIKE %s OR user_email LIKE %s", $term, $term ) );
		$students    = array();

		if ( tutor_utils()->count( $student_res ) ) {
			foreach ( $student_res as $student ) {
				$students[ $student->ID ] = sprintf(
					esc_html__( '%1$s (#%2$s - %3$s)', 'tutor-pro' ),
					$student->display_name,
					$student->ID,
					$student->user_email
				);
			}
		}

		wp_send_json( $students );
	}

	/**
	 * Manually enrol a student this this course
	 * By Course ID, Student ID
	 *
	 * @since v.1.4.0
	 */
	public function enrol_student() {
		$user_id   = (int) sanitize_text_field( tutor_utils()->array_get( 'student_id', $_POST ) );
		$course_id = (int) sanitize_text_field( tutor_utils()->array_get( 'course_id', $_POST ) );

		$is_enrolled = tutor_utils()->is_enrolled( $course_id, $user_id );

		if ( $is_enrolled ) {
			$this->success_msgs = get_tnotice( __( 'This user has been already enrolled on this course', 'tutor-pro' ), 'Error', 'danger' );
		} elseif ( tutor_utils()->is_course_fully_booked( $course_id ) ) {
			$this->success_msgs = get_tnotice( __( 'Maximum student is reached!', 'tutor-pro' ), 'Error', 'danger' );
		} else {
			/**
			 * Enroll Now
			 */

			do_action( 'tutor_before_enroll', $course_id );
			$title       = __( 'Course Enrolled', 'tutor-pro' ) . ' &ndash; ' . date_i18n( get_option( 'date_format' ) ) . ' @ ' . date_i18n( get_option( 'time_format' ) );
			$enroll_data = apply_filters(
				'tutor_enroll_data',
				array(
					'post_type'   => 'tutor_enrolled',
					'post_title'  => $title,
					'post_status' => 'completed',
					'post_author' => $user_id,
					'post_parent' => $course_id,
				)
			);

			// Insert the post into the database
			$is_enrolled = wp_insert_post( $enroll_data );
			
			//NhatHuy:	enroll children course
			$children_ids = get_post_meta( $course_id, '_tutor_course_children', true );
			$children_ids_arr = array();
			if($children_ids)
				$children_ids_arr = explode(" ",trim($children_ids));
			if(count($children_ids_arr)){
				foreach($children_ids_arr as $cid){
					$title       = __( 'Course Enrolled', 'tutor-pro' ) . ' &ndash; ' . date_i18n( get_option( 'date_format' ) ) . ' @ ' . date_i18n( get_option( 'time_format' ) );
					$enroll_data_child = apply_filters(
						'tutor_enroll_data',
						array(
							'post_type'   => 'tutor_enrolled',
							'post_title'  => $title,
							'post_status' => 'completed',
							'post_author' => $user_id,
							'post_parent' => $cid,
						)
					);

					// Insert the post into the database
					$is_enrolled_child = wp_insert_post( $enroll_data_child );
				}
			}
			
			if ( $is_enrolled ) {
				do_action( 'tutor_after_enroll', $course_id, $is_enrolled );

				// Run this hook for only completed enrolment regardless of payment provider and free/paid mode
				if ( $enroll_data['post_status'] == 'completed' ) {
					do_action( 'tutor_after_enrolled', $course_id, $user_id, $is_enrolled );
				}

				// Change the enrol status again. to fire complete hook
				tutor_utils()->course_enrol_status_change( $is_enrolled, 'completed' );
				// Mark Current User as Students with user meta data
				update_user_meta( $user_id, '_is_tutor_student', tutor_time() );

				do_action( 'tutor_enrollment/after/complete', $is_enrolled );
			}

			$this->success_msgs = get_tnotice( __( 'Enrolment has been done', 'tutor-pro' ), 'Success', 'success' );
		}

		add_filter( 'student_enrolled_to_course_msg', array( $this, 'return_message' ) );
	}


	public function return_message() {
		return $this->success_msgs;
	}

}
