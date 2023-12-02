<?php
namespace Elementor;

use Elementor\Core\Responsive\Responsive;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$document = Plugin::$instance->documents->get( Plugin::$instance->editor->get_post_id() );
?>
<script type="text/template" id="tmpl-co-panel">
	<div id="co-mode-switcher"></div>
	<div id="co-panel-state-loading">
		<i class="eicon-loading eicon-animation-spin"></i>
	</div>
	<header id="co-panel-header-wrapper"></header>
	<main id="co-panel-content-wrapper"></main>
	<footer id="co-panel-footer">
		<div class="co-panel-container">
		</div>
	</footer>
</script>

<script type="text/template" id="tmpl-co-panel-menu">
	<div id="co-panel-page-menu-content"></div>
</script>

<script type="text/template" id="tmpl-co-panel-menu-group">
	<div class="co-panel-menu-group-title">{{{ title }}}</div>
	<div class="co-panel-menu-items"></div>
</script>

<script type="text/template" id="tmpl-co-panel-menu-item">
	<div class="co-panel-menu-item-icon">
		<i class="{{ icon }}"></i>
	</div>
	<# if ( 'undefined' === typeof type || 'link' !== type ) { #>
		<div class="co-panel-menu-item-title">{{{ title }}}</div>
	<# } else {
		let target = ( 'undefined' !== typeof newTab && newTab ) ? '_blank' : '_self';
	#>
		<a href="{{ link }}" target="{{ target }}"><div class="co-panel-menu-item-title">{{{ title }}}</div></a>
	<# } #>
</script>

<script type="text/template" id="tmpl-co-panel-header">
	<div id="co-panel-header-menu-button" class="co-header-button">
		<i class="co-icon eicon-menu-bar tooltip-target" aria-hidden="true" data-tooltip="<?php esc_attr_e( 'Menu', 'elementor' ); ?>"></i>
		<span class="co-screen-only"><?php echo __( 'Menu', 'elementor' ); ?></span>
	</div>
	<div id="co-panel-header-title"></div>
	<div id="co-panel-header-add-button" class="co-header-button">
		<i class="co-icon eicon-apps tooltip-target" aria-hidden="true" data-tooltip="<?php esc_attr_e( 'Widgets Panel', 'elementor' ); ?>"></i>
		<span class="co-screen-only"><?php echo __( 'Widgets Panel', 'elementor' ); ?></span>
	</div>
</script>

