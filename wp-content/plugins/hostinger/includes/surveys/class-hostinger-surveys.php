<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Hostinger_Surveys {
	private const SUBMIT_SURVEY = '/v3/wordpress/survey/store';
	private const GET_SURVEY = '/v3/wordpress/survey/get';
	private const CLIENT_SURVEY_ELIGIBILITY = '/v3/wordpress/survey/client-eligible';
	private const CLIENT_SURVEY_IDENTIFIER = 'customer_satisfaction_score';
	private const REQUIRED_SURVEY_ITEMS = [
		[
			'question_slug' => 'location',
			'answer'        => 'wordpress_cms'
		]
	];

	private Hostinger_Config $config_handler;
	private Hostinger_Settings $settings;
	private Hostinger_Requests_Client $client;
	private Hostinger_Helper $helper;
	private Hostinger_Surveys_Questions $survey_questions;

	public function __construct() {
		$this->settings         = new Hostinger_Settings();
		$this->helper           = new Hostinger_Helper();
		$this->config_handler   = new Hostinger_Config();
		$this->survey_questions = new Hostinger_Surveys_Questions();
		$this->client           = new Hostinger_Requests_Client( $this->config_handler->get_config_value( 'base_rest_uri', HOSTINGER_REST_URI ), [
			Hostinger_Config::TOKEN_HEADER  => $this->helper::get_api_token(),
			Hostinger_Config::DOMAIN_HEADER => $this->helper->get_host_info()
		] );
	}

	public function is_survey_enabled(): bool {
		return ! $this->settings->get_setting( 'feedback_survey_completed' ) && $this->settings->get_setting( 'content_published' ) && $this->is_client_eligible();
	}

	public function is_client_eligible(): bool {
		$response = $this->client->get( self::CLIENT_SURVEY_ELIGIBILITY, [
			'identifier' => self::CLIENT_SURVEY_IDENTIFIER,
		] );

		$response_code = wp_remote_retrieve_response_code( $response );
		$response_body = wp_remote_retrieve_body( $response );

		if ( is_wp_error( $response ) || $response_code !== 200 ) {
			return false;
		}

		$response_data = json_decode( $response_body );

		if ( isset( $response_data->data ) && $response_data->data === true ) {
			return true;
		}

		return false;
	}

	private function get_survey_questions(): array {
		$response = $this->client->get( self::GET_SURVEY, [
			'identifier' => self::CLIENT_SURVEY_IDENTIFIER,
		] );

		if ( is_wp_error( $response ) ) {
			return [];
		}

		$response_code = wp_remote_retrieve_response_code( $response );
		$response_body = wp_remote_retrieve_body( $response );

		if ( $response_code !== 200 || empty( $response_body ) ) {
			return [];
		}

		$response_data = json_decode( $response_body, true );

		if ( isset( $response_data['data']['questions'] ) && is_array( $response_data['data']['questions'] ) ) {
			return $response_data['data']['questions'];
		}

		return [];
	}

	public function submit_survey_answers( array $answers ): void {

		$data = [
			'identifier' => self::CLIENT_SURVEY_IDENTIFIER,
			'answers'    => self::REQUIRED_SURVEY_ITEMS

		];

		foreach ( $answers as $answer_slug => $answer ) {
			$answer            = [
				'question_slug' => $answer_slug,
				'answer'        => $answer
			];
			$data['answers'][] = $answer;
		}

		$response = $this->client->post( self::SUBMIT_SURVEY, $data );

		if ( is_wp_error( $response ) ) {
			error_log( print_r( $response, true ) );
			wp_send_json_error( __( 'Survey failed', 'hostinger' ) );
		}

		$response_code = wp_remote_retrieve_response_code( $response );
		$response_body = wp_remote_retrieve_body( $response );
		$response_data = json_decode( $response_body, true );

		if ( $response_code == 200 && $response_data['success'] ) {
			$this->settings->update_setting( 'feedback_survey_completed', true );
			wp_send_json( __( 'Survey completed', 'hostinger' ) );
		}

	}

	public function get_wp_survey_questions(): array {
		$all_questions  = $this->get_survey_questions();
		$question_slugs = array( 'score', 'comment' );

		return $this->filter_questions_by_slug( $all_questions, $question_slugs );
	}

	private function filter_questions_by_slug( array $all_questions, $question_slugs ): array {
		$questions_with_required_rule = [];

		foreach ( $all_questions as $question ) {
			if ( isset( $question['slug'] ) && in_array( $question['slug'], $question_slugs ) ) {
				$questions_with_required_rule[] = [
					'slug'  => $question['slug'],
					'rules' => $question['rules']
				];
			}
		}

		return $questions_with_required_rule;
	}

	private function is_survey_question_required( array $question ): bool {
		return isset( $question['rules'] ) && in_array( 'required', $question['rules'] );
	}

	public function generate_json( $survey_questions ) {
		$jsonStructure = [
			"pages"               => [],
			"showQuestionNumbers" => "off",
			"showTOC"             => false,
			"pageNextText"        => __( 'Next', 'hostinger' ),
			"pagePrevText"        => __( 'Previous', 'hostinger' ),
			"completeText"        => __( 'Submit', 'hostinger' ),
			"completedHtml"       => __( 'Thank you for completing the survey !', 'hostinger' ),
			"requiredText"        => '*',
		];

		foreach ( $survey_questions as $question ) {

			$element = [
				"type"              => $this->survey_questions->map_survey_questions( $question['slug'] )['type'],
				"name"              => $question['slug'],
				"title"             => $this->survey_questions->map_survey_questions( $question['slug'] )['question'],
				"requiredErrorText" => __( 'Response required.', 'hostinger' ),
			];

			if ( $question['slug'] == 'comment' ) {
				$element['maxLength'] = 250;
			}

			if ( isset( $question['rules'] ) ) {

				$betweenRule = $this->get_between_rule_values( $question['rules'] );
				if ( $betweenRule ) {
					$element["rateMin"]            = $betweenRule[0];
					$element["rateMax"]            = $betweenRule[1];
					$element["minRateDescription"] = __( 'Poor', 'hostinger' );
					$element["maxRateDescription"] = __( 'Excellent', 'hostinger' );
				}

				if( $this->is_survey_question_required( $question ) ) {
					$element["isRequired"] = true;
				}

			}

			$question_data = [
				"name"     => $question['slug'],
				"elements" => [ $element ]
			];

			$jsonStructure["pages"][] = $question_data;
		}

		return json_encode( $jsonStructure );
	}

	public function get_between_rule_values( array $rules ): array {
		foreach ( $rules as $rule ) {
			if ( strpos( $rule, 'between:' ) === 0 ) {
				$betweenValues = explode( ',', substr( $rule, 8 ) );
				if ( count( $betweenValues ) === 2 ) {
					return $betweenValues;
				}
			}
		}

		return [];
	}

}

$surveys = new Hostinger_Surveys();