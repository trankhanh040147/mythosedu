<?php


namespace DIVI\Includes\Core;


class Post
{
	CONST FIELDS = [
		'id' => 'id',
		'post_code' => 'post_code',
		'post_title' => 'post_title',
		'post_unit' => 'post_unit',
		'post_price' => 'post_price',
		'post_category' => 'post_category',
		'post_number' => 'post_number',
		'post_inventory' => 'post_inventory',
		'number_inventory' => 'number_inventory',
		'post_pay' => 'post_pay',
		'post_description' => 'post_description',
		'post_status' => 'post_status',
		'post_gallery' => 'post_gallery',
		'search' => 'search',
		'address' => 'address',
		'long' => 'long',
		'lat' => 'lat',
		'user_id' => 'user_id',
		'order_level' => 'order_level',
		'post_lang' => 'post_lang',
		'post_relative_lang' => 'post_relative_lang',
		'tag' => 'tag',
	];
	public static function posts(){
		global $system_api;
		$fields = [
			'id',
			'post_code',
			'post_title',
			'post_category' => [
				'id',
				'post_cate_title'
			],
			'post_description',
			'post_excerpt',
			'post_slug',
			'post_status',
			'post_gallery',
			'updated',
			'created'
		];
		$response = $system_api->re_query('GET', 'posts', [
			'fields' => $fields,
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['posts'];
	}
	public static function your_posts(){
		global $system_api;
		$fields = [
			'id',
			'post_code',
			'post_title',
			'post_unit',
			'post_price',
			'post_category' => [
				'id',
				'cate_title'
			],
			'post_description',
			'address',
			'post_pay',
			'post_status',
			'post_gallery',
			'updated',
			'created'
		];
		$response = $system_api->re_query('GET', 'yourPosts', [
			'fields' => $fields,
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['yourPosts'];
	}

	public static function add($data, $fields = []){
		global $system_api;
		if( !$fields ){
			$fields = ['id'];
		}
		$response = $system_api->re_query('POST', 'addPost', [
			'params' => $data,
			'fields' => $fields
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['addPost'];
	}

	public static function update($data, $fields = []){
		global $system_api;
		if( !$fields ){
			$fields = ['id'];
		}
		$response = $system_api->re_query('POST', 'updatePost', [
			'params' => $data,
			'fields' => $fields
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['updatePost'];
	}

	public static function delete($id){
		global $system_api;
		$response = $system_api->re_query('POST', 'deletePost', [
			'params' => ['id' => $id],
			'fields' => ['id']
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['deletePost'];
	}

	public static function get_by_id($id, $fields = []){
		$__key = md5(__FUNCTION__ . serialize(func_get_args()));
		$result = wp_cache_get($__key, 'post');
		if( !$result ) {
			if (!$fields) {
				$fields = ['id'];
			}
			global $system_api;
			$response = $system_api->re_query('GET', 'post', [
				'params' => [
					'id' => $id
				],
				'fields' => $fields
			], true);
			if (is_wp_error($response)) {
				return $response;
			}
			$result = $response['post'];
			wp_cache_add($__key, $result, 'post');
		}
		return $result;
	}
}
