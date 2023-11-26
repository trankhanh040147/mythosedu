<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 5/15/19
 * Time: 10:38 AM
 */
if ( !defined('BF_DEVELOPMENT_MODE') ) {
    define('BF_DEVELOPMENT_MODE', 'bf_development_mode');
}

if ( !defined('BF_PRODUCTION_MODE') ) {
    define('BF_PRODUCTION_MODE', 'bf_production_mode');
}

/**
 * get current time by timezone of the site
 * @return false|int
 */
function bf_current_time() {
    return strtotime( current_time('Y-m-d H:i:s') );
}

function bf_get_site_mode() {
    $home_url = explode("." , home_url() );

    if ( end($home_url) === "local" ) {
        return BF_DEVELOPMENT_MODE;
    }

    return BF_PRODUCTION_MODE;
}

function bf_create_random_password() {
    $normal_characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $normal_character_part = bf_create_random_string($normal_characters, 6);

    $special_characters = '!@#$$|%^&*().';
    $special_character_part = bf_create_random_string($special_characters, 3);

    return $normal_character_part . $special_character_part;
}

function bf_create_random_string($characters, $length) {
    $rand_string = '';

    for ($i = 0; $i < $length; $i++) {
        $rand_string .= $characters[rand(0, strlen($characters))];
    }

    return $rand_string;
}

function bf_get_param($key, $return = null) {
    return !empty ($_GET[$key]) ? trim( $_GET[$key] ) : $return;
}

function bf_convert_to_friendly_number_format($number) {
    if ( !is_numeric($number) ) {
        return "";
    }

    return number_format($number, 0, "", ".");
}

function bf_convert_time_to_seconds($time) {
    $time = explode(":", (string) $time);

    $count = 0;

    if ( isset($time[0]) ) {
        $count += (int) $time[0] *  3600;
    }

    if ( isset($time[1]) ) {
        $count += (int) $time[1] *  60;
    }

    return $count;
}

function bf_convert_number_to_day($number) {
    switch ($number) {
        case 1:
             return "sunday";
        case 2:
            return "monday";
        case 3:
            return "tuesday";
        case 4:
            return "wednesday";
        case 5:
            return "thursday";
        case 6:
            return "friday";
        case 7:
            return "saturday";
        default:
            return "today";
    }
}

function bf_substring($string, $length) {
    if ( strlen($string) > $length ) {
       return substr_replace( $string, " ...", $length );
    }

    return $string;
}

function bf_redirect($url) {
    echo '<script language="JavaScript">window.location="' . $url . '"</script>';
}

function bf_validate_email($email) {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function bf_copy_file($fileTemplate, $fileCopy) {
    @copy($fileTemplate, $fileCopy);
    @chmod($fileCopy, 0777);
}

function bf_is_int($value) {
    return preg_match("/[0-9]+/", (string) $value);
}

function bf_array_trim($array) {
   return array_map(function($ele) {
        return trim( (string) $ele );
   },$array);
}

function is_a_leap_year($year) {
    if ( (int)$year % 400 === 0 ||  ( (int)$year % 4 === 0 && (int)$year % 100 !== 0 ) ) {
        return true;
    }

    return false;
}

function bf_get_the_end_date_of_the_month($month, $year = null) {
    if ( !empty($year) ) {
        $year = date("Y");
    }

    if ( in_array($month, [1,3,5,7,8,10,12]) ) {
        return 31;
    }
    else if ( in_array( $month, [4,6,9, 11] ) ) {
        return 30;
    }
    else if ( is_a_leap_year($year)) {
        return 29;
    }
    else {
        return 28;
    }
}

function bf_compare_date($date1, $date2) {
    $time1 = strtotime($date1);
    $time2 = strtotime($date2);

    if ( $time1 > $time2 ) {
        return ">";
    }
    else if ( $time1 < $time2 ) {
        return "<";
    }

    return "=";
}
