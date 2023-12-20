<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Hostinger_Surveys_Questions {

	public function __construct() {
		$this->settings = new Hostinger_Settings();
	}

	public function map_survey_questions( string $slug ): array {

		$questions = [
			'score' => [
				'type' => 'rating',
				'question' => __( 'How would you rate your experience using our AI Assistant plugin for content generation? (Scale 1-10)', 'hostinger' ),
			],
			'comment' => [
				'type' => 'comment',
				'question' => __( 'Do you have any comments/suggestions to improve our AI tools?', 'hostinger' ),
			],
		];

		if ( isset( $questions[ $slug ] ) ) {
			return $questions[ $slug ];
		} else {
			return [];
		}
	}


}

$surveys_questions = new Hostinger_Surveys_Questions();