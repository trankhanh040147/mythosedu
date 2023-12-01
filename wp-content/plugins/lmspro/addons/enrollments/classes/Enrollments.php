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
		$course_id = (int) sanitize_text_field( tutor_utils()->array_get( 'course_id', $_POST ) );
		$add_students = $_POST['add_students'];
		$add_students_arr = array();
		global $wpdb;
		$add_students_ids_arr = array();
		$table_name_users  = $wpdb->prefix."users";
		if ( $add_students ) {
			$add_students_arr = explode( "\n", $add_students );
			
			if(count($add_students_arr)){
			$total_enroll = 0;	
			foreach($add_students_arr as $student){
				$student_arr 			= explode( ",", $student );				
				$student_email 			= isset($student_arr[0]) ? trim($student_arr[0]) : '';
				$student_branch_id 		= isset($student_arr[1]) ? trim($student_arr[1]) : '';
				$student_branch_name 	= isset($student_arr[2]) ? trim($student_arr[2]) : '';
				$student_gender 		= isset($student_arr[3]) ? trim($student_arr[3]) : '';
				$student_age 			= isset($student_arr[4]) ? trim($student_arr[4]) : '';
				
				if (filter_var($student_email, FILTER_VALIDATE_EMAIL)) {
				   $user_id_add = email_exists($student_email);
				   if ( !$user_id_add ){
					   $user_data = array(
							'user_login' => $student_email,
							'user_email' => $student_email,
							'role'       =>  'subscriber',
							'user_pass'  => $student_email,
						);

						$user_id_add = wp_insert_user( $user_data );
						if ($user_id_add) {
							update_user_meta( $user_id_add, '_tutor_vus_member', 'Internal' );
							if($student_gender)	update_user_meta( $user_id_add, '_tutor_gender', $student_gender );
							if($student_age)	update_user_meta( $user_id_add, '_tutor_age', $student_age );
							$table_name  = $wpdb->prefix."users";
							$wpdb->query( $wpdb->prepare("UPDATE $table_name 
											SET Branch_ID = %s, Branch_Name = %s  
											WHERE ID = %d",$student_branch_id,$student_branch_name, $user_id_add)
								);
						}
				   }
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
								if(defined("__SENDEMAIL_ON_OFF") && __SENDEMAIL_ON_OFF == '__MAIL_ON'){
									$subject = 'Course Enrolled';
									$body = "Hi, you was enrolled a course on traininghub-uat.vus.edu.vn";
									$headers = array('Content-Type: text/html; charset=UTF-8');
									$wp_mail = wp_mail( $student_email, $subject, $body, $headers );
									if($wp_mail) $wp_mail = '. Mails sent!';
									else $wp_mail = '. Mails sent failed!';
								}								
								
								do_action( 'tutor_after_enroll', $course_id, $is_enrolled );

								if ( $enroll_data['post_status'] == 'completed' ) {
									do_action( 'tutor_after_enrolled', $course_id, $user_id_add, $is_enrolled );
								}

								update_user_meta( $user_id_add, '_is_tutor_student', tutor_time() );

								do_action( 'tutor_enrollment/after/complete', $is_enrolled );
								$total_enroll +=1;
							}
							$this->success_msgs = get_tnotice( __( 'Enrolment has been done', 'tutor-pro' ), 'Success', 'success' );
						}
						
					}
				}
			}
			$user_current = wp_get_current_user();
			if ( in_array( 'shop_manager', (array) $user_current->roles ) || in_array( 'st_lt', (array) $user_current->roles ) ) {
				$staff_id = $user_current->ID;
				if($staff_id){
					$entry = $wpdb->get_row( "SELECT * FROM ".$table_name_users." WHERE ID = '" . $staff_id . "'");
					if (isset($entry)){					
						$Manage_Users = $entry->Manage_Users;
					}
					$Manage_Users_arr = explode(",",$Manage_Users);
					$add_students_ids_arr_m = array_unique (array_merge($Manage_Users_arr,$add_students_ids_arr));
					$add_students_ids_arr_str = implode(",",$add_students_ids_arr_m);
					$wpdb->query( $wpdb->prepare("UPDATE $table_name_users 
													SET Manage_Users = %s  
													WHERE ID = %d",$add_students_ids_arr_str, $staff_id)
										);//die();
				}
			}
			if($total_enroll)
					$this->success_msgs = get_tnotice( __( 'Enrolment has been done'.$wp_mail, 'tutor-pro' ), 'Success', 'success' );
			else 
					$this->success_msgs = get_tnotice( __( 'Enrolment failed! Please enter valid email!', 'tutor-pro' ), 'Error', 'danger' );
			add_filter( 'student_enrolled_to_course_msg', array( $this, 'return_message' ) );	
			return;
			}
		}	
		
		

		$user_id   = (int) sanitize_text_field( tutor_utils()->array_get( 'student_id', $_POST ) );
		if(!$user_id){
			$this->success_msgs = get_tnotice( __( 'Please enter students', 'tutor-pro' ), 'Error', 'danger' );
			add_filter( 'student_enrolled_to_course_msg', array( $this, 'return_message' ) );
			return;
		}		
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
