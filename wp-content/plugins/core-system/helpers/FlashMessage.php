<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 8/19/19
 * Time: 4:02 PM
 */

namespace CoreSystem\Helpers;

class FlashMessage {
    static function get_message() {
        if ( !empty($_SESSION["flash_message"]) ) {
            return $_SESSION["flash_message"];
        }

        return "";
    }

    static function show_message() {
        if ( !empty($_SESSION["flash_message"]) ) {
            $message = $_SESSION["flash_message"];
            unset($_SESSION["flash_message"]);
            return '<div class="alert alert-' . $message["type"] . ' alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $message["content"] . '</div>';
        }
        return "";
    }

    static function set_message($content, $type) {
        $_SESSION["flash_message"] = [
            "content" => $content,
            "type" => $type
        ];
    }
}