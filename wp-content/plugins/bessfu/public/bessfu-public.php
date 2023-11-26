<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 8/27/18
 * Time: 10:34 AM
 */

add_filter('site_configuration', 'site_get_configuration', 10);
function site_get_configuration(){
    #global $wpdb;
    #$prefix = $wpdb->get_blog_prefix(get_current_blog_id());
    static $site_config;
    $__key = '_config_site_';
    if( !isset($site_config[$__key]) ){
        $site_config[$__key] = get_option('bessfu_configuration_section', true);
    }

    return $site_config[$__key];
}

/**
 * Retrieves a post given its path.
 *
 * @since 2.1.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string       $post_path post path.
 * @param string       $output    Optional. The required return type. One of OBJECT, ARRAY_A, or ARRAY_N, which correspond to
 *                                a WP_Post object, an associative array, or a numeric array, respectively. Default OBJECT.
 * @param string|array $post_type Optional. Post type or array of post types. Default 'post'.
 * @return WP_Post|array|null WP_Post (or array) on success, or null on failure.
 */
function get_post_by_path( $post_path, $output = OBJECT, $post_type = 'post' ) {
    global $wpdb;

    $last_changed = wp_cache_get_last_changed( 'posts' );

    $hash = md5( $post_path . serialize( $post_type ) );
    $cache_key = "get_page_by_path:$hash:$last_changed";
    $cached = wp_cache_get( $cache_key, 'posts' );
    if ( false !== $cached ) {
        // Special case: '0' is a bad `$page_path`.
        if ( '0' === $cached || 0 === $cached ) {
            return;
        } else {
            return get_post( $cached, $output );
        }
    }

    $post_path = rawurlencode(urldecode($post_path));
    $post_path = str_replace('%2F', '/', $post_path);
    $post_path = str_replace('%20', ' ', $post_path);
    $parts = explode( '/', trim( $post_path, '/' ) );
    $parts = array_map( 'sanitize_title_for_query', $parts );
    $escaped_parts = esc_sql( $parts );

    $in_string = "'" . implode( "','", $escaped_parts ) . "'";

    if ( is_array( $post_type ) ) {
        $post_types = $post_type;
    } else {
        $post_types = array( $post_type, 'attachment' );
    }

    $post_types = esc_sql( $post_types );
    $post_type_in_string = "'" . implode( "','", $post_types ) . "'";
    $sql = "
		SELECT ID, post_name, post_parent, post_type
		FROM $wpdb->posts
		WHERE post_name IN ($in_string)
		AND post_type IN ($post_type_in_string)
	";

    $posts = $wpdb->get_results( $sql, OBJECT_K );

    $revparts = array_reverse( $parts );

    $foundid = 0;
    foreach ( (array) $posts as $post ) {
        if ( $post->post_name == $revparts[0] ) {
            $count = 0;
            $p = $post;

            /*
             * Loop through the given path parts from right to left,
             * ensuring each matches the post ancestry.
             */
            while ( $p->post_parent != 0 && isset( $posts[ $p->post_parent ] ) ) {
                $count++;
                $parent = $posts[ $p->post_parent ];
                if ( ! isset( $revparts[ $count ] ) || $parent->post_name != $revparts[ $count ] )
                    break;
                $p = $parent;
            }

            $foundid = $post->ID;
            if ( $post->post_type == $post_type )
                break;
        }
    }

    // We cache misses as well as hits.
    wp_cache_set( $cache_key, $foundid, 'posts' );

    if ( $foundid ) {
        return get_post( $foundid, $output );
    }
}
