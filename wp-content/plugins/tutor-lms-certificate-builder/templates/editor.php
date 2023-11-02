<?php

/**
 * Certificate builder main template
 *
 * @package  Tutor\Certificate\Builder
 * @author   Themeum <support@themeum.com>
 * @license  GPLv2 or later
 * @link     https://www.themeum.com/product/tutor-lms/
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp_version;
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo esc_html_e( 'Certificate Builder', 'tutor-lms-certificate-builder' ) . ' | ' . get_the_title(); ?></title>
	<script>
		window.tutor_previous_url=<?php echo isset($_SERVER['HTTP_REFERER']) ? '"'.$_SERVER['HTTP_REFERER'].'"' : '"'.tutor_utils()->tutor_dashboard_url('certificate-builder').'"'; ?>;
	</script>
	<?php wp_head(); ?>
</head>

<body class="wp-version-<?php echo str_replace( '.', '-', $wp_version .' with-tutor-certificate-builder'); ?>">

	<div id="tutor-certificate-builder">
		<div id="tutor-certificate-builder-app"></div>
	</div>

	<?php
	wp_footer();
	do_action( 'admin_print_footer_scripts' );
	?>
</body>

</html>
