<?php
/**
 * Created by PhpStorm.
 * User: BCM_dev
 * Date: 8/6/18
 * Time: 5:03 PM
 */

if ( ! function_exists( 'cs_start_output_buffers' ) ) {
    add_action('init', 'cs_start_output_buffers');

    function cs_start_output_buffers() {
        ob_start();
    }
}

if ( ! function_exists( 'content_syndication_meta_box' ) ) {
    if ( is_main_site() ) {
        add_action('add_meta_boxes', 'content_syndication_meta_box', 10, 2);

        function content_syndication_meta_box() {
            add_meta_box('content_syndication', 'Broadcast', 'render_content_syndication', BCM_PRODUCTS_PRODUCT, 'normal', 'high');
        }
    }
}

if ( ! function_exists( 'render_content_syndication' ) ) {
    function render_content_syndication( $post ) {
        if ( is_main_site() ) {
            $current_blog_id = get_current_blog_id();
            $list_sites = get_post_meta( $post->ID, '_list_sites', true );
            $blogs = get_sites();

            echo '<div><label><input id="check-all" type="checkbox">' . __('All') . '</label></div>';

            foreach ( $blogs as $blog ) {
                if ( $current_blog_id != $blog->blog_id ):
                    ?>
                    <label class="select-multisite">
                        <input type="checkbox" name="site_ids[]" value="<?php echo $blog->blog_id ; ?> "
                            <?php echo check_blog_id_is_broadcasted( $list_sites, $blog->blog_id ) ? 'checked' : ''; ?> />
                        <?php
                        $blog_details = get_blog_details($blog->blog_id );
                        echo $blog_details->blogname ;
                        ?>
                    </label>
                <?php
                endif;
            }
        }
    }
}

