<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Drag & Drop Layout text shadow control.
 *
 * A base control for creating text shadows control. Displays input fields for
 * horizontal shadow, vertical shadow, shadow blur and shadow color.
 *
 * @since 1.6.0
 */
class Control_Text_Shadow extends Control_Base_Multiple {

	/**
	 * Get text shadow control type.
	 *
	 * Retrieve the control type, in this case `text_shadow`.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'text_shadow';
	}

	/**
	 * Get text shadow control default values.
	 *
	 * Retrieve the default value of the text shadow control. Used to return the
	 * default values while initializing the text shadow control.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @return array Control default value.
	 */
	public function get_default_value() {
		return [
			'horizontal' => 0,
			'vertical' => 0,
			'blur' => 10,
			'color' => 'rgba(0,0,0,0.3)',
		];
	}

	/**
	 * Get text shadow control sliders.
	 *
	 * Retrieve the sliders of the text shadow control. Sliders are used while
	 * rendering the control output in the editor.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @return array Control sliders.
	 */
	public function get_sliders() {
		return [
			'blur' => [
				'label' => __( 'Blur', 'elementor' ),
				'min' => 0,
				'max' => 100,
			],
			'horizontal' => [
				'label' => __( 'Horizontal', 'elementor' ),
				'min' => -100,
				'max' => 100,
			],
			'vertical' => [
				'label' => __( 'Vertical', 'elementor' ),
				'min' => -100,
				'max' => 100,
			],
		];
	}

	/**
	 * Render text shadow control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.6.0
	 * @access public
	 */
	public function content_template() {
		?>
		<div class="co-shadow-box">
			<div class="co-control-field co-color-picker-wrapper">
				<label class="co-control-title"><?php echo __( 'Color', 'elementor' ); ?></label>
				<div class="co-control-input-wrapper co-control-unit-1">
					<div class="co-color-picker-placeholder"></div>
				</div>
			</div>
			<?php
			foreach ( $this->get_sliders() as $slider_name => $slider ) :
				$control_uid = $this->get_control_uid( $slider_name );
				?>
				<div class="co-shadow-slider co-control-type-slider">
					<label for="<?php echo esc_attr( $control_uid ); ?>" class="co-control-title"><?php echo $slider['label']; ?></label>
					<div class="co-control-input-wrapper">
						<div class="co-slider" data-input="<?php echo esc_attr( $slider_name ); ?>"></div>
						<div class="co-slider-input co-control-unit-2">
							<input id="<?php echo esc_attr( $control_uid ); ?>" type="number" min="<?php echo esc_attr( $slider['min'] ); ?>" max="<?php echo esc_attr( $slider['max'] ); ?>" data-setting="<?php echo esc_attr( $slider_name ); ?>"/>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
