<?php
/**
 * Dynamic Style.
 *
 * @package    Woo_Product_Slider
 * @subpackage Woo_Product_Slider/public/views
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

$dynamic_style = '';
if ( 'true' == $wps_slider_title ) {
	$dynamic_style .= '
    div#wps-slider-section.wps-slider-section-' . $post_id . ' .sp-woo-product-slider-section-title{
        color: ' . $wps_slider_title_color . ';
        font-size: ' . $wps_slider_title_font_size . 'px;
    }';
}
if ( 'true' == $wps_show_pagination ) {
	$dynamic_style .= 'div#wps-slider-section #sp-woo-product-slider-' . $post_id . '.wps-product-section ul.slick-dots li button{
        background-color:' . $wps_pagination_color . ';
    }
    div#wps-slider-section #sp-woo-product-slider-' . $post_id . '.wps-product-section ul.slick-dots li.slick-active button{
        background-color:' . $wps_pagination_active_color . ';
    }';
}
if ( 'true' == $wps_show_navigation ) {
	$dynamic_style .= 'div#wps-slider-section #sp-woo-product-slider-' . $post_id . '.wps-product-section .slick-arrow{
        color:' . $wps_nav_arrow_color . ';
        background-color:' . $wps_nav_arrow_bg . ';
    }';
}
if ( 'true' == $wps_show_navigation && 'false' == $wps_slider_title ) {
	$dynamic_style .= '
    div#wps-slider-section.wps-slider-section-' . $post_id . '{
        padding-top: 45px;
    }';
}
if ( 'true' == $wps_product_name ) {
	$dynamic_style .= 'div#wps-slider-section #sp-woo-product-slider-' . $post_id . ' .wpsf-product-title a{
        color: ' . $wps_product_name_color . ';
        font-size: ' . $wps_product_name_font_size . 'px;
    }
    div#wps-slider-section #sp-woo-product-slider-' . $post_id . ' .wpsf-product-title a:hover{
        color: ' . $wps_product_name_hover_color . ';
    }';
}
if ( 'true' == $wps_product_price ) {
	$dynamic_style .= 'div#wps-slider-section #sp-woo-product-slider-' . $post_id . ' .wpsf-product-price{
        color: ' . $wps_price_color . ';
    }
    div#wps-slider-section #sp-woo-product-slider-' . $post_id . ' .wpsf-product-price del span{
        color: ' . $wps_discount_price_color . ';
    }';
}
if ( 'true' == $wps_add_to_cart ) {
	$dynamic_style .= 'div#wps-slider-section #sp-woo-product-slider-' . $post_id . ' .wpsf-cart-button a:not(.sp-wqvpro-view-button):not(.sp-wqv-view-button){
        color: ' . $wps_add_to_cart_color . ';
        background-color: ' . $wps_add_to_cart_bg . ';
        border-color: ' . $wps_add_to_cart_border_color . ';
    }
    div#wps-slider-section #sp-woo-product-slider-' . $post_id . ' .wpsf-cart-button a:not(.sp-wqvpro-view-button):not(.sp-wqv-view-button):hover,
    div#wps-slider-section #sp-woo-product-slider-' . $post_id . ' .wpsf-cart-button a.added_to_cart{
        color: ' . $wps_add_to_cart_hover_color . ';
        background-color: ' . $wps_add_to_cart_hover_bg . ';
        border-color: ' . $wps_add_to_cart_border_hover_color . ';
    }';
}

$output .= '<style type="text/css">' . $dynamic_style . '</style>';
