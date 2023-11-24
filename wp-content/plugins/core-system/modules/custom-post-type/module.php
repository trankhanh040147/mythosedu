<?php

/**
 * Plugin Name: Custom Post Type
 * Plugin URI: #
 * Description: Admin panel for creating custom post types and custom taxonomies in WordPress
 * Author: #
 * Version: 1.7.4
 * Author URI: #
 * Text Domain: cpt-lang
 * Domain Path: /languages
 * License: GPL-2.0+
 */

namespace CoreSystem\Modules\CustomPostType;

// phpcs:disable #.All.RequireAuthor

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CoreSystem\Admin\Core_System_Admin;

class Module{

    public static $instance = null;

    public function __construct()
    {
        $this->define();
        $this->init_hooks();
        $this->autoloader();
    }

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function define(){
        define( 'CPT_VERSION', '1.7.4' );
        define( 'CPT_DIR', __DIR__ );
        define( 'CPT_URL', plugins_url(__FILE__) );
        define( 'CPT_LANG', 'cpt-lang' );
    }

    function autoloader(){
        require_once CPT_DIR . '/inc/helpers.php';
        require_once CPT_DIR . '/inc/utility.php';
        require_once CPT_DIR . '/inc/post-types.php';
        require_once CPT_DIR . '/inc/taxonomies.php';
        require_once CPT_DIR . '/inc/listings.php';
        require_once CPT_DIR . '/inc/tools.php';
        require_once CPT_DIR . '/classes/class-cpt-admin.php';
        require_once CPT_DIR . '/classes/class-cpt-debug-info.php';
    }

    public function init_hooks(){
        add_action( 'plugins_loaded', [$this, 'load_textdomain'] );

        add_action( 'admin_menu', [$this, 'admin_menu'] );

        add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue_scripts'] );

        add_action( 'init', [$this, 'create_custom_post_types'], 10 ); // Leave on standard init for legacy purposes.

        add_action( 'init', [$this, 'create_custom_taxonomies'], 9 );  // Leave on standard init for legacy purposes.

        add_action( 'admin_init', [$this, 'convert_settings'] );
    }

    public function load_textdomain(){
        load_plugin_textdomain( CPT_LANG );
    }

    /**
     * Load our main menu.
     *
     * Submenu items added in version 1.1.0
     *
     * @since 0.1.0
     *
     * @internal
     */
    public function admin_menu(){
        $capability  = apply_filters( 'cpt_required_capabilities', 'manage_options' );
        $parent_slug = 'cpt_main_menu';
        add_menu_page( __( 'Custom Post Types', CPT_LANG ), __( 'CPT', CPT_LANG ), $capability, $parent_slug, 'cpt_settings', cpt_menu_icon() );
        add_submenu_page( $parent_slug, __( 'Add/Edit Post Types', CPT_LANG ), __( 'Add/Edit Post Types', CPT_LANG ), $capability, 'cpt_manage_post_types', 'cpt_manage_post_types' );
        add_submenu_page( $parent_slug, __( 'Add/Edit Taxonomies', CPT_LANG ), __( 'Add/Edit Taxonomies', CPT_LANG ), $capability, 'cpt_manage_taxonomies', 'cpt_manage_taxonomies' );
        add_submenu_page( $parent_slug, __( 'Registered Types and Taxes', CPT_LANG ), __( 'Registered Types/Taxes', CPT_LANG ), $capability, 'cpt_listings', 'cpt_listings' );
        add_submenu_page( $parent_slug, __( 'Tools', CPT_LANG ), __( 'Tools', CPT_LANG ), $capability, 'cpt_tools', 'cpt_tools' );

        /**
         * Fires after the default submenu pages.
         *
         * @since 1.3.0
         *
         * @param string $value      Parent slug for Custom Post Type menu.
         * @param string $capability Capability required to manage CPT settings.
         */
        do_action( 'cpt_extra_menu_items', $parent_slug, $capability );

        // Remove the default one so we can add our customized version.
        remove_submenu_page( $parent_slug, 'cpt_main_menu' );
    }

