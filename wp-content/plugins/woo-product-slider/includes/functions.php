<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access

/**
 * Shortcode converter function
 */
function woo_product_slider_id( $id ) {
	echo do_shortcode( '[woo_product_slider id="' . $id . '"]' );
}

/**
 * Functions
 */
class SP_Woo_Product_Slider_Functions {

	/**
	 * SP_Woo_Product_Slider_Functions single instance of the class
	 *
	 * @var null
	 * @since 2.0
	 */
	protected static $_instance = null;

	/**
	 * Main SP_Woo_Product_Slider_Functions Instance
	 *
	 * @since 2.0
	 * @static
	 * @see SP_Woo_Product_Slider_Functions()
	 * @return self Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Initialize the class
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_filter( 'admin_footer_text', array( $this, 'admin_footer' ), 1, 2 );
		add_action( 'admin_notices', array( $this, 'pro_admin_notice' ) );
	}

	/**
	 * Show admin notice if pro version is active
	 */
	function pro_admin_notice() {
		if ( class_exists( 'SP_WooCommerce_Product_Slider_PRO' ) ) {
			?>
			<div class="notice notice-error is-dismissible">
				<p><b>Product Slider for WooCommerce</b> free version is active. Please, deactivate the free version to get better performance of the pro version.</p>
			</div>
			<?php
		}
	}

	/**
	 * Admin Menu
	 */
	function admin_menu() {
		add_submenu_page( 'edit.php?post_type=sp_wps_shortcodes', __( 'Product Slider for WooCommerce Help', 'woo-product-slider' ), __( 'Help', 'woo-product-slider' ), 'manage_options', 'wps_help', array( $this, 'help_page_callback' ) );
	}

