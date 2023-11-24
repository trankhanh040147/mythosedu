<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<script type="text/template" id="tmpl-co-panel-elements">
	<div id="co-panel-elements-navigation" class="co-panel-navigation">
		<div class="co-component-tab co-panel-navigation-tab" data-tab="categories"><?php echo __( 'Elements', 'elementor' ); ?></div>
		<div class="co-component-tab co-panel-navigation-tab" data-tab="global"><?php echo __( 'Global', 'elementor' ); ?></div>
	</div>
	<div id="co-panel-elements-search-area"></div>
	<div id="co-panel-elements-wrapper"></div>
</script>

<script type="text/template" id="tmpl-co-panel-categories">
	<div id="co-panel-categories"></div>

	<div id="co-panel-get-pro-elements" class="co-nerd-box">
		<img class="co-nerd-box-icon" src="<?php echo ELEMENTOR_ASSETS_URL . 'images/go-pro.svg'; ?>" />
		<div class="co-nerd-box-message"><?php echo __( 'Get more with Drag & Drop Layout Pro', 'elementor' ); ?></div>
		<a class="co-button co-button-default co-nerd-box-link" target="_blank" href="<?php echo Utils::get_pro_link( '#' ); ?>"><?php echo __( 'Go Pro', 'elementor' ); ?></a>
	</div>
</script>

<script type="text/template" id="tmpl-co-panel-elements-category">
	<div class="co-panel-category-title">{{{ title }}}</div>
	<div class="co-panel-category-items"></div>
</script>

<script type="text/template" id="tmpl-co-panel-element-search">
	<label for="co-panel-elements-search-input" class="screen-reader-text"><?php echo __( 'Search Widget:', 'elementor' ); ?></label>
	<input type="search" id="co-panel-elements-search-input" placeholder="<?php esc_attr_e( 'Search Widget...', 'elementor' ); ?>" autocomplete="off"/>
	<i class="eicon-search-bold" aria-hidden="true"></i>
</script>

<script type="text/template" id="tmpl-co-element-library-element">
	<div class="co-element">
		<# if ( false === obj.editable ) { console.log(obj); #>
			<i class="eicon-lock"></i>
		<# } #>
		<div class="icon">
			<i class="{{ icon }}" aria-hidden="true"></i>
		</div>
		<div class="co-element-title-wrapper">
			<div class="title">{{{ title }}}</div>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-co-panel-global">
	<div class="co-nerd-box">
		<img class="co-nerd-box-icon" src="<?php echo ELEMENTOR_ASSETS_URL . 'images/information.svg'; ?>" />
		<div class="co-nerd-box-title"><?php echo __( 'Meet Our Global Widget', 'elementor' ); ?></div>
		<div class="co-nerd-box-message"><?php echo __( 'With this feature, you can save a widget as global, then add it to multiple areas. All areas will be editable from one single place.', 'elementor' ); ?></div>
		<a class="co-button co-button-default co-nerd-box-link" target="_blank" href="<?php echo Utils::get_pro_link( '#' ); ?>"><?php echo __( 'Go Pro', 'elementor' ); ?></a>
	</div>
</script>
