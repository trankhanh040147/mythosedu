<?php

namespace CoreSystem\Modules\ExtensionsDDL\Inc\Controls\Groups;

use Elementor\Group_Control_Base;
use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Icon_Timeline extends Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'co-icon-timeline';
	}

	protected function init_fields() {
		$controls = [];


		$controls['icon_type'] = [
			'type'        => Controls_Manager::CHOOSE,
			'label'       => __( 'Type', ETSDDL_LANG ),
			'default'     => 'icon',
			'options'     => [
				'icon'  => [
					'title' => __( 'Fontawesome Icon', ETSDDL_LANG ),
					'icon'  => 'fa fa-font-awesome',
				],
				'image' => [
					'title' => __( 'Custom Icons', ETSDDL_LANG ),
					'icon'  => 'fa fa-image',
				],
				'text'  => [
					'title' => __( 'Text', ETSDDL_LANG ),
					'icon'  => 'fa fa-font',
				],
			],
			'label_block' => false,
			'toggle'      => false,
			'condition'   => [
				'co_icon!' => ''
			]
		];


		$controls['icon'] = [
			'label'     => __( 'Icon', ETSDDL_LANG ),
			'type'      => Controls_Manager::ICON,
			'default'   => 'fa fa-star',
			'condition' => [
				'co_icon!' => '',
				'icon_type'  => 'icon'
			],
		];

		$controls['image'] = [
			'label'       => __( 'Custom Icon', ETSDDL_LANG ),
			'type'        => Controls_Manager::MEDIA,
			'label_block' => false,
			'condition'   => [
				'co_icon!' => '',
				'icon_type'  => 'image'
			],
		];

		$controls['text'] = [
			'label'       => __( 'Text', ETSDDL_LANG ),
			'type'        => Controls_Manager::TEXT,
			'label_block' => false,
			'condition'   => [
				'co_icon!' => '',
				'icon_type'  => 'text'
			],
		];

		/*$controls['view'] = [
			'label'     => __( 'View', ETSDDL_LANG ),
			'type'      => Controls_Manager::SELECT,
			'options'   => [
				//'default' => __( 'Default', ETSDDL_LANG ),
				'stacked' => __( 'Stacked', ETSDDL_LANG ),
				//'framed'  => __( 'Framed', ETSDDL_LANG ),
			],
			'default'   => 'stacked',
			'condition' => [
				'co_icon!' => '',
				'icon!'      => ''
			],
		];*/

		$controls['shape'] = [
			'label'     => __( 'Shape', ETSDDL_LANG ),
			'type'      => Controls_Manager::SELECT,
			'options'   => [
				'circle' => __( 'Circle', ETSDDL_LANG ),
				'square' => __( 'Square', ETSDDL_LANG ),
			],
			'default'   => 'circle',
			'condition' => [
				'co_icon!' => '',
				'icon!'      => ''
			],
		];

		return $controls;
	}

	protected function get_default_options() {
		return [
			'popover' => [
				'starter_title' => _x( 'Icon', ETSDDL_LANG ),
				'starter_name'  => 'co_icon',
				'starter_value' => 'yes',
			]
		];
	}
}
