<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 9/9/19
 * Time: 2:37 PM
 */
function render_select_month($value) {
    $html = "<select name='month' class='form-control'>";
    $month_text = __("Tháng", BF_LANG_DOMAIN);

    for ($i = 1; $i <= 12; $i ++) {
        $month_text_i = $i < 10 ? $month_text . ' 0' . $i : $month_text . " " . $i;
        $selected = $i == $value ? "selected" : "";
        $html .= "<option value='{$i}' $selected>{$month_text_i}</option>";
    }

    $html .= "</select>";

    return $html;
}

function render_select_year($start_year, $end_year, $value) {
    $html = "<select name='year' class='form-control'>";
    $year_text = __("Năm", BF_LANG_DOMAIN);

    for ($i = $start_year; $i <= $end_year; $i ++) {
        $year_text_i = $i < 10 ? $year_text . ' 0' . $i : $year_text . " " . $i;
        $selected = $i == $value ? "selected" : "";
        $html .= "<option value='{$i}' $selected>{$year_text_i}</option>";
    }

    $html .= "</select>";

    return $html;
}

if ( !function_exists("bf_render_alert_message") ) {
    function bf_render_alert_message($type, $message) {
        return AlertMessage::render($type, $message);
    }
}

if ( !function_exists("bf_render_qrcode") ) {
    function bf_render_qrcode($code, $size) {
        return "<img src='https://chart.googleapis.com/chart?cht=qr&chl={$code}&choe=UTF-8&chs={$size}x{$size}'/>";
    }
}

if ( !function_exists("bf_render_select") ) {
    function bf_render_select($data, $name, $value_key = "id", $label_key = "name", $default_value = false, $class = "form-control", $id = "") {
        $html_string = "<select name='$name' class='$class' id='$id'>";

        foreach ($data as $item) {
            if ( is_array($item) ) {
                $value = $item[$value_key];
                $label = $item[$label_key];
            }
            else {
                $value = $item;
                $label = $item;
            }

            $checked = ( $default_value !== false && $default_value == $value ) ? "selected" : "";
            $html_string .= "<option value='$value' $checked>$label</option>";
        }

        $html_string .= "</select>";

        return $html_string;
    }
}

if ( !function_exists("bf_render_paginate_links") ) {
    function bf_render_paginate_links($total_count, $row_numbers, $current_page) {
        $args = array(
            'total'              => ceil($total_count/ $row_numbers),
            'current'            => $current_page,
            'show_all'           => false,
            'end_size'           => 3,
            'mid_size'           => 1,
            'prev_next'          => true,
            'prev_text'          => __('«'),
            'next_text'          => __('»'),
            'type'               => 'plain',
            'add_args'           => false,
            'add_fragment'       => '',
        );

        return paginate_links( $args );
    }
}
