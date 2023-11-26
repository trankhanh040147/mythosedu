<?php
/**
 * Overview tempate
 *
 * @since 1.9.9
 */
use \TUTOR_REPORT\Analytics;

// global variables
$user        = wp_get_current_user();
$time_period = $active = isset( $_GET['period'] ) ? $_GET['period'] : '';
$start_date  = isset( $_GET['start_date'] ) ? sanitize_text_field( $_GET['start_date'] ) : '';
$end_date    = isset( $_GET['end_date'] ) ? sanitize_text_field( $_GET['end_date'] ) : '';
if ( '' !== $start_date ) {
	$start_date = tutor_get_formated_date( 'Y-m-d', $start_date );
}
if ( '' !== $end_date ) {
	$end_date = tutor_get_formated_date( 'Y-m-d', $end_date );
}
?>
<div class="tutor-analytics-overview">

	<?php
		/**
		 * Overview card info
		 *
		 * @since 1.9.9
		 */
		$card_template = TUTOR_REPORT()->path . 'templates/elements/box-card.php';
		$user          = wp_get_current_user();
		$data          = array(
			array(
				'icon'      => 'tutor-icon-mortarboard-o',
				'title'     => count( tutor_utils()->get_courses_by_instructor( $user->ID ) ),
				'sub_title' => __( 'Total Course', 'tutor-pro' ),
				'price'     => false,
			),
			array(
				'icon'      => 'tutor-icon-add-member',
				'title'     => tutor_utils()->get_total_students_by_instructor( $user->ID ),
				'sub_title' => __( 'Total Student', 'tutor-pro' ),
				'price'     => false,
			),
			array(
				'icon'      => 'tutor-icon-star-bold',
				'title'     => tutor_utils()->get_reviews_by_instructor( $user->ID )->count,
				'sub_title' => __( 'Reviews', 'tutor-pro' ),
				'price'     => false,
			),
		);

		tutor_load_template_from_custom_path( $card_template, $data );
		?>
	<!--filter buttons tabs-->
	<?php
		/**
		 * Prepare filter period buttons
		 *
		 * Array structure is required as below
		 *
		 * @since 1.9.8
		 */
		$filter_period = array(
			array(
				'url'   => esc_url( tutor_utils()->tutor_dashboard_url() . 'analytics?period=today' ),
				'title' => __( 'Today', 'tutor-pro' ),
				'class' => 'tutor-analytics-period-button',
				'type'  => 'today',
			),
			array(
				'url'   => esc_url( tutor_utils()->tutor_dashboard_url() . 'analytics?period=monthly' ),
				'title' => __( 'Monthly', 'tutor-pro' ),
				'class' => 'tutor-analytics-period-button',
				'type'  => 'monthly',
			),
			array(
				'url'   => esc_url( tutor_utils()->tutor_dashboard_url() . 'analytics?period=yearly' ),
				'title' => __( 'Yearly', 'tutor-pro' ),
				'class' => 'tutor-analytics-period-button',
				'type'  => 'yearly',
			),
		);

		/**
		 * Calendar date buttons
		 *
		 * Array structure is required as below
		 *
		 * @since 1.9.8
		 */

		$filter_period_calendar = array(
			'filter_period'   => $filter_period,
			'filter_calendar' => true,
		);

		$filter_period_calendar_template = TUTOR_REPORT()->path . 'templates/elements/period-calendar.php';
		tutor_load_template_from_custom_path( $filter_period_calendar_template, $filter_period_calendar );
	?>

	<?php
		/**
		 * Get analytics data
		 *
		 * @since 1.9.9
		 */
		$earnings      = Analytics::get_earnings_by_user( $user->ID, $time_period, $start_date, $end_date );
		$enrollments   = Analytics::get_total_students_by_user( $user->ID, $time_period, $start_date, $end_date );
		$discounts     = Analytics::get_discounts_by_user( $user->ID, $time_period, $start_date, $end_date );
		$refunds       = Analytics::get_refunds_by_user( $user->ID, $time_period, $start_date, $end_date );
		$content_title = '';

		if ( 'today' === $time_period ) {
			$day           = date( 'l' );
			$content_title = __( "for today ($day) ", 'tutor-pro' );
		} elseif ( 'monthly' === $time_period ) {
			$month         = date( 'F' );
			$content_title = __( "for this month ($month) ", 'tutor-pro' );
		} elseif ( 'yearly' === $time_period ) {
			$year          = date( 'Y' );
			$content_title = __( "for this year ($year) ", 'tutor-pro' );
		}

		$graph_tabs     = array(
			array(
				'tab_title'     => __( 'Total Earning', 'tutor-pro' ),
				'tab_value'     => $earnings['total_earnings'],
				'data_attr'     => 'ta_total_earnings',
				'active'        => ' is-active',
				'price'         => true,
				'content_title' => __( 'Earnings chart ' . $content_title, 'tutor-pro' ),
			),
			array(
				'tab_title'     => __( 'Course Enrolled', 'tutor-pro' ),
				'tab_value'     => $enrollments['total_enrollments'],
				'data_attr'     => 'ta_total_course_enrolled',
				'active'        => '',
				'price'         => false,
				'content_title' => __( 'Course enrolled Chart ' . $content_title, 'tutor-pro' ),
			),
			array(
				'tab_title'     => __( 'Total Refund', 'tutor-pro' ),
				'tab_value'     => $refunds['total_refunds'],
				'data_attr'     => 'ta_total_refund',
				'active'        => '',
				'price'         => true,
				'content_title' => __( 'Refund chart ' . $content_title, 'tutor-pro' ),
			),
			array(
				'tab_title'     => __( 'Total Discount', 'tutor-pro' ),
				'tab_value'     => $discounts['total_discounts'],
				'data_attr'     => 'ta_total_discount',
				'active'        => '',
				'price'         => true,
				'content_title' => __( 'Discount chart ' . $content_title, 'tutor-pro' ),
			),
		);

		$graph_template = TUTOR_REPORT()->path . 'templates/elements/graph.php';
		tutor_load_template_from_custom_path( $graph_template, $graph_tabs );
	?>

	<!-- Popular Courses -->
	<div class="tutor-table-responsive tutor-analytics-most-popular-courses tutor-mb-lg-50 tutor-mb-8">
		<?php
			$popular_courses = tutor_utils()->most_popular_courses( $limit = 7, get_current_user_id() );
		?>
		<div class="analytics-title tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16">
			<?php esc_html_e( 'Most Popular Courses', 'tutor-pro' ); ?>
		</div>
		<div class="tutor-table-wrapper">
			<table class="tutor-table tutor-table-responsive table-popular-courses" style="--column-count: 3">
				<thead>
					<th>
						<div class="tutor-fs-7 tutor-color-secondary">
							<?php esc_html_e( 'Course Name', 'tutor-pro' ); ?>
						</div>
					</th>
					<th class="tutor-table-rows-sorting">
						<div class="tutor-d-inline-flex tutor-align-center tutor-fs-7 tutor-color-secondary">
							<span class="">
								<?php esc_html_e( 'Total Enrolled', 'tutor-pro' ); ?>
							</span>
							<span class="up-down-icon tutor-icon-order-down"></span>
						</div>
					</th>
					<th class="tutor-table-rows-sorting">
						<div class="tutor-d-inline-flex tutor-align-center tutor-fs-7 tutor-color-secondary">
							<span class="">
								<?php esc_html_e( 'Rating', 'tutor-pro' ); ?>
							</span>
							<span class="up-down-icon tutor-icon-order-down"></span>
						</div>
					</th>
				</thead>
				<tbody>
					<?php if ( count( $popular_courses ) ) : ?>
						<?php foreach ( $popular_courses as $course ) : ?>
						<tr>
							<td data-th="<?php esc_html_e( 'Course Name', 'tutor-pro' ); ?>">
								<div class="td-course tutor-fs-6 tutor-fw-medium  tutor-color-black">
									<?php esc_html_e( $course->post_title ); ?>
								</div>
							</td>
							<td data-th="<?php esc_html_e( 'Total Enrolled', 'tutor-pro' ); ?>">
								<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
									<?php esc_html_e( $course->total_enrolled ); ?>
								</span>
							</td>
							<td data-th="<?php esc_html_e( 'Rating', 'tutor-pro' ); ?>">
								<?php
									$rating     = tutor_utils()->get_course_rating( $course->ID );
									$avg_rating = ! is_null( $rating ) ? $rating->rating_avg : 0;
								?>
								<div class="td-tutor-rating tutor-fs-6 tutor-color-secondary">
									<?php tutor_utils()->star_rating_generator_v2( $avg_rating, null, true ); ?>
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

	<!-- Reviews -->
	<div class="tutor-table-wrapper tutor-analytics-course-reviews">
		<?php
			$reviews = tutor_utils()->get_reviews_by_instructor( $instructor_id = $user->ID, $offset = 0, $limit = 7 );
		?>
		<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16">
			<?php esc_html_e( 'Recent Reviews', 'tutor-pro' ); ?>
		</div>
		<table class="tutor-table- tutor-table tutor-table-responsive table-reviews" style="--column-count: 3">
			<thead>
				<th>
					<div class="tutor-fs-7 tutor-color-secondary">
						<?php esc_html_e( 'Student', 'tutor-pro' ); ?>
					</div>
				</th>
				<th>
					<div class="tutor-fs-7 tutor-color-secondary">
						<?php esc_html_e( 'Date', 'tutor-pro' ); ?>
					</div>
				</th>
				<th>
					<div class="tutor-fs-7 tutor-color-secondary">
						<?php esc_html_e( 'Feedback', 'tutor-pro' ); ?>
					</div>
				</th>
			</thead>
			<tbody>
				<?php
				if ( is_array( $reviews->results ) && count( $reviews->results ) ) :
					?>
					<?php foreach ( $reviews->results as  $key => $review ) : ?>

					<tr>
						<td data-th="<?php esc_html_e( 'Student', 'tutor-pro' ); ?>">
							<div class="td-avatar">
								<?php echo tutor_utils()->get_tutor_avatar( $review->user_id ); ?>
								<div class="tutor-fs-6 tutor-fw-medium  tutor-color-black">
									<?php esc_html_e( $review->display_name ); ?>
								</div>
							</div>
						</td>
						<td data-th="<?php _e( 'Date', 'tutor-pro' ); ?>">
							<div class="tutor-color-black tutor-fs-7 tutor-fw-medium">
								<?php
									$date_time_format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
                                    $date = tutor_get_formated_date( $date_time_format, $review->comment_date );
                                    esc_html_e( $date ); 
								?>
							</div>
						</td>
						<td data-th="<?php esc_html_e( 'Feedback', 'tutor-pro' ); ?>">
							<div class="td-feedback">
								<div class="td-tutor-rating tutor-fs-6 tutor-color-secondary">
									<?php tutor_utils()->star_rating_generator_v2( $review->rating, null, true ); ?>
								</div>
								<div class="tutor-fs-6 tutor-color-secondary tutor-mt-4">
									<?php echo esc_textarea( $review->comment_content ); ?>
								</div>
								<div class="course-name tutor-fs-7 tutor-color-secondary tutor-mb-0">
									<span class="tutor-fs-8 tutor-fw-medium"><?php esc_html_e( 'Course', 'tutor' ); ?>:</span>&nbsp;
									<span data-href="<?php echo esc_url( get_the_permalink( $review->comment_post_ID ) ); ?>">
										<?php echo esc_html( get_the_title( $review->comment_post_ID ) ); ?>
									</span>
								</div>
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
