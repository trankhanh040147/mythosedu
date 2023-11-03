<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<script type="text/template" id="tmpl-co-template-library-header-actions">
	<div id="co-template-library-header-import" class="co-templates-modal__header__item">
		<i class="eicon-upload-circle-o" aria-hidden="true" title="<?php esc_attr_e( 'Import Template', 'elementor' ); ?>"></i>
		<span class="co-screen-only"><?php echo __( 'Import Template', 'elementor' ); ?></span>
	</div>
	<div id="co-template-library-header-sync" class="co-templates-modal__header__item">
		<i class="eicon-sync" aria-hidden="true" title="<?php esc_attr_e( 'Sync Library', 'elementor' ); ?>"></i>
		<span class="co-screen-only"><?php echo __( 'Sync Library', 'elementor' ); ?></span>
	</div>
	<div id="co-template-library-header-save" class="co-templates-modal__header__item">
		<i class="eicon-save-o" aria-hidden="true" title="<?php esc_attr_e( 'Save', 'elementor' ); ?>"></i>
		<span class="co-screen-only"><?php echo __( 'Save', 'elementor' ); ?></span>
	</div>
</script>

<script type="text/template" id="tmpl-co-template-library-header-menu">
	<# jQuery.each( tabs, ( tab, args ) => { #>
		<div class="co-component-tab co-template-library-menu-item" data-tab="{{{ tab }}}">{{{ args.title }}}</div>
	<# } ); #>
</script>

<script type="text/template" id="tmpl-co-template-library-header-preview">
	<div id="co-template-library-header-preview-insert-wrapper" class="co-templates-modal__header__item">
		{{{ elementor.templates.layout.getTemplateActionButton( obj ) }}}
	</div>
</script>

<script type="text/template" id="tmpl-co-template-library-header-back">
	<i class="eicon-" aria-hidden="true"></i>
	<span><?php echo __( 'Back to Library', 'elementor' ); ?></span>
</script>

<script type="text/template" id="tmpl-co-template-library-loading">
	<div class="co-loader-wrapper">
		<div class="co-loader">
			<div class="co-loader-boxes">
				<div class="co-loader-box"></div>
				<div class="co-loader-box"></div>
				<div class="co-loader-box"></div>
				<div class="co-loader-box"></div>
			</div>
		</div>
		<div class="co-loading-title"><?php echo __( 'Loading', 'elementor' ); ?></div>
	</div>
</script>

<script type="text/template" id="tmpl-co-template-library-templates">
	<#
		var activeSource = elementor.templates.getFilter('source');
	#>
	<div id="co-template-library-toolbar">

			<div id="co-template-library-filter-toolbar-local" class="co-template-library-filter-toolbar"></div>

		<div id="co-template-library-filter-text-wrapper">
			<label for="co-template-library-filter-text" class="co-screen-only"><?php echo __( 'Search Templates:', 'elementor' ); ?></label>
			<input id="co-template-library-filter-text" placeholder="<?php echo esc_attr__( 'Search', 'elementor' ); ?>">
			<i class="eicon-search"></i>
		</div>
	</div>
	<# if ( 'local' === activeSource ) { #>
		<div id="co-template-library-order-toolbar-local">
			<div class="co-template-library-local-column-1">
				<input type="radio" id="co-template-library-order-local-title" class="co-template-library-order-input" name="co-template-library-order-local" value="title" data-default-ordering-direction="asc">
				<label for="co-template-library-order-local-title" class="co-template-library-order-label"><?php echo __( 'Name', 'elementor' ); ?></label>
			</div>
			<div class="co-template-library-local-column-2">
				<input type="radio" id="co-template-library-order-local-type" class="co-template-library-order-input" name="co-template-library-order-local" value="type" data-default-ordering-direction="asc">
				<label for="co-template-library-order-local-type" class="co-template-library-order-label"><?php echo __( 'Type', 'elementor' ); ?></label>
			</div>
			<div class="co-template-library-local-column-3">
				<input type="radio" id="co-template-library-order-local-author" class="co-template-library-order-input" name="co-template-library-order-local" value="author" data-default-ordering-direction="asc">
				<label for="co-template-library-order-local-author" class="co-template-library-order-label"><?php echo __( 'Created By', 'elementor' ); ?></label>
			</div>
			<div class="co-template-library-local-column-4">
				<input type="radio" id="co-template-library-order-local-date" class="co-template-library-order-input" name="co-template-library-order-local" value="date">
				<label for="co-template-library-order-local-date" class="co-template-library-order-label"><?php echo __( 'Creation Date', 'elementor' ); ?></label>
			</div>
			<div class="co-template-library-local-column-5">
				<div class="co-template-library-order-label"><?php echo __( 'Actions', 'elementor' ); ?></div>
			</div>
		</div>
	<# } #>
	<div id="co-template-library-templates-container"></div>
