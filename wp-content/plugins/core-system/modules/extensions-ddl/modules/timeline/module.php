<?php

namespace CoreSystem\Modules\ExtensionsDDL\Modules\Timeline;

use CoreSystem\Modules\ExtensionsDDL\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'Timeline',
		];
	}

	public function get_name() {
		return 'co-timeline';
	}

}