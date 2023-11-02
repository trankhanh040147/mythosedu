<?php

/**
 * Class Ajax
 *
 * @package  Tutor\Certificate\Builder
 * @author   Themeum <support@themeum.com>
 * @license  GPLv2 or later
 * @link     https://www.themeum.com/product/tutor-lms/
 * @since    1.0.0
 */

namespace Tutor\Certificate\Builder;


/**
 * Class Ajax
 *
 * @package Tutor\Certificate\Builder
 *
 * @since   1.0.0
 */
class Ajax
{
	/**
	 * Ajax constructor.
	 */
	public function __construct()
	{
		add_action('wp_ajax_tutor_save_certificate', array($this, 'tutor_save_certificate'));
		add_action('wp_ajax_tutor_save_draft_certificate', array($this, 'tutor_save_certificate'));

		add_action('wp_ajax_tutor_view_certificate', array($this, 'tutor_view_certificate'));
		add_action('wp_ajax_nopriv_tutor_view_certificate', array($this, 'tutor_view_certificate'));

		add_action('wp_ajax_tutor_certificate_store_preview', array($this, 'tutor_certificate_store_preview'));
		add_action('wp_ajax_nopriv_tutor_certificate_store_preview', array($this, 'tutor_certificate_store_preview'));
		add_action( 'wp_ajax_tutor_get_cert_info', array($this, 'tutor_get_cert_info') );
		add_action( 'wp_ajax_nopriv_tutor_get_cert_info', array($this, 'tutor_get_cert_info') );
		add_action( 'wp_ajax_tutor_delete_certificate_template', array($this, 'tutor_delete_certificate') );
		add_action( 'wp_ajax_tutor_cb_template_status_update', array($this, 'tutor_cb_template_status_update') );
	}

	public function tutor_cb_template_status_update() {
		tutor_utils()->checking_nonce();

		// Get the template info
		$status = tutor_utils()->array_get('status', $_POST);
		$template_id = tutor_utils()->array_get('template_id', $_POST);

		wp_update_post( array('post_status' => $status, 'ID' => $template_id) );

		wp_send_json_success( array('message' => 'Certificate Status Updated') );
	}

	public function tutor_delete_certificate() {
		tutor_utils()->checking_nonce();
		$id = tutor_utils()->array_get('certificate_id', $_POST);
		
		// Check permission
		if($id && is_numeric($id)) {
			$has_access = tutor_utils()->has_user_role('administrator') || get_post_field( 'post_author', $id )==get_current_user_id();

			if($has_access) {
				// Delete thumbnail		
				$basedir = wp_upload_dir()['basedir'] . DIRECTORY_SEPARATOR . Plugin::CERTIFICATE_TEMPLATE_DIR;
				$_name = get_post_meta( $id, Plugin::CERTIFICATE_PREVIEW_META_KEY, true );
				$path = $basedir . DIRECTORY_SEPARATOR . $_name;
				file_exists($path) ? unlink($path) : 0;

				// Now delete the post 
				wp_delete_post($id, true);

				// Send response
				wp_send_json_success();
				exit;
			}
			
		}
		
		wp_send_json_error( array(
			'message' => __('Permission Denied', 'tutor-lms-certificate-builder')
		) );
	}

	private function get_user_name($user){
		$user_name = '';
		!$user_name ? $user_name = trim($user->display_name) : 0;
		!$user_name ? $user_name = trim($user->user_firstname.' '.$user->user_lastname) : 0;
		!$user_name ? $user_name = $user->user_login : 0;
		return $user_name;
	}

