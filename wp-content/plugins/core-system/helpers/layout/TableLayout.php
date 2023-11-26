<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 8/20/19
 * Time: 4:24 PM
 */
namespace CoreSystem\Helpers;

class TableLayout {
    protected $data;
    protected $header;
    protected $table_class = "table table-striped table-hover r-0 table-common text-center";
    protected $head_class = "cf row-thead-title-parent";
    protected $head_row_class = "row-thead-title-parent no-b";
    protected $preprocessing_item_function = null;
    protected $addional_data;

    public function __construct($data, $header, $classes = [], $addional_data = []) {
        $this->data = $data;
        $this->header = $header;
        $this->set_classes($classes);
        $this->addional_data = $addional_data;
        wp_enqueue_script( 'bf-table-js', self::get_file_url( dirname(__DIR__) ) . '/js/table.js', array ( 'jquery' ), 1.1, true);
    }

    function render() {
        if ( !empty($this->data) ) {
            $table = "<div class='table-responsive'><table class='{$this->table_class}'>";
            $table .= $this::renderThead();
            $table .= $this::renderTbody();
            $table .= "</table></div>";

            return $table;
        }

        return $this->empty_data() ;
    }

    private function renderThead() {
        $thead = "<thead class='$this->head_class'>";

        $key = 0;
        $addition[$key] = $this->header;

        while ( !empty($addition[$key]) ) {
            $thead .= $this->render_header_row($addition, $key);
            $key++;
        }

        $thead .= "</thead>";

        return $thead;
    }

    public function renderTbody() {
        $body = $this->data;
        $tbody = '<tbody>';

        foreach ($body as $key => $item) {
            if ($this->preprocessing_item_function !== null) {
                $item = call_user_func( $this->preprocessing_item_function, $item, $key,  $this->addional_data );
            }

            $item = $this->modify_item($item);

            if ( !empty($item) ) {
                $tbody .=  "<tr class='tr-action'>" . $this->render_columns_of_row($this->header, $item ) . "</tr>";
            }
        }

        $tbody .= "</tbody>";

        return $tbody;
    }

    private function render_header_row ( &$data, $key ) {
        $row = "<tr class='$this->head_row_class'>";
        $data[$key + 1] = [];

        foreach ($data[$key] as $th) {
            $att = "";
            if (  is_array($th) ) {
                if ( !empty( $th["children"] ) ) {
                    $data[$key + 1] = array_merge( $data[$key + 1], $th["children"]);
                }

                if ( !empty($th["rowspan"]) ) {
                    $att .= " rowspan='{$th["rowspan"]}'";
                }

                if ( !empty($th["colspan"]) ) {
                    $att .= " colspan='{$th["colspan"]}'";
                }

                $th = $th["value"];
            }

            $row .= "<th{$att}>{$th}</th>";
        }

        $row .= "</tr>";

        return $row;
    }

    private function render_columns_of_row($data, $item) {
        $row = "";

        foreach ($data as $key => $th) {
            if ( !empty( $th["children"] ) ) {
                $row .= $this->render_columns_of_row( $th["children"], $item[$key] );
            }
            else {
                $row .= "<td>{$item[$key]}</td>";
            }
        }

        return $row;
    }

    protected static function get_file_url($path) {
        return str_replace(ABSPATH, home_url("/"), $path);
    }

    function modify_item($item) {
        return $item;
    }

    public function set_preprocessing_item_function($func) {
        $this->preprocessing_item_function = $func;
    }

    protected function set_classes($classes) {
        if ( !empty($classes["table_class"]) ) {
            $this->table_class = $classes["table_class"];
        }

        if ( !empty($classes["head_class"]) ) {
            $this->head_class = $classes["head_class"];
        }

        if ( !empty($classes["head_row_class"]) ) {
            $this->head_row_class = $classes["head_row_class"];
        }
    }

    protected function empty_data() {
        return "Không có dữ liệu";
    }
}
