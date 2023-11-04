<?php
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
$per_page    = tutor_utils()->get_option( 'pagination_per_page' );
$offset      = ( $per_page * $paged ) - $per_page;
$course_id   = isset( $_GET['course-id'] ) ? $_GET['course-id'] : '';
$date_filter = isset( $_GET['date'] ) && $_GET['date'] != '' ? $_GET['date'] : '';

$orderby = '';
if ( isset( $_GET['orderby'] ) && $_GET['orderby'] == 'registration_date' ) {
	$orderby = 'registration_date';
} elseif ( isset( $_GET['orderby'] ) && $_GET['orderby'] == 'course_taken' ) {
	$orderby = 'course_taken';
} else {
	$orderby = 'student';
}

$order      = ( ! isset( $_GET['order'] ) || $_GET['order'] !== 'desc' ) ? 'asc' : 'desc';
$sort_order = array( 'order' => $order == 'asc' ? 'desc' : 'asc' );

$student_sort           = http_build_query( array_merge( $_GET, ( $orderby == 'student' ? $sort_order : array() ), array( 'orderby' => 'student' ) ) );
$registration_date_sort = http_build_query( array_merge( $_GET, ( $orderby == 'registration_date' ? $sort_order : array() ), array( 'orderby' => 'registration_date' ) ) );
$course_taken_sort      = http_build_query( array_merge( $_GET, ( $orderby == 'course_taken' ? $sort_order : array() ), array( 'orderby' => 'course_taken' ) ) );

$student_sort_icon      = $orderby == 'student' ? ( strtolower( $order ) == 'asc' ? 'up' : 'down' ) : 'up';
$register_sort_icon     = $orderby == 'registration_date' ? ( strtolower( $order ) == 'asc' ? 'up' : 'down' ) : 'up';
$course_taken_sort_icon = $orderby == 'course_taken' ? ( strtolower( $order ) == 'asc' ? 'up' : 'down' ) : 'up';

$search_filter = isset( $_GET['search'] ) ? $_GET['search'] : '';

$students = tutor_utils()->get_students_by_instructor( $user->ID, $offset, $per_page, $search_filter, $course_id, $date_filter, $sort_order, $order );
$courses  = tutor_utils()->get_courses_by_instructor();
?>
<div class="tutor-analytics-students">
	<div class="tutor-analytics-students-wrapper ">
		<div class="tutor-form-group">
			<form action="" method="get" id="tutor_analytics_search_form">
				<label class="tutor-form-label" for="" style="opacity: 0">
					<?php _e( 'Search', 'tutor-pro' ); ?>
				</label>
				<div class="tutor-form-wrap">
					<span class="tutor-icon-search tutor-form-icon" area-hidden="true"></span>
					<input type="search" class="tutor-form-control" autocomplete="off" name="search" placeholder="<?php esc_attr_e( 'Search...', 'tutor-pro' ); ?>">
				</div>
			</form>

		</div>
		<div class="tutor-form-group">
			<label class="tutor-form-label" for="">
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
		<div class="tutor-form-group">
			<label class="tutor-form-label"><?php _e( 'Date', 'tutor-pro' ); ?></label>
			<div class="tutor-v2-date-picker"></div>
		</div>
	</div>

	<div class="students-wrapper tutor-mt-24 tutor-mb-40">
		<div class="tutor-table-wrapper">
			<table class="tutor-table tutor-table-responsive">
				<thead>
					<tr>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center">
								<span class="tutor-color-secondary tutor-fs-7">
									<?php _e( 'Student', 'tutor-pro' ); ?>
								</span>
								<a href="?<?php echo $student_sort; ?>">
									<img src="<?php echo esc_url( tutor_pro()->url ); ?>assets/images/order-<?php echo $student_sort_icon; ?>.svg"/>
								</a>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center">
								<span class="tutor-color-secondary tutor-fs-7">
									<?php _e( 'Registration Date', 'tutor-pro' ); ?>
								</span>
								<a href="?<?php echo $registration_date_sort; ?>">
									<img src="<?php echo esc_url( tutor_pro()->url ); ?>assets/images/order-<?php echo $register_sort_icon; ?>.svg"/>
								</a>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center">
								<span class="tutor-color-secondary tutor-fs-7">
									<?php _e( 'Course Taken', 'tutor-pro' ); ?>
								</span>
								<a href="?<?php echo $course_taken_sort; ?>">
									<img src="<?php echo esc_url( tutor_pro()->url ); ?>assets/images/order-<?php echo $course_taken_sort_icon; ?>.svg"/>
								</a>
							</div>
						</th>
						<th class="tutor-shrink"></th>
					</tr>
				</thead>
				<tbody>
					<?php if ( count( $students['students'] ) ) : ?>
						<?php foreach ( $students['students'] as $student ) : ?>
							<tr>
								<td data-th="<?php _e( 'Student', 'tutor-pro' ); ?>">
									<?php
										$first_name = get_user_meta( $student->ID, 'first_name', true );
										$last_name  = get_user_meta( $student->ID, 'last_name', true );
										$name       = esc_html__( $student->display_name );
									if ( '' === $name ) {
										$name = $first_name . ' ' . $last_name;
									}
									?>
									<div class="td-avatar">
										<?php echo tutor_utils()->get_tutor_avatar( $student->ID ); ?>
										<div>
											<div class="tutor-color-black tutor-fs-6 tutor-fw-medium">
												<?php echo $name; ?>
											</div>
											<div class="tutor-color-muted tutor-fs-7">
												<?php esc_html_e( $student->user_email ); ?>
											</div>
										</div>
									</div>
								</td>
								<td data-th="<?php _e( 'Registration Date', 'tutor-pro' ); ?>">
									<span class="tutor-color-black tutor-fs-7">
										<?php esc_html_e( tutor_get_formated_date( get_option( 'date_format' ), $student->user_registered ) ); ?>
									</span>
								</td>
								<td data-th="<?php _e( 'Course Taken', 'tutor-pro' ); ?>">
									<span class="tutor-color-black tutor-fs-7">
										<?php esc_html_e( $student->course_taken ); ?>
									</span>
								</td>
								<td data-th="<?php _e( '-', 'tutor-pro' ); ?>" class="td-action-btns">
									<a href="<?php echo esc_url( tutor_utils()->tutor_dashboard_url() . "analytics/student-details?student_id=$student->ID" ); ?>" class="tutor-btn tutor-btn-outline-primary tutor-btn-sm">
										<?php _e( 'Details', 'tutor-pro' ); ?>
									</a>
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
		if($students['total_students'] > $per_page) {
			$pagination_data = array(
				'total_items' => $students['total_students'],
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
