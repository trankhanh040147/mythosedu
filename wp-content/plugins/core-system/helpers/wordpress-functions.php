<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 8/15/19
 * Time: 3:35 PM
 */
function get_file_url($path) {
    return str_replace(ABSPATH, home_url("/"), $path);
}