</script>

<script type="text/template" id="tmpl-co-template-library-template-remote">
	<div class="co-template-library-template-body">
		<# if ( 'page' === type ) { #>
			<div class="co-template-library-template-screenshot" style="background-image: url({{ thumbnail }});"></div>
		<# } else { #>
			<img src="{{ thumbnail }}">
		<# } #>
		<div class="co-template-library-template-preview">
			<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
		</div>
	</div>
	<div class="co-template-library-template-footer">
		{{{ elementor.templates.layout.getTemplateActionButton( obj ) }}}
		<div class="co-template-library-template-name">{{{ title }}} - {{{ type }}}</div>
		<div class="co-template-library-favorite">
			<input id="co-template-library-template-{{ template_id }}-favorite-input" class="co-template-library-template-favorite-input" type="checkbox"{{ favorite ? " checked" : "" }}>
			<label for="co-template-library-template-{{ template_id }}-favorite-input" class="co-template-library-template-favorite-label">
				<i class="eicon-heart-o" aria-hidden="true"></i>
				<span class="co-screen-only"><?php echo __( 'Favorite', 'elementor' ); ?></span>
			</label>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-co-template-library-template-local">
	<div class="co-template-library-template-name co-template-library-local-column-1">{{{ title }}}</div>
	<div class="co-template-library-template-meta co-template-library-template-type co-template-library-local-column-2">{{{ elementor.translate( type ) }}}</div>
	<div class="co-template-library-template-meta co-template-library-template-author co-template-library-local-column-3">{{{ author }}}</div>
	<div class="co-template-library-template-meta co-template-library-template-date co-template-library-local-column-4">{{{ human_date }}}</div>
	<div class="co-template-library-template-controls co-template-library-local-column-5">
		<div class="co-template-library-template-preview">
			<i class="eicon-preview-medium" aria-hidden="true"></i>
			<span class="co-template-library-template-control-title"><?php echo __( 'Preview', 'elementor' ); ?></span>
		</div>
		<button class="co-template-library-template-action co-template-library-template-insert co-button co-button-success">
			<i class="eicon-file-download" aria-hidden="true"></i>
			<span class="co-button-title"><?php echo __( 'Insert', 'elementor' ); ?></span>
		</button>
		<div class="co-template-library-template-more-toggle">
			<i class="eicon-ellipsis-h" aria-hidden="true"></i>
			<span class="co-screen-only"><?php echo __( 'More actions', 'elementor' ); ?></span>
		</div>
		<div class="co-template-library-template-more">
			<div class="co-template-library-template-delete">
				<i class="eicon-trash-o" aria-hidden="true"></i>
				<span class="co-template-library-template-control-title"><?php echo __( 'Delete', 'elementor' ); ?></span>
			</div>
			<div class="co-template-library-template-export">
				<a href="{{ export_link }}">
					<i class="eicon-sign-out" aria-hidden="true"></i>
					<span class="co-template-library-template-control-title"><?php echo __( 'Export', 'elementor' ); ?></span>
				</a>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-co-template-library-insert-button">
	<a class="co-template-library-template-action co-template-library-template-insert co-button">
		<i class="eicon-file-download" aria-hidden="true"></i>
		<span class="co-button-title"><?php echo __( 'Insert', 'elementor' ); ?></span>
	</a>
</script>

<script type="text/template" id="tmpl-co-template-library-get-pro-button">
	<a class="co-template-library-template-action co-button co-go-pro" href="<?php echo Utils::get_pro_link( '#' ); ?>" target="_blank">
		<i class="eicon-external-link-square" aria-hidden="true"></i>
		<span class="co-button-title"><?php echo __( 'Go Pro', 'elementor' ); ?></span>
	</a>
</script>

