<?php
/**
 * This file display meta box tab
 *
 * @package woo-product-slider
 */

$current_screen        = get_current_screen();
$the_current_post_type = $current_screen->post_type;
if ( $the_current_post_type == 'sp_wps_shortcodes' ) {
	?>
	<div class="sp-wps-metabox-framework">
		<div class="sp-wps-mbf-banner">
			<div class="sp-wps-mbf-logo"><img src="<?php echo SP_WPS_URL; ?>admin/assets/images/woo-product-slider.png" alt="Product Slider for WooCommerce"></div>
			<div class="sp-wps-mbf-short-links">
				<a href="https://shapedplugin.com/support-forum/" target="_blank"><i class="fa fa-life-ring"></i> Support</a>
			</div>
		</div>
		<div class="sp-wps-mbf text-center">

			<div class="sp-wps-col-lg-3">
				<div class="sp-wps-mbf-shortcode">
					<h2 class="sp-wps-mbf-shortcode-title"><?php _e( 'Shortcode', 'woo-product-slider' ); ?> </h2>
					<p>
					<?php
					_e( 'Copy and paste this shortcode into your posts or pages:', 'woo-product-slider' );
						global $post;
					?>
						</p>
					<div class="spsc-code selectable">[woo_product_slider <?php echo 'id="' . $post->ID . '"'; ?>]</div>
				</div>

			</div>
			<div class="sp-wps-col-lg-3">
				<div class="sp-wps-mbf-shortcode">
					<h2 class="sp-wps-mbf-shortcode-title"><?php _e( 'Template Include', 'woo-product-slider' ); ?> </h2>

					<p><?php _e( 'Paste the PHP code into your template file:', 'woo-product-slider' ); ?></p>

					<div class="spsc-code selectable">
						&lt;?php echo do_shortcode('[woo_product_slider <?php echo 'id="' . $post->ID . '"'; ?>]'); ?&gt;</div>

				</div>
			</div>
			<div class="sp-wps-col-lg-3">
				<div class="sp-wps-mbf-shortcode">
					<h2 class="sp-wps-mbf-shortcode-title"><?php _e( 'Post or Page editor', 'woo-product-slider' ); ?> </h2>

					<p><?php _e( 'Insert it into an existing post or page with the icon:', 'woo-product-slider' ); ?></p>
					<img class="back-image" src="<?php echo SP_WPS_URL . 'admin/assets/images/wps-editor-button.png'; ?>" alt="">
				</div>
			</div>

		</div>
		<div class="sp-wps-shortcode-divider"></div>

		<div class="sp-wps-mbf-nav nav-tab-wrapper current">
			<a class="nav-tab nav-tab-active" data-tab="sp-wps-tab-1"><i class="fa fa-cog"></i>General Settings</a>
			<a class="nav-tab" data-tab="sp-wps-tab-2"><i class="fa fa-sliders"></i>Slider Controls</a>
			<a class="nav-tab" data-tab="sp-wps-tab-3"><i class="fa fa-th-large"></i>Display Options</a>
			<a class="nav-tab" data-tab="sp-wps-tab-4"><i class="fa fa-font"></i>Typography</a>
			<a class="nav-tab sp-wps-upgrade-to-pro" data-tab="sp-wps-tab-5"><i class="fa fa-rocket"></i>Upgrade to Pro</a>
		</div>

		<?php
		include_once 'partials/general-settings.php';
		include_once 'partials/slider-settings.php';
		include_once 'partials/stylization.php';
		include_once 'partials/typography.php';
		include_once 'partials/upgrade-to-pro.php';
		?>
	</div>
	<?php
}
