<?php

namespace CoreSystem\Modules\ExtensionsDDL\Inc\Controls;

use Elementor\Base_Data_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Hover_Transition extends Base_Data_Control {

	private static $_hover_transition;

	public function get_type() {
		return 'EAE_HOVER_TRANSITION';
	}

	public static function get_transitions() {
		if ( is_null( self::$_hover_transition ) ) {
			self::$_hover_transition = [
				'2D Transitions'  => [
					'hvr-grow'                   => __( 'Grow', ETSDDL_LANG ),
					'hvr-shrink'                 => __( 'Shrink', ETSDDL_LANG ),
					'hvr-pulse'                  => __( 'Pulse', ETSDDL_LANG ),
					'hvr-pulse-grow'             => __( 'Pulse Grow', ETSDDL_LANG ),
					'hvr-pulse-shrink'           => __( 'Pulse Shrink', ETSDDL_LANG ),
					'hvr-push'                   => __( 'Push', ETSDDL_LANG ),
					'hvr-pop'                    => __( 'Pop', ETSDDL_LANG ),
					'hvr-bounce-in'              => __( 'Bounce In', ETSDDL_LANG ),
					'hvr-bounce-out'             => __( 'Bounce Out', ETSDDL_LANG ),
					'hvr-rotate'                 => __( 'Rotate', ETSDDL_LANG ),
					'hvr-grow-rotate'            => __( 'Icon Shrink', ETSDDL_LANG ),
					'hvr-float'                  => __( 'Float', ETSDDL_LANG ),
					'hvr-sink'                   => __( 'Sink', ETSDDL_LANG ),
					'hvr-bob'                    => __( 'Bob', ETSDDL_LANG ),
					'hvr-hang'                   => __( 'Hang', ETSDDL_LANG ),
					'hvr-skew'                   => __( 'Skew', ETSDDL_LANG ),
					'hvr-skew-forward'           => __( 'Skew Forward', ETSDDL_LANG ),
					'hvr-skew-backward'          => __( 'Skew Backward', ETSDDL_LANG ),
					'hvr-wobble-horizontal'      => __( 'Wobble Horizontal', ETSDDL_LANG ),
					'hvr-wobble-vertical'        => __( 'Wobble Vertical', ETSDDL_LANG ),
					'hvr-wobble-to-bottom-right' => __( 'Wobble To Bottom Right', ETSDDL_LANG ),
					'hvr-wobble-to-top-right'    => __( 'Wobble To Top Right', ETSDDL_LANG ),
					'hvr-wobble-top'             => __( 'Wobble Top', ETSDDL_LANG ),
					'hvr-wobble-bottom'          => __( 'Wobble Bottom', ETSDDL_LANG ),
					'hvr-wobble-skew'            => __( 'Wobble Skew', ETSDDL_LANG ),
					'hvr-buzz'                   => __( 'Buzz', ETSDDL_LANG ),
					'hvr-buzz-out'               => __( 'Buzz Out', ETSDDL_LANG ),
					'hvr-forward'                => __( 'Forward', ETSDDL_LANG ),
					'hvr-backward'               => __( 'Backward', ETSDDL_LANG ),
				],
				'Background'      => [
					'hvr-fade'                   => __( 'Fade', ETSDDL_LANG ),
					'hvr-back-pulse'             => __( 'Back Pulse', ETSDDL_LANG ),
					'hvr-sweep-to-right'         => __( 'Sweep To Right', ETSDDL_LANG ),
					'hvr-sweep-to-left'          => __( 'Sweep To Left', ETSDDL_LANG ),
					'hvr-sweep-to-bottom'        => __( 'Sweep To Bottom', ETSDDL_LANG ),
					'hvr-sweep-to-top'           => __( 'Sweep To Top', ETSDDL_LANG ),
					'hvr-bounce-to-right'        => __( 'Bounce To Right', ETSDDL_LANG ),
					'hvr-bounce-to-left'         => __( 'Bounce To Left', ETSDDL_LANG ),
					'hvr-bounce-to-bottom'       => __( 'Bounce To Bottom', ETSDDL_LANG ),
					'hvr-bounce-to-top'          => __( 'Bounce To Top', ETSDDL_LANG ),
					'hvr-radial-out'             => __( 'Radial Out', ETSDDL_LANG ),
					'hvr-radial-in'              => __( 'Radial In', ETSDDL_LANG ),
					'hvr-rectangle-in'           => __( 'Rectangle In', ETSDDL_LANG ),
					'hvr-rectangle-out'          => __( 'Rectangle Out', ETSDDL_LANG ),
					'hvr-shutter-in-horizontal'  => __( 'Shutter In Horizontal', ETSDDL_LANG ),
					'hvr-shutter-out-horizontal' => __( 'Shutter Out Horizontal', ETSDDL_LANG ),
					'hvr-shutter-in-vertical'    => __( 'Shutter In Vertical', ETSDDL_LANG ),
					'hvr-shutter-out-vertical'   => __( 'Shutter Out Vertical', ETSDDL_LANG ),
				],
				'Icon'            => [
					'hvr-icon-back'              => __( 'Icon Back', ETSDDL_LANG ),
					'hvr-icon-forward'           => __( 'Icon Forward', ETSDDL_LANG ),
					'hvr-icon-down'              => __( 'Icon Down', ETSDDL_LANG ),
					'hvr-icon-up'                => __( 'Icon Up', ETSDDL_LANG ),
					'hvr-icon-spin'              => __( 'Icon Spin', ETSDDL_LANG ),
					'hvr-icon-drop'              => __( 'Icon Drop', ETSDDL_LANG ),
					'hvr-icon-fade'              => __( 'Icon Fade', ETSDDL_LANG ),
					'hvr-icon-float-away'        => __( 'Icon Float Away', ETSDDL_LANG ),
					'hvr-icon-sink-away'         => __( 'Icon Sink Away', ETSDDL_LANG ),
					'hvr-icon-grow'              => __( 'Icon Grow', ETSDDL_LANG ),
					'hvr-icon-shrink'            => __( 'Icon Shrink', ETSDDL_LANG ),
					'hvr-icon-pulse'             => __( 'Icon Pulse', ETSDDL_LANG ),
					'hvr-icon-pulse-grow'        => __( 'Icon Pulse Grow', ETSDDL_LANG ),
					'hvr-icon-pulse-shrink'      => __( 'Icon Pulse Shrink', ETSDDL_LANG ),
					'hvr-icon-push'              => __( 'Icon Push', ETSDDL_LANG ),
					'hvr-icon-pop'               => __( 'Icon Pop', ETSDDL_LANG ),
					'hvr-icon-bounce'            => __( 'Icon Bounce', ETSDDL_LANG ),
					'hvr-icon-rotate'            => __( 'Icon Rotate', ETSDDL_LANG ),
					'hvr-icon-grow-rotate'       => __( 'Icon Grow Rotate', ETSDDL_LANG ),
					'hvr-icon-float'             => __( 'Icon Float', ETSDDL_LANG ),
					'hvr-icon-sink'              => __( 'Icon Sink', ETSDDL_LANG ),
					'hvr-icon-bob'               => __( 'Icon Bob', ETSDDL_LANG ),
					'hvr-icon-hang'              => __( 'Icon Hang', ETSDDL_LANG ),
					'hvr-icon-wobble-horizontal' => __( 'Icon Wobble Horizontal', ETSDDL_LANG ),
					'hvr-icon-wobble-vertical'   => __( 'Icon Wobble Vertical', ETSDDL_LANG ),
					'hvr-icon-buzz'              => __( 'Icon Buzz', ETSDDL_LANG ),
					'hvr-icon-buzz-out'          => __( 'Icon Buzz Out', ETSDDL_LANG ),
				],
				'Border'          => [
					'hvr-border-fade'           => __( 'Border Fade', ETSDDL_LANG ),
					'hvr-hollow'                => __( 'Hollow', ETSDDL_LANG ),
					'hvr-trim'                  => __( 'Trim', ETSDDL_LANG ),
					'hvr-ripple-out'            => __( 'Ripple Out', ETSDDL_LANG ),
					'hvr-ripple-in'             => __( 'Ripple In', ETSDDL_LANG ),
					'hvr-outline-out'           => __( 'Outline Out', ETSDDL_LANG ),
					'hvr-outline-in'            => __( 'Outline In', ETSDDL_LANG ),
					'hvr-round-corners'         => __( 'Round Corners', ETSDDL_LANG ),
					'hvr-underline-from-left'   => __( 'Underline From Left', ETSDDL_LANG ),
					'hvr-underline-from-center' => __( 'Underline From Center', ETSDDL_LANG ),
					'hvr-underline-from-right'  => __( 'Underline From Right', ETSDDL_LANG ),
					'hvr-reveal'                => __( 'Reveal', ETSDDL_LANG ),
					'hvr-underline-reveal'      => __( 'Underline Reveal', ETSDDL_LANG ),
					'hvr-overline-reveal'       => __( 'Overline Reveal', ETSDDL_LANG ),
					'hvr-overline-from-left'    => __( 'Overline From Left', ETSDDL_LANG ),
					'hvr-overline-from-center'  => __( 'Overline From Center', ETSDDL_LANG ),
					'hvr-overline-from-right'   => __( 'Overline From Right', ETSDDL_LANG ),
				],
				'Shadow And Glow' => [
					'hvr-shadow'            => __( 'Shadow', ETSDDL_LANG ),
					'hvr-grow-shadow'       => __( 'Grow Shadow', ETSDDL_LANG ),
					'hvr-float-shadow'      => __( 'Trim', ETSDDL_LANG ),
					'hvr-ripple-out'        => __( 'Float Shadow', ETSDDL_LANG ),
					'hvr-glow'              => __( 'Glow', ETSDDL_LANG ),
					'hvr-shadow-radial'     => __( 'Shadow Radial', ETSDDL_LANG ),
					'hvr-box-shadow-outset' => __( 'Box Shadow Outset', ETSDDL_LANG ),
					'hvr-box-shadow-inset'  => __( 'Box Shadow Inset', ETSDDL_LANG ),
				]

			];
		}

		return self::$_hover_transition;
	}

	public function enqueue() {

		wp_register_script( 'co-control', ETSDDL_URL . 'assets/js/editor.js', [ 'jquery' ], '1.0.0' );
		wp_enqueue_script( 'co-control' );
	}


	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
        <div class="elementor-control-field">
            <label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <select id="<?php echo $control_uid; ?>" data-setting="{{ data.name }}">
                    <option value=""><?php echo __( 'None', ETSDDL_LANG ); ?></option>
					<?php foreach ( self::get_transitions() as $transitions_group_name => $transitions_group ) : ?>
                        <optgroup label="<?php echo $transitions_group_name; ?>">
							<?php foreach ( $transitions_group as $transition_name => $transition_title ) : ?>
                                <option value="<?php echo $transition_name; ?>"><?php echo $transition_title; ?></option>
							<?php endforeach; ?>
                        </optgroup>
					<?php endforeach; ?>
                </select>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
		<?php
	}
}
