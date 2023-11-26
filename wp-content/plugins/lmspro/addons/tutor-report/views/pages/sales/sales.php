<?php
/**
 * Report sales list
 *
 * @package Report
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use TUTOR_REPORT\Report;

$course_id = isset( $_GET['course-id'] ) ? $_GET['course-id'] : '';
$order     = isset( $_GET['order'] ) ? $_GET['order'] : 'DESC';
$date      = isset( $_GET['date'] ) ? tutor_get_formated_date( 'Y-m-d', $_GET['date'] ) : '';
$search    = isset( $_GET['search'] ) ? $_GET['search'] : '';


$current_page  = ( isset( $_GET['paged'] ) && is_numeric( $_GET['paged'] ) && $_GET['paged'] >= 1 ) ? $_GET['paged'] : 1;
$item_per_page = tutor_utils()->get_option( 'pagination_per_page' );
$offset        = ( $item_per_page * $current_page ) - $item_per_page;

$sales_list  = Report::sales_list( $offset, $item_per_page, $course_id, $date, $order, $search );
$lists       = $sales_list['list'];
$total_items = $sales_list['total'];

$filters          = array(
	'bulk_action'   => false,
	'filters'       => true,
	'course_filter' => true,
);
$filters_template = tutor()->path . 'views/elements/filters.php';

?>

<div id="tutor-report-sales" class="tutor-report-common">
	<div class="tutor-mx-n20">
		<?php tutor_load_template_from_custom_path( $filters_template, $filters ); ?>
	</div>

	<div class="tutor-report-sales-data-table tutor-mt-24">
		<div class="tutor-table-wrapper">
			<table class="tutor-table tutor-table-responsive">
				<thead>
					<tr>
						<th>
							<span class="tutor-fs-7 tutor-color-secondary">
								<?php esc_html_e( 'Order ID', 'tutor-pro' ); ?>
							</span>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Course', 'tutor-pro' ); ?>
								</span>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Student', 'tutor-pro' ); ?>
								</span>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Date', 'tutor-pro' ); ?>
								</span>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Status', 'tutor-pro' ); ?>
								</span>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Price', 'tutor-pro' ); ?>
								</span>
							</div>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( is_array( $lists ) && count( $lists ) ) : ?>
						<?php foreach ( $lists as $report ) : ?>
							<?php
								$tutor_order = function_exists( 'wc_get_order' ) ? wc_get_order( $report->order_id ) : null;
								$instructor = get_post_field( 'post_author', $report->post_parent );
								$user_info  = get_userdata( $instructor );
								// $tutor_order->get_item_count()
								$price = is_object( $tutor_order ) ? $tutor_order->get_total() : 0;
								$alert = ( 'processing' == $report->post_status ? 'processing' : ( 'on-hold' == $report->post_status ? 'onhold' : ( 'completed' == $report->post_status ? 'success' : ( 'cancelled' == $report->post_status || 'canceled' == $report->post_status ? 'danger' : 'default' ) ) ) );
							?>
							<tr>
								<td data-th="<?php esc_html_e( 'Order ID', 'tutor-pro' ); ?>" class="order-id">
									<span class="tutor-fs-6 tutor-fw-medium  tutor-color-black">
									<?php echo esc_html( '#' . $report->order_id ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'Course', 'tutor-pro' ); ?>" class="course">
									<div class="tutor-d-flex tutor-align-center">
										<div class="tutor-fs-6 tutor-fw-medium tutor-color-black tutor-mr-12">
											<?php echo esc_html( get_the_title( $report->post_parent ) ); ?>
										</div>
										<a href="<?php echo esc_url( get_permalink( $report->post_parent ) ); ?>" class="tutor-iconic-btn" target="_blank">
											<span class="tutor-icon-external-link" area-hidden="true"></span>
										</a>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Student', 'tutor-pro' ); ?>" class="student">
									<div class="td-avatar">
										<?php echo tutor_utils()->get_tutor_avatar( $user_info->ID ); ?>
										<div class="tutor-fs-6 tutor-fw-medium tutor-color-black">
											<?php echo esc_html( $user_info->display_name ); ?>
										</div>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Date', 'tutor-pro' ); ?>" class="date">
									<span class="tutor-color-black tutor-fs-7 tutor-fw-medium">
										<?php echo esc_html( tutor_i18n_get_formated_date( $report->post_date, get_option( 'date_format' ) ) ); ?>,
										<?php echo esc_html( tutor_i18n_get_formated_date( $report->post_date, get_option( 'time_format' ) ) ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'Status', 'tutor-pro' ); ?>" class="status">
									<span class="tutor-badge-label label-<?php echo esc_attr( $alert ); ?> tutor-m-4">
										<?php echo esc_html( tutor_utils()->translate_dynamic_text( $report->post_status ) ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'Price', 'tutor-pro' ); ?>" class="price">
									<span class="tutor-color-black tutor-fs-7 tutor-fw-medium">
										<?php echo wp_kses_post( tutor_utils()->tutor_price( $price ) ); ?>
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
	<div class="tutor-report-sales-data-table-pagination tutor-report-content-common-pagination tutor-mt-32">
		<?php
			if($total_items > $item_per_page){
				$pagination_data = array(
					'base'        => str_replace( $current_page, '%#%', 'admin.php?page=tutor_report&sub_page=sales&paged=%#%' ),
					'total_items' => $total_items,
					'per_page'    => $item_per_page,
					'paged'       => $current_page,
				);
				tutor_load_template_from_custom_path( tutor()->path . 'views/elements/pagination.php', $pagination_data );
			}
		?>
	</div>
</div>