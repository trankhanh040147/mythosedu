<?php

namespace CoreSystem\Modules\ExtensionsDDL\Base;

use Elementor\Widget_Base as Widget;

abstract class Widget_Base extends Widget{

	public function get_categories() {
		return [ 'core-ets' ];
	}
}