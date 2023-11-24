<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<script type="text/template" id="tmpl-co-empty-preview">
	<div class="co-first-add">
		<div class="co-icon eicon-plus"></div>
	</div>
</script>

<script type="text/template" id="tmpl-co-preview">
	<div class="co-section-wrap"></div>
</script>

<script type="text/template" id="tmpl-co-add-section">
	<div class="co-add-section-inner">
		<div class="co-add-section-close">
			<i class="eicon-close" aria-hidden="true"></i>
			<span class="co-screen-only"><?php echo __( 'Close', 'elementor' ); ?></span>
		</div>
		<div class="co-add-new-section">
			<div class="co-add-section-area-button co-add-section-button" title="<?php echo __( 'Add New Section', 'elementor' ); ?>">
				<i class="eicon-plus"></i>
			</div>
			<div class="co-add-section-area-button co-add-template-button" title="<?php echo __( 'Add Template', 'elementor' ); ?>">
				<i class="eicon-folder"></i>
			</div>
			<div class="co-add-section-drag-title"><?php echo __( 'Drag widget here', 'elementor' ); ?></div>
		</div>
		<div class="co-select-preset">
			<div class="co-select-preset-title"><?php echo __( 'Select your Structure', 'elementor' ); ?></div>
			<ul class="co-select-preset-list">
				<#
					var structures = [ 10, 20, 30, 40, 21, 22, 31, 32, 33, 50, 60, 34 ];

					_.each( structures, function( structure ) {
					var preset = elementor.presetsFactory.getPresetByStructure( structure ); #>

					<li class="co-preset co-column co-col-16" data-structure="{{ structure }}">
						{{{ elementor.presetsFactory.getPresetSVG( preset.preset ).outerHTML }}}
					</li>
					<# } ); #>
			</ul>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-co-tag-controls-stack-empty">
	<?php echo __( 'This tag has no settings.', 'elementor' ); ?>
</script>
