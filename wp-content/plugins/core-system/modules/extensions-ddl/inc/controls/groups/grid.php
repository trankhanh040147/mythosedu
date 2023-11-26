<?php

namespace CoreSystem\Modules\ExtensionsDDL\Inc\Controls\Groups;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

class Grid extends Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'co-grid';
	}

	protected function init_fields() {

		$controls = [];

		$controls['columns'] = [

			'label'      => __( 'Columns', ETSDDL_LANG ),
			'type'       => Controls_Manager::SELECT,
			'options'    => [
				'1' => __( '1', ETSDDL_LANG ),
				'2' => __( '2', ETSDDL_LANG ),
				'3' => __( '3', ETSDDL_LANG ),
				'4' => __( '4', ETSDDL_LANG ),
				'5' => __( '5', ETSDDL_LANG ),
				'6' => __( '6', ETSDDL_LANG ),
			],
			'default'    => '3',
			'responsive' => true,
			'selectors' => [
				'{{WRAPPER}} .bepl-grid-container' => 'grid-template-columns: repeat({{VALUE}}, 1fr)',
			]
		];

		$controls['col-gap'] = [
			'label'     => __('Column Gap', ETSDDL_LANG),
			'type'      => Controls_Manager::SLIDER,
			'default' => [
				'size' => 30,
			],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'responsive' => true,
			'selectors' => [
				'{{WRAPPER}} .bepl-grid-container' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
			],
		];

		$controls['row-gap'] = [
			'label'     => __('Row Gap', ETSDDL_LANG),
			'type'      => Controls_Manager::SLIDER,
			'default' => [
				'size' => 30,
			],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'responsive' => true,
			'selectors' => [
				'{{WRAPPER}} .bepl-grid-container' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
			],
		];



		return $controls;
	}

	protected function get_default_options() {
		return [
			'popover' => false,
		];
	}
}

