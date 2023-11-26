<?php
/**
 * Statements template
 *
 * @since 1.9.9
 */
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
$courses    = tutor_utils()->get_courses_by_instructor();
?>
<div class="tutor-analytics-statements">
	<div class="tutor-d-lg-flex tutor-justify-between">
		<div class="tutor-form-group tutor-mb-2 tutor-mb-lg-0">
			<label for="" class="tutor-form-label">
				<?php _e( 'Courses', 'tutor-pro' ); ?>
			</label>
			<select class="tutor-form-select tutor-report-category tutor-announcement-course-sorting ignore-nice-select">

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
		<div class="tutor-form-group tutor-ml-44">
			<label class="tutor-form-label"><?php esc_html_e( 'Date', 'tutor-pro' ); ?></label>
			<div class="tutor-v2-date-picker"></div>
		</div>

	</div>

	<div class="statements-wrapper tutor-mt-24 tutor-mb-40">
		<div class="tutor-table-wrapper">
			<table class="tutor-table tutor-table-responsive tutor-table-analytics-statement">
				<thead>
					<th>
						<div class="tutor-color-secondary tutor-fs-7">
							<?php _e( 'Statement Info', 'tutor-pro' ); ?>
						</div>
					</th>
					<th>
						<div class="tutor-color-secondary tutor-fs-7">
							<?php _e( 'Earning(%)', 'tutor-pro' ); ?>
						</div>
					</th>
					<th>
						<div class="tutor-color-secondary tutor-fs-7">
							<?php _e( 'Commission(%)', 'tutor-pro' ); ?>
						</div>
					</th>
					<th>
						<div class="tutor-color-secondary tutor-fs-7">
							<?php _e( 'Fees', 'tutor-pro' ); ?>
						</div>
					</th>
				</thead>
				<tbody>
					<?php if ( count( $statements['statements'] ) ) : ?>
						<?php foreach ( $statements['statements'] as $statement ) : ?>
							<?php
								$order = wc_get_order( $statement->order_id );
							if ( ! $order ) {
								continue;
							}
								$customer = $order->get_user();
							?>
							<tr>
								<td data-th="<?php _e( 'Statement Info', 'tutor-pro' ); ?>">
									<div class="td-statement-info">
										<div class="meta-data-1 tutor-d-inline-flex tutor-align-center">
											<span class="tutor-badge-label label-<?php esc_attr_e( $statement->order_status == 'completed' ? 'success' : $statement->order_status ); ?>">
												<?php esc_html_e( ucfirst( $statement->order_status ) ); ?></span>
											<span class="tutor-fs-7 tutor-color-black">
												<?php esc_html_e( tutor_get_formated_date( get_option( 'date_format' ), $statement->created_at ) ); ?>
											</span>
										</div>
										<div class="meta-data-2  tutor-fs-6 tutor-fw-medium  tutor-color-black">
											<?php esc_html_e( $statement->course_title ); ?>
										</div>
										<div class="meta-data-3 tutor-d-inline-flex tutor-align-center tutor-fs-7 tutor-color-secondary">
											<div class="tutor-d-inline-flex tutor-align-center">
												<span class="tutor-mr-12">
													Order ID: #<span class="tutor-fw-medium"><?php esc_html_e( $statement->order_id ); ?></span>
												</span>
												<span>
													<?php esc_html_e( 'Purchaser:', 'tutor-pro' ); ?> 
													<span class="tutor-fw-medium">
														<?php
															if ( is_a( $customer, 'WP_User' ) ) {
																echo esc_html( 'Purchaser: ' . $customer->display_name == '' ?$customer->user_nicename : $customer->display_name );
															}
														?>
													</span>
												</span>
											</div>
										</div>
									</div>
								</td>
								<td data-th="<?php _e( 'Earning(%)', 'tutor-pro' ); ?>">
									<?php
										$instructor_commission_type = $statement->commission_type === 'percent' ? '%' : '';
									?>
									<div class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php echo tutor_utils()->tutor_price( $statement->course_price_total ); ?> <br />
										<span class="tutor-fs-7 tutor-color-muted">
											<?php esc_html_e( 'As per ' . $statement->instructor_rate . $instructor_commission_type, 'tutor-pro' ); ?>
										</span>
									</div>
								</td>
								<td data-th="<?php _e( 'Commission(%)', 'tutor-pro' ); ?>">
									<?php
										 $admin_rate_type = $statement->commission_type === 'percent' ? '%' : '';
									?>
									<div class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php echo tutor_utils()->tutor_price( $statement->admin_amount ); ?> <br />
										<span class="tutor-fs-7 tutor-color-muted">
											<?php esc_html_e( 'As per ' . $statement->admin_rate . $admin_rate_type, 'tutor-pro' ); ?>
										</span>
									</div>
								</td>
								<td data-th="<?php _e( 'Frees', 'tutor-pro' ); ?>">
									<?php
										$service_rate_type = $statement->deduct_fees_type === 'percent' ? '%' : '';
									?>
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
					<?php else : ?>
						<tr>
						<td colspan="100%" class="tutor-empty-state">
                        	<?php tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() ); ?>
                    	</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="tutor-mt-20">
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
	</div>
</div>
