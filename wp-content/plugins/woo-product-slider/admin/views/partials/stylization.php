<?php
/**
 * Provides the 'Resources' view for the corresponding tab in the Shortcode Meta Box.
 *
 * @since 2.0
 *
 * @package    woo-product-slider
 */
?>
<div id="sp-wps-tab-3" class="sp-wps-mbf-tab-content">
	<?php
	$this->metaboxform->checkbox(
		array(
			'id'      => 'wps_slider_title',
			'name'    => __( 'Slider Section Title', 'woo-product-slider' ),
			'desc'    => __( 'Show/Hide slider section title.', 'woo-product-slider' ),
			'default' => 'off',
		)
	);
	$this->metaboxform->number(
		array(
			'id'      => 'wps_slider_title_font_size',
			'name'    => __( 'Section Title Font Size', 'woo-product-slider' ),
			'desc'    => __( 'Set slider section title font size.', 'woo-product-slider' ),
			'after'   => __( '(px)', 'woo-product-slider' ),
			'default' => '22',
		)
	);
	$this->metaboxform->color(
		array(
			'id'      => 'wps_slider_title_color',
			'name'    => __( 'Section Title Color', 'woo-product-slider' ),
			'desc'    => __( 'Set slider section title color.', 'woo-product-slider' ),
			'default' => '#444444',
		)
	);
	echo '<div class="sp-wps-element sp-field-subheading">Product Name</div>',
	$this->metaboxform->checkbox(
		array(
			'id'      => 'wps_product_name',
			'name'    => __( 'Name', 'woo-product-slider' ),
			'desc'    => __( 'Check to show product name.', 'woo-product-slider' ),
			'default' => 'on',
		)
	);
	$this->metaboxform->number(
		array(
			'id'      => 'wps_product_name_font_size',
			'name'    => __( 'Font Size', 'woo-product-slider' ),
			'desc'    => __( 'Set product name font size.', 'woo-product-slider' ),
			'after'   => __( '(px)', 'woo-product-slider' ),
			'default' => '15',
		)
	);
	$this->metaboxform->color(
		array(
			'id'      => 'wps_product_name_color',
			'name'    => __( 'Color', 'woo-product-slider' ),
			'desc'    => __( 'Set product name color.', 'woo-product-slider' ),
			'default' => '#444444',
		)
	);
	$this->metaboxform->color(
		array(
			'id'      => 'wps_product_name_hover_color',
			'name'    => __( 'Hover Color', 'woo-product-slider' ),
			'desc'    => __( 'Set product name hover color.', 'woo-product-slider' ),
			'default' => '#444444',
		)
	);
	echo '<div class="sp-wps-element sp-field-subheading">Product Price</div>',
	$this->metaboxform->checkbox(
		array(
			'id'      => 'wps_product_price',
			'name'    => __( 'Price', 'woo-product-slider' ),
			'desc'    => __( 'Check to show product price', 'woo-product-slider' ),
			'default' => 'on',
		)
	);
	$this->metaboxform->color(
		array(
			'id'      => 'wps_price_color',
			'name'    => __( 'Color', 'woo-product-slider' ),
			'desc'    => __( 'Set product price color.', 'woo-product-slider' ),
			'default' => '#222222',
		)
	);
	$this->metaboxform->color(
		array(
			'id'      => 'wps_discount_price_color',
			'name'    => __( 'Discount Color', 'woo-product-slider' ),
			'desc'    => __( 'Set discount price color.', 'woo-product-slider' ),
			'default' => '#888888',
		)
	);
	echo '<div class="sp-wps-element sp-field-subheading">Product Rating</div>',
	$this->metaboxform->checkbox(
		array(
			'id'      => 'wps_product_rating',
			'name'    => __( 'Rating', 'woo-product-slider' ),
			'desc'    => __( 'Check to show product rating.', 'woo-product-slider' ),
			'default' => 'on',
		)
	);
	echo '<div class="sp-wps-element sp-field-subheading">Add to Cart Button</div>',
	$this->metaboxform->checkbox(
		array(
			'id'      => 'wps_add_to_cart',
			'name'    => __( 'Add to Cart Button', 'woo-product-slider' ),
			'desc'    => __( 'Check to show product add to cart button.', 'woo-product-slider' ),
			'default' => 'on',
		)
	);
	$this->metaboxform->color(
		array(
			'id'      => 'wps_add_to_cart_color',
			'name'    => __( 'Color', 'woo-product-slider' ),
			'desc'    => __( 'Set product add to cart button color.', 'woo-product-slider' ),
			'default' => '#444444',
		)
	);
	$this->metaboxform->color(
		array(
			'id'      => 'wps_add_to_cart_hover_color',
			'name'    => __( 'Hover Color', 'woo-product-slider' ),
			'desc'    => __( 'Set add to cart button hover color.', 'woo-product-slider' ),
			'default' => '#ffffff',
		)
	);
	$this->metaboxform->color(
		array(
			'id'      => 'wps_add_to_cart_bg',
			'name'    => __( 'Background', 'woo-product-slider' ),
			'desc'    => __( 'Set add to cart button background color.', 'woo-product-slider' ),
			'default' => 'transparent',
		)
	);
	$this->metaboxform->color(
		array(
			'id'      => 'wps_add_to_cart_hover_bg',
			'name'    => __( 'Hover Background', 'woo-product-slider' ),
			'desc'    => __( 'Set add to cart button hover background color.', 'woo-product-slider' ),
			'default' => '#222222',
		)
	);
	$this->metaboxform->color(
		array(
			'id'      => 'wps_add_to_cart_border_color',
			'name'    => __( 'Border Color', 'woo-product-slider' ),
			'desc'    => __( 'Set add to cart button border color.', 'woo-product-slider' ),
			'default' => '#222222',
		)
	);
	$this->metaboxform->color(
		array(
			'id'      => 'wps_add_to_cart_border_hover_color',
			'name'    => __( 'Border Hover Color', 'woo-product-slider' ),
			'desc'    => __( 'Set add to cart button border hover color.', 'woo-product-slider' ),
			'default' => '#222222',
		)
	);
	?>
</div>