    function admin_enqueue_scripts() {
        if ( wp_doing_ajax() ) {
            return;
        }

        $min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
        wp_register_script( 'cpt', plugins_url( "js/cpt{$min}.js", __FILE__ ), [ 'jquery', 'jquery-ui-dialog', 'postbox' ], CPT_VERSION, true );
        wp_register_style( 'cpt-css', plugins_url( "css/cpt{$min}.css", __FILE__ ), [ 'wp-jquery-ui-dialog' ], CPT_VERSION );
    }


    /**
     * Register our users' custom post types.
     *
     * @since 0.5.0
     *
     * @internal
     */
    function create_custom_post_types() {
        $cpts = get_option( 'cpt_post_types' );

        if ( empty( $cpts ) ) {
            return;
        }

        /**
         * Fires before the start of the post type registrations.
         *
         * @since 1.3.0
         *
         * @param array $cpts Array of post types to register.
         */
        do_action( 'cpt_pre_register_post_types', $cpts );

        if ( is_array( $cpts ) ) {
            foreach ( $cpts as $post_type ) {

                /**
                 * Filters whether or not to skip registration of the current iterated post type.
                 *
                 * Dynamic part of the filter name is the chosen post type slug.
                 *
                 * @since 1.7.0
                 *
                 * @param bool  $value     Whether or not to skip the post type.
                 * @param array $post_type Current post type being registered.
                 */
                if ( (bool) apply_filters( "cpt_disable_{$post_type['name']}_cpt", false, $post_type ) ) {
                    continue;
                }

                /**
                 * Filters whether or not to skip registration of the current iterated post type.
                 *
                 * @since 1.7.0
                 *
                 * @param bool  $value     Whether or not to skip the post type.
                 * @param array $post_type Current post type being registered.
                 */
                if ( (bool) apply_filters( 'cpt_disable_cpt', false, $post_type ) ) {
                    continue;
                }

                $this->register_single_post_type( $post_type );
            }
        }

        /**
         * Fires after the completion of the post type registrations.
         *
         * @since 1.3.0
         *
         * @param array $cpts Array of post types registered.
         */
        do_action( 'cpt_post_register_post_types', $cpts );
    }

    /**
     * Register our users' custom taxonomies.
     *
     * @since 0.5.0
     *
     * @internal
     */
    function create_custom_taxonomies() {
        $taxes = get_option( 'cpt_taxonomies' );

        if ( empty( $taxes ) ) {
            return;
        }

        /**
         * Fires before the start of the taxonomy registrations.
         *
         * @since 1.3.0
         *
         * @param array $taxes Array of taxonomies to register.
         */
        do_action( 'cpt_pre_register_taxonomies', $taxes );

        if ( is_array( $taxes ) ) {
            foreach ( $taxes as $tax ) {
                /**
                 * Filters whether or not to skip registration of the current iterated taxonomy.
                 *
                 * Dynamic part of the filter name is the chosen taxonomy slug.
                 *
                 * @since 1.7.0
                 *
                 * @param bool  $value Whether or not to skip the taxonomy.
                 * @param array $tax   Current taxonomy being registered.
                 */
                if ( (bool) apply_filters( "cpt_disable_{$tax['name']}_tax", false, $tax ) ) {
                    continue;
                }

                /**
                 * Filters whether or not to skip registration of the current iterated taxonomy.
                 *
                 * @since 1.7.0
                 *
                 * @param bool  $value Whether or not to skip the taxonomy.
                 * @param array $tax   Current taxonomy being registered.
                 */
                if ( (bool) apply_filters( 'cpt_disable_tax', false, $tax ) ) {
                    continue;
                }

                $this->register_single_taxonomy( $tax );
            }
        }

        /**
         * Fires after the completion of the taxonomy registrations.
         *
         * @since 1.3.0
         *
         * @param array $taxes Array of taxonomies registered.
         */
        do_action( 'cpt_post_register_taxonomies', $taxes );
    }