<script type="text/template" id="tmpl-co-panel-footer-content">
	<div id="co-panel-footer-settings" class="co-panel-footer-tool co-leave-open tooltip-target" data-tooltip="<?php esc_attr_e( 'Settings', 'elementor' ); ?>">
		<i class="eicon-cog" aria-hidden="true"></i>
		<span class="co-screen-only"><?php printf( __( '%s Settings', 'elementor' ), $document::get_title() ); ?></span>
	</div>
	<div id="co-panel-footer-navigator" class="co-panel-footer-tool tooltip-target" data-tooltip="<?php esc_attr_e( 'Navigator', 'elementor' ); ?>">
		<i class="eicon-navigator" aria-hidden="true"></i>
		<span class="co-screen-only"><?php echo __( 'Navigator', 'elementor' ); ?></span>
	</div>
	<div id="co-panel-footer-history" class="co-panel-footer-tool co-leave-open tooltip-target" data-tooltip="<?php esc_attr_e( 'History', 'elementor' ); ?>">
		<i class="eicon-history" aria-hidden="true"></i>
		<span class="co-screen-only"><?php echo __( 'History', 'elementor' ); ?></span>
	</div>
	<div id="co-panel-footer-responsive" class="co-panel-footer-tool co-toggle-state">
		<i class="eicon-device-desktop tooltip-target" aria-hidden="true" data-tooltip="<?php esc_attr_e( 'Responsive Mode', 'elementor' ); ?>"></i>
		<span class="co-screen-only">
			<?php echo __( 'Responsive Mode', 'elementor' ); ?>
		</span>
		<div class="co-panel-footer-sub-menu-wrapper">
			<div class="co-panel-footer-sub-menu">
				<div class="co-panel-footer-sub-menu-item" data-device-mode="desktop">
					<i class="co-icon eicon-device-desktop" aria-hidden="true"></i>
					<span class="co-title"><?php echo __( 'Desktop', 'elementor' ); ?></span>
					<span class="co-description"><?php echo __( 'Default Preview', 'elementor' ); ?></span>
				</div>
				<div class="co-panel-footer-sub-menu-item" data-device-mode="tablet">
					<i class="co-icon eicon-device-tablet" aria-hidden="true"></i>
					<span class="co-title"><?php echo __( 'Tablet', 'elementor' ); ?></span>
					<?php $breakpoints = Responsive::get_breakpoints(); ?>
					<span class="co-description"><?php echo sprintf( __( 'Preview for %s', 'elementor' ), $breakpoints['md'] . 'px' ); ?></span>
				</div>
				<div class="co-panel-footer-sub-menu-item" data-device-mode="mobile">
					<i class="co-icon eicon-device-mobile" aria-hidden="true"></i>
					<span class="co-title"><?php echo __( 'Mobile', 'elementor' ); ?></span>
					<span class="co-description"><?php echo sprintf( __( 'Preview for %s', 'elementor' ), '360px' ); ?></span>
				</div>
			</div>
		</div>
	</div>
	<div id="co-panel-footer-saver-preview" class="co-panel-footer-tool tooltip-target" data-tooltip="<?php esc_attr_e( 'Preview Changes', 'elementor' ); ?>">
		<span id="co-panel-footer-saver-preview-label">
			<i class="eicon-preview-medium" aria-hidden="true"></i>
			<span class="co-screen-only"><?php echo __( 'Preview Changes', 'elementor' ); ?></span>
		</span>
	</div>
	<div id="co-panel-footer-saver-publish" class="co-panel-footer-tool">
		<button id="co-panel-saver-button-publish" class="co-button co-button-success co-disabled">
			<span class="co-state-icon">
				<i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i>
			</span>
			<span id="co-panel-saver-button-publish-label">
				<?php echo __( 'Publish', 'elementor' ); ?>
			</span>
		</button>
	</div>
	<div id="co-panel-footer-saver-options" class="co-panel-footer-tool co-toggle-state">
		<button id="co-panel-saver-button-save-options" class="co-button co-button-success tooltip-target co-disabled" data-tooltip="<?php esc_attr_e( 'Save Options', 'elementor' ); ?>">
			<i class="eicon-caret-up" aria-hidden="true"></i>
			<span class="co-screen-only"><?php echo __( 'Save Options', 'elementor' ); ?></span>
		</button>
		<div class="co-panel-footer-sub-menu-wrapper">
			<p class="co-last-edited-wrapper">
				<span class="co-state-icon">
					<i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i>
				</span>
				<span class="co-last-edited">
				</span>
			</p>
			<div class="co-panel-footer-sub-menu">
				<div id="co-panel-footer-sub-menu-item-save-draft" class="co-panel-footer-sub-menu-item co-disabled">
					<i class="co-icon eicon-save" aria-hidden="true"></i>
					<span class="co-title"><?php echo __( 'Save Draft', 'elementor' ); ?></span>
				</div>
				<div id="co-panel-footer-sub-menu-item-save-template" class="co-panel-footer-sub-menu-item">
					<i class="co-icon eicon-folder" aria-hidden="true"></i>
					<span class="co-title"><?php echo __( 'Save as Template', 'elementor' ); ?></span>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-co-mode-switcher-content">
	<input id="co-mode-switcher-preview-input" type="checkbox">
	<label for="co-mode-switcher-preview-input" id="co-mode-switcher-preview">
		<i class="eicon" aria-hidden="true" title="<?php esc_attr_e( 'Hide Panel', 'elementor' ); ?>"></i>
		<span class="co-screen-only"><?php echo __( 'Hide Panel', 'elementor' ); ?></span>
	</label>
</script>

<script type="text/template" id="tmpl-editor-content">
	<div class="co-panel-navigation">
		<# _.each( elementData.tabs_controls, function( tabTitle, tabSlug ) {
			if ( 'content' !== tabSlug && ! elementor.userCan( 'design' ) ) {
				return;
			}
			$e.bc.ensureTab( 'panel/editor', tabSlug );
			#>
			<div class="co-component-tab co-panel-navigation-tab co-tab-control-{{ tabSlug }}" data-tab="{{ tabSlug }}">
				<a href="#">{{{ tabTitle }}}</a>
			</div>
		<# } ); #>
	</div>
	<# if ( elementData.reload_preview ) { #>
		<div class="co-update-preview">
			<div class="co-update-preview-title"><?php echo __( 'Update changes to page', 'elementor' ); ?></div>
			<div class="co-update-preview-button-wrapper">
				<button class="co-update-preview-button co-button co-button-success"><?php echo __( 'Apply', 'elementor' ); ?></button>
			</div>
		</div>
	<# } #>
	<div id="co-controls"></div>
	<# if ( elementData.help_url ) { #>
		<div id="co-panel__editor__help">
			<a id="co-panel__editor__help__link" href="{{ elementData.help_url }}" target="_blank">
				<?php echo __( 'Need Help', 'elementor' ); ?>
				<i class="eicon-help-o"></i>
			</a>
		</div>
	<# } #>
</script>

<script type="text/template" id="tmpl-co-panel-schemes-disabled">
	<img class="co-nerd-box-icon" src="<?php echo ELEMENTOR_ASSETS_URL . 'images/information.svg'; ?>" />
	<div class="co-nerd-box-title">{{{ '<?php echo __( '%s are disabled', 'elementor' ); ?>'.replace( '%s', disabledTitle ) }}}</div>
	<div class="co-nerd-box-message"><?php printf( __( 'You can enable it from the <a href="%s" target="_blank">Drag & Drop Layout settings page</a>.', 'elementor' ), Settings::get_url() ); ?></div>
</script>

