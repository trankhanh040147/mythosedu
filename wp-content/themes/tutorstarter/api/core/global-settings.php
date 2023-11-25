<?php


namespace DIVI\Includes\Core;


class GlobalSettings
{
	public static function publishGlobalSetting($key){
		global $system_api;
		$response = $system_api->re_query('GET', 'publishGlobalSetting', [
			'params' => ['key' => $key],
			'fields' => ['id', 'value'],
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['publishGlobalSetting'];
	}

	public static function addPublishGlobalSetting($key, $value){
		global $system_api;
		$response = $system_api->re_query('POST', 'addPublishGlobalSetting', [
			'params' => ['key' => $key, 'value' => $value],
			'fields' => ['id', 'value'],
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['addPublishGlobalSetting'];
	}

	public static function updatePublishGlobalSetting($id, $key, $value){
		global $system_api;
		$response = $system_api->re_query('POST', 'updatePublishGlobalSetting', [
			'params' => ['key' => $key, 'value' => $value, 'id' => $id],
			'fields' => ['id', 'value'],
		], true);
		if( is_wp_error($response) ){
			return $response;
		}
		return $response['updatePublishGlobalSetting'];
	}
}