	public function tutor_get_cert_info() {
		$cert_hash = sanitize_text_field(tutils()->array_get('cert_hash', $_GET));

		// Check gradebook if enabled
		$has_gradebook = function_exists('TUTOR_GB') && tutor_utils()->is_addon_enabled(TUTOR_GB()->basename);

		if (empty($cert_hash) || !is_string($cert_hash)) {
			$signature_url = apply_filters( 'tutor_certificate_instructor_signature', get_current_user_id(), false) ;
			$signature_url = $signature_url ? str_replace(get_home_url(), '', $signature_url) : '';
			
			wp_send_json_success( array(
				"SIGNATURE_URL" => $signature_url,
				'ADDONS' => array(
					'gradebook' => $has_gradebook
				)
			) );
			exit;
		}

		// Check if course completed
		$completed = apply_filters( 'tutor_certificate_completion_data', $cert_hash );
		if (!is_object($completed) || !property_exists($completed, 'completed_user_id')) {
			wp_send_json_error( 'Invalid Course' );
			exit;
		}

		// Get course info
		$course = get_post($completed->course_id);
		$student = get_userdata($completed->completed_user_id);
		$instructor = get_userdata(get_post_field( 'post_author', $completed->course_id ));
		
		// PDF download name
		$user = get_userdata(get_current_user_id());
		$formatted_date = date_format(date_create(), get_option('date_format'));
		$pdf_name = 'Certificate_for_'. str_replace( ' ', '_', $user->display_name );

		// Get signature URL
		$signature_url = apply_filters( 'tutor_certificate_instructor_signature', $instructor->ID, false );
		$signature_url = $signature_url ? str_replace(get_home_url(), '', $signature_url) : '';

		// Get grade info
		$def_grade = array(
			'gradename' => '',
			'gradepoint' => ''
		);
		$grade = apply_filters( 'tutor_gradebook_get_final_stats', $def_grade, $completed->course_id );

		wp_send_json_success( array(
			'COURSE_TITLE' 		=> $course->post_title,
            'STUDENT_NAME' 		=> $this->get_user_name($student),
            'INSTRUCTOR_NAME' 	=> $this->get_user_name($instructor),
            'VERIFICATION_ID' 	=> $cert_hash,
            'POINT' 			=> $grade['gradepoint'],
            'GRADE' 			=> $grade['gradename'],
            'QR_URL' 			=> apply_filters( 'tutor_certificate_public_url', $cert_hash ),
            'TIME' 				=> date_format(date_create($completed->completion_date), get_option('date_format')),
            'DURATION' 			=> tutor_utils()->get_course_duration($completed->course_id, false),
            'SIGNATURE_URL' 	=> $signature_url,
			'PDF_NAME' 			=> $pdf_name,
			'ADDONS' 			=> array(
				'gradebook' => $has_gradebook
			)
		) );
	}

