<?php
/**
 * Tutor Report Overview page
 *
 * @package Tutor Report
 */

use TUTOR\Input;
use \TUTOR_REPORT\Analytics;
global $wpdb;

$course_post_type 		= tutor()->course_post_type;
$lesson_type      		= tutor()->lesson_post_type;

$totalCourse 			= tutor_utils()->get_total_course();
$totalCourseEnrolled 	= tutor_utils()->get_total_enrolled_course();
$totalLesson 			= tutor_utils()->get_total_lesson();
$totalQuiz 				= tutor_utils()->get_total_quiz();
$totalQuestion			= tutor_utils()->get_total_question();
$totalInstructor 		= tutor_utils()->get_total_instructors( $search_filter = '', array( 'approved' ));
$totalStudents 			= tutor_utils()->get_total_students();
$totalReviews			= tutor_utils()->get_total_review();

$most_popular_courses	= tutor_utils()->most_popular_courses( $limit = 5 );
$last_enrolled_courses	= Analytics::get_last_enrolled_courses();
$reviews 				= Analytics::get_reviews();
$students 				= Analytics::get_students();
$teachers 				= Analytics::get_teachers();
$questions 				= tutor_utils()->get_qa_questions();

$time_period = $active = Input::get( 'period', '' );
$start_date  = Input::has('start_date') ? tutor_get_formated_date( 'Y-m-d', Input::get( 'start_date' ) ) : '';
$end_date    = Input::has('end_date') ? tutor_get_formated_date( 'Y-m-d', Input::get( 'end_date' ) ) : '';

$add_30_days  = tutor_utils()->sub_days_with_today( '30 days' );
$add_90_days  = tutor_utils()->sub_days_with_today( '90 days' );
$add_365_days = tutor_utils()->sub_days_with_today( '365 days' );

$current_frequency = Input::get( 'period', 'last30days' );
$frequencies       = tutor_utils()->report_frequencies();

?>

