<?php

defined( 'ABSPATH' ) || exit;

class Hostinger_Admin_Ajax {
	public function __construct() {
		add_action( 'init', [ $this, 'define_ajax_events' ], 0 );
	}

	public function define_ajax_events(): void {
		$events = [
			'complete_onboarding_step',
			'publish_website',
			'track_click',
			'identify_action',
			'get_survey',
			'submit_survey',
			'menu_action',
			'regenerate_website',
		];

		foreach ( $events as $event ) {
			add_action( 'wp_ajax_hostinger_' . $event, [ __CLASS__, $event ] );
			add_action( 'wp_ajax_nopriv_hostinger_' . $event, [ __CLASS__, $event ] );
		}
	}

	public static function regenerate_website(): void {
		$location     = sanitize_text_field( $_POST['location'] ) ?? '';
		$event_action = sanitize_text_field( $_POST['event_action'] ) ?? '';
		$nonce        = sanitize_text_field( $_POST['nonce'] );

		if ( ! wp_verify_nonce( $nonce, 'hts-ajax-nonce' ) ) {
			wp_send_json_error( 'Invalid nonce.' );
		}

		$amplitude = new Hostinger_Amplitude();
		$amplitude->regenerate_website( $event_action, $location );
	}

	public static function get_survey(): void {
		$nonce = sanitize_text_field( $_POST['nonce'] );
		if ( ! wp_verify_nonce( $nonce, 'get_questions' ) ) {
			wp_send_json_error( 'Invalid nonce.' );
		}
		$surveys          = new Hostinger_Surveys();
		$survey_questions = $surveys->get_wp_survey_questions();
		$questions_json   = $surveys->generate_json( $survey_questions );

		wp_send_json( $questions_json );
	}

	public static function submit_survey(): void {
		$nonce = sanitize_text_field( $_POST['nonce'] );
		$survey_results = sanitize_text_field( $_POST['survey_results'] );
		$surveys = new Hostinger_Surveys();

		if ( ! wp_verify_nonce( $nonce, 'submit_questions' ) ) {
			wp_send_json_error( 'Invalid nonce.' );
		}

		$decoded_json = json_decode(stripslashes($survey_results), true);
		$surveys->submit_survey_answers( $decoded_json );

	}

	public static function publish_website(): void {
		$publish = (bool) $_POST['maintenance'];
		Hostinger_Settings::update_setting( 'maintenance_mode', $publish ? 1 : 0 );

		require_once HOSTINGER_ABSPATH . 'includes/admin/onboarding/class-hostinger-onboarding.php';
		$content = new Hostinger_Onboarding();

		if ( has_action( 'litespeed_purge_all' ) ) {
			do_action( 'litespeed_purge_all' );
		}

		wp_send_json_success( [
			'published'   => $publish,
			'title'       => __( 'Website is published', 'hostinger' ),
			'description' => __( 'Congratulations! Your website is online.', 'hostinger' ),
			'content'     => $content->get_content(),
			'preview_url' => home_url(),
		] );
	}

	public static function complete_onboarding_step(): void {
		$step            = $_POST['step'];
		$completed_steps = get_option( 'hostinger_onboarding_steps', [] );
		if ( ! in_array( $step, array_column($completed_steps, 'action'), true ) ) {
			$completed_steps[] = [
				'action' => $step,
				'date'   => date( 'Y-m-d H:i:s' ),
			];
		}
		Hostinger_Settings::update_setting( 'onboarding_steps', $completed_steps );

		wp_send_json_success( [] );
	}

	public static function track_click(): void {
		$valid_options = [
			'hostinger_preview_button_click'
		];

		$click_action = $_POST['click_action'];
		if ( ! in_array( $click_action, $valid_options, true ) ) {
			wp_send_json_error( __( 'invalid data', 'hostinger' ) );
		}

		$click_count = get_option( $click_action, 0 );
		Hostinger_Settings::update_setting( $click_action, ++ $click_count, 'no' );

		wp_send_json_success( [] );
	}

	public static function identify_action(): void {
		$action = sanitize_text_field( $_POST['action_name'] ) ?? '';

		if ( in_array( $action, Hostinger_Admin_Actions::ACTIONS_LIST, true ) ) {
			setcookie($action, $action, time() + (86400), '/');
			wp_send_json_success( $action );
		} else {
			wp_send_json_error( 'Invalid action' );
		}
	}

	public static function menu_action(): void {

		$nonce         = sanitize_text_field( $_POST['nonce'] );
		$location      = sanitize_text_field( $_POST['location'] ) ?? '';
		$event_action  = sanitize_text_field( $_POST['event_action'] ) ?? '';

		if ( ! wp_verify_nonce( $nonce, 'menu_actions' ) ) {
			wp_send_json_error( 'Invalid nonce.' );
		}

		$amplitude = new Hostinger_Amplitude();
		$amplitude->track_menu_action( $event_action, $location );
	}

}

new Hostinger_Admin_Ajax();
