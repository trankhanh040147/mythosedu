<?php
namespace Elementor;

use Elementor\Core\Files\Assets\Svg\Svg_Handler;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Drag & Drop Layout Icons control.
 *
 * A base control for creating a Icons chooser control.
 * Used to select an Icon.
 *
 * Usage: @see #
 *
 * @since 2.6.0
 */
class Control_Icons extends Control_Base_Multiple {

	/**
	 * Get media control type.
	 *
	 * Retrieve the control type, in this case `media`.
	 *
	 * @access public
	 * @since 2.6.0
	 * @return string Control type.
	 */
	public function get_type() {
		return 'icons';
	}

	/**
	 * Get Icons control default values.
	 *
	 * Retrieve the default value of the Icons control. Used to return the default
	 * values while initializing the Icons control.
	 *
	 * @access public
	 * @since 2.6.0
	 * @return array Control default value.
	 */
	public function get_default_value() {
		return [
			'value'   => '',
			'library' => '',
		];
	}

	/**
	 * Render Icons control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 2.6.0
	 * @access public
	 */
	public function content_template() {
		?>
		<# if ( 'inline' === data.skin ) { #>
			<?php $this->render_inline_skin(); ?>
		<# } else { #>
			<?php $this->render_media_skin(); ?>
		<# } #>
		<?php
	}

	public function render_media_skin() {
		?>
		<div class="co-control-field co-control-media">
			<label class="co-control-title">{{{ data.label }}}</label>
			<div class="co-control-input-wrapper co-aspect-ratio-219">
				<div class="co-control-media__content co-control-tag-area co-control-preview-area co-fit-aspect-ratio">
					<div class="co-control-media-upload-button co-fit-aspect-ratio">
						<i class="eicon-plus-circle" aria-hidden="true"></i>
					</div>
					<div class="co-control-media-area co-fit-aspect-ratio">
						<div class="co-control-media__remove" title="<?php echo __( 'Remove', 'elementor' ); ?>">
							<i class="eicon-trash"></i>
						</div>
						<div class="co-control-media__preview co-fit-aspect-ratio"></div>
					</div>
					<div class="co-control-media__tools co-control-dynamic-switcher-wrapper">
						<div class="co-control-icon-picker co-control-media__tool"><?php echo __( 'Icon Library', 'elementor' ); ?></div>
						<div class="co-control-svg-uploader co-control-media__tool"><?php echo __( 'Upload SVG', 'elementor' ); ?></div>
					</div>
				</div>
			</div>
			<# if ( data.description ) { #>
			<div class="co-control-field-description">{{{ data.description }}}</div>
			<# } #>
			<input type="hidden" data-setting="{{ data.name }}"/>
		</div>
		<?php
	}

	public function render_inline_skin() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="co-control-field co-control-inline-icon">
			<label class="co-control-title">{{{ data.label }}}</label>
			<div class="co-control-input-wrapper">
				<div class="co-choices">
					<input id="<?php echo $control_uid; ?>-none" type="radio" value="none">
					<label class="co-choices-label co-control-unit-1 tooltip-target co-control-icons--inline__none" for="<?php echo $control_uid; ?>-none" data-tooltip="<?php echo __( 'None', 'elementor' ); ?>" title="<?php echo __( 'None', 'elementor' ); ?>">
						<i class="eicon-ban" aria-hidden="true"></i>
						<span class="co-screen-only"><?php echo __( 'None', 'elementor' ); ?></span>
					</label>
					<# if ( ! data.exclude_inline_options.includes( 'svg' ) ) { #>
						<input id="<?php echo $control_uid; ?>-svg" type="radio" value="svg">
						<label class="co-choices-label co-control-unit-1 tooltip-target co-control-icons--inline__svg" for="<?php echo $control_uid; ?>-svg" data-tooltip="<?php echo __( 'Upload SVG', 'elementor' ); ?>" title="<?php echo __( 'Upload SVG', 'elementor' ); ?>">
							<i class="eicon-upload" aria-hidden="true"></i>
							<span class="co-screen-only"><?php echo __( 'Upload SVG', 'elementor' ); ?></span>
						</label>
					<# }
					if ( ! data.exclude_inline_options.includes( 'icon' ) ) { #>
						<input id="<?php echo $control_uid; ?>-icon" type="radio" value="icon">
						<label class="co-choices-label co-control-unit-1 tooltip-target co-control-icons--inline__icon" for="<?php echo $control_uid; ?>-icon" data-tooltip="<?php echo __( 'Icon Library', 'elementor' ); ?>" title="<?php echo __( 'Icon Library', 'elementor' ); ?>">
							<span class="co-control-icons--inline__displayed-icon">
								<i class="eicon-circle" aria-hidden="true"></i>
							</span>
							<span class="co-screen-only"><?php echo __( 'Icon Library', 'elementor' ); ?></span>
						</label>
					<# } #>
				</div>
			</div>
		</div>

		<# if ( data.description ) { #>
		<div class="co-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	/**
	 * Get Icons control default settings.
	 *
	 * Retrieve the default settings of the Icons control. Used to return the default
	 * settings while initializing the Icons control.
	 *
	 * @since 2.6.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'label_block' => true,
			'dynamic' => [
				'categories' => [ TagsModule::IMAGE_CATEGORY ],
				'returnType' => 'object',
			],
			'search_bar' => true,
			'recommended' => false,
			'is_svg_enabled' => Svg_Handler::is_enabled(),
			'skin' => 'media',
			'exclude_inline_options' => [],
		];
	}

	public function support_svg_import( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	public function on_import( $settings ) {
		if ( empty( $settings['library'] ) || 'svg' !== $settings['library'] || empty( $settings['value']['url'] ) ) {
			return $settings;
		}

		add_filter( 'upload_mimes', [ $this, 'support_svg_import' ], 100 );

		$imported = Plugin::$instance->templates_manager->get_import_images_instance()->import( $settings['value'] );

		remove_filter( 'upload_mimes', [ $this, 'support_svg_import' ], 100 );

		if ( ! $imported ) {
			$settings['value'] = '';
			$settings['library'] = '';
		} else {
			$settings['value'] = $imported;
		}
		return $settings;
	}
}
