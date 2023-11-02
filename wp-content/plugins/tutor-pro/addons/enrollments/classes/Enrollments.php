<?php
/**
 * Enrollments class
 *
 * @author: themeum
 * @link https://themeum.com
 * @package Tutor
 * @since 1.4.0
 */

namespace TUTOR_ENROLLMENTS;

use TUTOR\Input;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Enrollments {

	/**
	 * Success message
	 *
	 * @var string
	 * @deprecated 2.0.6
	 */
	protected $success_msgs = '';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'tutor_admin_register', array( $this, 'register_menu' ) );

		add_action( 'wp_ajax_tutor_json_search_students', array( $this, 'tutor_json_search_students' ) );
		add_action( 'tutor_action_enrol_student', array( $this, 'enrol_student' ) );
		add_action( 'wp_ajax_tutor_search_students', array( $this, 'tutor_search_students' ) );
		add_action( 'wp_ajax_tutor_enroll_bulk_student', array( $this, 'tutor_enroll_bulk_student' ) );
	}

	/**
	 * Register Enrollment Menu
	 *
	 * @return void
	 * @since 2.0.0
	 */
	public function register_menu() {
		add_submenu_page( 'tutor', __( 'Enrollment', 'tutor-pro' ), __( 'Enrollment', 'tutor-pro' ), 'manage_tutor', 'enrollments', array( $this, 'enrollments' ) );
	}

	/**
	 * Manual Enrollment Page
	 *
	 * @return void
	 * @since 2.0.0
	 */
	public function enrollments() {
		include TUTOR_ENROLLMENTS()->path . 'views/enrollments.php';
	}

	/**
	 * Student search ajax handler
	 *
	 * @return void
	 * @since 2.0.0
	 * @deprecated 2.0.6
	 */
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
	 * Student advance search
	 *
	 * @return string
	 *
	 * @since 2.0.6
	 */
	public function tutor_search_students() {
		tutor_utils()->checking_nonce();

		global $wpdb;

		$term        = Input::post( 'term', '' );
		$course_id   = Input::post( 'course_id', 0, Input::TYPE_INT );
		$term        = '%' . $term . '%';
		$shortlisted = Input::post( 'shortlisted', array(), Input::TYPE_ARRAY );

		// Validate each shortlisted item is numeric value
		$shortlisted = array_filter(
			$shortlisted,
			function( $id ) {
				return is_numeric( $id );
			}
		);

		if ( Input::has( 'term' ) ) {
			$sql = "SELECT * FROM {$wpdb->users} WHERE ( display_name LIKE %s OR user_email LIKE %s )";

			$enrolled_student_ids = tutor_utils()->get_students_data_by_course_id( $course_id, 'ID' );
			$exclude_arr          = array_merge( $enrolled_student_ids, $shortlisted );

			if ( count( $exclude_arr ) ) {
				$excluded_ids = implode( ',', $exclude_arr );
				$sql         .= " AND ID NOT IN ({$excluded_ids})";
			}

			$sql .= ' LIMIT 6';

			$student_res = $wpdb->get_results( $wpdb->prepare( $sql, $term, $term ) );
			$students    = array();

			if ( tutor_utils()->count( $student_res ) ) {
				foreach ( $student_res as $student ) {
					$students[] = array(
						'id'    => $student->ID,
						'name'  => $student->display_name,
						'email' => $student->user_email,
						'photo' => get_avatar_url( $student->ID ),
					);
				}
			}

			$search_result = '';
			if ( is_array( $student_res ) && count( $student_res ) ) {
				foreach ( $student_res as $row ) {
					ob_start();
					include TUTOR_ENROLLMENTS()->path . '/views/search-result-item.php';
					$search_result .= ob_get_clean();
				}
			} else {
				$search_result .= '<div class="tutor-text-center tutor-mb-20"> <span>' . __( 'No student found!', 'tutor' ) . '</span> </div>';
			}

			wp_send_json(
				array(
					'success' => true,
					'data'    => $search_result,
				)
			);
		}

		if ( Input::has( 'selection' ) ) {
			$shortlisted_html = '';
			foreach ( $shortlisted as $id ) {
				$user = get_userdata( $id );
				ob_start();
				include TUTOR_ENROLLMENTS()->path . '/views/search-selected-item.php';
				$shortlisted_html .= ob_get_clean();
			}

			$shortlisted_html = '<div class="tutor-fs-6 tutor-fw-medium tutor-color-secondary tutor-mb-16">' . __( 'Selected Student', 'tutor-pro' ) . '</div>
								<div class="tutor-d-flex tutor-flex-wrap tutor-gap-2">' . $shortlisted_html . '</div>';
			wp_send_json(
				array(
					'success' => true,
					'data'    => $shortlisted_html,
				)
			);
		}

	}

	/**
	 * Enroll multiple student by course ID
	 *
	 * @return void
	 *
	 * @since 2.0.6
	 */
	public function tutor_enroll_bulk_student() {

		tutor_utils()->checking_nonce();

		// Comma seperated string id
		$student_ids = Input::post( 'student_ids' );
		$student_ids = array_filter(
			explode( ',', $student_ids ),
			function( $id ) {
				return is_numeric( $id );
			}
		);

		$course_id = Input::post( 'course_id', Input::TYPE_INT );

		// Check all selected student are not enrolled before
		$flag = false;
		foreach ( $student_ids as $student_id ) {
			$is_enrolled = tutor_utils()->is_enrolled( $course_id, $student_id );
			if ( false !== $is_enrolled ) {
				$flag = $student_id;
				break;
			}
		}

		if ( false !== $flag ) {
			$student = get_userdata( $student_id );
			wp_send_json(
				array(
					'success' => false,
					'message' => __(
						"{$student->display_name} is already enrolled for selected course",
						'tutor-pro'
					),
				)
			);
		}

		$is_paid_course   = tutor_utils()->is_course_purchasable( $course_id );
		$monetize_by      = tutor_utils()->get_option( 'monetize_by' );
		$generate_invoice = tutor_utils()->get_option( 'tutor_woocommerce_invoice' );
		// Now enroll each student for selected course.
		foreach ( $student_ids as $student_id ) {
			$order_id = 0;
			/**
			 * Check generate invoice settings along with monetize by
			 *
			 * @since 2.1.4
			 */
			if ( $is_paid_course && 'wc' === $monetize_by && $generate_invoice ) {
				// Make an manual order for student with this course.
				$product_id = tutor_utils()->get_course_product_id( $course_id );
				$order      = wc_create_order();

				$order->add_product( wc_get_product( $product_id ), 1 );
				$order->set_customer_id( $student_id );
				$order->calculate_totals();
				$order->update_status( 'Pending payment', __( 'Manual Enrollment Order', 'tutor-pro' ), true );

				$order_id = $order->get_id();

				/**
				 * Set transient for showing modal in view enrollment-success-modal.php
				 */
				$course = get_post( $course_id );
				set_transient( 'tutor_manual_enrollment_success', $course );
			}

			/**
			 * Paid course enrollment will automatically completed without generate a WC order 
			 * If user disable generate invoice from tutor settings
			 *
			 * @since 2.1.4
			 */
			if ( ! $generate_invoice && $is_paid_course && 'wc' === $monetize_by) {
				add_filter( 'tutor_enroll_data', function( $data ) {
					$data['post_status'] = 'completed';
					return $data;
				});
			}

			tutor_utils()->do_enroll( $course_id, $order_id, $student_id );
		}

		wp_send_json(
			array(
				'success' => true,
				'message' => __(
					'Enrollment done for selected students',
					'tutor-pro'
				),
			)
		);

	}

	/**
	 * Manually enrol a student this this course
	 * By Course ID, Student ID
	 *
	 * @since v.1.4.0
	 * @deprecated 2.0.6
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
			if ( $is_enrolled ) {
				do_action( 'tutor_after_enroll', $course_id, $is_enrolled );

				// Run this hook for only completed enrollment regardless of payment provider and free/paid mode
				if ( $enroll_data['post_status'] == 'completed' ) {
					do_action( 'tutor_after_enrolled', $course_id, $user_id, $is_enrolled );
				}

				// Change the enrol status again. to fire complete hook
				tutor_utils()->course_enrol_status_change( $is_enrolled, 'completed' );
				// Mark Current User as Students with user meta data
				update_user_meta( $user_id, '_is_tutor_student', tutor_time() );

				do_action( 'tutor_enrollment/after/complete', $is_enrolled );
			}

			$this->success_msgs = get_tnotice( __( 'Enrollment has been done', 'tutor-pro' ), 'Success', 'success' );
		}

		add_filter( 'student_enrolled_to_course_msg', array( $this, 'return_message' ) );
	}

	/**
	 * Get messsage
	 *
	 * @return void
	 * @deprecated 2.0.6
	 */
	public function return_message() {
		return $this->success_msgs;
	}

}