if ( ! function_exists( 'content_syndication_save' ) ) {
    add_action( 'save_post', 'content_syndication_save', 10, 2 );

    function content_syndication_save($post_id, $post_object) {
        if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE )
            return;

        if ( defined( 'DOING_AJAX') && DOING_AJAX )
            return;

        if ( in_array( $post_object->post_status, array( 'auto-draft', 'inherit' ) ) )
            return;

        remove_action( 'save_post', 'content_syndication_save' );

        if ( is_main_site() && ($post_object->post_type == BCM_PRODUCTS_PRODUCT_CHILDREN || $post_object->post_type == BCM_PRODUCTS_PRODUCT) ) {
            remove_filter( 'wp_insert_post_empty_content', 'cs_user_can_modify_post' );

            update_post_meta( $post_id, '_main_post', $post_id );

            $list_sites = get_post_meta( $post_id, '_list_sites', true );
            $list_sites = $list_sites ? $list_sites : [];

            $site_ids = $_POST['site_ids'];
            $action = $_REQUEST['action'];
            $new_list_sites = [];
            $child_list_sites = [];
            $getPostChild = new WP_Query([
                    'posts_per_page' => -1,
                    'post_type' => BCM_PRODUCTS_PRODUCT_CHILDREN,
                    'post_parent' => $post_id,
                    'post_status' => ['publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash']]
            );

            $getPostChild = $getPostChild->get_posts();

            if ( ! empty( $site_ids ) ) {

                $post = array(
                    'post_title'    => $post_object->post_title,
                    'post_content'  => $post_object->post_content,
                    'post_status'   => 'publish',
                    'post_type'   => $post_object->post_type,
                    'post_author'   => $post_object->post_author,
                    'tags_input'    => convert_to_array_of_names( get_the_tags( $post_id ) )
                );

                $category_names = convert_to_array_of_names( get_the_terms( $post_id, 'module_type') );

                $main_post_id = $post_id;

                foreach ( $site_ids as $sid ) {
                    switch_to_blog( (int)$sid );
                    $post['tax_input'] = array( 'module_type' => convert_to_array_of_ids( $category_names, 'module_type') );
                    $key = array_search( (int)$sid, array_column( $list_sites, 'site_id' ) );

                    if ( $key !== false ) {
                        $post['ID'] = $list_sites[$key]['pid'];
                        remove_filter( 'wp_insert_post_empty_content', 'cs_user_can_modify_post' );
                        $pid = wp_update_post( $post );
                    }
                    else {
                        unset($post['ID']);
                        $pid = wp_insert_post($post);
                        if (!empty($getPostChild)) {
                            foreach ($getPostChild as $child) {
                                $data = [
                                    'post_title' => $child->post_title,
                                    'post_type' => BCM_PRODUCTS_PRODUCT_CHILDREN,
                                    'post_status' => 'auto-draft',
                                    'post_parent' => $pid,
                                    'menu_order' => $child->menu_order,
                                    'post_name' => sanitize_title($child->post_title.' '.$post['post_title']),
                                ];

                                $child_id = wp_insert_post($data);
                                update_post_meta( $child_id, '_main_post', $child->ID );
                                $child_list_sites[$child->ID][] = array( 'site_id' => $sid, 'pid' => $child_id );
                            }
                        }
                    }

                    if ( is_int( $pid ) && $pid != 0 ) {
                        update_post_meta( $pid, '_main_post', $main_post_id );
                        $new_list_sites[] = array( 'site_id' => $sid, 'pid' => $pid );
                    }

                    restore_current_blog();
                }

                update_post_meta( $post_id, '_list_sites', $new_list_sites );

                foreach ($child_list_sites as $key => $list) {
                    update_post_meta( $key, '_list_sites', $list );
                }

                if ( ! empty( $list_sites ) ) {
                    foreach ( $list_sites as $site ) {
                        if ( ! in_array( (int)$site['site_id'], array_column( $new_list_sites, 'site_id' ) ) ) {
                            implement_function_follow_blog_id( $site['site_id'], 'wp_delete_post', array( $site['pid'], true ) );
                        }
                    }
                }
            } else if ( $action == "editpost" && ($post_object->post_type == BCM_PRODUCTS_PRODUCT_CHILDREN ) && !empty($list_sites) ) {
                $data = [
                    'post_title' => $post_object->post_title,
                    'post_type' => $post_object->post_type,
                    'post_status' => $post_object->post_status,
                    'menu_order' => $post_object->menu_order,
                    'post_name' => $post_object->post_name,
                    'post_content'  => $post_object->post_content,
                ];

                $_wp_page_template = get_post_meta($post_object->ID, '_wp_page_template', true);

                foreach ( $list_sites as $site ) {
                    $data['ID'] = $site['pid'];
                    remove_filter( 'wp_insert_post_empty_content', 'cs_user_can_modify_post' );
                    implement_function_follow_blog_id( $site['site_id'], 'wp_update_post', array( $data) );
                    implement_function_follow_blog_id( $site['site_id'], 'update_post_meta', array($data['ID'], '_wp_page_template', $_wp_page_template) );
                }
            }
        }
    }
}

if (! function_exists( 'cs_trash_post' )) {
    function cs_trash_post($post_id) {
        if ( is_main_site() ) {
            $list_sites = get_post_meta( $post_id, '_list_sites', true );
            implement_function_follow_list_sites( $list_sites, 'wp_trash_post' );
        }
    }
}

add_action('wp_trash_post', 'cs_trash_post', 10, 1);

if (! function_exists( 'cs_untrash_post' )) {
    function cs_untrash_post($post_id) {
        if ( is_main_site() ) {
            $list_sites = get_post_meta( $post_id, '_list_sites', true );
            implement_function_follow_list_sites( $list_sites, 'wp_untrash_post' );
        }
    }
}

add_action('untrashed_post', 'cs_untrash_post', 10, 1);

if ( ! function_exists( 'cs_delete_post' ) ) {
    add_action( 'before_delete_post', 'cs_delete_post', 10, 1 );

    function cs_delete_post( $post_id ) {
        remove_action( 'before_delete_post', 'cs_delete_post' );

        $list_sites = get_post_meta( $post_id, '_list_sites', true );
        implement_function_follow_list_sites ( $list_sites, 'wp_delete_post', array ( true ) );
    }
}

