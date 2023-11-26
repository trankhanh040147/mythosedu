<?php
/**
 * Integrate templates to certificate addon
 *
 * @package  Tutor\Certificate\Builder
 * @author   Themeum <support@themeum.com>
 * @license  GPLv2 or later
 * @link     https://www.themeum.com/product/tutor-lms/
 * @since    1.0.0
 */

namespace Tutor\Certificate\Builder;
use \Tutor\Certificate\Builder\Utils;

class ProIntegration {
	function __construct() {
		add_filter('tutor_certificate_templates', array($this, 'register_certificate'));
		add_filter( 'tutor_certificate_builder_url', array($this, 'certificate_builder_url'), 10, 2 );

		/**
		 * Certificate builder support for frontend dashboard
		 * @since v2.0.0
		 */ 
		add_filter('tutor_dashboard/instructor_nav_items', array($this, 'frontend_dashboard_nav_items'));
		add_filter('load_dashboard_template_part_from_other_location' , array( $this, 'tutor_certificate_frontend' ) ) ;
		add_filter( 'tutor/options/extend/attr', array($this, 'setting_page_content'), 11 );
	}

	public function register_certificate($templates) {
		$builder_templates = array();
		$certificates = (new Utils)->get_certificates();
		
		foreach($certificates as $certificate) {
			$builder_templates['tutor_cb_' . $certificate->ID] = array(
				'name' => $certificate->post_title, 
				'orientation' => get_post_meta( $certificate->ID, 'tutor_certificate_dimension', true ),
				'path' => '',
				'url' => '',
				'preview_src' => $certificate->thumbnail_url,
				'background_src' => '',
				'author_id' => $certificate->post_author
			);
		}

		return array_merge($builder_templates, $templates);
	}

	public function certificate_builder_url($id=null, $additional=array()) {
		return Helper::certificate_builder_url($id, $additional);
	}

	public function frontend_dashboard_nav_items($nav_items) {
		$nav_items['certificate-builder'] = array(
			'title' => __('Certificate', 'tutor-pro') ,
			'auth_cap' => tutor()->instructor_role
		);
		return $nav_items;
	}

	public function tutor_certificate_frontend($template) {
		global $wp_query;
		$query_vars = $wp_query->query_vars;
		if ( $query_vars['tutor_dashboard_page'] && $query_vars['tutor_dashboard_page'] === 'certificate-builder' ) {
			
			$new_template = TUTOR_CB_PLUGIN_PATH . 'templates/certificate-list-table.php';
			if ( file_exists($new_template) ) {
				return apply_filters( 'tutor_frontend_certificate_template', $new_template ); 
			}
		}
		return $template; 
	}

	public function setting_page_content($attr) {
		if(!isset($attr['tutor_certificate'])) {
			return $attr;
		}

		array_unshift($attr['tutor_certificate']['blocks'], array(
			'label'	=> null,
			'slug'  => 'certificate_add',
			'block_type' => 'custom',
			'template_path' => TUTOR_CB_PLUGIN_PATH . 'templates/add-certificate-area.php'
		), 
		array(
			'label'	=> null,
			'slug'  => 'certificate_list',
			'block_type' => 'custom',
			'template_path' => TUTOR_CB_PLUGIN_PATH . 'templates/certificate-list-table.php'
		));

		return $attr;
	}
}