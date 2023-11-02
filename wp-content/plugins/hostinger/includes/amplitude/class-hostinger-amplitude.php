<?php

class Hostinger_Amplitude {
	private const AMPLITUDE_ENDPOINT = '/v3/wordpress/plugin/trigger-event';
	private const AMPLITUDE_HOME_SLUG = 'home';
	private const AMPLITUDE_LEARN_SLUG = 'learn';
	private const AMPLITUDE_AI_ASSISTANT_SLUG = 'ai-assistant';

	private Hostinger_Config $config_handler;
	private Hostinger_Requests_Client $client;
	private Hostinger_Helper $helper;

	public function __construct() {
		$this->helper         = new Hostinger_Helper();
		$this->config_handler = new Hostinger_Config();
		$this->client         = new Hostinger_Requests_Client( $this->config_handler->get_config_value( 'base_rest_uri', HOSTINGER_REST_URI ), array(
			Hostinger_Config::TOKEN_HEADER  => $this->helper::get_api_token(),
			Hostinger_Config::DOMAIN_HEADER => $this->helper->get_host_info()
		) );
	}

	private function send_request( string $endpoint, array $params ): void {
		$response = $this->client->post( $endpoint, array( 'params' => $params ) );
		if ( is_wp_error( $response ) ) {
			error_log( $response );
		}
	}

	public function track_menu_action( string $event_action, string $location ): void {
		$endpoint = self::AMPLITUDE_ENDPOINT;
		$action   = $this->map_action( $event_action );

		if ( empty( $action ) ) {
			return;
		}

		$params = array(
			'action'   => $action,
			'location' => $location
		);

		$this->send_request( $endpoint, $params );
	}

	public function regenerate_website( string $event_action, string $location ): void {
		$endpoint      = self::AMPLITUDE_ENDPOINT;
		$action        = sanitize_text_field( $event_action ) ?? '';
		$valid_actions = [
			Hostinger_Amplitude_Actions::AI_REGENERATE_ENTER,
			Hostinger_Amplitude_Actions::AI_REGENERATE_SIGNUP,
		];

		if ( ! in_array( $action, $valid_actions, true ) ) {
			return;
		}

		$params = array(
			'action'   => $action,
			'location' => $location
		);

		$this->send_request( $endpoint, $params );
	}

	private function map_action( string $event_action ): string {
		$amplitude_actions = new Hostinger_Amplitude_Actions();

		switch ( $event_action ) {
			case self::AMPLITUDE_HOME_SLUG:
				return $amplitude_actions::HOME_ENTER;
			case self::AMPLITUDE_LEARN_SLUG:
				return $amplitude_actions::LEARN_ENTER;
			case self::AMPLITUDE_AI_ASSISTANT_SLUG;
				return $amplitude_actions::AI_ASSISTANT_ENTER;
			default:
				return '';
		}

	}


}

new Hostinger_Amplitude();
