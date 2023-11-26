<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<script type="text/template" id="tmpl-co-panel-revisions">
	<div class="co-panel-box">
	<div class="co-panel-scheme-buttons">
			<div class="co-panel-scheme-button-wrapper co-panel-scheme-discard">
				<button class="co-button" disabled>
					<i class="eicon-close" aria-hidden="true"></i>
					<?php echo __( 'Discard', 'elementor' ); ?>
				</button>
			</div>
			<div class="co-panel-scheme-button-wrapper co-panel-scheme-save">
				<button class="co-button co-button-success" disabled>
					<?php echo __( 'Apply', 'elementor' ); ?>
				</button>
			</div>
		</div>
	</div>

	<div class="co-panel-box">
		<div class="co-panel-heading">
			<div class="co-panel-heading-title"><?php echo __( 'Revisions', 'elementor' ); ?></div>
		</div>
		<div id="co-revisions-list" class="co-panel-box-content"></div>
	</div>
</script>

<script type="text/template" id="tmpl-co-panel-revisions-no-revisions">
	<img class="co-nerd-box-icon" src="<?php echo ELEMENTOR_ASSETS_URL . 'images/information.svg'; ?>" />
	<div class="co-nerd-box-title"><?php echo __( 'No Revisions Saved Yet', 'elementor' ); ?></div>
	<div class="co-nerd-box-message">{{{ elementor.translate( elementor.config.document.revisions.enabled ? 'no_revisions_1' : 'revisions_disabled_1' ) }}}</div>
	<div class="co-nerd-box-message">{{{ elementor.translate( elementor.config.document.revisions.enabled ? 'no_revisions_2' : 'revisions_disabled_2' ) }}}</div>
</script>

<script type="text/template" id="tmpl-co-panel-revisions-loading">
	<i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i>
</script>

<script type="text/template" id="tmpl-co-panel-revisions-revision-item">
	<div class="co-revision-item__wrapper {{ type }}">
		<div class="co-revision-item__gravatar">{{{ gravatar }}}</div>
		<div class="co-revision-item__details">
			<div class="co-revision-date">{{{ date }}}</div>
			<div class="co-revision-meta"><span>{{{ elementor.translate( type ) }}}</span> <?php echo __( 'By', 'elementor' ); ?> {{{ author }}}</div>
		</div>
		<div class="co-revision-item__tools">
			<# if ( 'current' === type ) { #>
				<i class="co-revision-item__tools-current eicon-star" aria-hidden="true"></i>
				<span class="co-screen-only"><?php echo __( 'Current', 'elementor' ); ?></span>
			<# } #>

			<i class="co-revision-item__tools-spinner eicon-loading eicon-animation-spin" aria-hidden="true"></i>
		</div>
	</div>
</script>
