<?php
/**
 * Course Details Template
 *
 * @package Report
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use TUTOR_REPORT\Analytics;
	// single
	$all_data   = $wpdb->get_results(
		"SELECT ID, post_title 
        FROM {$wpdb->posts} 
        WHERE post_type ='{$course_type}' 
        AND post_status = 'publish' "
	);
	$current_id = isset( $_GET['course_id'] ) ? $_GET['course_id'] : ( isset( $all_data[0] ) ? $all_data[0]->ID : '' );

	$totalCount = (int) $wpdb->get_var(
		"SELECT COUNT(ID) 
        FROM {$wpdb->posts} 
        WHERE post_parent = {$current_id} 
        AND post_type = 'tutor_enrolled';"
	);

	$per_page     = 50;
	$total_items  = $totalCount;
	$current_page = isset( $_GET['paged'] ) ? $_GET['paged'] : 0;
	$start        = max( 0, ( $current_page - 1 ) * $per_page );


	$lesson_type = tutor()->lesson_post_type;

	$course_completed = $wpdb->get_results(
		"SELECT ID, post_author, meta.meta_value as order_id from {$wpdb->posts} 
        JOIN {$wpdb->postmeta} meta 
        ON ID = meta.post_id
        WHERE post_type = 'tutor_enrolled' 
        AND meta.meta_key = '_tutor_enrolled_by_order_id'
        AND post_parent = {$current_id} 
        AND post_status = 'completed' 
        ORDER BY ID DESC LIMIT {$start},{$per_page};"
	);

	$complete_data = 0;
	$course_single = array();
	if ( is_array( $course_completed ) && ! empty( $course_completed ) ) {
		$complete = 0;
		foreach ( $course_completed as $data ) {
			$var             = array();
			$var['order_id'] = $data->order_id;
			$var['post_id']  = $current_id;
			$var['complete'] = tutor_utils()->get_course_completed_percent( $current_id, $data->post_author );
			$var['user_id']  = $data->post_author;
			$course_single[] = $var;
			if ( $var['complete'] == 100 ) {
				$complete_data++; }
		}
	} else {
		$complete_data = 0;
	}

	$per_student   = tutor_utils()->get_option( 'pagination_per_page' );
	$student_page  = isset( $_GET['lp'] ) ? $_GET['lp'] : 0;
	$start_student = max( 0, ( $student_page - 1 ) * $per_student );

	$student_items = $wpdb->get_results(
		"SELECT ID FROM {$wpdb->posts} AS posts
			WHERE posts.post_type = 'tutor_enrolled'
				AND posts.post_status = 'completed'
				AND posts.post_parent = {$current_id}
			GROUP BY post_author
		"
	);
	$student_items = is_array( $student_items ) ? count( $student_items ) : 0;
	$student_list  = $wpdb->get_results(
		"SELECT post_author, ID, post_date, post_parent FROM {$wpdb->posts} AS posts
			WHERE posts.post_type = 'tutor_enrolled'
				AND posts.post_status = 'completed'
				AND posts.post_parent = {$current_id}
			GROUP BY post_author
			ORDER BY ID DESC LIMIT {$start_student},{$per_student}"
	);
	$instructors   = tutor_utils()->get_instructors_by_course( $current_id );

	$per_review    = tutor_utils()->get_option( 'pagination_per_page' );
	$review_page   = isset( $_GET['rp'] ) ? $_GET['rp'] : 0;
	$review_start  = max( 0, ( $review_page - 1 ) * $per_review );
	$review_items  = tutor_utils()->get_course_reviews( $current_id, null, null, true );
	$total_reviews = tutor_utils()->get_course_reviews( $current_id, $review_start, $per_review );

	/**
	 * Query params
	 */
	$time_period = $active = isset( $_GET['period'] ) ? $_GET['period'] : '';
	$start_date  = isset( $_GET['start_date'] ) ? sanitize_text_field( $_GET['start_date'] ) : '';
	$end_date    = isset( $_GET['end_date'] ) ? sanitize_text_field( $_GET['end_date'] ) : '';
	if ( '' !== $start_date ) {
		$start_date = tutor_get_formated_date( 'Y-m-d', $start_date );
	}
	if ( '' !== $end_date ) {
		$end_date = tutor_get_formated_date( 'Y-m-d', $end_date );
	}
	$add_30_days  = tutor_utils()->sub_days_with_today( '30 days' );
	$add_90_days  = tutor_utils()->sub_days_with_today( '90 days' );
	$add_365_days = tutor_utils()->sub_days_with_today( '365 days' );

	$current_frequency = isset( $_GET['period'] ) ? $_GET['period'] : 'last30days';
	$frequencies = tutor_utils()->report_frequencies();
	?>

