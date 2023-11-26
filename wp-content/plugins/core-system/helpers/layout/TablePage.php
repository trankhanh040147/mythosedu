<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 10/4/19
 * Time: 4:48 PM
 */

namespace CoreSystem\Helpers;
Class TablePage {
    private $current_url;
    private $search = "";
    private $rows = -1;
    private $page;
    private $table_args;
    private $filter_params;
    private $filter_rows;
    private $total_row = 0;

    public function __construct( $table_args, $filter_params = [], $filter_rows = [] ) {
        global $wp;

        $this->search = bf_get_param("search", "");
        $this->rows = bf_get_param("rows", 20);
        $this->current_url = $this->remove_page( site_url($wp->request) );
        $this->page = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

        $this->table_args = $table_args;
        $this->filter_rows = $filter_rows;
        $this->filter_params = $filter_params;
        wp_enqueue_script( 'bf-table-page-js', get_file_url( dirname(__DIR__) ) . '/js/table-page.js', array ( 'jquery' ), 1.1, true);
    }

    public function echo_filter_form() {
        if ( !empty($this->filter_params) ) {
            ?>
            <form id="params-filter-form" class="bf-submit-form" method="get" action="<?php echo $this->current_url; ?>">
                <?php
                $class = "form-control";
                $value_key = "";
                $label_key = "";

                foreach ($this->filter_params as $item) {
                    if ( !empty($item["class"]) ) {
                        $class = $item["class"];
                    }

                    if ( !empty($item["value_key"]) ) {
                        $value_key = $item["value_key"];
                    }

                    if ( !empty($item["label_key"]) ) {
                        $label_key = $item["label_key"];
                    }

                    ?>
                    <div class="params-filter">
                        <?php
                            if ( !empty($item["list"]) ) {
                                echo bf_render_select($item["list"], $item["name"], $value_key , $label_key, $item["default_value"], $class );
                            }
                            else {
                                echo "<input class='$class' name='{$item["name"]}' value='{$item["default_value"]}' />";
                            }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </form>
            <?php
        }
    }

    public function echo_row_number_filter_form() {
        ?>
        <form id="number-of-rows" class="bf-submit-form" method="get" action="<?php echo $this->current_url; ?>">
            <?php
            foreach ( $this->filter_params as $item) {
                ?>
                <input type="hidden" name="type" value="<?php echo $item["default_value"]; ?>">
                <?php
            }
            ?>
            <input type="hidden" name="search" value="<?php echo $this->search; ?>">
            <?php echo bf_render_select($this->filter_rows, "rows", "", "",  $this->rows); ?>
        </form>
        <?php
    }

    public function echo_search_form() {
        ?>
        <form id="search-filter" method="get" action="<?php echo $this->current_url; ?>">
            <div class="row">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="search" value="<?php echo $this->search; ?>">
                </div>
                <div class="col-md-4">
                    <input type="submit" value="<?php _e("Tìm kiếm"); ?>"
                </div>
            </div>
        </form>
        <?php
    }

    public function echo_table() {
        $params = array_merge($this->table_args["params"], [
            "limit" => $this->rows,
            "offset" => ( $this->page - 1 ) * $this->rows,
            "search" => $this->search
        ]);

        $salary = call_user_func_array( $this->table_args["function"], [ $params, ARRAY_A ]);
        $table = new TableLayout( $salary, $this->table_args["fields"] );

        if ( !empty($this->table_args["preprocess_item_function"]) ) {
            $table->set_preprocessing_item_function($this->table_args["preprocess_item_function"]);
        }

        $this->total_row = IDEntity::get_total_count();

        echo $table->render();
    }

    public function set_total_row($total_row) {
        $this->total_row = $total_row;
    }

    public function echo_paginate_link() {
        echo bf_render_paginate_links($this->total_row, $this->rows, $this->page);
    }

    private function remove_page($url) {
        return preg_replace("/page\/\d*/", "", $url);
    }

    public function echo_page() {
        ?>
        <div class="page-layout">
            <div class="row">
                <div class="col-md-4">
                    <?php $this->echo_search_form() ?>
                </div>
                <div class="col-md-8 pull-right">
                    <?php $this->echo_filter_form() ?>
                </div>
            </div>
            <?php  $this->echo_table(); ?>
            <div class="row">
                <div class="col-md-2">
                    <?php $this->echo_row_number_filter_form() ?>
                </div>
                <div class="col-md-10 pull-right">
                    <?php $this->echo_paginate_link() ?>
                </div>
            </div>
        </div>
        <?php
    }
}
