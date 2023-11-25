<?php


namespace DIVI\Includes\Core;


class Booking
{
	public static function addBookingItem($data, $fields = [])
	{
		global $system_api;
		$response = $system_api->re_query('POST', 'addBooking', [
			'params' => $data,
			'fields' => $fields,
		], true);
		if (is_wp_error($response)) {
			return $response;
		}
		return $response['addBooking'];
	}

	public static function add($data, $fields = [])
	{
		global $system_api;
		if (!$fields)
			$fields = ['id'];
		$response = $system_api->re_query('POST', 'addBooking', [
			'params' => $data,
			'fields' => $fields,
		], true);
		if (is_wp_error($response)) {
			return $response;
		}
		return $response['addBooking'];
	}



	public static function booking($id, $fields)
	{
		global $system_api;
		if (!$fields)
			$fields = ['id'];
		$response = $system_api->re_query('GET', 'booking', [
			'params' => ['id' => $id],
			'fields' => $fields,
		], true);
		if (is_wp_error($response)) {
			return $response;
		}
		return $response['booking'];
	}

	public static function bookings()
	{
		global $system_api;
		$fields = [
			'id',
			'user_id {phone ,email}',
		];
		$response = $system_api->re_query('GET', 'bookings', [
			'fields' => [
				'id',
				'user_id {id,phone, email}',
			],
		], true);
		if (is_wp_error($response)) {
			return $response;
		}
		return $response['bookings'];
	}

	// public static function getListBookingByUser($user_id, $fields = []){
	// 	global $system_api;

	// 	$response = $system_api->re_query('GET', 'getListBookingByUser', [
	// 		'params' => ['user_id' => $user_id],
	// 		'fields' => [
	//                     'id',
	//                     'booking_id',
	//                     'booking_status',
	//                     'cv_info'
	//                 ],
	// 	], true);
	// 	if( is_wp_error($response) ){
	// 		return $response;
	// 	}
	// 	return $response['getListBookingByUser'];
	// }

	public static function getListBookingByUser($user_id, $fields = [])
	{
		global $system_api;

		$response = $system_api->re_query('GET', 'getListBookingByUser', [
			'params' => ['user_id' => $user_id],
			'fields' => [
				'id',
				'booking_id',
				'booking_status'
			],
		], true);
		if (is_wp_error($response)) {
			return $response;
		}
		return $response['getListBookingByUser'];
	}

	public static function getBookingDetailByID($booking_id, $fields = [])
	{
		global $system_api;

		$response = $system_api->re_query('GET', 'booking', [
			'params' => ['id' => $booking_id],
			'fields' => [
				'id',
				'booking_id',
				'booking_status',
				'cv_info',
				'booking_cv_file',
				'app_channel',
				'product_list { product_code } ',
				'user_id { id ,name, birthdate ,department, your_request, your_point } '
			],
		], true);
		if (is_wp_error($response)) {
			return $response;
		}
		return $response['booking'];
	}

	public static function updateUserByID($userID, $department = [], $list_identify, $notes)
	{
		global $system_api;

		$response = $system_api->re_query('POST', 'updateUser', [
			'params' => [
				'id' => $userID,
				'your_request' => $notes,
				'department' => $department,
				'your_point' => $list_identify,
			],
			'fields' => [
				'id'
			],
		], true);
		if (is_wp_error($response)) {
			return $response;
		}
		return $response['updateUser'];
	}

	public static function updateBookingByID($data, $fields = [])
	{
		global $system_api;

		$response = $system_api->re_query('POST', 'updateBooking', [
			'params' => [
				'id' => $data["id"],
				'booking_status' => $data["booking_status"],
			],
			'fields' => [
				'id',
				'booking_status'
			],
		], true);
		if (is_wp_error($response)) {
			return $response;
		}
		return $response['updateBooking'];
	}

	public static function getPhoneByEmail($email)
	{
		global $system_api;

		$response = $system_api->re_query('POST', 'getPhoneByEmail', [
			'params' => [
				'email' => $email,
			],
			'fields' => [
				'id',
				'phone',
				'email',
			],
		], true);
		if (is_wp_error($response)) {
			return $response;
		}
		return $response['getPhoneByEmail'];
	}

	public static function checkAccount($username)
	{
		global $system_api;

		$response = $system_api->re_query('POST', 'checkAccount', [
			'params' => [
				'username' => $username,
			],
		], true);
		if (is_wp_error($response)) {
			return $response;
		}
		return $response['checkAccount'];
	}
}
