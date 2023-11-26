<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 8/8/18
 * Time: 3:36 PM
 */

if ( ! function_exists( 'cs_user_can_modify_post' ) ) {
    add_filter( 'wp_insert_post_empty_content', 'cs_user_can_modify_post', 10, 2 );

    function cs_user_can_modify_post( $maybe_empty, $postarr ) {
        if ( ! empty( $postarr['ID'] ) ) {
            if ( ! is_main_site() && ($postarr['post_type'] == BCM_PRODUCTS_PRODUCT || $postarr['post_type'] == BCM_PRODUCTS_PRODUCT_CHILDREN) ) {
                return true;
            }
        }

        return false;
    }
}

if ( ! function_exists( 'cs_user_can_do_action' ) ) {
    add_filter( 'post_row_actions', 'cs_user_can_do_action', 10, 2 );

    function cs_user_can_do_action( $actions, $post ) {
        if ( ! is_main_site() && ($post->post_type == BCM_PRODUCTS_PRODUCT || $post->post_type == BCM_PRODUCTS_PRODUCT_CHILDREN)  ) {
            return [];
        }

        return $actions;
    }
}

add_action('admin_init', function(){
    global $pagenow;
    $post_id="";
    if ( $pagenow == 'post.php' && isset( $_GET['post'] ) )
        $post_id = $post_ID = (int) $_GET['post'];

    if ( $post_id ) {
        $post = get_post($post_id);
        if( ! is_main_site() && ($post->post_type == BCM_PRODUCTS_PRODUCT || $post->post_type == BCM_PRODUCTS_PRODUCT_CHILDREN) ){
            wp_die( __( 'Sorry, you are not allowed to edit posts in this post type.' ) );
        }
    }

});
