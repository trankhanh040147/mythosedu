<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<script type="text/template" id="tmpl-co-navigator">
	<div id="co-navigator__header">
		<i id="co-navigator__toggle-all" class="eicon-expand" data-co-action="expand"></i>
		<div id="co-navigator__header__title"><?php echo __( 'Navigator', 'elementor' ); ?></div>
		<i id="co-navigator__close" class="eicon-close"></i>
	</div>
	<div id="co-navigator__elements"></div>
	<div id="co-navigator__footer">
		<i class="eicon-ellipsis-h"></i>
	</div>
</script>

<script type="text/template" id="tmpl-co-navigator__elements">
	<# if ( obj.elType ) { #>
		<div class="co-navigator__item">
			<div class="co-navigator__element__list-toggle">
				<i class="eicon-sort-down"></i>
			</div>
			<#
			if ( icon ) { #>
				<div class="co-navigator__element__element-type">
					<i class="{{{ icon }}}"></i>
				</div>
			<# } #>
			<div class="co-navigator__element__title">
				<span class="co-navigator__element__title__text">{{{ title }}}</span>
			</div>
			<div class="co-navigator__element__toggle">
				<i class="eicon-preview-medium"></i>
			</div>
			<div class="co-navigator__element__indicators"></div>
		</div>
	<# } #>
	<div class="co-navigator__elements"></div>
</script>

<script type="text/template" id="tmpl-co-navigator__elements--empty">
	<div class="co-empty-view__title"><?php echo __( 'Empty', 'elementor' ); ?></div>
</script>

<script type="text/template" id="tmpl-co-navigator__root--empty">
	<img class="co-nerd-box-icon" src="<?php echo ELEMENTOR_ASSETS_URL . 'images/information.svg'; ?>" />
	<div class="co-nerd-box-title"><?php echo __( 'Easy Navigation is Here!', 'elementor' ); ?></div>
	<div class="co-nerd-box-message"><?php echo __( 'Once you fill your page with content, this window will give you an overview display of all the page elements. This way, you can easily move around any section, column, or widget.', 'elementor' ); ?></div>
</script>
