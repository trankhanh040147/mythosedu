<?php
/**
 * This file render the shortcode to the frontend
 * @package woo-product-slider
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product Slider for WooCommerce - Shortcode Render class
 * @since 1.0
 */
if ( ! class_exists( 'SP_WPS_Shortcode_Render_Dep' ) ) {
	class SP_WPS_Shortcode_Render_Dep {
		/**
		 * @var SP_WPS_Shortcode_Render_Dep single instance of the class
		 *
		 * @since 1.0
		 */
		protected static $_instance = null;


		/**
		 * Main SP_WPS Instance
		 *
		 * @since 1.0
		 * @static
		 * @return self Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * SP_WPS_Shortcode_Render constructor.
		 */
		public function __construct() {
			add_shortcode( 'woo-product-slider', array( $this, 'sp_woo_product_slider_old_shortcode' ) );
		}

		// old shortcode.
		function sp_woo_product_slider_old_shortcode( $atts ) {
			extract( shortcode_atts( array(
				'id'            => '01',
				'title'         => '',
				'color'         => '#e74c3c',
				'pagination'    => 'true',
				'nav'           => 'true',
				'auto_play'     => 'true',
				'items'         => '4',
				'stop_on_hover' => 'true',
				'rating'        => 'true',
			), $atts, 'woo-product-slider' ) );

			$args = array(
				'post_type'           => 'product',
				'post_status'         => 'publish',
				'posts_per_page'      => 12,
			);
			$que = new WP_Query( $args );

			$outline = '';

			$outline .= '<style>
			div#sp-woo-product-slider-free' . $id . '.wpsf-product-section .slick-arrow:hover,
			div.wpsf-slider-section .wpsf-cart-button a:hover,
			div#sp-woo-product-slider-free' . $id . '.wpsf-product-section ul.slick-dots li button{background-color: ' . $color . '; border-color: ' . $color . '; color: #fff; }
			div.wpsf-slider-section .wpsf-product-title a:hover{
				color: ' . $color . ';
			}
			</style>';

			$outline .= '
			<script type="text/javascript">
					jQuery(document).ready(function() {
					jQuery("#sp-woo-product-slider-free' . $id . '").slick({
						infinite: true,
						dots: ' . $pagination . ',
						pauseOnHover: ' . $stop_on_hover . ',
						slidesToShow: ' . $items . ',
						slidesToScroll: 1,
						autoplay: ' . $auto_play . ',
						arrows: ' . $nav . ',
						prevArrow: "<div class=\'slick-prev\'><i class=\'fa fa-angle-left\'></i></div>",
						nextArrow: "<div class=\'slick-next\'><i class=\'fa fa-angle-right\'></i></div>",
						responsive: [
								{
								breakpoint: 1000,
								settings: {
									slidesToShow: 3
								}
								},
								{
								breakpoint: 700,
								settings: {
									slidesToShow: 2
								}
								},
								{
								breakpoint: 460,
								settings: {
									slidesToShow: 1
								}
								}
							]
					});

				});
			</script>';

			wp_enqueue_style( 'sp-wps-slick' );
			wp_enqueue_style( 'sp-wps-font-awesome' );
			wp_enqueue_style( 'sp-wps-style-dep' );

			wp_enqueue_script( 'sp-wps-slick-min-js' );

			$outline .= '<div class="wpsf-slider-section">';
			if ( $title !== "" ) {
				$outline .= '<h2 class="wpsf-section-title">' . $title . '</h2>';
			}

			$outline .= '<div id="sp-woo-product-slider-free' . $id . '" class="wpsf-product-section">';

			if ( $que->have_posts() ) {
				while ( $que->have_posts() ) : $que->the_post();
					global $product;

					$outline .= '<div class="wpsf-product">';
					$outline .= '<a href="' . esc_url( get_the_permalink() ) . '">';
					if ( has_post_thumbnail( $que->post->ID ) ) {
						$outline .= get_the_post_thumbnail( $que->post->ID, 'shop_catalog_image_size', array( 'class' => 'wpsf-product-img' ) );
					} else {
						$outline .= '<img id="place_holder_thm" src="' . wc_placeholder_img_src() . '" alt="Placeholder" />';
					}
					$outline .= '</a>';
					$outline .= '<div class="wpsf-product-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></div>';

					if ( class_exists( 'WooCommerce' ) && $price_html = $product->get_price_html() ) {
						$outline .= '<div class="wpsf-product-price">' . $price_html . '</div>';
					};

					if ( class_exists( 'WooCommerce' ) && $rating == 'true' ) {
						$average = $product->get_average_rating();
						if ( $average > 0 ) {
							$outline .= '<div class="star-rating" title="' . esc_html__( 'Rated', 'woo-product-slider' ) . ' ' . $average . '' . esc_html__( ' out of 5', 'woo-product-slider' ) . '"><span style="width:' . ( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">' . $average . '</strong> ' . esc_html__( 'out of 5', 'woo-product-slider' ) . '</span></div>';
						}
					}

					$outline .= '<div class="wpsf-cart-button">' . do_shortcode( '[add_to_cart id="' . get_the_ID() . '"]' ) . '</div>';
					$outline .= '</div>';

				endwhile;
			} else {
				$outline .= '<h2 class="sp-not-found-any-product-f">' . __( 'No products found', 'woo-product-slider' ) . '</h2>';
			}
			$outline .= '</div>';
			$outline .= '</div>';

			wp_reset_query();

			return $outline;

		}

	}
}

new SP_WPS_Shortcode_Render_Dep();
