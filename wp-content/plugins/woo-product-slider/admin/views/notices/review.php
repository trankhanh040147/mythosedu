<?php
/**
 * The review admin notice.
 *
 * @since        2.1.14
 *
 * @package    Woo_Product_Slider
 * @subpackage Woo_Product_Slider/admin/views/notices
 * @author     ShapedPlugin<support@shapedplugin.com>
 */
class Woo_Product_Slider_Review {

	public function __construct() {
		add_action( 'admin_notices', array( $this, 'display_admin_notice' ) );
		add_action( 'wp_ajax_sp-wps-never-show-review-notice', array( $this, 'dismiss_review_notice' ) );
	}

	/**
	 * Display admin notice.
	 *
	 * @return void
	 */
	public function display_admin_notice() {
		// Show only to Admins.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Variable default value.
		$review = get_option( 'sp_woo_product_slider_review_notice_dismiss' );
		$time   = time();
		$load   = false;

		if ( ! $review ) {
			$review = array(
				'time'      => $time,
				'dismissed' => false,
			);
			add_option( 'sp_woo_product_slider_review_notice_dismiss', $review );
		} else {
			// Check if it has been dismissed or not.
			if ( ( isset( $review['dismissed'] ) && ! $review['dismissed'] ) && ( isset( $review['time'] ) && ( ( $review['time'] + ( DAY_IN_SECONDS * 3 ) ) <= $time ) ) ) {
				$load = true;
			}
		}

		// If we cannot load, return early.
		if ( ! $load ) {
			return;
		}
		?>
		<div id="sp-wps-review-notice" class="sp-wps-review-notice">
			<div class="sp-wps-plugin-icon">
				<img src="<?php echo SP_WPS_URL . 'admin/assets/images/logo.png'; ?>" alt="Product Slider for Woocommerce">
			</div>
			<div class="sp-wps-notice-text">
				<h3>Enjoying <strong>Product Slider for Woocommerce</strong>?</h3>
				<p>Hope that you had a good experience with the <strong>Product Slider for Woocommerce</strong>. Would you please show us a little love by rating us in the <a href="https://wordpress.org/support/plugin/woo-product-slider/reviews/?filter=5#new-post" target="_blank"><strong>WordPress.org</strong></a>?
				Just a minute to rate the plugin. Thank you!</p>

				<p class="sp-wps-review-actions">
					<a href="https://wordpress.org/support/plugin/woo-product-slider/reviews/?filter=5#new-post" target="_blank" class="button button-primary notice-dismissed rate-woo-product-slider">Ok, you deserve it</a>
					<a href="#" class="notice-dismissed remind-me-later"><span class="dashicons dashicons-clock"></span>Nope, maybe later
</a>
					<a href="#" class="notice-dismissed never-show-again"><span class="dashicons dashicons-dismiss"></span>Never show again</a>
				</p>
			</div>
		</div>

		<script type='text/javascript'>

			jQuery(document).ready( function($) {
				$(document).on('click', '#sp-wps-review-notice.sp-wps-review-notice .notice-dismissed', function( event ) {
					if ( $(this).hasClass('rate-woo-product-slider') ) {
						var notice_dismissed_value = "1";
					}
					if ( $(this).hasClass('remind-me-later') ) {
						var notice_dismissed_value =  "2";
						event.preventDefault();
					}
					if ( $(this).hasClass('never-show-again') ) {
						var notice_dismissed_value =  "3";
						event.preventDefault();
					}

					$.post( ajaxurl, {
						action: 'sp-wps-never-show-review-notice',
						notice_dismissed_data : notice_dismissed_value
					});

					$('#sp-wps-review-notice.sp-wps-review-notice').hide();
				});
			});

		</script>
		<?php
	}

	/**
	 * Dismiss review notice
	 *
	 * @since  2.1.14
	 *
	 * @return void
	 **/
	public function dismiss_review_notice() {
		if ( ! $review ) {
			$review = array();
		}
		switch ( $_POST['notice_dismissed_data'] ) {
			case '1':
				$review['time']      = time();
				$review['dismissed'] = false;
				break;
			case '2':
				$review['time']      = time();
				$review['dismissed'] = false;
				break;
			case '3':
				$review['time']      = time();
				$review['dismissed'] = true;
				break;
		}
		update_option( 'sp_woo_product_slider_review_notice_dismiss', $review );
		die;
	}
}

new Woo_Product_Slider_Review();
