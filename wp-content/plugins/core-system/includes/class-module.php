<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 4/1/20
 * Time: 5:10 PM
 */

namespace CoreSystem\Includes;

Class Module{
    public static $instance = null;

    private $modules = [];


    function __construct()
    {
        $this->set_modules();
        $this->register_autoloader();
    }

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set_modules(){
        $this->add_module(['CustomPostType' => __('Custom Post Type', CORES_LANG_DOMAIN)]);
        $this->add_module(['ExtensionsDdl' => __('Extension DDL', CORES_LANG_DOMAIN)]);
    }

    function add_module($module){
        if( is_array($module) && !empty($module) ) {
            $this->modules = array_merge($module, $this->modules);
        }
    }

    private function register_autoloader() {
        foreach ($this->modules as $module => $title){
            $folder = strtolower(
                preg_replace(
                    [ '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
                    [ '$1-$2', '-', DIRECTORY_SEPARATOR ],
                    $module
                )
            );
            $filename = CORES_MODULE_DIR . '/' . $folder . '/module.php';
            if ( is_readable( $filename )) {
                $class_name = "\CoreSystem\Modules\\$module\\Module";
                if( class_exists($class_name) ) {
                    $class_name::instance();
                }
            }
        }
    }

    public static function get_url_module($module = ''){
        return CORES_URL . 'modules/' . $module;
    }

    function load_modules(){

    }
}