<?php


namespace DIVI\Includes\Core;


class Pages
{
	CONST FIELDS = [
		'id' => 'id',
		'product_code' => 'product_code',
		'product_title' => 'product_title',
		'product_unit' => 'product_unit',
		'product_price' => 'product_price',
		'product_category' => 'product_category',
		'product_number' => 'product_number',
		'product_inventory' => 'product_inventory',
		'number_inventory' => 'number_inventory',
		'product_pay' => 'product_pay',
		'product_description' => 'product_description',
		'product_status' => 'product_status',
		'product_gallery' => 'product_gallery',
		'search' => 'search',
		'address' => 'address',
		'long' => 'long',
		'lat' => 'lat',
		'user_id' => 'user_id',
		'order_level' => 'order_level',
		'product_lang' => 'product_lang',
		'product_relative_lang' => 'product_relative_lang',
		'tag' => 'tag',
	];
	public static function pages(){
		global $system_api;
		$fields = [
			'id',
			'product_code',
			'product_title',
			'product_unit',
			'product_price',
			'product_category' => [
				'id',
				'cate_title'
			],
			'product_description',
			'address',
			'product_number',
			'product_pay',
			'product_status',
			'product_gallery',
			'updated',
			'created'
		];
		$response = $system_api->re_query('GET', 'pages', [
			'fields' => $fields,
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['pages'];
	}
	public static function your_pages(){
		global $system_api;
		$fields = [
			'id',
			'product_code',
			'product_title',
			'product_unit',
			'product_price',
			'product_category' => [
				'id',
				'cate_title'
			],
			'product_description',
			'address',
			'product_number',
			'product_pay',
			'product_status',
			'product_gallery',
			'updated',
			'created'
		];
		$response = $system_api->re_query('GET', 'yourPages', [
			'fields' => $fields,
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['yourPages'];
	}

	public static function add($data, $fields = []){
		global $system_api;
		$defaults = [
			'product_code' => '',
			'product_title' => '',
			'product_unit' => '',
			'product_price' => '',
			'product_category' => '',
			'product_number' => '',
			'product_inventory' => '',
			'number_inventory' => '',
			'product_pay' => '',
			'product_description' => '',
			'product_status' => '',
			'product_gallery' => '',
			'search' => '',
			'address' => '',
			'long' => '',
			'lat' => '',
			'user_id' => '',
			'order_level' => '',
			'product_lang' => '',
			'product_relative_lang' => '',
			'tag' => '',
		];
		//$data = wp_parse_args($data, $defaults);
//		extract($data);
//		$_fields = array_values(self::FIELDS);
//		$params = compact($_fields);
		if( !$fields ){
			$fields = ['id'];
		}
		$response = $system_api->re_query('POST', 'addPages', [
			'params' => $data,
			'fields' => $fields
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['addPages'];
	}

	public static function update($data, $fields = []){
		global $system_api;
		$defaults = [
			'product_code' => '',
			'product_title' => '',
			'product_unit' => '',
			'product_price' => '',
			'product_category' => '',
			'product_number' => '',
			'product_inventory' => '',
			'number_inventory' => '',
			'product_pay' => '',
			'product_description' => '',
			'product_status' => '',
			'product_gallery' => '',
			'search' => '',
			'address' => '',
			'long' => '',
			'lat' => '',
			'user_id' => '',
			'order_level' => '',
			'product_lang' => '',
			'product_relative_lang' => '',
			'tag' => '',
		];
		//$data = wp_parse_args($data, $defaults);
		#extract($data);
//		$_fields = array_values(self::FIELDS);
//		$params = compact($_fields);
		if( !$fields ){
			$fields = ['id'];
		}
		$response = $system_api->re_query('POST', 'updatePages', [
			'params' => $data,
			'fields' => $fields
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['updatePages'];
	}

	public static function delete($id){
		global $system_api;
		$response = $system_api->re_query('POST', 'deletePages', [
			'params' => ['id' => $id],
			'fields' => ['id']
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['deletePages'];
	}

	public static function get_by_id($id, $fields = []){
		$__key = md5(__FUNCTION__ . serialize(func_get_args()));
		$result = wp_cache_get($__key, 'page');
		if( !$result ) {
			if (!$fields) {
				$fields = ['id'];
			}
			global $system_api;
			$response = $system_api->re_query('GET', 'page', [
				'params' => [
					'id' => $id
				],
				'fields' => $fields
			], true);
			if (is_wp_error($response)) {
				return $response;
			}
			$result = $response['page'];
			wp_cache_add($__key, $result, 'page');
		}
		return $result;
	}
}
