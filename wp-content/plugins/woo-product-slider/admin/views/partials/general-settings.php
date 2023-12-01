<?php
/**
 * Provides the 'Resources' view for the corresponding tab in the Shortcode Meta Box.
 *
 * @since 2.0
 *
 * @package    woo-product-slider
 */
?>

<div id="sp-wps-tab-1" class="sp-wps-mbf-tab-content nav-tab-active">

	<?php
	$this->metaboxform->select_slider_type(
		array(
			'id'      => 'wps_slider_type',
			'name'    => __( 'Slider Type', 'woo-product-slider' ),
			'desc'    => __( 'Select which type of slider you want to show', 'woo-product-slider' ),
			'default' => 'product_slider',
		)
	);
	$this->metaboxform->layout(
		array(
			'id'      => 'wps_layout',
			'name'    => __( 'Layout Preset', 'woo-product-slider' ),
			'desc'    => __( 'Choose a layout preset.', 'woo-product-slider' ),
			'options' => array(
				'slider' => SP_WPS_URL . 'admin/assets/images/slider.jpg',
				'grid'   => SP_WPS_URL . 'admin/assets/images/grid.png',
			),
			'default' => 'slider',
		)
	);
	$this->metaboxform->select(
		array(
			'id'      => 'wps_themes',
			'name'    => __( 'Select Theme', 'woo-product-slider' ),
			'desc'    => __( 'Select which theme style you want to display. Browse themes <a href="https://shapedplugin.com/demo/woocommerce-product-slider-pro/" target="_blank">demo</a> in action!', 'woo-product-slider' ),
			'options' => array(
				'theme_one'   => __( 'Theme One', 'woo-product-slider' ),
				'theme_two'   => __( 'Theme Two', 'woo-product-slider' ),
				'theme_three' => __( 'Theme Three', 'woo-product-slider' ),
			),
			'default' => 'theme_one',
		)
	);
	$this->metaboxform->select_products_from(
		array(
			'id'      => 'wps_products_from',
			'name'    => __( 'Filter Products', 'woo-product-slider' ),
			'desc'    => __( 'Select an option to filter the products.', 'woo-product-slider' ),
			'default' => 'latest',
		)
	);

	$this->metaboxform->number(
		array(
			'id'      => 'wps_number_of_column',
			'name'    => __( 'Column(s) in Desktop', 'woo-product-slider' ),
			'desc'    => __( 'Set number of column(s) in desktop for the screen larger than 1100px.', 'woo-product-slider' ),
			'default' => 4,
		)
	);
	$this->metaboxform->number(
		array(
			'id'      => 'wps_number_of_column_desktop',
			'name'    => __( 'Column(s) in Small Desktop', 'woo-product-slider' ),
			'desc'    => __( 'Set number of column(s) in small desktop for the screen smaller than 1100px.', 'woo-product-slider' ),
			'default' => 3,
		)
	);
	$this->metaboxform->number(
		array(
			'id'      => 'wps_number_of_column_tablet',
			'name'    => __( 'Column(s) in Tablet', 'woo-product-slider' ),
			'desc'    => __( 'Set number of column(s) in tablet for the screen smaller than 990px.', 'woo-product-slider' ),
			'default' => 2,
		)
	);
	$this->metaboxform->number(
		array(
			'id'      => 'wps_number_of_column_mobile',
			'name'    => __( 'Column(s) in Mobile', 'woo-product-slider' ),
			'desc'    => __( 'Set number of column(s) in mobile for the screen smaller than 650px.', 'woo-product-slider' ),
			'default' => 1,
		)
	);
	$this->metaboxform->number(
		array(
			'id'      => 'wps_number_of_total_products',
			'name'    => __( 'Total Products to Show', 'woo-product-slider' ),
			'desc'    => __( 'Set number of total products to show.', 'woo-product-slider' ),
			'default' => 12,
		)
	);
	$this->metaboxform->select(
		array(
			'id'      => 'wps_order_by',
			'name'    => __( 'Order By', 'woo-product-slider' ),
			'desc'    => __( 'Select an order by option.', 'woo-product-slider' ),
			'options' => array(
				'ID'       => __( 'ID', 'woo-product-slider' ),
				'date'     => __( 'Date', 'woo-product-slider' ),
				'title'    => __( 'Title', 'woo-product-slider' ),
				'rand'     => __( 'Random', 'woo-product-slider' ),
				'modified' => __( 'Modified', 'woo-product-slider' ),
			),
			'default' => 'date',
		)
	);
	$this->metaboxform->select(
		array(
			'id'      => 'wps_order',
			'name'    => __( 'Order', 'woo-product-slider' ),
			'desc'    => __( 'Select an order option', 'woo-product-slider' ),
			'options' => array(
				'ASC'  => __( 'Ascending', 'woo-product-slider' ),
				'DESC' => __( 'Descending', 'woo-product-slider' ),
			),
			'default' => 'DESC',
		)
	);

	?>

</div>