	/**
	 * Save Certificate Draft data
	 * 
	 * @return json
	 */
	public function tutor_save_certificate()
	{
		if(false === Helper::has_editor_access()) {
			wp_send_json_error( array('message' => 'You can not save certificate!') );
			exit;
		}
		
		$result = array(
			"type" => "",
			"message" => "",
		);

		$certificate_id 	= $_POST['certificate_id'];
		$certificate_data 	= $_POST['certificate_data'];
		$nonce 				= $_POST['_wpnonce'];

		//Check for nonce security   
		if (!wp_verify_nonce($nonce, 'tutor-lms-certificate-builder')) {
			$result['type'] 	= 'error';
			$result['message'] 	= __('Bad Request sent. Please try again.', 'tutor-lms-certificate-builder');
			die($result);
		}

		// Remove Back slash from string
		$certificate_data_str 	= preg_replace('/\\\"/', "\"", $certificate_data);
		$certificate_data_arr 	= json_decode(stripslashes($certificate_data_str), true, JSON_UNESCAPED_SLASHES);
		$post_data 				= $certificate_data_arr['post'];
		
		// Unset Post data 
		unset($certificate_data_arr['post']);

		// Make Certificate data Json String 
		$certificate_data_json 	= serialize($certificate_data_arr);

		// Save Data
		$is_draft = $_POST['action']=='tutor_save_draft_certificate';
		$meta_key = $is_draft ? 'tutor_certificate_draft_data' : 'tutor_certificate_data';
		update_post_meta($certificate_id, $meta_key, $certificate_data_json);

		// Get and save the dimension in another meta for easy access
		$dimension = 'portrait';
		if(isset($certificate_data_arr['canvas'])) {
			$dimension = $certificate_data_arr['canvas']['attributes']['width']>$certificate_data_arr['canvas']['attributes']['height'] ? 'landscape' : 'portrait';
		}
		update_post_meta($certificate_id, 'tutor_certificate_dimension', $dimension);
		
		if(!$is_draft) {
			// Delete draft data if it is publish action
			delete_post_meta($certificate_id, 'tutor_certificate_draft_data');
		}

		// Update Post data
		 if ($post_data) {
			$postData = array(
				'ID'           	=> $certificate_id,
				'post_title' 	=> $post_data['post_title'],
			);

			// Add publish status only if publish action
			// Otherwise post status is not necessary since it is already set on post create
			!$is_draft ? $postData['post_status'] = 'publish' : 0;
			
			$post_id = wp_update_post($postData, true);

			if (is_wp_error($post_id)) {
				$result['type'] 	= 'error';
				$result['message'] 	= $post_id->get_error_message();
			} else {
				$result['type'] 	= 'success';
				$result['message'] 	= __('Certificate Data Updated Successfully', 'tutor-lms-certificate-builder');
			}
		} else {
			$result['type'] 		= 'error';
			$result['message'] 		= __('Something was wrong. Please try again.', 'tutor-lms-certificate-builder');
		}

		// Response Json
		header('Content-Type: application/json');
		die(json_encode($result, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
	}


	/**
	 * View Certificate data by ajax call
	 * 
	 * @return json
	 */
	public function tutor_view_certificate()
	{
		$result 		= array(
			"type" => "",
			"message" => "",
		);
		$certificate_id 			= $_POST['certificate_id'];
		$nonce 						= $_POST['_wpnonce'];

		//Check for nonce security      
		if (!wp_verify_nonce($nonce, 'tutor-lms-certificate-builder')) {
			$result['type'] 		= 'error';
			$result['message'] 		= __('Bad Request sent. Please try again.', 'tutor-lms-certificate-builder');
			die($result);
		}

		$draft = get_post_meta($certificate_id, 'tutor_certificate_draft_data', true);
		$published = get_post_meta($certificate_id, 'tutor_certificate_data', true);

		// Certificate Data
		$response  = $draft ? $draft : $published;
		$response = is_serialized( $response ) ? unserialize($response) : json_decode($response, true);

		$result['type'] 		= 'success';
		$result['message'] 		= __('Certificate data found.', 'tutor-lms-certificate-builder');
		if (!$response) {
			$result['type'] 		= 'info';
			$result['message'] 		= __('No certificate data found.', 'tutor-lms-certificate-builder');
		}
		$result['certificateData'] 	= $response;
		$result['certificateDataPublished'] = $draft ? $published : null;

		// send response
		$data = json_encode($result, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

		header('Content-Type: application/json');
		die($data);
	}

	public function tutor_certificate_store_preview() {

		// Check if valid image
		if(
			!isset( $_FILES['certificate_image'] ) ||
			$_FILES['certificate_image']['error'] ||
			$_FILES['certificate_image']['type'] != 'image/jpeg'
			) {

			wp_send_json_error( array('message' => __('Could not save preview due to invalid image.', 'tutor-lms-certificate-builder')) );
		}

		// et the dir from outside of the filter hook. Otherwise infinity loop will coccur.
		$certificate_id = tutor_utils()->array_get('certificate_id', $_POST, '0');
		$certificates_dir = wp_upload_dir()['basedir'] . DIRECTORY_SEPARATOR . Plugin::CERTIFICATE_TEMPLATE_DIR;

		// Make sure the directory exists
		wp_mkdir_p($certificates_dir);

		// Store new file
		$cache_bust = str_replace('.', '', (string)microtime(true));
		$file_name = 'template-' . $certificate_id . '-' . $cache_bust . '.jpg';
		$file_dest = $certificates_dir . DIRECTORY_SEPARATOR . $file_name;
		move_uploaded_file( $_FILES['certificate_image']['tmp_name'], $file_dest );

		// Delete old preview file
		$old_name = get_post_meta( $certificate_id, Plugin::CERTIFICATE_PREVIEW_META_KEY, true );
		$old_path = $old_name ? $certificates_dir . DIRECTORY_SEPARATOR . $old_name : null;
		($old_path && file_exists($old_path)) ? unlink($old_path) : 0;

		// Save the preview file name in meta
		update_post_meta( $certificate_id, Plugin::CERTIFICATE_PREVIEW_META_KEY, $file_name );

		wp_send_json_success();
	}
}