<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 8/27/19
 * Time: 5:24 PM
 */

namespace CoreSystem\Helpers;

class BasicTableLayout extends TableLayout {
    protected $current_url;
    public function __construct($name, $header) {
        $this->name = $name;
        $this->header = $header;
        $this->data = $this->get_data();
        global $wp;
        $this->current_url = home_url( $wp->request );
        wp_enqueue_script( 'bf-table-js', self::get_file_url( dirname(__DIR__) ) . '/js/table.js', array ( 'jquery' ), 1.1, true);
        $this->submit_delete_action();
    }

    protected function submit_delete_action() {
        if ( !empty($_POST["nonce"]) &&  wp_verify_nonce( $_POST["nonce"], "delete_nonce") ) {
            $db = new BFDB();
            $db->delete( $this->name,  [ "id" => (int) $_POST["id"] ] );
            $this->data = $this->get_data();
        }
    }

    function modify_item($item) {
        $title = $item["title"];

        $edit = __("Edit", TPL_DOMAIN_LANG);
        $delete = __("Delete", TPL_DOMAIN_LANG);

        $item["title"] = "<div class='position-relative kt-title'><div>" . $title . "</div><div class='kt-actions'>";
        $item["title"] .= "<span class='edit'><a class='redirect-edit' href='{$this->current_url}?action=update&id={$item["id"]}'>{$edit}</a></span> |";
        $item["title"] .= "<span class='delete'><a id='row-delete' class='submitdelete' href='#' data-toggle='modal' data-target='#modal-delete-row' data-title='{$title}' data-id='{$item["id"]}'>{$delete}</a></span>";
        $item["title"] .= "</div></div>";

        $item["checkbox"] = "<input type='checkbox' value='{$item["id"]}'/>";
        return $item;
    }


    protected function get_data() {
        return IDEntity::get_results($this->name, [], ARRAY_A );
    }
}