if ( ! function_exists( 'cs_create_items' ) ) {
    add_action( 'create_term', 'cs_create_items', 10, 3 );

    function cs_create_items( $term_id, $tt_id, $taxonomy ) {
        remove_action( 'create_term', 'cs_create_items' );

        cs_modify_term( $term_id, $taxonomy, 'wp_insert_term', 'cs_process_arguments_before_insert' );
    }
}

if ( ! function_exists( 'cs_edit_items' ) ) {
    add_action( 'edit_term', 'cs_edit_items', 10, 3 );

    function cs_edit_items( $term_id, $tt_id, $taxonomy ) {
        remove_action( 'edit_term', 'cs_edit_items' );

        cs_modify_term( $term_id, $taxonomy, 'wp_update_term', 'cs_process_arguments_before_update' );
    }
}

if ( ! function_exists( 'cs_delete_items' ) ) {
    add_action( 'delete_term', 'cs_delete_items', 10, 4 );

    function cs_delete_items( $term_id, $tt_id, $taxonomy, $deleted_term ) {
        remove_action( 'delete_term', 'cs_delete_items' );

        $arr = array( $deleted_term, $taxonomy );
        $blogs = get_sites();

        foreach ( $blogs as $blog ) {
            if ( !is_main_site($blog->blog_id) ) {
                implement_function_follow_blog_id( $blog->blog_id, 'wp_delete_term', $arr, 'cs_process_arguments_before_delete' );
            }
        }

        add_action( 'delete_term', 'cs_delete_items', 10, 4 );
    }
}

if ( ! function_exists( 'cs_modify_term' ) ) {
    function cs_modify_term( $term_id, $taxonomy, $syndication_function, $arguments_processing_function ) {
        if ( is_main_site() ) {
            $term = get_term( $term_id, $taxonomy );

            if ( $syndication_function == 'wp_update_term' ) {
                $old_name = $term->name;
                clean_term_cache( $term_id, $taxonomy );
                $term = get_term( $term_id, $taxonomy );
                $term->name = array( $term->name, $old_name );
            }

            $arr = array( $term, $taxonomy );

            if ($term->parent != 0) {
                $parent_term = get_term($term->parent, $taxonomy);
                $arr[] = array( 'parent' => $parent_term->name );
            }

            $blogs = get_sites();

            foreach ( $blogs as $blog ) {
                if ( !is_main_site($blog->blog_id) ) {
                    implement_function_follow_blog_id( $blog->blog_id, $syndication_function, $arr, $arguments_processing_function );
                }
            }
        }
    }
}

if ( ! function_exists( 'cs_process_arguments_before_insert' ) ) {
    function cs_process_arguments_before_insert( $arr ) {
        $term = get_term_by( 'name', $arr[2]['parent'], $arr[1]);
        $new_arr = array( $arr[0]->name, $arr[1], array( 'parent' => $term->term_id ) );

        return $new_arr;
    }
}

if ( ! function_exists( 'cs_process_arguments_before_update' ) ) {
    function cs_process_arguments_before_update( $arr ) {
        $term = get_term_by( 'name', $arr[0]->name[1], $arr[1] );
        $parent_term = get_term_by( 'name', $arr[2]['parent'], $arr[1] );
        $new_arr = array(
            $term->term_id,
            $arr[1],
            array(
                'name' => $arr[0]->name[0],
                'slug' => $arr[0]->slug,
                'description' => $arr[0]->description,
                'parent' => $parent_term->term_id,
            )
        );

        return $new_arr;
    }
}

if ( ! function_exists( 'cs_process_arguments_before_delete' ) ) {
    function cs_process_arguments_before_delete( $arr ) {
        $term = get_term_by( 'name', $arr[0]->name, $arr[1] );
        $new_arr = array(
            $term->term_id,
            $arr[1],
        );

        return $new_arr;
    }
}

