<?php
/**
 * The header for the theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tutor_Starter
 */

defined( 'ABSPATH' ) || exit;

wp_enqueue_script('game_plus_js2', get_template_directory_uri() . '/assets/dist/js/dragAndDrop.js', array(), '1.3', false);
wp_enqueue_script('game_plus_js2', get_template_directory_uri() . '/assets/dist/js/jquery-3.6.0.min.js', array(), '1.3', false);
$page_meta           = get_post_meta( get_the_ID(), '_tutorstarter_page_metadata', true );
$disable_header      = ( ! empty( $page_meta['header_toggle'] ) ? $page_meta['header_toggle'] : false );
$trans_header_toggle = ( ! empty( $page_meta['header_trans_toggle'] ) ? $page_meta['header_trans_toggle'] : false );

?>
