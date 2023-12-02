<?php 
namespace Tutor\Certificate\Builder;

use \Tutor\Certificate\Builder\Plugin;
use \Tutor\Certificate\Builder\Editor;

class Init {
	function __construct() {
		spl_autoload_register(array($this, 'loader'));
		add_action( 'plugins_loaded', array($this, 'load_certificate_builder') );
	}

	private function loader($className) {
		if(strpos($className, 'Tutor\\Certificate\\Builder\\')===0){
			$path = str_replace('Tutor\\Certificate\\Builder\\', '', $className);
			$path = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $path) . '.php';
			
			if(file_exists($path)) {
				require_once $path;
			} 
		}
	}

	public function load_certificate_builder() {

		if(
			!function_exists('tutor_utils') || 
			!function_exists('TUTOR_CERT') ||
			!method_exists(tutor_utils(), 'is_addon_enabled') ||
			!tutor_utils()->is_addon_enabled(TUTOR_CERT()->basename)
			) {
			return;
		}
		
		(new Plugin)->run();
		new ProIntegration();
	}
}