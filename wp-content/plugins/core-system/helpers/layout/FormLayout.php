<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 8/21/19
 * Time: 3:04 PM
 */

namespace CoreSystem\Helpers;

class FormLayout {
    static function renderInputGroup($input) {
        $inputGroup = '<div class="form-group">';

        if ( !empty( $input["label"] ) ) {
            $inputGroup .= '<label for="' . $input['name'] . '">' .  $input["label"] . '</label>';
        }

        if ( $input["type"] == "checkbox" || $input["type"] == "radio" ) {
            $data = (array) $input["data"];
            $default_value = !empty( $input["default_value"] ) ? $input["default_value"] : "";

            foreach ( $data as $item ) {
                $id = $input['name'] . '-' .  $item['value'];
                $checked = $item['value'] === $default_value ? "checked" : "";

                $inputGroup .= '<div class="form-check">';
                $inputGroup .= "<input class='form-check-input' type='{$input["type"]}' name='{$input["name"]}[]' value='{$item['value']}' id='$id' {$checked}>";
                $inputGroup .= '<label class="form-check-label" for="' . $id . '">' .  $item['label'] . '</label>';
                $inputGroup .= '</div>';
            }
        }
        else if ($input["type"] == "select" ) {
            $data = (array) $input["data"];
            $inputGroup .= "<select id='{$input["name"]}' name='{$input["name"]}' class='form-control'>";
            $default_value = !empty( $input["default_value"] ) ? $input["default_value"] : "";

            foreach ( $data as $item ) {
                $selected = $item['value'] === $default_value ? "selected" : "";
                $inputGroup .= "<option value='{$item['value']}' $selected>{$item['label']}</option>";
            }

            $inputGroup .= '</select>';
        }
        else {
            $default_value = !empty( $input["default_value"] ) ? $input["default_value"] : "";
            $inputGroup .= "<input class='form-control' type='{$input["type"]}' name='{$input["name"]}' value='{$default_value}' id='{$input["name"]}'>";
        }

        $inputGroup .= "</div>";

        return $inputGroup;
    }
}