    /**
     * Helper function to register the actual post_type.
     *
     * @since 1.0.0
     *
     * @internal
     *
     * @param array $post_type Post type array to register. Optional.
     * @return null Result of register_post_type.
     */
    function register_single_post_type( $post_type = [] ) {

        /**
         * Filters the map_meta_cap value.
         *
         * @since 1.0.0
         *
         * @param bool   $value     True.
         * @param string $name      Post type name being registered.
         * @param array  $post_type All parameters for post type registration.
         */
        $post_type['map_meta_cap'] = apply_filters( 'cpt_map_meta_cap', true, $post_type['name'], $post_type );

        if ( empty( $post_type['supports'] ) ) {
            $post_type['supports'] = [];
        }

        /**
         * Filters custom supports parameters for 3rd party plugins.
         *
         * @since 1.0.0
         *
         * @param array  $value     Empty array to add supports keys to.
         * @param string $name      Post type slug being registered.
         * @param array  $post_type Array of post type arguments to be registered.
         */
        $user_supports_params = apply_filters( 'cpt_user_supports_params', [], $post_type['name'], $post_type );

        if ( is_array( $user_supports_params ) && ! empty( $user_supports_params ) ) {
            if ( is_array( $post_type['supports'] ) ) {
                $post_type['supports'] = array_merge( $post_type['supports'], $user_supports_params );
            } else {
                $post_type['supports'] = [ $user_supports_params ];
            }
        }

        $yarpp = false; // Prevent notices.
        if ( ! empty( $post_type['custom_supports'] ) ) {
            $custom = explode( ',', $post_type['custom_supports'] );
            foreach ( $custom as $part ) {
                // We'll handle YARPP separately.
                if ( in_array( $part, [ 'YARPP', 'yarpp' ], true ) ) {
                    $yarpp = true;
                    continue;
                }
                $post_type['supports'][] = trim( $part );
            }
        }

        if ( isset( $post_type['supports'] ) && is_array( $post_type['supports'] ) && in_array( 'none', $post_type['supports'], true ) ) {
            $post_type['supports'] = false;
        }

        $labels = [
            'name'          => $post_type['label'],
            'singular_name' => $post_type['singular_label'],
        ];

        $preserved        = $this->get_preserved_keys( 'post_types' );
        $preserved_labels = $this->get_preserved_labels();
        foreach ( $post_type['labels'] as $key => $label ) {

            if ( ! empty( $label ) ) {
                if ( 'parent' === $key ) {
                    $labels['parent_item_colon'] = $label;
                } else {
                    $labels[ $key ] = $label;
                }
            } elseif ( empty( $label ) && in_array( $key, $preserved, true ) ) {
                $singular_or_plural = ( in_array( $key, array_keys( $preserved_labels['post_types']['plural'] ) ) ) ? 'plural' : 'singular';
                $label_plurality    = ( 'plural' === $singular_or_plural ) ? $post_type['label'] : $post_type['singular_label'];
                $labels[ $key ]     = sprintf( $preserved_labels['post_types'][ $singular_or_plural ][ $key ], $label_plurality );
            }
        }

        $has_archive = isset( $post_type['has_archive'] ) ? get_disp_boolean( $post_type['has_archive'] ) : false;
        if ( $has_archive && ! empty( $post_type['has_archive_string'] ) ) {
            $has_archive = $post_type['has_archive_string'];
        }

        $show_in_menu = get_disp_boolean( $post_type['show_in_menu'] );
        if ( ! empty( $post_type['show_in_menu_string'] ) ) {
            $show_in_menu = $post_type['show_in_menu_string'];
        }

        $rewrite = get_disp_boolean( $post_type['rewrite'] );
        if ( false !== $rewrite ) {
            // Core converts to an empty array anyway, so safe to leave this instead of passing in boolean true.
            $rewrite         = [];
            $rewrite['slug'] = ! empty( $post_type['rewrite_slug'] ) ? $post_type['rewrite_slug'] : $post_type['name'];

            $rewrite['with_front'] = true; // Default value.
            if ( isset( $post_type['rewrite_withfront'] ) ) {
                $rewrite['with_front'] = 'false' === disp_boolean( $post_type['rewrite_withfront'] ) ? false : true;
            }
        }

        $menu_icon = ! empty( $post_type['menu_icon'] ) ? $post_type['menu_icon'] : null;

        if ( in_array( $post_type['query_var'], [ 'true', 'false', '0', '1' ], true ) ) {
            $post_type['query_var'] = get_disp_boolean( $post_type['query_var'] );
        }
        if ( ! empty( $post_type['query_var_slug'] ) ) {
            $post_type['query_var'] = $post_type['query_var_slug'];
        }

        $menu_position = null;
        if ( ! empty( $post_type['menu_position'] ) ) {
            $menu_position = (int) $post_type['menu_position'];
        }

        $delete_with_user = null;
        if ( ! empty( $post_type['delete_with_user'] ) ) {
            $delete_with_user = get_disp_boolean( $post_type['delete_with_user'] );
        }

        $capability_type = 'post';
        if ( ! empty( $post_type['capability_type'] ) ) {
            $capability_type = $post_type['capability_type'];
            if ( false !== strpos( $post_type['capability_type'], ',' ) ) {
                $caps = array_map( 'trim', explode( ',', $post_type['capability_type'] ) );
                if ( count( $caps ) > 2 ) {
                    $caps = array_slice( $caps, 0, 2 );
                }
                $capability_type = $caps;
            }
        }

        $public = get_disp_boolean( $post_type['public'] );
        if ( ! empty( $post_type['exclude_from_search'] ) ) {
            $exclude_from_search = get_disp_boolean( $post_type['exclude_from_search'] );
        } else {
            $exclude_from_search = false === $public;
        }

        $queryable = ( ! empty( $post_type['publicly_queryable'] ) && isset( $post_type['publicly_queryable'] ) ) ? get_disp_boolean( $post_type['publicly_queryable'] ) : $public;

        if ( empty( $post_type['show_in_nav_menus'] ) ) {
            // Defaults to value of public.
            $post_type['show_in_nav_menus'] = $public;
        }

        if ( empty( $post_type['show_in_rest'] ) ) {
            $post_type['show_in_rest'] = false;
        }

        $rest_base = null;
        if ( ! empty( $post_type['rest_base'] ) ) {
            $rest_base = $post_type['rest_base'];
        }

        $rest_controller_class = null;
        if ( ! empty( $post_type['rest_controller_class'] ) ) {
            $rest_controller_class = $post_type['rest_controller_class'];
        }

        $args = [
            'labels'                => $labels,
            'description'           => $post_type['description'],
            'public'                => get_disp_boolean( $post_type['public'] ),
            'publicly_queryable'    => $queryable,
            'show_ui'               => get_disp_boolean( $post_type['show_ui'] ),
            'show_in_nav_menus'     => get_disp_boolean( $post_type['show_in_nav_menus'] ),
            'has_archive'           => $has_archive,
            'show_in_menu'          => $show_in_menu,
            'delete_with_user'      => $delete_with_user,
            'show_in_rest'          => get_disp_boolean( $post_type['show_in_rest'] ),
            'rest_base'             => $rest_base,
            'rest_controller_class' => $rest_controller_class,
            'exclude_from_search'   => $exclude_from_search,
            'capability_type'       => $capability_type,
            'map_meta_cap'          => $post_type['map_meta_cap'],
            'hierarchical'          => get_disp_boolean( $post_type['hierarchical'] ),
            'rewrite'               => $rewrite,
            'menu_position'         => $menu_position,
            'menu_icon'             => $menu_icon,
            'query_var'             => $post_type['query_var'],
            'supports'              => $post_type['supports'],
            'taxonomies'            => $post_type['taxonomies'],
        ];

        if ( true === $yarpp ) {
            $args['yarpp_support'] = $yarpp;
        }

        /**
         * Filters the arguments used for a post type right before registering.
         *
         * @since 1.0.0
         * @since 1.3.0 Added original passed in values array
         *
         * @param array  $args      Array of arguments to use for registering post type.
         * @param string $value     Post type slug to be registered.
         * @param array  $post_type Original passed in values for post type.
         */
        $args = apply_filters( 'cpt_pre_register_post_type', $args, $post_type['name'], $post_type );

        return register_post_type( $post_type['name'], $args );
    }



