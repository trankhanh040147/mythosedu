<?php
/**
 * Certificate list template
 *
 * @package  Tutor\Certificate\Builder
 * @author   Themeum <support@themeum.com>
 * @license  GPLv2 or later
 * @link     https://www.themeum.com/product/tutor-lms/
 * @since    1.0.0
 */

use Tutor\Certificate\Builder\Admin\Certificate_List;
use Tutor\Certificate\Builder\Plugin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$certificates = new Certificate_List();
$certificates->prepare_items();
?>

<div class="wrap">
	<h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<a href="<?php echo esc_url( apply_filters( 'tutor_certificate_builder_url', null) ); ?>" class="page-title-action">
		<i class="tutor-icon-plus"></i> <?php esc_html_e( 'Add New', 'tutor-lms-certificate-builder' ); ?>
	</a>

	<hr class="wp-header-end">

	<form id="certificates-filter" method="get">
		<input type="hidden" name="page" value="<?php echo esc_attr( wp_unslash( $_REQUEST['page'] ) ); ?>" />
		<?php
		$certificates->search_box( __( 'Search', 'tutor-lms-certificate-builder' ), 'certificates' );
		$certificates->display();
		?>
	</form>
</div>
