<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 5/14/19
 * Time: 4:33 PM
 */

namespace CoreSystem\Helpers;

class BFDB {
    private $errors;
    private $prefix;
    public $db;

    function __construct($blog_id = null) {
        global $wpdb;

        if ($blog_id === null) {
            $blog_id = get_current_blog_id();
        }

        $this->prefix = $wpdb->get_blog_prefix($blog_id);
        $this->db = $wpdb;
        $this->errors = [];
    }

    function get_results($query, $output = OBJECT) {
        return $this->return_result( $this->db->get_results($query, $output) );
    }

    function get_var($query) {
        return $this->return_result( $this->db->get_var($query) );
    }

    function insert($table, $values) {
        $table = $this->get_table_name($table);
        return $this->return_result( $this->db->insert( "{$table}", $values ) );
    }

    function update( $table, $data, $where ) {
        $table = $this->get_table_name($table);
        return $this->return_result( $this->db->update($table, $data, $where) );
    }

    function delete( $table, $where ) {
        $table = $this->get_table_name($table);
        return $this->return_result( $this->db->delete($table, $where) );
    }

    function query($query) {
        return $this->return_result( $this->db->query($query) );
    }

    function get_row($query, $output = OBJECT)
    {
        return $this->return_result($this->db->get_row($query, $output));
    }

    function foreach_query($list_query) {
        foreach ($list_query as $query) {
            $this->db->query($query);
        }
    }

    function add_column($table, $column) {
        $table = $this->get_table_name($table);

        $row = $this->get_row("SHOW COLUMNS FROM `{$table}` WHERE `Field` LIKE '{$column['name']}'");

        if ( $row === null ) {
            return $this->query("ALTER TABLE `{$table}` ADD `{$column['name']}` {$column['query']};");
        }

        return false;
    }

    function drop_column($table, $column_name) {
        $table = $this->get_table_name($table);
        $row = $this->get_row("SHOW COLUMNS FROM `{$table}` WHERE `Field` LIKE '{$column_name}'");

        if ( $row ) {
            return $this->query("ALTER TABLE `{$table}` DROP `{$column_name}`;");
        }

        return false;
    }

    function modify_column($table, $column) {
        $table = $this->get_table_name($table);
        $row = $this->get_row("SHOW COLUMNS FROM `{$table}` WHERE `Field` LIKE '{$column['name']}'");

        if ( $row ) {
            return $this->query("ALTER TABLE `{$table}` MODIFY COLUMN `{$column['name']}` {$column['query']}");
        }

        return false;
    }

    function change_column($table, $column) {
        $table = $this->get_table_name($table);
        $row = $this->get_row("SHOW COLUMNS FROM `{$table}` WHERE `Field` LIKE '{$column['name']}'");

        if ( $row ) {
            return $this->query("ALTER TABLE `{$table}` CHANGE COLUMN `{$column['name']}` {$column['query']}");
        }

        return false;
    }

    function check_constraint($table, $constraint_name) {
        $table = $this->get_table_name($table);
        $row = $this->get_row("SELECT constraint_name FROM information_schema.key_column_usage 
          WHERE referenced_table_name is not NULL AND table_name = '{$table}' AND constraint_name = '{$constraint_name}'");

        return $row;
    }

    function get_list_fields($table){
        $table = $this->get_table_name($table);
        $results = $this->return_result($this->get_results("SHOW COLUMNS FROM `{$table}`"));
        $fields = [];
        if( !empty($results) ){
            $fields = array_map(function($item){
                return $item->Field;
            }, $results);
        }
        return $fields;
    }

    private function return_result($res) {
        if ( !empty($this->db->last_error) ) {
            $this->add_error($this->db->last_error);
            return false;
        }

        return $res;
    }

    private function add_error($error) {
        $this->errors[] = $error;

        if ( bf_get_site_mode() === BF_DEVELOPMENT_MODE ) {
            var_dump($this->db->last_error);
        }
    }

    function get_charset_collate() {
        return $this->db->get_charset_collate();
    }

    function start_transaction() {
        $this->db->query("START TRANSACTION;");
    }

    function stop_transaction() {
        if ( !empty($this->errors) ) {
            $this->rollback();
        }
        else {
            $this->commit();
        }
    }

    function rollback(){
        $this->db->query("ROLLBACK;");
    }
    function commit(){
        $this->db->query("COMMIT;");
    }

    function get_table_name($name) {
        return "{$this->prefix}{$name}";
    }

    function set_prefix($blog_id) {
        $this->prefix = $this->db->get_blog_prefix($blog_id);
    }

    function get_prefix() {
        return $this->prefix;
    }

    function get_errors() {
        return $this->errors;
    }
}
