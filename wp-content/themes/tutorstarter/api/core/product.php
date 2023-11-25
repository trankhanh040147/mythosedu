<?php


namespace DIVI\Includes\Core;


class Product
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
		'address' => 'address',
		'long' => 'long',
		'lat' => 'lat',
		'user_id' => 'user_id',
		'order_level' => 'order_level',
		'product_lang' => 'product_lang',
		'product_relative_lang' => 'product_relative_lang',
		'tag' => 'tag',
		'product_sticky' => 'product_sticky',
		'product_type' => 'product_type',
		'search' => 'search',
		'product_seo_keywords' => 'product_seo_keywords',
		'product_seo_description' => 'product_seo_description',
		'product_seo_link' => 'product_seo_link'
	];
	public static function products(){
		global $system_api;
		$fields = [
			'id',
			'product_code',
			'product_title',
			'product_lang',
			'product_unit',
			'product_price',
			'product_category' => [
				'id',
				'cate_title'
			],
			'product_description',
			'product_excerpt',
			'product_slug',
			'product_properties',
			'address',
			'product_number',
			'product_pay',
			'product_status',
			'product_gallery',
			'updated',
			'created',
			'product_sticky',
			'product_type',
			'search',
			'product_seo_keywords',
			'product_seo_description',
			'product_seo_link',
			'order_level'
		];
		$response = $system_api->re_query('GET', 'products', [
			'fields' => $fields,
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['products'];
	}

	public static function productsMin(){
		global $system_api;
		$fields = [
			'id',
			'product_code',
			'product_title',
			'product_lang',
			'product_unit',
			'product_price',
			'product_category' => [
				'id',
				'cate_title'
			],
			'product_slug',
			'product_properties',
			'address',
			'product_number',
			'product_pay',
			'product_status',
			'product_gallery',
			'updated',
			'created',
			'product_sticky',
			'product_type',
			'search',
			'product_seo_link',
			'order_level'
		];
		$response = $system_api->re_query('GET', 'products', [
			'fields' => $fields,
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['products'];
	}


	public static function your_products(){
		global $system_api;
		$fields = [
			'id',
			'product_code',
			'product_title',
			'product_seo_link',
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
			'order_level',
			'created'
		];
		$response = $system_api->re_query('GET', 'yourProducts', [
			'fields' => $fields,
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['yourProducts'];
	}

	public static function getMinProd(){
		$fields = [
			'id',
			'product_code',
			'product_title',
			'product_seo_link',
			'product_unit',
			'product_category' => [
				'id',
				'cate_title'
			],
			'product_properties',
			'product_sticky',
			'address',
			'created'
		];

			global $system_api;
			$response = $system_api->re_query('GET', 'products', [
				
				'fields' => $fields
			], true);
			if (is_wp_error($response)) {
				return $response;
			}
			$result = $response['products'];

			return $result;
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
			'product_seo_keywords' => '',
			'product_seo_description' => '',
			'product_seo_link' => '',
		];
		//$data = wp_parse_args($data, $defaults);
//		extract($data);
//		$_fields = array_values(self::FIELDS);
//		$params = compact($_fields);
		if( !$fields ){
			$fields = ['id'];
		}

		//var_dump($data);die();

		$response = $system_api->re_query('POST', 'addProduct', [
			'params' => $data,
			'fields' => $fields
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['addProduct'];
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
			//'product_description' => '',
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
			'product_seo_keywords' => '',
			'product_seo_description' => '',
			'product_seo_link' => '',
		];
		//$data = wp_parse_args($data, $defaults);
		#extract($data);
//		$_fields = array_values(self::FIELDS);
//		$params = compact($_fields);
		if( !$fields ){
			$fields = ['id'];
		}
		$response = $system_api->re_query('POST', 'updateProduct', [
			'params' => $data,
			'fields' => $fields
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['updateProduct'];
	}

	public static function delete($id){
		global $system_api;
		$response = $system_api->re_query('POST', 'deleteProduct', [
			'params' => ['id' => $id],
			'fields' => ['id']
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['deleteProduct'];
	}

	public static function get_by_slug($slug, $fields = []){
		$__key = md5(__FUNCTION__ . serialize(func_get_args()));
		$result = wp_cache_get($__key, 'product');
		if( !$result ) {
			global $system_api;
			if (!$fields) {
				$fields = ['id'];
			}
			$response = $system_api->re_query('GET', 'productBySlug', [
				'params' => [
					'product_slug' => $slug
				],
				'fields' => $fields
			], true);
			if (is_wp_error($response)) {
				return $response;
			}
			$result = $response['productBySlug'];
			wp_cache_add($__key, $result, 'product');
		}
		return $result;
	}

	public static function get_by_id($id, $fields = []){
		$__key = md5(__FUNCTION__ . serialize(func_get_args()));
		$result = wp_cache_get($__key, 'product');
		if( !$result ) {
			if (!$fields) {
				$fields = ['id'];
			}
			global $system_api;
			$response = $system_api->re_query('GET', 'product', [
				'params' => [
					'id' => $id
				],
				'fields' => $fields
			], true);
			if (is_wp_error($response)) {
				return $response;
			}
			$result = $response['product'];
			wp_cache_add($__key, $result, 'product');
		}
		return $result;
	}

	public static function get_by_product_code($proCode){
		
			global $system_api;
			$response = $system_api->re_query('GET', 'product_code', [
				'params' => [
					'product_code' => $proCode
				],
				'fields' => ['product_title'],
			], true);

			return $response;
	}
}
