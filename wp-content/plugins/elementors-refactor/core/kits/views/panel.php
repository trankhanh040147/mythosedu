<script type="text/template" id="tmpl-co-kit-panel">
	<main id="co-kit__panel-content__wrapper" class="co-panel-content-wrapper"></main>
</script>

<script type="text/template" id="tmpl-co-kit-panel-content">
	<div id="co-kit-panel-content-controls"></div>
	<#
	const tabConfig = $e.components.get( 'panel/global' ).getActiveTabConfig();
	if ( tabConfig.helpUrl ) { #>
	<div id="co-panel__editor__help">
		<a id="co-panel__editor__help__link" href="{{ tabConfig.helpUrl }}" target="_blank">
			<?php echo __( 'Need Help', 'elementor' ); ?>
			<i class="eicon-help-o"></i>
		</a>
	</div>
	<# } #>
</script>
