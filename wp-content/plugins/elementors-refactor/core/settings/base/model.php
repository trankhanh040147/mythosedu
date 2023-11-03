<?php
namespace Elementor\Core\Settings\Base;

use Elementor\Controls_Stack;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Drag & Drop Layout settings base model.
 *
 * Drag & Drop Layout settings base model handler class is responsible for registering
 * and managing Drag & Drop Layout settings base models.
 *
 * @since 1.6.0
 * @abstract
 */
abstract class Model extends Controls_Stack {

	/**
	 * Get panel page settings.
	 *
	 * Retrieve the page setting for the current panel.
	 *
	 * @since 1.6.0
	 * @access public
	 * @abstract
	 */
	abstract public function get_panel_page_settings();
}
