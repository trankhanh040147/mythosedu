<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Core_System
 * @subpackage Core_System/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Core_System
 * @subpackage Core_System/admin
 * @author     Richard <nguyenkha252@gmail.com>
 */

namespace CoreSystem\Admin;

use CoreSystem\Helpers\BFDB;

class Core_System_Admin {

    static $new_site;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private static $parent_slug = 'co_main_menu';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		#$this->update_sites();
        $this->init_hooks();
	}

	function init_hooks(){
	    add_action('core_system/add_submenu_page', [$this, 'add_submenu_page'], 1, 2);
        add_action( 'admin_menu', [$this, 'admin_menu'] );
    }

    public function admin_menu(){
        $capability  = apply_filters( 'co_required_capabilities', 'manage_options' );
        add_menu_page( __( 'CoreSystem', CORES_LANG_DOMAIN ), __( 'CoreSystem', CORES_LANG_DOMAIN ), $capability, self::$parent_slug, '' );

        do_action('core_system/add_submenu_page', self::$parent_slug, $capability);

        remove_submenu_page(self::$parent_slug, self::$parent_slug);
    }

    public function add_submenu_page($parent_slug, $capability){
        add_submenu_page( $parent_slug, __('Settings'), __('Settings'), $capability, 'co-settings', [$this, 'menu_settings'] );
    }

    function menu_settings(){
        # @TODO
    }

    function update_database_at_main_site() {
        $blogs = get_sites();
        $current_blog_id = get_current_blog_id();
        if ( is_main_site($current_blog_id) ) {
            foreach ( $blogs as $blog ) {
                if ($current_blog_id !== $blog->id) {
                    $res = self::update_database($blog->id);
                }
            }
        }
        return $res;
    }

    function update_sites(){
        if ( is_main_site() ) {
            add_action('admin_menu', [$this, 'create_menu']);
        }
    }

    function create_menu() {
        add_menu_page('DB Updating', 'DB Updating', 'manage_options', __FILE__, [$this, 'db_updating_page'] , CORES_URL . '/admin/assets/images/database.jpg');
    }

    function db_updating_page() {
        if ( !empty($_POST["submit"]) ) {
            $res = $this->update_database_at_main_site();
        }
        ?>
        <h1><?php _e('Cập nhật database',CORES_LANG_DOMAIN); ?></h1>
        <?php
        if ( !empty($res) ) {
            ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php _e('Cập nhật thành công',CORES_LANG_DOMAIN);  ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
        }
        ?>
        <form method="post" action="">
            <input type="submit" name="submit" value="<?php _e('Cập nhật',CORES_LANG_DOMAIN); ?>" class="btn btn-primary"/>
        </form>
        <?php
    }

    static function update_database($blog_id) {
        $db_manager = new BFDB($blog_id);

        $db_manager->start_transaction();

        $prefix =  $db_manager->get_prefix();

        switch_to_blog($blog_id);

        /**
         * Update capabilities by role
         *
         */

        restore_current_blog();

        $db_manager->stop_transaction();

        return !empty( $db_manager->get_errors() ) ? false : true;
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Core_System_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Core_System_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/core-system-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Core_System_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Core_System_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/core-system-admin.js', array( 'jquery' ), $this->version, false );

	}


    /**
     * Filters list of allowed mime types and file extensions.
     *
     * @since 2.0.0
     *
     * @param array            $t    Mime types keyed by the file extension regex corresponding to
     *                               those types. 'swf' and 'exe' removed from full list. 'htm|html' also
     *                               removed depending on '$user' capabilities.
     * @param int|\WP_User|null $user User ID, User object or null if not provided (indicates current user).
     */
	public function upload_mimes($t, $user){
	    $file_types = [
            'svg' => 'image/svg+xml'
        ];
        return array_merge($t,  $file_types);
    }
}
