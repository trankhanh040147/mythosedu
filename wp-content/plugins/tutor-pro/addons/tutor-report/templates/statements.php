<?php
/**
 * Statements template
 *
 * @since 1.9.9
 */

use Tutor\Models\CourseModel;
use TUTOR_REPORT\Analytics;

global $wp_query, $wp;
$user     = wp_get_current_user();
$paged    = 1;
$url      = home_url( $wp->request );
$url_path = parse_url( $url, PHP_URL_PATH );
$basename = pathinfo( $url_path, PATHINFO_BASENAME );

if ( isset( $_GET['current_page'] ) && is_numeric( $_GET['current_page'] ) ) {
	$paged = $_GET['current_page'];
} else {
	is_numeric( $basename ) ? $paged = $basename : '';
}
$per_page = tutor_utils()->get_option( 'pagination_per_page' );
$offset   = ( $per_page * $paged ) - $per_page;

$course_id   = isset( $_GET['course-id'] ) ? $_GET['course-id'] : '';
$date_filter = isset( $_GET['date'] ) && $_GET['date'] != '' ? tutor_get_formated_date( 'Y-m-d', $_GET['date'] ) : '';

$statements = Analytics::get_statements_by_user( $user->ID, $offset, $per_page, $course_id, $date_filter );
$courses    = CourseModel::get_courses_by_instructor();
?>
<div class="tutor-analytics-statements">
	<div class="tutor-row tutor-gx-xl-5 tutor-mb-24">
		<div class="tutor-col-lg-8 tutor-mb-16 tutor-mb-lg-0">
			<label class="tutor-form-label">
				<?php _e( 'Courses', 'tutor-pro' ); ?>
			</label>
			<select class="tutor-form-select tutor-report-category tutor-announcement-course-sorting">
				<option value=""><?php _e( 'All', 'tutor-pro' ); ?></option>
				<?php if ( $courses ) : ?>
					<?php foreach ( $courses as $course ) : ?>
						<option value="<?php echo esc_attr( $course->ID ); ?>" <?php selected( $course_id, $course->ID, 'selected' ); ?>>
							<?php echo $course->post_title; ?>
						</option>
					<?php endforeach; ?>
				<?php else : ?>
					<option value=""><?php _e( 'No course found', 'tutor-pro' ); ?></option>
				<?php endif; ?>
			</select>
		</div>

		<div class="tutor-col-lg-4">
			<label class="tutor-form-label"><?php esc_html_e( 'Date', 'tutor-pro' ); ?></label>
			<div class="tutor-v2-date-picker"></div>
		</div>
	</div>

	<?php if ( count( $statements['statements'] ) ) : ?>
		<div class="tutor-table-responsive">
			<table class="tutor-table tutor-table-analytics-statement">
				<thead>
					<th>
						<?php _e( 'Statement Info', 'tutor-pro' ); ?>
					</th>
					<th>
						<?php _e( 'Earning(%)', 'tutor-pro' ); ?>
					</th>
					<th>
						<?php _e( 'Commission(%)', 'tutor-pro' ); ?>
					</th>
					<th>
						<?php _e( 'Fees', 'tutor-pro' ); ?>
					</th>
				</thead>

				<tbody>
					<?php foreach ( $statements['statements'] as $statement ) : ?>
						<?php
							$order = function_exists( 'wc_get_order' ) ? wc_get_order( $statement->order_id ) : false;
							if ( ! $order ) {
								continue;
							}
							$customer = $order->get_user();
						?>
						<tr>
							<td>
								<div class="td-statement-info">
									<div class="tutor-d-flex tutor-align-center">
										<span class="tutor-badge-label label-<?php esc_attr_e( $statement->order_status == 'completed' ? 'success' : $statement->order_status ); ?>">
											<?php esc_html_e( ucfirst( $statement->order_status ) ); ?>
										</span>
										<span class="tutor-fs-7 tutor-color-secondary tutor-ml-16">
											<?php esc_html_e( tutor_get_formated_date( get_option( 'date_format' ), $statement->created_at ) ); ?>
										</span>
									</div>

									<div class="tutor-mt-8">
										<?php esc_html_e( $statement->course_title ); ?>
									</div>

									<div class="tutor-meta tutor-mt-8">
										<span>
											<span class="tutor-meta-key"><?php _e("Order ID: #", "tutor-pro"); ?></span>
											<span class="tutor-meta-value"><?php esc_html_e( $statement->order_id ); ?></span>
										</span>

										<?php if ( is_a( $customer, 'WP_User' ) ) : ?>
										<span>
											<span class="tutor-meta-key"><?php _e("Purchaser:", "tutor-pro"); ?></span>
											<span class="tutor-meta-value"><?php echo esc_html( $customer->display_name == '' ? $customer->user_nicename : $customer->display_name ); ?></span>
										</span>
										<?php endif; ?>
									</div>
								</div>
							</td>

							<td>
								<?php $instructor_commission_type = $statement->commission_type === 'percent' ? '%' : ''; ?>
								<div class="tutor-fs-7 tutor-fw-medium tutor-color-black">
									<?php echo tutor_utils()->tutor_price( $statement->course_price_total ); ?> <br />
									<span class="tutor-fs-7 tutor-color-muted">
										<?php esc_html_e( 'As per ' . $statement->instructor_rate . $instructor_commission_type, 'tutor-pro' ); ?>
									</span>
								</div>
							</td>

							<td>
								<?php $admin_rate_type = $statement->commission_type === 'percent' ? '%' : ''; ?>
								<div class="tutor-fs-7 tutor-fw-medium tutor-color-black">
									<?php echo tutor_utils()->tutor_price( $statement->admin_amount ); ?> <br />
									<span class="tutor-fs-7 tutor-color-muted">
										<?php esc_html_e( 'As per ' . $statement->admin_rate . $admin_rate_type, 'tutor-pro' ); ?>
									</span>
								</div>
							</td>

							<td>
								<?php $service_rate_type = $statement->deduct_fees_type === 'percent' ? '%' : ''; ?>
								<div class="tutor-fs-7 tutor-fw-medium tutor-color-black">
									<?php echo tutor_utils()->tutor_price( $statement->deduct_fees_amount ); ?> <br />
									<span class="tutor-fs-7 tutor-color-muted">
										<?php esc_html_e( $statement->deduct_fees_name, 'tutor-pro' ); ?>
										<?php _e( 'Maintenance Fees', 'tutor-pro' ); ?>
									</span>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<?php
			if($statements['total_statements'] > $per_page) {
				$pagination_data = array(
					'total_items' => $statements['total_statements'],
					'per_page'    => $per_page,
					'paged'       => $paged,
				);
				tutor_load_template_from_custom_path(
					tutor()->path . 'templates/dashboard/elements/pagination.php',
					$pagination_data
				);
			}
		?>
	<?php else : ?>
		<?php tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() ); ?>
	<?php endif; ?>
</div>