    /**
     * Helper function to register the actual taxonomy.
     *
     * @since 1.0.0
     *
     * @internal
     *
     * @param array $taxonomy Taxonomy array to register. Optional.
     * @return null Result of register_taxonomy.
     */
    function register_single_taxonomy( $taxonomy = [] ) {

        $labels = [
            'name'          => $taxonomy['label'],
            'singular_name' => $taxonomy['singular_label'],
        ];

        $description = '';
        if ( ! empty( $taxonomy['description'] ) ) {
            $description = $taxonomy['description'];
        }

        $preserved        = $this->get_preserved_keys( 'taxonomies' );
        $preserved_labels = $this->get_preserved_labels();
        foreach ( $taxonomy['labels'] as $key => $label ) {

            if ( ! empty( $label ) ) {
                $labels[ $key ] = $label;
            } elseif ( empty( $label ) && in_array( $key, $preserved, true ) ) {
                $singular_or_plural = ( in_array( $key, array_keys( $preserved_labels['taxonomies']['plural'] ) ) ) ? 'plural' : 'singular';
                $label_plurality    = ( 'plural' === $singular_or_plural ) ? $taxonomy['label'] : $taxonomy['singular_label'];
                $labels[ $key ]     = sprintf( $preserved_labels['taxonomies'][ $singular_or_plural ][ $key ], $label_plurality );
            }
        }

        $rewrite = get_disp_boolean( $taxonomy['rewrite'] );
        if ( false !== get_disp_boolean( $taxonomy['rewrite'] ) ) {
            $rewrite               = [];
            $rewrite['slug']       = ! empty( $taxonomy['rewrite_slug'] ) ? $taxonomy['rewrite_slug'] : $taxonomy['name'];
            $rewrite['with_front'] = true;
            if ( isset( $taxonomy['rewrite_withfront'] ) ) {
                $rewrite['with_front'] = ( 'false' === disp_boolean( $taxonomy['rewrite_withfront'] ) ) ? false : true;
            }
            $rewrite['hierarchical'] = false;
            if ( isset( $taxonomy['rewrite_hierarchical'] ) ) {
                $rewrite['hierarchical'] = ( 'true' === disp_boolean( $taxonomy['rewrite_hierarchical'] ) ) ? true : false;
            }
        }

        if ( in_array( $taxonomy['query_var'], [ 'true', 'false', '0', '1' ], true ) ) {
            $taxonomy['query_var'] = get_disp_boolean( $taxonomy['query_var'] );
        }
        if ( true === $taxonomy['query_var'] && ! empty( $taxonomy['query_var_slug'] ) ) {
            $taxonomy['query_var'] = $taxonomy['query_var_slug'];
        }

        $public             = ( ! empty( $taxonomy['public'] ) && false === get_disp_boolean( $taxonomy['public'] ) ) ? false : true;
        $publicly_queryable = ( ! empty( $taxonomy['publicly_queryable'] ) && false === get_disp_boolean( $taxonomy['publicly_queryable'] ) ) ? false : true;
        if ( empty( $taxonomy['publicly_queryable'] ) ) {
            $publicly_queryable = $public;
        }

        $show_admin_column = ( ! empty( $taxonomy['show_admin_column'] ) && false !== get_disp_boolean( $taxonomy['show_admin_column'] ) ) ? true : false;

        $show_in_menu = ( ! empty( $taxonomy['show_in_menu'] ) && false !== get_disp_boolean( $taxonomy['show_in_menu'] ) ) ? true : false;

        if ( empty( $taxonomy['show_in_menu'] ) ) {
            $show_in_menu = get_disp_boolean( $taxonomy['show_ui'] );
        }

        $show_in_nav_menus = ( ! empty( $taxonomy['show_in_nav_menus'] ) && false !== get_disp_boolean( $taxonomy['show_in_nav_menus'] ) ) ? true : false;
        if ( empty( $taxonomy['show_in_nav_menus'] ) ) {
            $show_in_nav_menus = $public;
        }

        $show_in_rest = ( ! empty( $taxonomy['show_in_rest'] ) && false !== get_disp_boolean( $taxonomy['show_in_rest'] ) ) ? true : false;

        $show_in_quick_edit = ( ! empty( $taxonomy['show_in_quick_edit'] ) && false !== get_disp_boolean( $taxonomy['show_in_quick_edit'] ) ) ? true : false;

        $rest_base = null;
        if ( ! empty( $taxonomy['rest_base'] ) ) {
            $rest_base = $taxonomy['rest_base'];
        }

        $rest_controller_class = null;
        if ( ! empty( $post_type['rest_controller_class'] ) ) {
            $rest_controller_class = $post_type['rest_controller_class'];
        }

        $meta_box_cb = null;
        if ( ! empty( $taxonomy['meta_box_cb'] ) ) {
            $meta_box_cb = ( false !== get_disp_boolean( $taxonomy['meta_box_cb'] ) ) ? $taxonomy['meta_box_cb'] : false;
        }

        $args = [
            'labels'                => $labels,
            'label'                 => $taxonomy['label'],
            'description'           => $description,
            'public'                => $public,
            'publicly_queryable'    => $publicly_queryable,
            'hierarchical'          => get_disp_boolean( $taxonomy['hierarchical'] ),
            'show_ui'               => get_disp_boolean( $taxonomy['show_ui'] ),
            'show_in_menu'          => $show_in_menu,
            'show_in_nav_menus'     => $show_in_nav_menus,
            'query_var'             => $taxonomy['query_var'],
            'rewrite'               => $rewrite,
            'show_admin_column'     => $show_admin_column,
            'show_in_rest'          => $show_in_rest,
            'rest_base'             => $rest_base,
            'rest_controller_class' => $rest_controller_class,
            'show_in_quick_edit'    => $show_in_quick_edit,
            'meta_box_cb'           => $meta_box_cb,
        ];

        $object_type = ! empty( $taxonomy['object_types'] ) ? $taxonomy['object_types'] : '';

        /**
         * Filters the arguments used for a taxonomy right before registering.
         *
         * @since 1.0.0
         * @since 1.3.0 Added original passed in values array
         * @since 1.6.0 Added $obect_type variable to passed parameters.
         *
         * @param array  $args        Array of arguments to use for registering taxonomy.
         * @param string $value       Taxonomy slug to be registered.
         * @param array  $taxonomy    Original passed in values for taxonomy.
         * @param array  $object_type Array of chosen post types for the taxonomy.
         */
        $args = apply_filters( 'cpt_pre_register_taxonomy', $args, $taxonomy['name'], $taxonomy, $object_type );

        return register_taxonomy( $taxonomy['name'], $object_type, $args );
    }