<div class="tutor-report-overview-wrap">
	<div class="tutor-row tutor-gx-4">
		<div class="tutor-col-md-6 tutor-col-xl-3 tutor-my-8 tutor-my-md-16">
			<div class="tutor-card tutor-card-secondary tutor-p-24">
				<div class="tutor-d-flex">
					<div class="tutor-round-box">
						<span class="tutor-icon-mortarboard-o" area-hidden="true"></span>
					</div>

					<div class="tutor-ml-20">
						<div class="tutor-fs-4 tutor-fw-bold tutor-color-black"><?php echo $totalCourse; ?></div>
						<div class="tutor-fs-7 tutor-color-secondary"><?php _e( 'Publiched Courses', 'tutor-pro' ); ?></div>
					</div>
				</div>
			</div>
		</div>

		<div class="tutor-col-md-6 tutor-col-xl-3 tutor-my-8 tutor-my-md-16">
			<div class="tutor-card tutor-card-secondary tutor-p-24">
				<div class="tutor-d-flex">
					<div class="tutor-round-box">
						<span class="tutor-icon-add-member" area-hidden="true"></span>
					</div>

					<div class="tutor-ml-20">
						<div class="tutor-fs-4 tutor-fw-bold tutor-color-black"><?php echo $totalCourseEnrolled; ?></div>
						<div class="tutor-fs-7 tutor-color-secondary"><?php _e( 'Course Enrolled', 'tutor-pro' ); ?></div>
					</div>
				</div>
			</div>
		</div>

		<div class="tutor-col-md-6 tutor-col-xl-3 tutor-my-8 tutor-my-md-16">
			<div class="tutor-card tutor-card-secondary tutor-p-24">
				<div class="tutor-d-flex">
					<div class="tutor-round-box">
						<span class="tutor-icon-book-open" area-hidden="true"></span>
					</div>

					<div class="tutor-ml-20">
						<div class="tutor-fs-4 tutor-fw-bold tutor-color-black"><?php echo $totalLesson; ?></div>
						<div class="tutor-fs-7 tutor-color-secondary"><?php _e( 'Lessons', 'tutor-pro' ); ?></div>
					</div>
				</div>
			</div>
		</div>

		<div class="tutor-col-md-6 tutor-col-xl-3 tutor-my-8 tutor-my-md-16">
			<div class="tutor-card tutor-card-secondary tutor-p-24">
				<div class="tutor-d-flex">
					<div class="tutor-round-box">
						<span class="tutor-icon-quiz" area-hidden="true"></span>
					</div>

					<div class="tutor-ml-20">
						<div class="tutor-fs-4 tutor-fw-bold tutor-color-black"><?php echo $totalQuiz; ?></div>
						<div class="tutor-fs-7 tutor-color-secondary"><?php _e( 'Quiz', 'tutor-pro' ); ?></div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="tutor-col-md-6 tutor-col-xl-3 tutor-my-8 tutor-my-md-16">
			<div class="tutor-card tutor-card-secondary tutor-p-24">
				<div class="tutor-d-flex">
					<div class="tutor-round-box">
						<span class="tutor-icon-question" area-hidden="true"></span>
					</div>

					<div class="tutor-ml-20">
						<div class="tutor-fs-4 tutor-fw-bold tutor-color-black"><?php echo $totalQuestion; ?></div>
						<div class="tutor-fs-7 tutor-color-secondary"><?php _e( 'Questions', 'tutor-pro' ); ?></div>
					</div>
				</div>
			</div>
		</div>
	
		<div class="tutor-col-md-6 tutor-col-xl-3 tutor-my-8 tutor-my-md-16">
			<div class="tutor-card tutor-card-secondary tutor-p-24">
				<div class="tutor-d-flex">
					<div class="tutor-round-box">
						<span class="tutor-icon-user-bold" area-hidden="true"></span>
					</div>

					<div class="tutor-ml-20">
						<div class="tutor-fs-4 tutor-fw-bold tutor-color-black"><?php echo $totalInstructor; ?></div>
						<div class="tutor-fs-7 tutor-color-secondary"><?php _e( 'Instructors', 'tutor-pro' ); ?></div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="tutor-col-md-6 tutor-col-xl-3 tutor-my-8 tutor-my-md-16">
			<div class="tutor-card tutor-card-secondary tutor-p-24">
				<div class="tutor-d-flex">
					<div class="tutor-round-box">
						<span class="tutor-icon-user-graduate" area-hidden="true"></span>
					</div>

					<div class="tutor-ml-20">
						<div class="tutor-fs-4 tutor-fw-bold tutor-color-black"><?php echo $totalStudents; ?></div>
						<div class="tutor-fs-7 tutor-color-secondary"><?php _e( 'Students', 'tutor-pro' ); ?></div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="tutor-col-md-6 tutor-col-xl-3 tutor-my-8 tutor-my-md-16">
			<div class="tutor-card tutor-card-secondary tutor-p-24">
				<div class="tutor-d-flex">
					<div class="tutor-round-box">
						<span class="tutor-icon-star-bold" area-hidden="true"></span>
					</div>

					<div class="tutor-ml-20">
						<div class="tutor-fs-4 tutor-fw-bold tutor-color-black"><?php echo $totalReviews; ?></div>
						<div class="tutor-fs-7 tutor-color-secondary"><?php _e( 'Reviews', 'tutor-pro' ); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="tutor-analytics-wrapper tutor-analytics-graph tutor-mt-12">

		<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-d-flex tutor-align-center tutor-justify-between tutor-mb-16">
			<div>
				<?php esc_html_e( 'Earning graph', 'tutor-pro' ); ?>
			</div>
			<div class="tutor-admin-report-frequency-wrapper" style="min-width: 260px;">
				<?php tutor_load_template_from_custom_path( TUTOR_REPORT()->path . 'templates/elements/frequency.php' ); ?>
				<div class="tutor-v2-date-range-picker inactive" style="width: 305px; position:absolute; z-index: 99;"></div>
			</div>
		</div>
		<div class="tutor-overview-month-graph">
			<!--analytics graph -->
			<?php
				/**
				 * Get analytics data
				 * sending user_id 0 for getting all data
				 *
				 * @since 1.9.9
				 */
				$user_id        = get_current_user_id();
				$earnings       = Analytics::get_earnings_by_user( 0, $time_period, $start_date, $end_date );
				$enrollments    = Analytics::get_total_students_by_user( 0, $time_period, $start_date, $end_date );
				$discounts      = Analytics::get_discounts_by_user( 0, $time_period, $start_date, $end_date );
				$refunds        = Analytics::get_refunds_by_user( 0, $time_period, $start_date, $end_date );
				$content_title  = __( 'for ', 'tutor-pro' ) . $frequencies[ $current_frequency ];
				$graph_tabs     = array(
					array(
						'tab_title'     => __( 'Total Earning', 'tutor-pro' ),
						'tab_value'     => $earnings['total_earnings'],
						'data_attr'     => 'ta_total_earnings',
						'active'        => ' is-active',
						'price'         => true,
						'content_title' => __( 'Earnings Chart ' . $content_title, 'tutor-pro' ),
					),
					array(
						'tab_title'     => __( 'Course Enrolled', 'tutor-pro' ),
						'tab_value'     => $enrollments['total_enrollments'],
						'data_attr'     => 'ta_total_course_enrolled',
						'active'        => '',
						'price'         => false,
						'content_title' => __( 'Course Enrolled Chart ' . $content_title, 'tutor-pro' ),
					),
					array(
						'tab_title'     => __( 'Total Refund', 'tutor-pro' ),
						'tab_value'     => $refunds['total_refunds'],
						'data_attr'     => 'ta_total_refund',
						'active'        => '',
						'price'         => true,
						'content_title' => __( 'Refund Chart ' . $content_title, 'tutor-pro' ),
					),
					array(
						'tab_title'     => __( 'Total Discount', 'tutor-pro' ),
						'tab_value'     => $discounts['total_discounts'],
						'data_attr'     => 'ta_total_discount',
						'active'        => '',
						'price'         => true,
						'content_title' => __( 'Discount Chart ' . $content_title, 'tutor-pro' ),
					),
				);
				$graph_template = TUTOR_REPORT()->path . 'templates/elements/graph.php';
				tutor_load_template_from_custom_path( $graph_template, $graph_tabs );
				?>
			<!--analytics graph end -->
		</div>
	</div>

	<div class="tutor-mb-48" id="tutor-courses-overview-section">
		<div class="single-overview-section tutor-most-popular-courses">
			<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24">
				<?php esc_html_e( 'Most popular courses', 'tutor-pro' ); ?>
			</div>
			<div class="tutor-table-wrapper">
				<table class="tutor-table tutor-table-responsive table-popular-courses">
					<thead>
						<tr>
							<th>
								<span class="tutor-fs-7 tutor-color-secondary">
									<?php esc_html_e( 'Course Name', 'tutor-pro' ); ?>
								</span>
							</th>
							<th class="tutor-table-rows-sorting">
								<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
									<span class="tutor-fs-7">
										<?php esc_html_e( 'Total Enrolled', 'tutor-pro' ); ?>
									</span>
									<span class="tutor-icon-ordering-a-z a-to-z-sort-icon"></span>
								</div>
							</th>
							<th class="tutor-table-rows-sorting">
								<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
									<span class="tutor-fs-7">
										<?php esc_html_e( 'Rating', 'tutor-pro' ); ?>
									</span>
									<span class="tutor-icon-ordering-a-z a-to-z-sort-icon"></span>
								</div>
							</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( is_array( $most_popular_courses ) && count( $most_popular_courses ) ) : ?>
						<?php foreach ( $most_popular_courses as $course ) : ?>
							<tr>
								<td data-th="<?php esc_html_e( 'Course Name', 'tutor-pro' ); ?>" class="course-name column-fullwidth">
									<div class="tutor-fs-6 tutor-fw-medium  tutor-color-black">
										<span>
											<?php echo esc_html( $course->post_title ); ?>
										</span>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Total Enrolled', 'tutor-pro' ); ?>" class="total-enrolled">
									<span class="tutor-fs-7 tutor-fw-medium  tutor-color-black">
										<?php echo esc_html( $course->total_enrolled ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'Course Rating', 'tutor-pro' ); ?>" class="course-rating">
									<div class="td-tutor-rating tutor-fs-6 tutor-color-secondary">
										<?php tutor_utils()->star_rating_generator_v2( isset($course_rating->rating_avg)?$course_rating->rating_avg:0, null, true ); ?>
									</div>
								</td>
								<td data-th="-">
									<div class="tutor-details-link">
										<a href="<?php echo esc_url( get_permalink( $course->course_id ) ); ?>" class="tutor-iconic-btn" target="_blank"><span class="tutor-icon-external-link"></span></a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="100%" class="column-empty-state" >
								<?php tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() ); ?>
							</td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="single-overview-section tutor-last-enrolled-courses">
			<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24">
				<?php esc_attr_e( 'Last enrolled courses', 'tutor-pro' ); ?>
			</div>
			<div class="tutor-table-wrapper">
				<table class="tutor-table tutor-table-responsive table-popular-courses">
					<thead>
						<tr>
							<th>
								<span class="tutor-fs-7 tutor-color-secondary">
									<?php esc_html_e( 'Course Name', 'tutor-pro' ); ?>
								</span>
							</th>
							<th class="tutor-table-rows-sorting">
								<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
									<span class="tutor-fs-7">
										<?php esc_html_e( 'Date', 'tutor-pro' ); ?>
									</span>
									<span class="tutor-icon-ordering-a-z a-to-z-sort-icon"></span>
								</div>
							</th>
							<th class="tutor-table-rows-sorting">
								<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
									<span class="tutor-fs-7">
										<?php esc_html_e( 'Rating', 'tutor-pro' ); ?>
									</span>
									<span class="tutor-icon-ordering-a-z a-to-z-sort-icon"></span>
								</div>
							</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( is_array( $last_enrolled_courses ) && count( $last_enrolled_courses ) ) : ?>
						<?php foreach ( $last_enrolled_courses as $course ) : ?>
							<tr>
								<td data-th="<?php esc_html_e( 'Course Name', 'tutor-pro' ); ?>" class="column-fullwidth course-name">
									<div class="tutor-fs-6 tutor-fw-medium  tutor-color-black">
										<span>
											<?php echo esc_html( $course->post_title ); ?>
										</span>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Date', 'tutor-pro' ); ?>" class="date">
									<span class="tutor-fs-7 tutor-fw-medium  tutor-color-black">
										<?php echo esc_html( tutor_i18n_get_formated_date( $course->enrolled_time, get_option( 'date_format' ) ) ); ?>,<br>
										<?php echo esc_html( tutor_i18n_get_formated_date( $course->enrolled_time, get_option( 'time_format' ) ) ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'Rating', 'tutor-pro' ); ?>" class="rating">
									<div class="td-tutor-rating tutor-fs-6 tutor-color-secondary">
										<?php tutor_utils()->star_rating_generator_v2( isset($course_rating->rating_avg)?$course_rating->rating_avg:0, null, true ); ?>
									</div>
								</td>
								<td>
									<div class="tutor-details-link">
										<a href="<?php echo esc_url( get_permalink( $course->ID ) ); ?>" target="_blank" class="tutor-iconic-btn"><span class="tutor-icon-external-link"></span></a>
									</div>
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
	</div>

	<div id="tutor-courses-review-section" class="tutor-mb-48">
		<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24">
			<?php esc_html_e( 'Recent Reviews', 'tutor-pro' ); ?>
		</div>
		<div class="tutor-table-wrapper">
			<table class="tutor-table tutor-table-responsive tutor-table-report-tab-overview" id="tutor-admin-reviews-table">
				<thead>
					<tr>
						<th class="tutor-table-rows-sorting">
							<div class=" tutor-align-center tutor-d-flex">
								<span class="tutor-fs-7 tutor-color-secondary">
									<?php esc_html_e( 'Student', 'tutor-pro' ); ?>
								</span>
								<span class="tutor-icon-ordering-a-z a-to-z-sort-icon"></span>
							</div>
						</th>
						<th>
							<span class="tutor-fs-7 tutor-color-secondary">
								<?php esc_html_e( 'Date', 'tutor-pro' ); ?>
							</span>
						</th>
						<th>
							<span class="tutor-fs-7 tutor-color-secondary">
								<?php esc_html_e( 'Course', 'tutor-pro' ); ?>
							</span>
						</th>
						<th>
							<span class="tutor-fs-7 tutor-color-secondary">
								<?php esc_html_e( 'Feedback', 'tutor-pro' ); ?>
							</span>
						</th>
						<th>
							<span></span>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( is_array( $reviews ) && count( $reviews ) ) : ?>
						<?php foreach ( $reviews as $review ) : ?>
							<tr>
								<td data-th="<?php esc_html_e( 'Student', 'tutor-pro' ); ?>" class="student column-fullwidth">
									<div class="td-avatar">
										<?php echo tutor_utils()->get_tutor_avatar( $review->user_id ); ?>
										<span class="tutor-fs-6 tutor-fw-medium  tutor-color-black">
											<?php echo esc_html( $review->display_name ); ?>
										</span>
										<a href="<?php echo esc_url( tutor_utils()->profile_url( $review->user_id, false ) ); ?>" class="tutor-d-flex"><span class="tutor-icon-external-link  tutor-color-black"></span></a>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Date', 'tutor-pro' ); ?>" class="date">
									<span class="tutor-fs-7 tutor-fw-medium  tutor-color-black">
										<?php echo esc_html( tutor_i18n_get_formated_date( $review->comment_date, get_option( 'date_format' ) ) ); ?>,
										<br />
										<?php echo esc_html( tutor_i18n_get_formated_date( $review->comment_date, get_option( 'time_format' ) ) ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'Course', 'tutor-pro' ); ?>" class="course">
									<span class="tutor-fs-7 tutor-fw-medium  tutor-color-black">
										<?php echo esc_html( get_the_title( $review->comment_post_ID ) ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'Feedback', 'tutor-pro' ); ?>" class="feedback">
									<div class="td-feedback">
										<div class="td-tutor-rating tutor-fs-6 tutor-color-secondary">
											<div class="td-tutor-rating tutor-fs-6 tutor-color-secondary">
												<?php tutor_utils()->star_rating_generator_v2( $review->rating, null, true ); ?>
											</div>
										</div>
										<span class="review-text tutor-color-secondary"><?php echo esc_textarea( wp_unslash( $review->comment_content ) ); ?></span>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Action', 'tutor-pro' ); ?>" class="review-action-btns">
									<div class="tutor-d-inline-flex tutor-align-center td-action-btns">
										<a data-tutor-modal-target="tutor-common-confirmation-modal" class="tutor-btn tutor-btn-outline-primary tutor-btn-sm tutor-delete-recent-reviews" data-id="<?php echo esc_attr( $review->comment_ID ); ?>" style="cursor: pointer;">Delete</a>
										<a href="<?php echo esc_url( get_the_permalink( $review->comment_post_ID ) ); ?>" class="tutor-iconic-btn" target="_blank" >
											<span class="tutor-icon-external-link"></span>
										</a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="100%" class="column-empty-state">
								<?php tutor_utils()->tutor_empty_state(); ?>
							</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<div id="tutor-new-registered-section">
		<div class="single-new-registered-section">
			<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24">
				<?php esc_html_e( 'New Registered students', 'tutor-pro' ); ?>
			</div>
			<div class="tutor-table-wrapper">
				<table class="tutor-table tutor-table-responsive">
					<thead>
						<tr>
							<th class="tutor-table-rows-sorting">
								<div class="tutor-d-flex  tutor-align-center">
									<span class="tutor-fs-7 tutor-color-secondary">
										<?php esc_html_e( 'Student', 'tutor-pro' ); ?>
									</span>
									<span class="tutor-icon-ordering-a-z a-to-z-sort-icon"></span>
								</div>
							</th>
							<th>
								<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
									<span class="tutor-fs-7">
										<?php esc_html_e( 'Email', 'tutor-pro' ); ?>
									</span>
								</div>
							</th>
							<th>
								<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
									<span class="tutor-fs-7">
										<?php esc_html_e( 'Register at', 'tutor-pro' ); ?>
									</span>
								</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php if ( is_array( $students ) && count( $students ) ) : ?>
							<?php foreach ( $students as $student ) : ?>
								<tr>
									<td data-th="<?php esc_html_e( 'Student', 'tutor-pro' ); ?>">
										<div class="tutor-instructor-card">
											<?php echo tutor_utils()->get_tutor_avatar( $student->ID ); ?>
											<div class="tutor-icard-content">
												<h6 class="tutor-fs-7 tutor-fw-medium tutor-color-black tutor-d-flex tutor-align-center">
													<?php echo esc_html( $student->display_name ); ?>
												</h6>
												<a href="<?php echo esc_url( tutor_utils()->profile_url( $student->ID, false ) ); ?>" class="tutor-iconic-btn" target="_blank"><i class="tutor-icon-external-link" area-hidden="true"></i></a>
											</div>
										</div>
									</td>
									<td data-th="<?php esc_html_e( 'Email', 'tutor-pro' ); ?>">
										<span class="tutor-fs-7 tutor-fw-medium  tutor-color-black">
											<?php echo esc_html( $student->user_email ); ?>
										</span>
									</td>
									<td data-th="<?php esc_html_e( 'Registered at', 'tutor-pro' ); ?>">
										<div class="td-tutor-rating tutor-fs-6 tutor-color-secondary">
											<div class="tutor-ratings">
												<div class="tutor-fs-7 tutor-fw-medium  tutor-color-black">
													<?php echo esc_html( tutor_i18n_get_formated_date( $student->user_registered ) ); ?>
												</div>
											</div>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="100%" class="column-empty-state">
									<?php tutor_utils()->tutor_empty_state(); ?>
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="single-new-registered-section">
			<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24">
				<div class="heading">
					<?php esc_html_e( 'New Registered Teachers', 'tutor-pro' ); ?>
				</div>
			</div>
			<div class="tutor-table-wrapper">
				<table class="tutor-table tutor-table-responsive">
					<thead>
						<tr>
							<th class="tutor-table-rows-sorting">
								<div class="tutor-d-flex  tutor-align-center">
									<span class="tutor-fs-7 tutor-color-secondary">
										<?php esc_html_e( 'Teacher', 'tutor-pro' ); ?>
									</span>
									<span class="tutor-icon-ordering-a-z a-to-z-sort-icon"></span>
								</div>
							</th>
							<th>
								<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
									<span class="tutor-fs-7">
										<?php esc_html_e( 'Email', 'tutor-pro' ); ?>
									</span>
								</div>
							</th>
							<th>
								<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
									<span class="tutor-fs-7">
										<?php esc_html_e( 'Register at', 'tutor-pro' ); ?>
									</span>
								</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php if ( is_array( $teachers ) && count( $teachers ) ) : ?>
							<?php foreach ( $teachers as $teacher ) : ?>
								<tr>
									<td data-th="<?php esc_html_e( 'Teacher', 'tutor-pro' ); ?>">
										<div class="tutor-instructor-card">
											<?php echo tutor_utils()->get_tutor_avatar( $teacher->ID ); ?>
											<div class="tutor-icard-content">
												<h6 class="tutor-name">
												<?php echo esc_html( $teacher->display_name ); ?>
												</h6>
												<a href="<?php echo esc_url( tutor_utils()->profile_url( $teacher->ID, true ) ); ?>" class="tutor-iconic-btn" target="_blank"><i class="tutor-icon-external-link" area-hidden="true"></i></a>
											</div>
										</div>
									</td>
									<td data-th="<?php esc_html_e( 'Email', 'tutor-pro' ); ?>">
										<span class="tutor-fs-7 tutor-fw-medium  tutor-color-black">
										<?php echo esc_html( $teacher->user_email ); ?>
										</span>
									</td>
									<td data-th="<?php esc_html_e( 'Registered at', 'tutor-pro' ); ?>">
										<div class="td-tutor-rating tutor-fs-6 tutor-color-secondary">
											<div class="tutor-ratings">
												<div class="tutor-fs-7 tutor-fw-medium  tutor-color-black">
													<?php echo esc_html( tutor_i18n_get_formated_date( $teacher->user_registered ) ); ?>
												</div>
											</div>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="100%" class="column-empty-state">
										<?php tutor_utils()->tutor_empty_state(); ?>
									</td>
								</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php tutor_load_template_from_custom_path( tutor()->path . 'views/elements/common-confirm-popup.php' ); ?>
