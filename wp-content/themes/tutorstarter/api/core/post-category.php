<?php


namespace DIVI\Includes\Core;


class PostCategory
{
	CONST FIELDS = [
		'id' => 'id',
		'post_cate_title' => 'post_cate_title',
		#'cate_description' => 'cate_description',
		#'cate_parent' => 'cate_parent',
	];
	public static function postCategories($args = []){
		global $system_api;
		$fields = array_values(self::FIELDS);
		$response = $system_api->re_query('GET', 'postCategories', [
			'params' => $args,
			'fields' => $fields,
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['postCategories'];
	}
}