    /**
     * Convert our old settings to the new options keys.
     *
     * These are left with standard get_option/update_option function calls for legacy and pending update purposes.
     *
     * @since 1.0.0
     *
     * @internal
     *
     * @return bool Whether or not options were successfully updated.
     */
    function convert_settings() {

        if ( wp_doing_ajax() ) {
            return;
        }

        $retval = '';

        if ( false === get_option( 'cpt_post_types' ) && ( $post_types = get_option( 'cpt_custom_post_types' ) ) ) {

            $new_post_types = [];
            foreach ( $post_types as $type ) {
                $new_post_types[ $type['name'] ]               = $type; // This one assigns the # indexes. Named arrays are our friend.
                $new_post_types[ $type['name'] ]['supports']   = ! empty( $type[0] ) ? $type[0] : []; // Especially for multidimensional arrays.
                $new_post_types[ $type['name'] ]['taxonomies'] = ! empty( $type[1] ) ? $type[1] : [];
                $new_post_types[ $type['name'] ]['labels']     = ! empty( $type[2] ) ? $type[2] : [];
                unset(
                    $new_post_types[ $type['name'] ][0],
                    $new_post_types[ $type['name'] ][1],
                    $new_post_types[ $type['name'] ][2]
                ); // Remove our previous indexed versions.
            }

            $retval = update_option( 'cpt_post_types', $new_post_types );
        }

        if ( false === get_option( 'cpt_taxonomies' ) && ( $taxonomies = get_option( 'cpt_custom_tax_types' ) ) ) {

            $new_taxonomies = [];
            foreach ( $taxonomies as $tax ) {
                $new_taxonomies[ $tax['name'] ]                 = $tax;    // Yep, still our friend.
                $new_taxonomies[ $tax['name'] ]['labels']       = $tax[0]; // Taxonomies are the only thing with.
                $new_taxonomies[ $tax['name'] ]['object_types'] = $tax[1]; // "tax" in the name that I like.
                unset(
                    $new_taxonomies[ $tax['name'] ][0],
                    $new_taxonomies[ $tax['name'] ][1]
                );
            }

            $retval = update_option( 'cpt_taxonomies', $new_taxonomies );
        }

        if ( ! empty( $retval ) ) {
            flush_rewrite_rules();
        }

        return $retval;
    }