<div id="tutor-report-courses-details-wrap">
	<div class="tutor-course-report-header">
		<div class="tutor-course-report-header-left">
			<div class="tutor-course-report-header-title">
				<div class="tutor-fs-4 tutor-fw-medium tutor-color-black">
					<?php echo esc_html( get_the_title( $current_id ) ); ?>
				</div>
			</div>
			<div class="tutor-course-report-header-meta tutor-d-flex flex-wrap  tutor-align-center">
				<div class="tutor-course-report-created-date tutor-fs-7 tutor-color-secondary">
					<span><?php esc_html_e( 'Created', 'tutor-pro' ); ?></span>:
					<?php echo esc_html( get_the_date( get_option( 'date_format' ), $current_id ) ); ?>
				</div>
				<div
					class="tutor-course-report-last-update-date tutor-d-flex  tutor-align-center tutor-fs-7 tutor-color-secondary">
					<span class="tutor-icon-refresh"></span>
					<span><?php esc_html_e( 'Last Update', 'tutor-pro' ); ?></span>: 
					<?php echo esc_html( get_the_modified_date( get_option( 'date_format' ), $current_id ) ); ?>
				</div>
			</div> <!-- tutor-course-report-header-meta -->
		</div> <!-- tutor-course-report-header-left -->
		<div class="tutor-course-report-header-right tutor-course-report-header-right tutor-d-flex  tutor-align-end tutor-justify-end">
			<a href="<?php echo esc_url( get_edit_post_link( $current_id ) ); ?>" class="tutor-btn tutor-btn-outline-primary tutor-btn-md tutor-mr-16" target="_blank">
				<?php esc_html_e( 'Edit with Builder', 'tutor-pro' ); ?>
			</a>
			<a href="<?php echo esc_url( the_permalink( $current_id ) ); ?>" class="tutor-btn tutor-btn-primary tutor-btn-md" target="_blank">
				<?php esc_html_e( 'View Course', 'tutor-pro' ); ?>
			</a>
		</div>
	</div>
	<div id="tutor-course-report-stats">
		<div class="tutor-course-report-single-stats">
			<div class="tutor-fs-5 tutor-fw-bold tutor-color-black tutor-course-report-single-stats-number">
				<?php
					$info_lesson = tutor_utils()->get_lesson_count_by_course( $current_id );
					echo esc_html( $info_lesson );
				?>
			</div>
			<div class="tutor-fs-7 tutor-color-secondary tutor-course-report-single-stats-text">
				<?php esc_html_e( 'Lesson', 'tutor-pro' ); ?>
			</div>
		</div>
		<div class="tutor-course-report-single-stats">
			<div class="tutor-fs-5 tutor-fw-bold tutor-color-black tutor-course-report-single-stats-number">
			<?php
				$info_quiz = '';
			if ( $current_id ) {
				$info_quiz = $wpdb->get_var(
					"SELECT COUNT(ID) FROM {$wpdb->posts}
							WHERE post_parent IN (SELECT ID FROM {$wpdb->posts} WHERE post_type='topics' AND post_parent = {$current_id} AND post_status = 'publish')
							AND post_type ='tutor_quiz' 
							AND post_status = 'publish'"
				);
			}
				echo esc_html( $info_quiz );
			?>
			</div>
			<div class="tutor-fs-7 tutor-color-secondary tutor-course-report-single-stats-text">
				<?php esc_html_e( 'Total Quiz', 'tutor-pro' ); ?>
			</div>
		</div>
		<div class="tutor-course-report-single-stats">
			<div class="tutor-fs-5 tutor-fw-bold tutor-color-black tutor-course-report-single-stats-number">
			<?php
				$info_assignment = tutor_utils()->get_assignments_by_course( $current_id )->count;
				echo esc_html( $info_assignment );
			?>
			</div>
			<div class="tutor-fs-7 tutor-color-secondary tutor-course-report-single-stats-text">
				<?php esc_html_e( 'Assignment', 'tutor-pro' ); ?>
			</div>
		</div>
		<div class="tutor-course-report-single-stats">
			<div class="tutor-fs-5 tutor-fw-bold tutor-color-black tutor-course-report-single-stats-number">
			<?php
				$info_students = tutor_utils()->count_enrolled_users_by_course( $current_id );
				echo esc_html( $info_students );
			?>
			</div>
			<div class="tutor-fs-7 tutor-color-secondary tutor-course-report-single-stats-text">
				<?php esc_html_e( 'Total Student', 'tutor-pro' ); ?>
			</div>
		</div>
		<div class="tutor-course-report-single-stats">
			<div class="tutor-fs-5 tutor-fw-bold tutor-color-black tutor-course-report-single-stats-number">
				<?php echo esc_html( $complete_data ); ?>
			</div>
			<div class="tutor-fs-7 tutor-color-secondary tutor-course-report-single-stats-text">
				<?php esc_html_e( 'Course Completed', 'tutor-pro' ); ?>
			</div>
		</div>
		<div class="tutor-course-report-single-stats">
			<div class="tutor-fs-5 tutor-fw-bold tutor-color-black tutor-course-report-single-stats-number">
			<?php
				$total_student = tutor_utils()->count_enrolled_users_by_course( $current_id );
				echo esc_html( $total_student - $complete_data );
			?>
			</div>
			<div class="tutor-fs-7 tutor-color-secondary tutor-course-report-single-stats-text">
				<?php esc_html_e( 'Course Continue', 'tutor-pro' ); ?>
			</div>
		</div>
		<div class="tutor-course-report-single-stats tutor-ratings-stats">
			<div class="tutor-ratings-text tutor-fs-7 tutor-color-secondary tutor-mt-4">
				<?php
					$course_rating = tutor_utils()->get_course_rating( $current_id );
					tutor_utils()->star_rating_generator( $course_rating->rating_avg );
				?>
				<span>
					<?php echo esc_html( number_format( $course_rating->rating_avg, 2 ) ); ?>
					(<?php printf( _n( '%s Rating', '%s Ratings', $course_rating->rating_count, 'tutor-pro' ), $course_rating->rating_count ); ?>)
				</span>
			</div>
		</div>
	</div>

	<div class="tutor-analytics-wrapper tutor-analytics-graph tutor-mt-12">
		<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-d-flex tutor-align-center tutor-justify-between tutor-mb-24">
			<div>
				<?php esc_html_e( 'Earning graph', 'tutor-pro' ); ?>
			</div>
			<div class="tutor-admin-report-frequency-wrapper" style="min-width: 260px;">
				<?php tutor_load_template_from_custom_path( TUTOR_REPORT()->path . 'templates/elements/frequency.php' ); ?>
				<div class="tutor-v2-date-range-picker inactive" style="width: 305px; position:absolute; z-index: 99;"></div>
			</div>
		</div>
		<div class="tutor-overview-month-graph">
			<?php
				/**
				 * Get analytics data
				 * sending user_id 0 for getting all data
				 *
				 * @since 1.9.9
				 */
				$user_id        = get_current_user_id();
				$course_id      = isset( $_GET['course_id'] ) ? $_GET['course_id'] : null;
				$earnings       = Analytics::get_earnings_by_user( 0, $time_period, $start_date, $end_date, $course_id );
				$enrollments    = Analytics::get_total_students_by_user( 0, $time_period, $start_date, $end_date, $course_id );
				$discounts      = Analytics::get_discounts_by_user( 0, $time_period, $start_date, $end_date, $course_id );
				$refunds        = Analytics::get_refunds_by_user( 0, $time_period, $start_date, $end_date, $course_id );
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
		</div>
	</div>

	<div id="tutor-course-details-student-list" class="tutor-mb-48">
		<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24">
			<?php esc_html_e( 'Students', 'tutor-pro' ); ?>
		</div>
		<div class="tutor-course-details-student-list-table tutor-mb-48">
			<table class="tutor-table tutor-table-responsive table-students">
				<thead>
					<tr>
						<th class="tutor-table-rows-sorting">
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Student', 'tutor-pro' ); ?>
								</span>
								<span class="tutor-icon-ordering-a-z a-to-z-sort-icon"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Enroll Date', 'tutor-pro' ); ?>
								</span>
								<span class="tutor-icon-order-down up-down-icon"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Lesson', 'tutor-pro' ); ?>
								</span>
								<span class="tutor-icon-order-down up-down-icon"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Assignment', 'tutor-pro' ); ?>
								</span>
								<span class="tutor-icon-order-down up-down-icon"></span>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Progress', 'tutor-pro' ); ?>
								</span>
							</div>
						</th>
						<th class="tutor-shrink"></th>
					</tr>
				</thead>
				<tbody>
					<?php if ( is_array( $student_list ) && count( $student_list ) ) : ?>
						<?php foreach ( $student_list as $student ) : ?>
							<?php
								$user_info = get_userdata( $student->post_author );
							if ( ! $user_info ) {
								continue;
							}
							?>
							<tr>
								<td class="student" data-th="<?php esc_html_e( 'Student', 'tutor-pro' ); ?>">
									<div class="td-avatar">
										<?php echo tutor_utils()->get_tutor_avatar( $user_info->ID ); ?>
										<div class="td-avatar-detials">
											<div class="td-avatar-name tutor-d-flex">
												<div class="tutor-color-black tutor-fs-6 tutor-fw-medium">
													<?php echo esc_html( $user_info->display_name ); ?>
												</div>
												<a href="<?php echo esc_url( tutor_utils()->profile_url( $user_info->ID, true ) ); ?>" class="tutor-iconic-btn">
													<span class="tutor-icon-external-link"></span>
												</a>
											</div>
											<div class="tutor-color-secondary tutor-fs-7">
												<?php echo esc_html( $user_info->user_email ); ?>
											</div>
										</div>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Enroll Date', 'tutor-pro' ); ?>">
									<span class="tutor-color-black tutor-fs-7">
										<?php echo esc_html( tutor_i18n_get_formated_date( $student->post_date, get_option( 'date_format' ) ) ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'Lesson', 'tutor-pro' ); ?>">
									<span class="tutor-color-black tutor-fs-7"><?php echo esc_html( tutor_utils()->get_completed_lesson_count_by_course( $current_id, $user_info->ID ) ); ?></span><span class="color-black-fill-40 tutor-fs-7"><?php echo esc_html( '/' . $info_lesson ); ?></span>
								</td>
								<td data-th="<?php esc_html_e( 'Assignment', 'tutor-pro' ); ?>">
									<span class="tutor-color-black tutor-fs-7"><?php echo esc_html( tutor_utils()->count_completed_assignment( $current_id, $user_info->ID ) ); ?></span><span class="color-black-fill-40 tutor-fs-7"><?php echo esc_html( '/' . $info_assignment ); ?></span>
								</td>
								<td data-th="<?php esc_html_e( 'Progress', 'tutor-pro' ); ?>">
									<?php $percentage = tutor_utils()->get_course_completed_percent( $current_id, $user_info->ID ); ?>
									<div class="td-progress tutor-d-inline-flex tutor-align-center">
										<div class="tutor-progress-bar" style="min-width: 50px; --tutor-progress-value:<?php echo esc_attr( $percentage ); ?>%;">
											<div class="tutor-progress-value"></div>
										</div>
										<div class="tutor-fs-7 tutor-fw-medium tutor-color-black tutor-ml-12">
											<?php echo esc_html( $percentage ); ?>%
										</div>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Details', 'tutor-pro' ); ?>">
									<div class="tutor-d-inline-flex tutor-align-center td-action-btns">
										<a href="<?php echo esc_url( admin_url( 'admin.php?page=tutor_report&sub_page=students&student_id=' . $user_info->ID ) ); ?>" class="tutor-btn tutor-btn-primary" target="_blank">
											<?php esc_html_e( 'Details', 'tutor-pro' ); ?>
										</a>
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

		<?php
			$student_pagination_data = array(
				'base'        => 'admin.php?page=tutor_report&sub_page=courses&course_id=' . $current_id . '&lp=%#%',
				'per_page'    => $per_student,
				'paged'       => max( 1, $student_page ),
				'total_items' => $student_items,
			);
			tutor_load_template_from_custom_path( tutor()->path . 'views/elements/pagination.php', $student_pagination_data );
		?>
	</div>

	<div id="tutor-course-details-instructor-list" class="tutor-mb-48">
		<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24">
			<?php esc_html_e( 'Instructors', 'tutor-pro' ); ?>
		</div>
		<div class="tutor-course-details-instructor-list-table">
			<table class="tutor-table tutor-table-responsive table-students">
				<thead>
					<tr>
						<th class="tutor-table-rows-sorting">
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7 tutor-mt-2">
									<?php esc_html_e( 'Teacher', 'tutor-pro' ); ?>
								</span>
								<span class="tutor-icon-ordering-a-z a-to-z-sort-icon"></span>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Total Courses', 'tutor-pro' ); ?>
								</span>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Total Students', 'tutor-pro' ); ?>
								</span>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Rating', 'tutor-pro' ); ?>
								</span>
							</div>
						</th>
						<th class="tutor-shrink"></th>
					</tr>
				</thead>
				<tbody>
					<?php if ( is_array( $instructors ) && count( $instructors ) ) : ?>
						<?php foreach ( $instructors as $instructor ) : ?>
							<?php
								$crown     = false;
								$user_info = get_userdata( $instructor->ID );
							if ( ! $user_info ) {
								continue;
							}
							if ( get_post_field( 'post_author', $instructor->ID ) == $instructor->ID ) {
								$crown = true;
							}
							?>
							<tr>
								<td class="teacher" data-th="<?php esc_html_e( 'Teacher', 'tutor-pro' ); ?>">
									<div class="td-avatar">
										<?php echo tutor_utils()->get_tutor_avatar( $instructor->ID ); ?>
										<div class="td-avatar-detials">
											<div class="td-avatar-name tutor-d-flex">
												<div class="tutor-color-black tutor-fs-6 tutor-fw-medium">
													<?php
													echo esc_html( $instructor->display_name );
													?>
												</div>
												<?php if ( $crown ) : ?>
													<a class="tutor-ml-4 tutor-d-flex">
														<span class="tutor-icon-crown tutor-color-warning"></span>
													</a>
												<?php endif; ?>
											</div>
											<div class="tutor-color-secondary tutor-fs-7">
												<?php echo esc_html( $user_info->user_email ); ?>
												</div>
										</div>
									</div>
								</td>
								<td class="total-courses" data-th="<?php esc_html_e( 'Total Courses', 'tutor-pro' ); ?>">
									<span class="tutor-color-black tutor-fs-7">
										<?php echo esc_html( tutor_utils()->get_course_count_by_instructor( $instructor->ID ) ); ?>
									</span>
								</td>
								<td class="total-students" data-th="<?php esc_html_e( 'Total Students', 'tutor-pro' ); ?>">
									<span class="tutor-color-black tutor-fs-7">
										<?php echo esc_html( tutor_utils()->get_total_students_by_instructor( $instructor->ID ) ); ?>
									</span>
								</td>
								<td class="rating" data-th="<?php esc_html_e( 'Rating', 'tutor-pro' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-color-secondary">
										<div class="tutor-ratings">
											<?php
											$rating = tutor_utils()->get_instructor_ratings( $instructor->ID );
											tutor_utils()->star_rating_generator( $rating->rating_avg );
											?>
											<div class="tutor-fs-6 tutor-fw-medium tutor-mt-2 tutor-ml-12">
												<?php echo esc_html( number_format( $rating->rating_avg, 2 ) ); ?>
											</div>
										</div>
									</div>
								</td>
								<td class="action-btns">
									<div class="tutor-d-inline-flex tutor-align-center td-action-btns">
										<a href="<?php echo esc_url( tutor_utils()->profile_url( $instructor->ID, true ) ); ?>" class="tutor-btn tutor-btn-primary" target="_blank">
											View Profile
										</a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<?php tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() ); ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<div id="tutor-course-details-review-section" class="tutor-mb-48">
		<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24">
			<?php esc_html_e( 'Reviews List', 'tutor-pro' ); ?>
		</div>
		<div class="tutor-table-wrapper tutor-mb-48">
			<table class="tutor-table tutor-table-responsive"  id="tutor-admin-reviews-table">
				<thead>
					<tr>
						<th class="tutor-table-rows-sorting">
							<div class="tutor-align-center tutor-d-flex">
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
								<?php esc_html_e( 'Feedback', 'tutor-pro' ); ?>
							</span>
						</th>
						<th>
							<span></span>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( is_array( $total_reviews ) && count( $total_reviews ) ) : ?>
						<?php foreach ( $total_reviews as $review ) : ?>
						<tr>
							<td data-th="<?php esc_html_e( 'Student', 'tutor-pro' ); ?>" class="student">
								<div class="td-avatar">
									<?php echo tutor_utils()->get_tutor_avatar( $review->user_id ); ?>
									<div class="tutor-fs-6 tutor-fw-medium  tutor-color-black">
										<?php echo esc_html( $review->display_name ); ?>
									</div>
									<a href="<?php echo esc_url( tutor_utils()->profile_url( $review->user_id, false ) ); ?>" class="tutor-iconic-btn" target="_blank">
										<span class="tutor-icon-external-link" area-hidden="true"></span>
									</a>
								</div>
							</td>
							<td data-th="<?php esc_html_e( 'Date', 'tutor-pro' ); ?>" class="date">
								<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
									<?php echo esc_html( tutor_i18n_get_formated_date( $review->comment_date, get_option( 'date_format' ) ) ); ?>, <br />
									<?php echo esc_html( tutor_i18n_get_formated_date( $review->comment_date, get_option( 'time_format' ) ) ); ?>
								</span>
							</td>
							<td data-th="<?php esc_html_e( 'Feedback', 'tutor-pro' ); ?>" class="feedback">
								<div class="td-feedback">
									<div class="td-tutor-rating tutor-fs-6 tutor-color-secondary">
										<div class="tutor-ratings">
											<?php tutor_utils()->star_rating_generator( $review->rating ); ?>
											<div class="tutor-ratings-count tutor-ml-12">
												<?php echo esc_html( number_format( $review->rating, 2 ) ); ?>
											</div>
										</div>
									</div>
									<p class="review-text tutor-color-secondary">
										<?php echo wp_kses_post( $review->comment_content ); ?>
									</p>
								</div>
							</td>
							<td data-th="<?php esc_html_e( 'Action', 'tutor-pro' ); ?>" class="review-action-btns text-align-center">
								<div class="tutor-d-inline-flex tutor-align-center td-action-btns">
									<a class="tutor-btn tutor-btn-outline-primary tutor-delete-recent-reviews" data-id="<?php echo esc_attr( $review->comment_ID ); ?>">
										<?php esc_html_e( 'Delete', 'tutor-pro' ); ?>
									</a>
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

		<?php
			$review_pagination_data = array(
				'base'        => 'admin.php?page=tutor_report&sub_page=courses&course_id=' . $current_id . '&rp=%#%',
				'per_page'    => $per_review,
				'paged'       => max( 1, $review_page ),
				'total_items' => $review_items,
			);
			tutor_load_template_from_custom_path( tutor()->path . 'views/elements/pagination.php', $review_pagination_data, false );
		?>
	</div>
</div>