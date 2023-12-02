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
		$course_id = (int) sanitize_text_field( tutor_utils()->array_get( 'cid', $_GET ) );
		$add_students = $_POST['selected_ids'];
		//$add_students_arr = array();
		global $wpdb;
		$add_students_ids_arr = array();
		$table_name_users  = $wpdb->prefix."users";
		if ( $add_students ) {
			//$add_students_arr = explode( "\n", $add_students );
			
			if(count($add_students)){
			$total_enroll = 0;	
			foreach($add_students as $user_id_add){
				
				   if ( $user_id_add ){					   
					   $add_students_ids_arr[] = strval($user_id_add);
					   $is_enrolled = tutor_utils()->is_enrolled( $course_id, $user_id_add );

						if ( !$is_enrolled ) {
							do_action( 'tutor_before_enroll', $course_id );
							$title       = __( 'Course Enrolled', 'tutor-pro' ) . ' &ndash; ' . date_i18n( get_option( 'date_format' ) ) . ' @ ' . date_i18n( get_option( 'time_format' ) );
							$enroll_data = apply_filters(
								'tutor_enroll_data',
								array(
									'post_type'   => 'tutor_enrolled',
									'post_title'  => $title,
									'post_status' => 'completed',
									'post_author' => $user_id_add,
									'post_parent' => $course_id,
								)
							);

							$is_enrolled = wp_insert_post( $enroll_data );
							
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
											'post_author' => $user_id_add,
											'post_parent' => $cid,
										)
									);

									$is_enrolled_child = wp_insert_post( $enroll_data_child );
								}
							}
							
							if ( $is_enrolled ) {
								
								update_user_meta( $user_id_add, '_is_tutor_student', tutor_time() );

								do_action( 'tutor_enrollment/after/complete', $is_enrolled );
								$total_enroll +=1;
							}
							$this->success_msgs = get_tnotice( __( $total_enroll.' Enrolment has been done', 'tutor-pro' ), 'Success', 'success' );
						}
						
					}
				
			}			
			}
		}	
		if($total_enroll)
			$this->success_msgs = get_tnotice( __( 'Enrolment has been done! '.$total_enroll.' more students enrolled.', 'tutor-pro' ), 'Success', 'success' );
		else 
			$this->success_msgs = get_tnotice( __( 'Enrolment failed! No student selected.', 'tutor-pro' ), 'Error', 'danger' );
		add_filter( 'student_enrolled_to_course_msg', array( $this, 'return_message' ) );
	}


	public function return_message() {
		return $this->success_msgs;
	}

}
