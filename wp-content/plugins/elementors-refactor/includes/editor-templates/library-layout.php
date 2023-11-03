<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<script type="text/template" id="tmpl-co-templates-modal__header">
	<div class="co-templates-modal__header__logo-area"></div>
	<div class="co-templates-modal__header__menu-area"></div>
	<div class="co-templates-modal__header__items-area">
		<# if ( closeType ) { #>
			<div class="co-templates-modal__header__close co-templates-modal__header__close--{{{ closeType }}} co-templates-modal__header__item">
				<# if ( 'skip' === closeType ) { #>
				<span><?php echo __( 'Skip', 'elementor' ); ?></span>
				<# } #>
				<i class="eicon-close" aria-hidden="true" title="<?php echo __( 'Close', 'elementor' ); ?>"></i>
				<span class="co-screen-only"><?php echo __( 'Close', 'elementor' ); ?></span>
			</div>
		<# } #>
		<div id="co-template-library-header-tools"></div>
	</div>
</script>

<script type="text/template" id="tmpl-co-templates-modal__header__logo">
	<span class="co-templates-modal__header__logo__icon-wrapper co-gradient-logo">
		<i class="eicon-elementor"></i>
	</span>
	<span class="co-templates-modal__header__logo__title">{{{ title }}}</span>
</script>
