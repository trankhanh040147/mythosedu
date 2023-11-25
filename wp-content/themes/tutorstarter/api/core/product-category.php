<?php


namespace DIVI\Includes\Core;


class ProductCategory
{
	CONST FIELDS = [
		'id' => 'id',
		'cate_title' => 'cate_title',
		#'cate_description' => 'cate_description',
		#'cate_parent' => 'cate_parent',
	];
	public static function productCategories($args = []){
		global $system_api;
		$fields = array_values(self::FIELDS);
		$response = $system_api->re_query('GET', 'productCategories', [
			'params' => $args,
			'fields' => $fields,
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['productCategories'];
	}
}
