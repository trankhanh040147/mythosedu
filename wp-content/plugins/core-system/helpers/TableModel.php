<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 11/19/19
 * Time: 10:06 AM
 */

namespace CoreSystem\Helpers;

class TableModel {
    static function get_row($query_data, $output = OBJECT) {
        if ( !empty( $query_data["where"] ) ) {
            $query_data["where"] = static::convert_query_array_into_query_string($query_data["where"]);
        }

        return IDEntity::get_row(static::name ,$query_data, $output);
    }

    static function get_results($query_data, $output = OBJECT) {
        if ( !empty( $query_data["where"] ) ) {
            $query_data["where"] = static::convert_query_array_into_query_string($query_data["where"]);
        }

        return IDEntity::get_results(static::name ,$query_data, $output);
    }
}