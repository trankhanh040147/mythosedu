<?php
/**
 * Enrolment List Template.
 *
 * @package Enrolment List
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use TUTOR_ENROLLMENTS\Enrollments_List;
$enrollments = new Enrollments_List();

/**
 * Short able params
 */
$course_id = isset( $_GET['course-id'] ) ? $_GET['course-id'] : '';
$order     = isset( $_GET['order'] ) ? $_GET['order'] : 'DESC';
$date      = isset( $_GET['date'] ) ? tutor_get_formated_date( 'Y-m-d', $_GET['date'] ) : '';
$search    = isset( $_GET['search'] ) ? $_GET['search'] : '';

/**
 * Determine active tab
 */
$active_tab = isset( $_GET['data'] ) && $_GET['data'] !== '' ? esc_html__( $_GET['data'] ) : 'all';

/**
 * Pagination data
 */
$paged    = ( isset( $_GET['paged'] ) && is_numeric( $_GET['paged'] ) && $_GET['paged'] >= 1 ) ? $_GET['paged'] : 1;
$per_page = tutor_utils()->get_option( 'pagination_per_page' );
$offset   = ( $per_page * $paged ) - $per_page;

$enrollments_list = tutor_utils()->get_enrolments( $active_tab, $offset, $per_page, $search, $course_id, $date, $order );
$total            = tutor_utils()->get_total_enrolments( $active_tab, $search, $course_id, $date );

/**
 * Navbar data to make nav menu
 */
$navbar_data = array(
	'page_title' => $enrollments->page_title,
	'tabs'       => $enrollments->tabs_key_value( $course_id, $date, $search ),
	'active'     => $active_tab,
	'add_button' => true,
	'button_title' => __( 'Enroll a student', 'tutor' ),
	'button_url'   => esc_url( admin_url( 'admin.php?page=enrollments&sub_page=enroll_student' ) ),
);

/**
 * Bulk action & filters
 */
// $filters = array(
// 'bulk_action'   => $enrollments->bulk_action,
// 'bulk_actions'  => $enrollments->prpare_bulk_actions(),
// 'search_filter' => true,
// );
$filters = array(
	'bulk_action'   => $enrollments->bulk_action,
	'bulk_actions'  => $enrollments->prpare_bulk_actions(),
	'ajax_action'   => 'tutor_enrollment_bulk_action',
	'filters'       => true,
	'course_filter' => true,
);

?>
<div class="tutor-admin-wrap">
	<?php
		/**
		 * Load Templates with data.
		 */
		$navbar_template  = tutor()->path . 'views/elements/navbar.php';
		$filters_template = tutor()->path . 'views/elements/filters.php';
		tutor_load_template_from_custom_path( $navbar_template, $navbar_data );
		tutor_load_template_from_custom_path( $filters_template, $filters );
	?>
	<div class="tutor-admin-body">
		<div class="tutor-admin-page-wrapper tutor-admin-enrollment-wrapper">
			<div class="tutor-mt-24">
				<div class="tutor-table-wrapper">
					<table class="tutor-table tutor-table-responsive tutor-table-with-checkbox">
						<thead class="tutor-text-sm tutor-text-400">
							<tr>
								<th style="width: 2%;">
									<div class="tutor-d-flex">
										<input type="checkbox" id="tutor-bulk-checkbox-all" class="tutor-form-check-input">
									</div>
								</th>
								<th>
									<div class="tutor-fs-7 tutor-color-secondary">
										<?php esc_html_e( 'Date', 'tutor-pro' ); ?>
									</div>
								</th>
								<th>
									<div class="tutor-fs-7 tutor-color-secondary">
										<?php esc_html_e( 'Course', 'tutor-pro' ); ?>
									</div>
								</th>
								<th class="tutor-table-rows-sorting">
									<div class="tutor-color-secondary">
										<span class="tutor-fs-7">
											<?php esc_html_e( 'Name', 'tutor-pro' ); ?>
										</span>
										<span class="a-to-z-sort-icon tutor-icon-ordering-a-z"></span>
									</div>
								</th>
								<th>
									<div class="tutor-fs-7 tutor-color-secondary">
										<?php esc_html_e( 'Status', 'tutor-pro' ); ?>
									</div>
								</th>
							</tr>
						</thead>
						<tbody class="tutor-text-500">
							<?php if ( is_array( $enrollments_list ) && count( $enrollments_list ) ) : ?>
								<?php
								foreach ( $enrollments_list as $list ) :
									$alert = '';
									if ( 'cancel' === $list->status || 'cancelled' === $list->status || 'canceled' === $list->status ) {
										$alert = 'danger';
									} elseif ( 'completed' === $list->status ) {
										$alert = 'success';
									} elseif ( 'processing' === $list->status ) {
										$alert = 'processing';
									} elseif ( 'on-hold' === $list->status || 'onhold' === $list->status ) {
										$alert = 'onhold';
									} else {
										$alert = 'default';
									}
									$translate_status  = __( 'Approved', 'tutor-pro' );
									$enrollment_status = 'completed' === $list->status ? $translate_status : tutor_utils()->translate_dynamic_text( $list->status );
									?>
									<tr>
										<td data-th="<?php _e('Checkbox', 'tutor-pro'); ?>">
											<div class="td-checkbox tutor-d-flex ">
												<input type="checkbox" class="tutor-form-check-input tutor-bulk-checkbox" name="tutor-bulk-checkbox-all" value="<?php echo esc_attr( $list->enrol_id ); ?>">
											</div>
										</td>
										<td data-th="<?php _e('Date', 'tutor-pro'); ?>">
											<div class="td-datetime tutor-fs-7 tutor-color-black">
												<?php esc_html_e( tutor_get_formated_date( get_option( 'date_format' ). ', ' . get_option( 'time_format' ),$list->enrol_date ) ); 
												?>
											</div>
										</td>
										<td data-th="<?php _e('Course', 'tutor-pro'); ?>">
											<div class="td-avatar">
												<div class="tutor-fs-6 tutor-fw-medium  tutor-color-black">
													<?php echo esc_html( $list->course_title ); ?>
												</div>
												<a href="<?php echo esc_url( get_permalink($list->course_id) ); ?>" class="tutor-iconic-btn" target="_blank">
													<span class="tutor-icon-external-link" area-hidden="true"></span>
												</a>
											</div>
										</td>
										<td data-th="<?php _e('Name', 'tutor-pro'); ?>">
											<div class="tutor-fs-7 tutor-color-black">
												<?php echo esc_html( $list->display_name ); ?>
											</div>
											<div class="tutor-fs-7 tutor-color-black">
												<?php echo esc_html( $list->user_email ); ?>
											</div>
										</td>
										<td data-th="<?php _e('Status', 'tutor-pro'); ?>">
											<span class="tutor-badge-label label-<?php echo esc_attr( $alert ); ?> tutor-m-4">
												<?php echo esc_html( $enrollment_status ); ?>
											</span>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="100%" class="column-empty-state">
										<?php tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() ); ?>
									</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="tutor-admin-page-pagination-wrapper tutor-mt-32">
				<?php
					/**
					 * Prepare pagination data & load template
					 */
					if($total > $per_page) {
						$pagination_data     = array(
							'total_items' => $total,
							'per_page'    => $per_page,
							'paged'       => $paged,
						);
						$pagination_template = tutor()->path . 'views/elements/pagination.php';
						tutor_load_template_from_custom_path( $pagination_template, $pagination_data );
					}
					?>
			</div>
		</div>
	</div>
</div>