if ( ! function_exists( 'cs_scripts_styles' ) ) {
    add_action('admin_enqueue_scripts', 'cs_scripts_styles');

    function cs_scripts_styles() {
        wp_enqueue_script("cs-content-syndication-js", plugins_url("js/content-syndication.js", __FILE__), false, "1.0");
    }
}

if ( !function_exists( 'syndycate_post_after_duplicate' ) ) {
    function syndycate_post_after_duplicate($from_site_id, $to_site_id) {
        switch_to_blog( (int) $to_site_id );
        global $wpdb;

        update_domain_for_database( get_home_url($from_site_id), get_home_url($to_site_id) );

        $query = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts as p
            JOIN {$wpdb->prefix}postmeta as m ON p.ID = m.post_id AND m.meta_key = '_main_post'
            WHERE p.post_type = %s OR p.post_type = %s", BCM_PRODUCTS_PRODUCT, BCM_PRODUCTS_PRODUCT_CHILDREN);
        $posts = $wpdb->get_results( $query, OBJECT );

        switch_to_blog( BLOG_ID_CURRENT_SITE );

        foreach ($posts as $post) {
            $main_post_id = $post->meta_value;

            $list_sites = get_post_meta( $main_post_id, '_list_sites', true );

            $list_sites = $list_sites ? $list_sites : [];
            $list_sites[] = array( 'site_id' => $to_site_id, 'pid' =>  $post->ID );

            update_post_meta( $main_post_id, '_list_sites', $list_sites );
        }

        restore_current_blog();
    }
}

add_action( 'mucd_after_copy_data', 'syndycate_post_after_duplicate', 10, 2);


add_action( 'update_option', "syndycate_post_before_set_domain", 10, 3 );

function syndycate_post_before_set_domain($option, $old_value, $new_value) {
    if ( $option === "siteurl" ) {
        update_domain_for_database($old_value, $new_value);
    }
}

function update_domain_for_database($old_value, $new_value) {
    global $wpdb;

    $query = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts as p
            WHERE p.post_type != %s AND p.post_type != %s", BCM_PRODUCTS_PRODUCT, BCM_PRODUCTS_PRODUCT_CHILDREN);
    $posts = $wpdb->get_results( $query, OBJECT );

    $from_url = preg_replace("/http(s)?:\/\/(www\.)?/", "", $old_value );
    $to_url = preg_replace("/http(s)?:\/\/(www\.)?/", "", $new_value );

    foreach ($posts as $post) {
        wp_update_post([
            "ID" => $post->ID,
            "post_content" =>  str_replace($from_url, $to_url, $post->post_content)
        ]);
    }

    $query = $wpdb->prepare("SELECT pt.* FROM {$wpdb->prefix}postmeta as pt
            JOIN {$wpdb->prefix}posts as p ON  pt.post_id = p.ID 
            WHERE p.post_type != %s AND p.post_type != %s", BCM_PRODUCTS_PRODUCT, BCM_PRODUCTS_PRODUCT_CHILDREN);
    $post_metas = $wpdb->get_results( $query, OBJECT );

    foreach ($post_metas as $meta) {
        $meta_value = unserialize( $meta->meta_value ) ;

        if ( $meta_value ) {
            $meta_value = replace_array_value($meta_value, $from_url, $to_url);
            update_post_meta( $meta->post_id, $meta->meta_key, $meta_value );
        }
        else {
            update_post_meta($meta->post_id, $meta->meta_key, str_replace($from_url, $to_url, str_replace( "www.", "", $meta->meta_value) ));
        }
    }
}

function replace_array_value($meta_key, $from_url, $to_url) {
    foreach ( $meta_key as $key => $item ) {
        if ( is_array($item) ) {
            $meta_key[$key] = replace_array_value($item, $from_url, $to_url);
        }
        else {
            $meta_key[$key] = str_replace( $from_url, $to_url, str_replace( "www.", "", $item) );
        }
    }

    return $meta_key;
}