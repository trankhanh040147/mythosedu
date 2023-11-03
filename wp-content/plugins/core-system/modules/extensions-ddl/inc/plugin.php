<?php
namespace CoreSystem\Modules\ExtensionsDDL\Inc;

use Elementor;
use CoreSystem\Modules\ExtensionsDDL\Core\Module_Manager;
use CoreSystem\Modules\ExtensionsDDL\Inc\Controls\Groups\Icon;
use CoreSystem\Modules\ExtensionsDDL\Inc\Controls\Groups\Icon_Timeline;
use CoreSystem\Modules\ExtensionsDDL\Inc\Controls\Groups\Grid;
use CoreSystem\Modules\ExtensionsDDL\Core\Admin\Settings;

class Plugin {

	public static $instance;

	public $module_manager;

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function __construct() {

		$this->register_autoloader();

		add_action( 'elementor/init', [ $this, 'co_elementor_init' ], - 10 );
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_category' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );
		add_action( 'plugins_loaded', [ $this, '_plugins_loaded' ] );

        $this->_admin();

		$this->module_manager = new Module_Manager();
	}

	function co_elementor_init() {

	}

	public function _plugins_loaded() {


		if ( ! did_action( 'elementor/loaded' ) ) {
			/* TO DO */
			add_action( 'admin_notices', array( $this, 'core_co_pro_fail_load' ) );

			return;
		}
	}

	public function register_category( $elements ) {

		\Elementor\Plugin::instance()->elements_manager->add_category(
			ETSDDL_LANG,
			[
				'title' => 'Extension Drag & Drop Layout',
				'icon'  => 'font'
			],
			1
		);
	}

	public function _admin() {
		if(is_admin()){

		}
	}
	public function register_controls( Elementor\Controls_Manager $controls_manager ) {

		$controls_manager->add_group_control( 'co-icon', new Icon() );

		$controls_manager->add_group_control( 'co-icon-timeline', new Icon_Timeline() );

		$controls_manager->add_group_control( 'co-grid', new Grid() );

	}

	function co_disable_admin_notices() {
		global $wp_filter;
		if ( is_user_admin() ) {
			if ( isset( $wp_filter['user_admin_notices'] ) ) {
				unset( $wp_filter['user_admin_notices'] );
			}
		} elseif ( isset( $wp_filter['admin_notices'] ) ) {
			unset( $wp_filter['admin_notices'] );
		}
		if ( isset( $wp_filter['all_admin_notices'] ) ) {
			unset( $wp_filter['all_admin_notices'] );
		}
	}

	function enqueue_scripts() {

		wp_register_style( 'ets-co-timeline', ETSDDL_URL . '/assets/css/widgets/timeline'.ETSDLL_SCRIPT_SUFFIX.'.css' );

		wp_register_style( 'ets-co-table', ETSDDL_URL . '/assets/css/widgets/table'.ETSDLL_SCRIPT_SUFFIX.'.css' );
		wp_register_style( 'ets-co-tablesaw', ETSDDL_URL . '/assets/lib/tablesaw/tablesaw'.ETSDLL_SCRIPT_SUFFIX.'.css' );



		wp_register_script( 'ets-co-timeline', ETSDDL_URL . '/assets/js/widgets/timeline'.ETSDLL_SCRIPT_SUFFIX.'.js', array('jquery'), '1.0', true );

		wp_register_script( 'ets-co-frontend', ETSDDL_URL . '/assets/js/frontend'.ETSDLL_SCRIPT_SUFFIX.'.js', array('jquery'), '1.0', true );

		wp_register_script( 'ets-co-tablesaw', ETSDDL_URL . '/assets/lib/tablesaw/tablesaw.jquery'.ETSDLL_SCRIPT_SUFFIX.'.js', array('jquery'), '1.0', true );


	}

	function co_editor_enqueue_scripts() {

		wp_enqueue_style( 'co-icons', ETSDDL_URL . '/assets/lib/co-icons/style.css' );
	}

	private function register_autoloader() {
		spl_autoload_register( [ __CLASS__, 'autoload' ] );
	}

	function autoload( $class ) {

		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}


		if ( ! class_exists( $class ) ) {

			$filename = strtolower(
				preg_replace(
					[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$class
				)
			);

			$filename = ETSDDL_DIR . $filename . '.php';

			if ( is_readable( $filename ) ) {
				include( $filename );
			}
		}
	}
	public function core_co_pro_fail_load() {

		$plugin = 'elementor/elementor.php';

		if ( function_exists('_is_elementor_installed') && _is_elementor_installed() ) {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			$message = sprintf( __( '<b>Extension Drag & Drop Layout</b> is not working because you need to activate the <b>Drag & Drop Layout</b> plugin.', ETSDDL_LANG ), '<strong>', '</strong>' );

		} else {
			if ( ! current_user_can( 'install_plugins' ) ) {
				return;
			}
			$message = sprintf( __( '<b>Extension Drag & Drop Layout</b> is not working because you need to install the <b>Drag & Drop Layout</b> plugin.', ETSDDL_LANG ), '<strong>', '</strong>' );
		}

		$button = '';

		printf( '<div class="%1$s"><p>%2$s</p>%3$s</div>', 'notice notice-error', $message, $button );
	}
}

Plugin::instance();