<?php
namespace CoreSystem\Modules\ExtensionsDDL\Core;

use CoreSystem\Modules\ExtensionsDDL\Inc\Helper;

class Module_Manager {
	protected $modules = [];
	public function __construct() {
		$this->modules = Helper::get_modules();

		#$this->modules = apply_filters('core_co_active_modules', $this->modules);
		// Todo:: apply filter for modules that depends on third party plugins

		foreach ( $this->modules as $key => $module_name ) {
			if($module_name['enabled'] == 'true' || trim($module_name['enabled']) === '' || $module_name['enabled'] == null){
				$class_name = str_replace( '-', ' ', $key );
				//$class_name = $module_name['Name'];
				$class_name = str_replace( ' ', '', ucwords( $class_name ) );
				$class_name = 'CoreSystem' . '\\Modules\\ExtensionsDDL\\Modules\\' . $class_name . '\Module';

				$this->modules[ $module_name['name'] ] = $class_name::instance();
			}

		}

	}
}