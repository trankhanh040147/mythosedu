<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 11/28/19
 * Time: 10:08 AM
 */

namespace CoreSystem;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


class Autoloader {

    /**
     * Classes map.
     *
     * @since 1.6.0
     * @access private
     * @static
     *
     * @var array Classes
     */
    private static $classes_map;

    /**
     * Run autoloader.
     *
     * Register a function as `__autoload()` implementation.
     *
     * @since 1.6.0
     * @access public
     * @static
     */
    public static function run() {
        spl_autoload_register( [ __CLASS__, 'autoload' ] );
    }

    public static function get_classes_map() {
        if ( ! self::$classes_map ) {
            self::init_classes_map();
        }

        return self::$classes_map;
    }

    private static function init_classes_map() {
        self::$classes_map = [
            'Includes\Cores_AJAX' => 'includes/class-ajax.php',
        ];

    }

    /**
     * Load class.
     *
     * For a given class name, require the class file.
     *
     * @since 1.6.0
     * @access private
     * @static
     *
     * @param string $class_name Class name.
     */
    private static function load_class( $class_name ) {
        $classes_map = self::get_classes_map();

        if ( isset( $classes_map[ $class_name ] ) ) {
            $filename = CORES_DIR . '/' . $classes_map[ $class_name ];
            if( !file_exists($filename)  && file_exists($classes_map[ $class_name ])){
                $filename = $classes_map[ $class_name ];
            }
        } else {
            $filename = strtolower(
                preg_replace(
                    [ '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
                    [ '$1-$2', '-', DIRECTORY_SEPARATOR ],
                    $class_name
                )
            );

            $filename = CORES_DIR . '/' . $filename . '.php';
        }
        if ( is_readable( $filename )) {
            require $filename;
        }
    }

    /**
     * Autoload.
     *
     * For a given class, check if it exist and load it.
     *
     * @since 1.6.0
     * @access private
     * @static
     *
     * @param string $class Class name.
     */
    private static function autoload( $class ) {
        if ( 0 !== strpos( $class, __NAMESPACE__ . '\\' ) ) {
            return;
        }

        $relative_class_name = preg_replace( '/^' . __NAMESPACE__ . '\\\/', '', $class );


        $final_class_name = __NAMESPACE__ . '\\' . $relative_class_name;

        if ( ! class_exists( $final_class_name ) ) {
            self::load_class( $relative_class_name );
        }


    }
}