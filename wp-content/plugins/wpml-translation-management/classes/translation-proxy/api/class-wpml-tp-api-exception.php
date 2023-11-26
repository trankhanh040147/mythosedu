<?php

class WPML_TP_API_Exception extends Exception {

	public function __construct( $message, WPML_TP_API_Request $request = null, $response = null ) {
		if ( $request ) {
			$message .= ' ' . $this->get_exception_message(
				$request->get_url(),
				$request->get_method(),
				$request->get_params(),
				$response
			);
		}

		parent::__construct( $message );
	}

	private function get_exception_message( $url, $method, $params, $response ) {
		return 'Details: |'
		       . ' url: '
		       . '`'
		       . $url
		       . '`'
		       . ' method: '
		       . '`'
		       . $method
		       . '`'
		       . ' param: '
		       . '`'
		       . json_encode( $params )
		       . '`'
		       . ' response: '
		       . '`'
		       . json_encode( $response )
		       . '`';
	}
}