    /**
     * Return array of keys needing preserved.
     *
     * @since 1.0.5
     *
     * @param string $type Type to return. Either 'post_types' or 'taxonomies'. Optional. Default empty string.
     * @return array Array of keys needing preservered for the requested type.
     */
    function get_preserved_keys( $type = '' ) {

        $preserved_labels = [
            'post_types' => [
                'add_new_item',
                'edit_item',
                'new_item',
                'view_item',
                'view_items',
                'all_items',
                'search_items',
                'not_found',
                'not_found_in_trash',
            ],
            'taxonomies' => [
                'search_items',
                'popular_items',
                'all_items',
                'parent_item',
                'parent_item_colon',
                'edit_item',
                'update_item',
                'add_new_item',
                'new_item_name',
                'separate_items_with_commas',
                'add_or_remove_items',
                'choose_from_most_used',
            ],
        ];
        return ! empty( $type ) ? $preserved_labels[ $type ] : [];
    }


    /**
     * Return label for the requested type and label key.
     *
     * @since 1.0.5
     *
     * @deprecated
     *
     * @param string $type Type to return. Either 'post_types' or 'taxonomies'. Optional. Default empty string.
     * @param string $key Requested label key. Optional. Default empty string.
     * @param string $plural Plural verbiage for the requested label and type. Optional. Default empty string.
     * @param string $singular Singular verbiage for the requested label and type. Optional. Default empty string.
     * @return string Internationalized default label.
     */
    function get_preserved_label( $type = '', $key = '', $plural = '', $singular = '' ) {

        $preserved_labels = [
            'post_types' => [
                'add_new_item'       => sprintf( __( 'Add new %s', CPT_LANG ), $singular ),
                'edit_item'          => sprintf( __( 'Edit %s', CPT_LANG ), $singular ),
                'new_item'           => sprintf( __( 'New %s', CPT_LANG ), $singular ),
                'view_item'          => sprintf( __( 'View %s', CPT_LANG ), $singular ),
                'view_items'         => sprintf( __( 'View %s', CPT_LANG ), $plural ),
                'all_items'          => sprintf( __( 'All %s', CPT_LANG ), $plural ),
                'search_items'       => sprintf( __( 'Search %s', CPT_LANG ), $plural ),
                'not_found'          => sprintf( __( 'No %s found.', CPT_LANG ), $plural ),
                'not_found_in_trash' => sprintf( __( 'No %s found in trash.', CPT_LANG ), $plural ),
            ],
            'taxonomies' => [
                'search_items'               => sprintf( __( 'Search %s', CPT_LANG ), $plural ),
                'popular_items'              => sprintf( __( 'Popular %s', CPT_LANG ), $plural ),
                'all_items'                  => sprintf( __( 'All %s', CPT_LANG ), $plural ),
                'parent_item'                => sprintf( __( 'Parent %s', CPT_LANG ), $singular ),
                'parent_item_colon'          => sprintf( __( 'Parent %s:', CPT_LANG ), $singular ),
                'edit_item'                  => sprintf( __( 'Edit %s', CPT_LANG ), $singular ),
                'update_item'                => sprintf( __( 'Update %s', CPT_LANG ), $singular ),
                'add_new_item'               => sprintf( __( 'Add new %s', CPT_LANG ), $singular ),
                'new_item_name'              => sprintf( __( 'New %s name', CPT_LANG ), $singular ),
                'separate_items_with_commas' => sprintf( __( 'Separate %s with commas', CPT_LANG ), $plural ),
                'add_or_remove_items'        => sprintf( __( 'Add or remove %s', CPT_LANG ), $plural ),
                'choose_from_most_used'      => sprintf( __( 'Choose from the most used %s', CPT_LANG ), $plural ),
            ],
        ];

        return $preserved_labels[ $type ][ $key ];
    }

