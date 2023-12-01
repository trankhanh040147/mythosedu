<?php
/**
 * This file is to display typography.
 *
 * @package woo-product-slider
 */
?>

<div id="sp-wps-tab-4" class="sp-wps-mbf-tab-content sp-wps-mbf-tab-typography">

	<div class="sp-wpspro-notice">These Typography (840+ Google Fonts) options are available in the <b><a href="https://shapedplugin.com/plugin/woocommerce-product-slider-pro/" target="_blank">Pro Version</a></b>!</div>
	<?php
	$this->metaboxform->typography_type(
		array(
			'id'   => 'wps_slider_title_font',
			'name' => __( 'Slider Section Title Font', 'woo-product-slider' ),
			'desc' => __( 'Set slider section title font properties.', 'woo-product-slider' ),
		)
	);
	$this->metaboxform->typography_type(
		array(
			'id'   => 'wps_product_name_font',
			'name' => __( 'Product Name Font', 'woo-product-slider' ),
			'desc' => __( 'Set product name font properties.', 'woo-product-slider' ),
		)
	);
	$this->metaboxform->typography_type(
		array(
			'id'   => 'wps_product_description_font',
			'name' => __( 'Product Description Font', 'woo-product-slider' ),
			'desc' => __( 'Set product description font properties.', 'woo-product-slider' ),
		)
	);
	$this->metaboxform->typography_type(
		array(
			'id'   => 'wps_product_price_font',
			'name' => __( 'Product Price Font', 'woo-product-slider' ),
			'desc' => __( 'Set product price font properties.', 'woo-product-slider' ),
		)
	);
	$this->metaboxform->typography_type(
		array(
			'id'   => 'wps_sale_ribbon_font',
			'name' => __( 'Sale Ribbon Font', 'woo-product-slider' ),
			'desc' => __( 'Set product sale ribbon font properties.', 'woo-product-slider' ),
		)
	);
	$this->metaboxform->typography_type(
		array(
			'id'   => 'wps_out_of_stock_ribbon_font',
			'name' => __( 'Out of Stock Ribbon Font', 'woo-product-slider' ),
			'desc' => __( 'Set product out of stock ribbon font properties.', 'woo-product-slider' ),
		)
	);
	$this->metaboxform->typography_type(
		array(
			'id'   => 'wps_product_category_font',
			'name' => __( 'Product Category Font', 'woo-product-slider' ),
			'desc' => __( 'Set product category font properties.', 'woo-product-slider' ),
		)
	);
	$this->metaboxform->typography_type(
		array(
			'id'   => 'wps_compare_font',
			'name' => __( 'Compare & Wishlist Font', 'woo-product-slider' ),
			'desc' => __( 'Set compare and wishlist font properties.', 'woo-product-slider' ),
		)
	);
	$this->metaboxform->typography_type(
		array(
			'id'   => 'wps_add_to_cart_font',
			'name' => __( 'Add to Cart & View Details Font', 'woo-product-slider' ),
			'desc' => __( 'Set add to cart and view details font properties.', 'woo-product-slider' ),
		)
	);
	?>
</div>