	/**
	 * Help Page Callback
	 */
	public function help_page_callback() {
		?>
		<div class="wrap about-wrap sp-wps-help">
			<h1><?php _e( 'Welcome to Product Slider for WooCommerce!', 'woo-product-slider' ); ?></h1>
			<p class="about-text"><?php _e( 'Thank you for installing Product Slider for WooCommerce! You\'re now running the most popular WooCommerce Product Slider plugin. This video will help you get started with the plugin.', 'woo-product-slider' ); ?></p>
			<div class="wp-badge"></div>

			<hr>

			<div class="headline-feature feature-video">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/CE0VJoJhAjw" frameborder="0" allowfullscreen></iframe>
			</div>

			<hr>

			<div class="feature-section three-col">
				<div class="col">
					<div class="sp-wps-feature sp-wps-text-center">
						<i class="fa fa-life-ring"></i>
						<h3>Need any Assistance?</h3>
						<p>Our Expert Support Team is always ready to help you out promptly.</p>
						<a href="https://shapedplugin.com/support-forum/" target="_blank" class="button button-primary">Contact Support</a>
					</div>
				</div>
				<div class="col">
					<div class="sp-wps-feature sp-wps-text-center">
						<i class="fa fa-file-text"></i>
						<h3>Looking for Documentation?</h3>
						<p>We have detailed documentation on every aspects of Product Slider for WooCommerce.</p>
						<a href="https://shapedplugin.com/docs/docs/woocommerce-product-slider/" target="_blank" class="button button-primary">Documentation</a>
					</div>
				</div>
				<div class="col">
					<div class="sp-wps-feature sp-wps-text-center">
						<i class="fa fa-bug"></i>
						<h3>Found any Bugs?</h3>
						<p>Report any bug that you found, Get a instant solutions from developer.</p>
						<a href="https://shapedplugin.com/support-forum/" target="_blank" class="button button-primary">Report a Bug</a>
					</div>
				</div>
			</div>

			<hr>

			<div class="sp-wps-pro-features">
				<h2 class="sp-wps-text-center">Upgrade to Product Slider Pro for WooCommerce!</h2>
				<p class="sp-wps-text-center sp-wps-pro-subtitle">We've added 100+ extra features in our Premium Version of this plugin. Let’s see some amazing features.</p>
				<div class="feature-section three-col">
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>30+ Premium Ready Themes</h3>
							<p>Product Slider Pro for WooCommerce comes with 30+ amazing premium ready theme styles which are fully customizable directly from the plugin settings panel. You can choose any theme styles or more from several theme styles to fit your requirements. These themes can help you make your website a professional & quality appearance.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Unlimited Product & Category Sliders</h3>
							<p>No restrictions on the number of sliders available in Premium Version. You will be able to create as many as you want to make products carousel slider and category slider. You can make different unique sliders on your way and place them in different parts of your shop or pages. </p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Tailor-made Responsivity</h3>
							<p>Product Slider Pro for WooCommerce is 100% responsive and using intuitive breakpoints settings that you can customise the number of slides displayed on a desktop, tablet, and mobile. With the premium version of the plugin, you can set the number of product columns to show simultaneously in the carousel according to the specific device resolution.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Display Specific Products</h3>
							<p>You can display the specific products from your product list as a slider. A product slider is one of the best ways to highlight your specific products and, if you put this slider in strategic positions, it will allow you to increase your online store sales & conversion of your shop or site.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Show Products from Specific Category or Tag</h3>
							<p>Do you want to display a specific product category or tag to your probable customers? Creating a products slider from the same category is super easy. You can display the products from a particular category or multi-categories as carousel slider. Also, you can show product slider from a specific tag. It's easy enough!</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Products from Exclude Categories or Tags</h3>
							<p>This is another cool feature of Product Slider Pro for WooCommerce. This feature will allow you to show excluding specific product categories on the slider.
								Let's say you have 3 Product Categories like Category 1, Category 2, Category 3. You want to create a slider which will show all category products except Category 2. The Pro plugin makes it possible.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Upsells & Cross-Sells</h3>
							<p>Upsells are products that you recommend instead of the currently viewed product.
							<br>
							<br>
							Cross-sells are products that you promote in the cart, based on the current product. 
							<br>
							<br>
							With this premium plugin, You can display Upsells & Cross-Sells slider easily and increase conversion and purchases of your shop or website.
							</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Best Selling Products</h3>
							<p>You can display best selling products in a slider on the product page, dedicated best sellers page, or in any widget even anywhere you want. With the Pro version, you will be able to display those products which are mostly sold on your site or shop. Also, you can showcase the best selling products on the homepage or on any other page of your shop.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Related Products Slider</h3>
							<p>Quickly increase your customers’ engagement with your products by adding Related Products Slider in the bottom of your single product page. Automatically added Related Products Slider can increase your internal traffic up to 10% that is really helpful to get customers much. </p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Product Slider from Product Attributes</h3>
							<p>You can create product slider from product attribute and attribute values that are amazing features of the premium version. You can select different attributes like color, size, style etc. </p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Also, Filter the List of Products by Different Types</h3>
							<p>Enjoy the top possibility to show different product for each slider! If you did not want to show all products in your shop, you can select only some of them (products), according to the following selection criteria: On Sale! Products, Latest Added, Featured Products, Top Rated, Most Viewed, Recently Viewed, Products SKU or ID, Free Products etc.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Hide Out of Stocks and Free Products</h3>
							<p>You can show/hide out of stocks and free products.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Ticker Mode Carousel</h3>
							<p>This is an another amazing feature of Product Slider Pro for WooCommerce. It slides with infinite loop, with no Pause. You can set the speed and if the slider pauses on hover. You can enable or disable this option easily from the beginning of slider settings.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Show/hide Product Title, Price, Sale text, Excerpt (Description), Read more, Add to Cart button, Rating, Category, image etc.</h3>
							<p>You can control easily any contents like Product Name, Price, Description, Sale text, Excerpt, Read more, Add to Cart button, Rating, Category, Product image etc. Show/hide and with unlimited styles and of course live preview.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Product Quick-View, Wishlist, & Compare Options</h3>
							<p>Product Slider Pro for WooCommerce has three amazing features like Quick-View, Wishlist, & Compare Options. These three important features can help you attract your product and increase sales. And it is only possible with Pro version.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Typography: 840+ Google Fonts</h3>
							<p>With Premium version, You can add your desired font in the slider from 840+ Google Fonts. You can easily customize the Font family, size, transform, letter spacing, color, and line-height for each and every content of the product. You have full control of the fonts! Handle any content with 840+ google fonts with live preview.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Ticker Carousel Slider</h3>
							<p>This is another amazing feature of Product Slider Pro for WooCommerce. It slides smoothly with the infinite loop, with no Pause. You can set the speed and if the slider pauses on hover. You can enable or disable this option easily from the beginning of slider settings.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Slider Settings</h3>
							<p>In the slider settings of the Product Slider Pro for WooCommerce plugin, you can set how many products to scroll at a time in the slider or show, the transition speed, autoplay, swipe, pause on hover, infinite loop, mouse draggable, ticker mode, and many other settings.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Navigation Styles & 8 Positions</h3>
							<p>You can select your desired arrow style to fit your needs from 6 six different arrow styles. This plugin has 8+ different navigational arrow positions (Top right, top center, top left, bottom left, bottom center, bottom right, vertically center, vertically inner center, vertically inner center on hover etc.).</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Unlimited Colors & Stylization</h3>
							<p>You can change anything including opacity like font colors, overlay colors, background colors, border colors etc. with hover from dashboard settings panel easily. It needs few clicks only. There are plenty of amazing styling options which can help to build as per your needs. The color for every product element is unlimited. </p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Lightbox for Product Image</h3>
							<p>Another important feature is Lightbox functionality for your product image. Images Lightbox feature can help you to zoom your images when it is clicked on. This feature is available in Pro version. It attracts your visitor much than generally sized images. You can on/off the Lightbox option. </p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>GrayScale & Overlay Effects</h3>
							<p>This premium plugin is compatible with most of the browsers, you can choose to display the product images on a Grayscale version and a bit of transparency and choose if on hover the product image will have the original colors or not. There are 3 options such as GrayScale with normal on hover, GrayScale on hover and always GrayScale.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Image Custom Re-size Options</h3>
							<p>You can change the default size of your product images on the settings. New uploaded image will be resized to the specified dimensions.

								Your images will be hard cropped equally with your defined size. You need upload bigger images to re-size in your chosen dimension. By default, this option is disabled and when you enable it, you need set an image dimension. You can also set a default or custom placeholder image for product image.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Ribbon Management</h3>
							<p>Ribbon management like Sale, Out of Stock, Featured with managing unlimited background colors, style, unlimited font colors, hide/show as well position.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>Visual Composer & Widget Ready!</h3>
							<p>To include slider inside a widget area is as simple as including any other widget! The plugin comes ready with a widget so you can easily display the products slider you need, just be filling out the form! This widget will also work on any WordPress theme. An extra component will also be added to Visual Composer. Easy enough!</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-wps-feature">
							<h3><span class="dashicons dashicons-yes"></span>24/7 Fast & Friendly Support</h3>
							<p>After purchasing premium version, you can get our top-notch support from a highly expert support team. We normally replied your support message within average 1-2 hours. A fully dedicated 24/7 Expert Support Team is always ready to help you instantly whenever you face any issues to configure or use the plugin.</p>
						</div>
					</div>
				</div>
			</div>

			<div class="sp-wps-upgrade-sticky-footer sp-wps-text-center">
				<p><a href="https://shapedplugin.com/demo/woocommerce-product-slider-pro/" target="_blank" class="button button-primary">Live Demo</a> <a href="https://shapedplugin.com/plugin/woocommerce-product-slider-pro/" target="_blank" class="button button-primary">Upgrade Now</a></p>
			</div>

		</div>
		<?php
	}

	/**
	 * Review Text
	 *
	 * @param $text
	 *
	 * @return string
	 */
	public function admin_footer( $text ) {
		if ( 'sp_wps_shortcodes' == get_post_type() ) {
			$url  = 'https://wordpress.org/support/plugin/woo-product-slider/reviews/?filter=5#new-post';
			$text = sprintf( __( 'If you like <strong>Product Slider for WooCommerce</strong> please leave us a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more. ', 'woo-product-slider' ), $url );
		}

		return $text;
	}

}

new SP_Woo_Product_Slider_Functions();
