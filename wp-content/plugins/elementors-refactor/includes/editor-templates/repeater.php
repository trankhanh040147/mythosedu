<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<script type="text/template" id="tmpl-co-repeater-row">
	<div class="co-repeater-row-tools">
		<# if ( itemActions.drag_n_drop ) {  #>
			<div class="co-repeater-row-handle-sortable">
				<i class="eicon-ellipsis-v" aria-hidden="true"></i>
				<span class="co-screen-only"><?php echo __( 'Drag & Drop', 'elementor' ); ?></span>
			</div>
		<# } #>
		<div class="co-repeater-row-item-title"></div>
		<# if ( itemActions.duplicate ) {  #>
			<div class="co-repeater-row-tool co-repeater-tool-duplicate">
				<i class="eicon-copy" aria-hidden="true"></i>
				<span class="co-screen-only"><?php echo __( 'Duplicate', 'elementor' ); ?></span>
			</div>
		<# }
		if ( itemActions.remove ) {  #>
			<div class="co-repeater-row-tool co-repeater-tool-remove">
				<i class="eicon-close" aria-hidden="true"></i>
				<span class="co-screen-only"><?php echo __( 'Remove', 'elementor' ); ?></span>
			</div>
		<# } #>
	</div>
	<div class="co-repeater-row-controls"></div>
</script>
