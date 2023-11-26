<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<script type="text/template" id="tmpl-co-panel-history-page">
	<div id="co-panel-elements-navigation" class="co-panel-navigation">
		<div class="co-component-tab co-panel-navigation-tab" data-tab="actions"><?php echo __( 'Actions', 'elementor' ); ?></div>
		<div class="co-component-tab co-panel-navigation-tab" data-tab="revisions"><?php echo __( 'Revisions', 'elementor' ); ?></div>
	</div>
	<div id="co-panel-history-content"></div>
</script>

<script type="text/template" id="tmpl-co-panel-history-tab">
	<div id="co-history-list"></div>
	<div class="co-history-revisions-message"><?php echo __( 'Switch to Revisions tab for older versions', 'elementor' ); ?></div>
</script>

<script type="text/template" id="tmpl-co-panel-history-no-items">
	<img class="co-nerd-box-icon" src="<?php echo ELEMENTOR_ASSETS_URL . 'images/information.svg'; ?>" />
	<div class="co-nerd-box-title"><?php echo __( 'No History Yet', 'elementor' ); ?></div>
	<div class="co-nerd-box-message"><?php echo __( 'Once you start working, you\'ll be able to redo / undo any action you make in the editor.', 'elementor' ); ?></div>
</script>

<script type="text/template" id="tmpl-co-panel-history-item">
	<div class="co-history-item__details">
		<span class="co-history-item__title">{{{ title }}}</span>
		<span class="co-history-item__subtitle">{{{ subTitle }}}</span>
		<span class="co-history-item__action">{{{ action }}}</span>
	</div>
	<div class="co-history-item__icon">
		<span class="eicon" aria-hidden="true"></span>
	</div>
</script>
