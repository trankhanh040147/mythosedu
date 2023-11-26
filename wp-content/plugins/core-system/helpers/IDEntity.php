<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 8/15/19
 * Time: 3:41 PM
 */

namespace CoreSystem\Helpers;

class IDEntity {
    static function get_by_id($table, $id, $object = OBJECT, $blog_id = null) {
        $BFDB_Manager = new BFDB($blog_id);
        $table = $BFDB_Manager->get_table_name($table);

        return $BFDB_Manager->get_row("SELECT * FROM {$table} WHERE id = {$id}", $object);
    }

    static function get_row($table, $query_data = [], $object = OBJECT, $blog_id = null) {
        $default = [
            "where" => "",
            "fields" => "*"
        ];

        $BFDB_Manager = new BFDB($blog_id);
        $table = $BFDB_Manager->get_table_name($table);
        $query_data = array_merge($default, $query_data);
        $query = self::process_query_data($query_data, $table);

        return $BFDB_Manager->get_row($query, $object);
    }

    static function get_results($table, $query_data = [] , $object = OBJECT, $blog_id = null) {
        $default = [
            "where" => "",
            "fields" => "*",
            "limit" => -1,
            "offset" => 0
        ];

        $BFDB_Manager = new BFDB($blog_id);
        $query_data = array_merge($default, $query_data);
        $query = self::process_query_data($query_data, $BFDB_Manager->get_table_name( $table) );
        return $BFDB_Manager->get_results($query, $object);
    }

    private static function query_basic($table, $query_data) {
        $query = self::select_fields($query_data["fields"]);
        $query .= " FROM {$table}";

        if ( !empty ($query_data["join"]) ) {
            $query .=  " " . $query_data["join"];
        }

        if ( !empty($query_data["where"]) ) {
            $query .= " WHERE {$query_data["where"]}";
        }

        return $query;
    }

    private static function process_query_data($query_data, $table) {
        $query = self::query_basic($table, $query_data);

        if ( !empty($query_data["group_by"]) && !preg_match("/;/", $query_data["group_by"] ) ) {
            $query .= " GROUP BY {$query_data["group_by"]}";
        }

        if ( !empty($query_data["order_by"]) && !preg_match("/;/", $query_data["order_by"] ) ) {
            $query .= " ORDER BY {$query_data["order_by"]}";
        }

        if ( !empty( $query_data["limit"] ) &&  $query_data["limit"] != -1 && bf_is_int($query_data["limit"]) ) {
            $query .= " LIMIT {$query_data["limit"]}";

            if (!empty( $query_data["offset"] ) &&  bf_is_int($query_data["offset"]) ) {
                $query .= " OFFSET {$query_data["offset"]}";
            }
        }

        return $query;
    }

    private static function select_fields($fields) {
        if ( !preg_match("/;/", $fields ) ) {
            return "SELECT SQL_CALC_FOUND_ROWS {$fields}";
        }

        return "";
    }

    static function preprocess_value($value) {
        if ( !is_array($value) ) {
            return [ "value" => $value, "operator" => "=" ];
        }

        if ( !in_array( $value["operator"], [ "=", "<", ">", "<=", ">=" , "LIKE", "!=" ] )  ) {
            $value["operator"] = "=";
        }

        return $value;
    }

    static function get_total_count() {
        $db_manager = new BFDB();
        return $db_manager->get_var("SELECT FOUND_ROWS();");
    }
}
