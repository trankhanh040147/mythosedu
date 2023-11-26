<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 8/8/18
 * Time: 11:02 AM
 */

if ( ! function_exists( 'check_blog_id_is_broadcasted' ) ) {
    function check_blog_id_is_broadcasted( $list_sites, $blog_id ) {
        if ( empty($list_sites) ) {
            return false;
        }

        return in_array( (int)$blog_id, array_column( $list_sites, 'site_id' ));
    }
}

if ( ! function_exists( 'is_main_site' ) ) {
    function is_main_site($current_blog_id = null) {
        if ($current_blog_id == null) $current_blog_id = get_current_blog_id();
        $current_site = get_current_site();

        return $current_site->blog_id == $current_blog_id;
    }
}

if ( ! function_exists( 'convert_to_array_of_names' ) ) {
    function convert_to_array_of_names( $arr_of_objs ) {
        $arr = [];

        if ( !empty($arr_of_objs) ) {
            foreach ( $arr_of_objs as $obj ) {
                $arr[] = $obj->name;
            }
        }

        return $arr;
    }
}

if ( ! function_exists( 'convert_to_array_of_ids' ) ) {
    function convert_to_array_of_ids( $arr_of_names, $taxanomy ) {
        $arr = [];

        if ( !empty($arr_of_names) ) {
            foreach ( $arr_of_names as $name ) {
                $term = get_term_by( 'name', $name, $taxanomy );
                $arr[] = $term->term_id;
            }
        }

        return $arr;
    }
}

if ( ! function_exists( 'implement_function_follow_list_sites' ) ) {
    function implement_function_follow_list_sites( $list_sites, $syndication_function, $options = []) {
        if ( ! empty( $list_sites ) ) {
            remove_filter( 'wp_insert_post_empty_content', 'cs_user_can_modify_post' );

            foreach ($list_sites as $site) {
                $arr = array_merge( array( $site['pid'] ), $options );
                implement_function_follow_blog_id( $site['site_id'], $syndication_function, $arr );
            }
        }
    }
}

if ( ! function_exists( 'cs_post_api' ) ) {
    function cs_post_api( $post_id, $function, $arr = []) {
        $main_post_id = get_post_meta( $post_id, '_main_post', true );

        if ( ! empty( $main_post_id ) ) {
            $current_site = get_current_site();
            $arr = add_element_to_arguments($main_post_id, $arr, $function);
            return implement_function_follow_blog_id( $current_site->blog_id, $function, $arr );
        }

        $arr = add_element_to_arguments($post_id, $arr, $function);
        return call_user_func_array($function, $arr);
    }
}

if ( ! function_exists( 'implement_function_follow_blog_id' ) ) {
    function implement_function_follow_blog_id( $blog_id, $syndication_function, $arr, $arguments_processing_function = '' ) {
        switch_to_blog( (int) $blog_id );

        if ( $arguments_processing_function !== '' ) {
            $new_arr = $arguments_processing_function( $arr );
            $result = call_user_func_array( $syndication_function, $new_arr );
        }
        else {
            $result = call_user_func_array( $syndication_function, $arr );
        }

        restore_current_blog();

        return $result;
    }
}

if ( ! function_exists( 'add_element_to_arguments' ) ) {
    function add_element_to_arguments( $post_id, $arr, $function) {
        if ($function == 'get_field') {
            $arr[] =  $post_id;
        }
        else {
            array_unshift($arr, $post_id);
        }

        return $arr;
    }
}