    /**
     * Returns an array of translated labels, ready for use with sprintf().
     *
     * Replacement for get_preserved_label for the sake of performance.
     *
     * @since 1.6.0
     *
     * @return array
     */
    function get_preserved_labels() {
        return [
            'post_types' => [
                'singular' => [
                    'add_new_item' => __( 'Add new %s', CPT_LANG ),
                    'edit_item'    => __( 'Edit %s', CPT_LANG ),
                    'new_item'     => __( 'New %s', CPT_LANG ),
                    'view_item'    => __( 'View %s', CPT_LANG ),
                ],
                'plural' => [
                    'view_items'         => __( 'View %s', CPT_LANG ),
                    'all_items'          => __( 'All %s', CPT_LANG ),
                    'search_items'       => __( 'Search %s', CPT_LANG ),
                    'not_found'          => __( 'No %s found.', CPT_LANG ),
                    'not_found_in_trash' => __( 'No %s found in trash.', CPT_LANG ),
                ],
            ],
            'taxonomies' => [
                'singular' => [
                    'parent_item'       => __( 'Parent %s', CPT_LANG ),
                    'parent_item_colon' => __( 'Parent %s:', CPT_LANG ),
                    'edit_item'         => __( 'Edit %s', CPT_LANG ),
                    'update_item'       => __( 'Update %s', CPT_LANG ),
                    'add_new_item'      => __( 'Add new %s', CPT_LANG ),
                    'new_item_name'     => __( 'New %s name', CPT_LANG ),
                ],
                'plural' => [
                    'search_items'               => __( 'Search %s', CPT_LANG ),
                    'popular_items'              => __( 'Popular %s', CPT_LANG ),
                    'all_items'                  => __( 'All %s', CPT_LANG ),
                    'separate_items_with_commas' => __( 'Separate %s with commas', CPT_LANG ),
                    'add_or_remove_items'        => __( 'Add or remove %s', CPT_LANG ),
                    'choose_from_most_used'      => __( 'Choose from the most used %s', CPT_LANG ),
                ],
            ],
        ];
    }
}