<script type="text/template" id="tmpl-co-template-library-save-template">
	<div class="co-template-library-blank-icon">
		<i class="eicon-library-save" aria-hidden="true"></i>
		<span class="co-screen-only"><?php echo __( 'Save', 'elementor' ); ?></span>
	</div>
	<div class="co-template-library-blank-title">{{{ title }}}</div>
	<div class="co-template-library-blank-message">{{{ description }}}</div>
	<form id="co-template-library-save-template-form">
		<input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
		<input id="co-template-library-save-template-name" name="title" placeholder="<?php echo esc_attr__( 'Enter Template Name', 'elementor' ); ?>" required>
		<button id="co-template-library-save-template-submit" class="co-button co-button-success">
			<span class="co-state-icon">
				<i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i>
			</span>
			<?php echo __( 'Save', 'elementor' ); ?>
		</button>
	</form>
	<div class="co-template-library-blank-footer">
		<?php echo __( 'Want to learn more about the Drag & Drop Layout library?', 'elementor' ); ?>
		<a class="co-template-library-blank-footer-link" href="#" target="_blank"><?php echo __( 'Click here', 'elementor' ); ?></a>
	</div>
</script>

<script type="text/template" id="tmpl-co-template-library-import">
	<form id="co-template-library-import-form">
		<div class="co-template-library-blank-icon">
			<i class="eicon-library-upload" aria-hidden="true"></i>
		</div>
		<div class="co-template-library-blank-title"><?php echo __( 'Import Template to Your Library', 'elementor' ); ?></div>
		<div class="co-template-library-blank-message"><?php echo __( 'Drag & drop your .JSON or .zip template file', 'elementor' ); ?></div>
		<div id="co-template-library-import-form-or"><?php echo __( 'or', 'elementor' ); ?></div>
		<label for="co-template-library-import-form-input" id="co-template-library-import-form-label" class="co-button co-button-success"><?php echo __( 'Select File', 'elementor' ); ?></label>
		<input id="co-template-library-import-form-input" type="file" name="file" accept=".json,.zip" required/>
		<div class="co-template-library-blank-footer">
			<?php echo __( 'Want to learn more about the Drag & Drop Layout library?', 'elementor' ); ?>
			<a class="co-template-library-blank-footer-link" href="#" target="_blank"><?php echo __( 'Click here', 'elementor' ); ?></a>
		</div>
	</form>
</script>

<script type="text/template" id="tmpl-co-template-library-templates-empty">
	<div class="co-template-library-blank-icon">
		<img src="<?php echo ELEMENTOR_ASSETS_URL . 'images/no-search-results.svg'; ?>" class="co-template-library-no-results" />
	</div>
	<div class="co-template-library-blank-title"></div>
	<div class="co-template-library-blank-message"></div>
	<div class="co-template-library-blank-footer">
		<?php echo __( 'Want to learn more about the Drag & Drop Layout library?', 'elementor' ); ?>
		<a class="co-template-library-blank-footer-link" href="#" target="_blank"><?php echo __( 'Click here', 'elementor' ); ?></a>
	</div>
</script>

<script type="text/template" id="tmpl-co-template-library-preview">
	<iframe></iframe>
</script>

<script type="text/template" id="tmpl-co-template-library-connect">
	<div id="co-template-library-connect-logo" class="co-gradient-logo">
		<i class="eicon-elementor" aria-hidden="true"></i>
	</div>
	<div class="co-template-library-blank-title">
		{{{ title }}}
	</div>
	<div class="co-template-library-blank-message">
		{{{ message }}}
	</div>
	<?php $url = Plugin::$instance->common->get_component( 'connect' )->get_app( 'library' )->get_admin_url( 'authorize' ); ?>
	<a id="co-template-library-connect__button" class="co-button co-button-success" href="<?php echo esc_attr( $url ); ?>">
		{{{ button }}}
	</a>
	<?php
	$base_images_url = $this->get_assets_base_url() . '/assets/images/library-connect/';

	$images = [ 'left-1', 'left-2', 'right-1', 'right-2' ];

	foreach ( $images as $image ) : ?>
		<img id="co-template-library-connect__background-image-<?php echo $image; ?>" class="co-template-library-connect__background-image" src="<?php echo $base_images_url . $image; ?>.png" draggable="false"/>
	<?php endforeach; ?>
</script>