<script type="text/template" id="tmpl-co-panel-scheme-color-item">
	<div class="co-panel-scheme-color-picker-placeholder"></div>
	<div class="co-panel-scheme-color-title">{{{ title }}}</div>
</script>

<script type="text/template" id="tmpl-co-panel-scheme-typography-item">
	<div class="co-panel-heading">
		<div class="co-panel-heading-toggle">
			<i class="eicon" aria-hidden="true"></i>
		</div>
		<div class="co-panel-heading-title">{{{ title }}}</div>
	</div>
	<div class="co-panel-scheme-typography-items co-panel-box-content">
		<?php
		$scheme_fields_keys = Group_Control_Typography::get_scheme_fields_keys();

		$typography_group = Plugin::$instance->controls_manager->get_control_groups( 'typography' );
		$typography_fields = $typography_group->get_fields();

		$scheme_fields = array_intersect_key( $typography_fields, array_flip( $scheme_fields_keys ) );

		foreach ( $scheme_fields as $option_name => $option ) :
			?>
			<div class="co-panel-scheme-typography-item co-control co-control-type-select">
				<div class="co-panel-scheme-item-title co-control-title"><?php echo $option['label']; ?></div>
				<div class="co-panel-scheme-typography-item-value co-control-input-wrapper">
					<?php if ( 'select' === $option['type'] ) : ?>
						<select name="<?php echo esc_attr( $option_name ); ?>" class="co-panel-scheme-typography-item-field">
							<?php foreach ( $option['options'] as $field_key => $field_value ) : ?>
								<option value="<?php echo esc_attr( $field_key ); ?>"><?php echo $field_value; ?></option>
							<?php endforeach; ?>
						</select>
					<?php elseif ( 'font' === $option['type'] ) : ?>
						<select name="<?php echo esc_attr( $option_name ); ?>" class="co-panel-scheme-typography-item-field">
							<option value=""><?php echo __( 'Default', 'elementor' ); ?></option>
							<?php foreach ( Fonts::get_font_groups() as $group_type => $group_label ) : ?>
								<optgroup label="<?php echo esc_attr( $group_label ); ?>">
									<?php foreach ( Fonts::get_fonts_by_groups( [ $group_type ] ) as $font_title => $font_type ) : ?>
										<option value="<?php echo esc_attr( $font_title ); ?>"><?php echo $font_title; ?></option>
									<?php endforeach; ?>
								</optgroup>
							<?php endforeach; ?>
						</select>
					<?php elseif ( 'text' === $option['type'] ) : ?>
						<input name="<?php echo esc_attr( $option_name ); ?>" class="co-panel-scheme-typography-item-field" />
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</script>

<script type="text/template" id="tmpl-co-control-responsive-switchers">
	<div class="co-control-responsive-switchers">
		<div class="co-control-responsive-switchers__holder">
		<#
			var devices = responsive.devices || [ 'desktop', 'tablet', 'mobile' ];

			_.each( devices, function( device ) {
				var deviceLabel = device.charAt(0).toUpperCase() + device.slice(1),
					tooltipDir = "<?php echo is_rtl() ? 'e' : 'w'; ?>";
			#>
				<a class="co-responsive-switcher tooltip-target co-responsive-switcher-{{ device }}" data-device="{{ device }}" data-tooltip="{{ deviceLabel }}" data-tooltip-pos="{{ tooltipDir }}">
					<i class="eicon-device-{{ device }}"></i>
				</a>
			<# } );
		#>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-co-control-dynamic-switcher">
	<div class="co-control-dynamic-switcher co-control-unit-1" data-tooltip="<?php echo __( 'Dynamic Tags', 'elementor' ); ?>">
		<i class="eicon-database"></i>
	</div>
</script>

<script type="text/template" id="tmpl-co-control-dynamic-cover">
	<div class="co-dynamic-cover__settings">
		<i class="eicon-{{ hasSettings ? 'wrench' : 'database' }}"></i>
	</div>
	<div class="co-dynamic-cover__title" title="{{{ title + ' ' + content }}}">{{{ title + ' ' + content }}}</div>
	<# if ( isRemovable ) { #>
		<div class="co-dynamic-cover__remove">
			<i class="eicon-close-circle"></i>
		</div>
	<# } #>
</script>

<script type="text/template" id="tmpl-co-dynamic-tags-promo">
	<div class="co-tags-list__teaser">
		<div class="co-tags-list__group-title co-tags-list__teaser-title">
			<i class="eicon-info-circle"></i><?php echo __( 'Drag & Drop Layout Dynamic Content', 'elementor' ); ?>
		</div>
		<div class="co-tags-list__teaser-text">
			<?php echo __( 'You’re missing out!', 'elementor' ); ?><br />
			<?php echo __( 'Get more dynamic capabilities by incorporating dozens of Elementor\'s native dynamic tags.', 'elementor' ); ?>
			<a href="{{{ elementor.config.dynamicPromotionURL }}}" class="co-tags-list__teaser-link" target="_blank">
				<?php echo __( 'See it in action', 'elementor' ); ?>
			</a>
		</div>
	</div>
</script>
