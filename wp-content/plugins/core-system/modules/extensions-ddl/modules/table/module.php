<?php

namespace CoreSystem\Modules\ExtensionsDDL\Modules\Table;

use CoreSystem\Modules\ExtensionsDDL\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'co-table';
	}

	public function get_widgets() {
		return [
			'Table',
		];
	}
}
