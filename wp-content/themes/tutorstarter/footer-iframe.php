<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tutor_Starter
 */

defined( 'ABSPATH' ) || exit;
?>



<?php 
wp_enqueue_script('game_plus_js2', get_template_directory_uri() . '/assets/dist/js/dragAndDrop.js', array(), '1.3', false);
wp_enqueue_script('game_plus_js2', get_template_directory_uri() . '/assets/dist/js/jquery-3.6.0.min.js', array(), '1.3', false);?>
</body>
</html>
