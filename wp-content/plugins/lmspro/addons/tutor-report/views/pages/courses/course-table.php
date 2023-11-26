<?php
/**
 * Course List Template.
 *
 * @package Course List
 */
/*
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
*/

use TUTOR\Course_List;
use TUTOR_REPORT\Analytics;
use TUTOR_REPORT\CourseAnalytics;

$courses = new Course_List();

/**
 * Short able params
 */
$course_id     = isset( $_GET['course-id'] ) ? sanitize_text_field( $_GET['course-id'] ) : '';
$order_filter  = isset( $_GET['order'] ) ? sanitize_text_field( $_GET['order'] ) : 'DESC';
$date          = isset( $_GET['date'] ) ? sanitize_text_field( $_GET['date'] ) : '';
$search_filter = isset( $_GET['search'] ) ? sanitize_text_field( $_GET['search'] ) : '';
$category_slug = isset( $_GET['category'] ) ? sanitize_text_field( $_GET['category'] ) : '';

/**
 * Determine active tab
 */
$active_tab = isset( $_GET['data'] ) && $_GET['data'] !== '' ? esc_html__( $_GET['data'] ) : 'all';

/**
 * Pagination data
 */
$paged_filter = ( isset( $_GET['paged'] ) && is_numeric( $_GET['paged'] ) && $_GET['paged'] >= 1 ) ? $_GET['paged'] : 1;
$limit        = tutor_utils()->get_option( 'pagination_per_page' );
$offset       = ( $limit * $paged_filter ) - $limit;

/**
 * Navbar data to make nav menu
 */
$add_course_url = esc_url( admin_url( 'post-new.php?post_type=courses' ) );

/**
 * Bulk action & filters
 */
$filters = array(
	'bulk_action'     => false,
	'filters'         => true,
	'category_filter' => true,
);

$args = array(
	'post_type'      => tutor()->course_post_type,
	'orderby'        => 'ID',
	'order'          => $order_filter,
	'paged'          => $paged_filter,
	'offset'         => $offset,
	'posts_per_page' => tutor_utils()->get_option( 'pagination_per_page' ),
);

// if ( 'all' === $active_tab || 'mine' === $active_tab ) {
// $args['post_status'] = array( 'publish', 'pending', 'draft' );
// } else {
// $status              = $active_tab === 'published' ? 'publish' : $active_tab;
// $args['post_status'] = array( $status );
// }
/**
 * For admin report course list will show only published course.
 */
$args['post_status'] = array( 'publish' );

if ( 'mine' === $active_tab ) {
	$args['author'] = get_current_user_id();
}
$date_filter = sanitize_text_field( tutor_utils()->array_get( 'date', $_GET, '' ) );

$year  = date( 'Y', strtotime( $date_filter ) );
$month = date( 'm', strtotime( $date_filter ) );
$day   = date( 'd', strtotime( $date_filter ) );
// Add date query.
if ( '' !== $date_filter ) {
	$args['date_query'] = array(
		array(
			'year'  => $year,
			'month' => $month,
			'day'   => $day,
		),
	);
}

if ( '' !== $course_id ) {
	$args['p'] = $course_id;
}
// Add author param.
if ( 'mine' === $active_tab ) {
	$args['author'] = get_current_user_id();
}
// Search filter.
if ( '' !== $search_filter ) {
	$args['s'] = $search_filter;
}
// Category filter.
if ( '' !== $category_slug ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'course-category',
			'field'    => 'slug',
			'terms'    => $category_slug,
		),
	);
}

$the_query = new WP_Query( $args );

$available_status = array(
	'publish' => __( 'Publish', 'tutor' ),
	'pending' => __( 'Pending', 'tutor' ),
	'draft'   => __( 'Draft', 'tutor' ),
);

?>
<div class="tutor-admin-page-wrapper" id="tutor-report-courses-wrap">
	<div class="tutor-mx-n20">
		<?php
		/**
		 * Load Templates with data.
		 */
		$filters_template = tutor()->path . 'views/elements/filters.php';
		tutor_load_template_from_custom_path( $filters_template, $filters );
		?>
	</div>

	<div class="tutor-report-courses-data-table tutor-mt-24">
		<div class="tutor-table-wrapper">
			<table class="tutor-table tutor-table-responsive table-popular-courses">
				<thead>
					<tr>
						<th>
							<span class="tutor-fs-7 tutor-color-secondary">
								<?php esc_html_e( 'Course', 'tutor-pro' ); ?>
							</span>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Lesson', 'tutor-pro' ); ?>
								</span>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Assignment', 'tutor-pro' ); ?>
								</span>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Total Learners', 'tutor-pro' ); ?>
								</span>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7">
									<?php esc_html_e( 'Earnings', 'tutor-pro' ); ?>
								</span>
							</div>
						</th>
						<th>
							<div class="tutor-d-inline-flex tutor-align-center tutor-color-secondary">
								<span class="tutor-fs-7"></span>
							</div>
						</th>
					</tr>
				</thead>

				<tbody>
					<?php if ( $the_query->have_posts() ) : ?>
						<?php foreach ( $the_query->posts as $course ) : ?>
							<?php
								$count_lesson     = tutor_utils()->get_lesson_count_by_course( $course->ID );
								$count_assignment = tutor_utils()->get_assignments_by_course( $course->ID )->count;
								$student_details  = CourseAnalytics::course_enrollments_with_student_details( $course->ID );
								$total_student    = $student_details['total_enrollments'];
								$earnings         = Analytics::get_earnings_by_user( 0, '', '', '', $course->ID )['total_earnings'];
							?>
							<tr>

								<td data-th="<?php esc_attr_e( 'Course Name', 'tutor-pro' ); ?>" class="course-name">
									<div class="tutor-color-black td-course tutor-fs-6 tutor-fw-medium">
										<a>
											<?php echo esc_html( $course->post_title ); ?>
										</a>
									</div>
								</td>
								<td data-th="<?php esc_attr_e( 'Lesson', 'tutor-pro' ); ?>" class="lesson">
									<span class="tutor-color-black tutor-fs-7 tutor-fw-medium">
										<?php echo esc_html( $count_lesson ); ?>
									</span>
								</td>
								<td data-th="<?php esc_attr_e( 'Assignment', 'tutor-pro' ); ?>" class="assignment">
									<span class="tutor-color-black tutor-fs-7 tutor-fw-medium">
										<?php echo esc_html( $count_assignment ); ?>
									</span>
								</td>
								<td data-th="<?php esc_attr_e( 'Total Learners', 'tutor-pro' ); ?>" class="total-learners">
									<span class="tutor-color-black tutor-fs-7 tutor-fw-medium">
										<?php echo esc_html( $total_student ); ?>
									</span>
								</td>
								<td data-th="<?php esc_attr_e( 'Earnings', 'tutor-pro' ); ?>" class="earnings">
									<span class="tutor-color-black tutor-fs-7 tutor-fw-medium">
										<?php echo wp_kses_post( tutor_utils()->tutor_price( $earnings ) ); ?>
									</span>
								</td>
								<td data-th="<?php esc_attr_e( 'URL', 'tutor-pro' ); ?>" class="url">
									<div class="tutor-d-inline-flex tutor-align-center td-action-btns">
										<a href="<?php echo esc_url( admin_url( 'admin.php?page=tutor_report&sub_page=courses&course_id=' . $course->ID ) ); ?>" class="tutor-btn tutor-btn-outline-primary tutor-btn-sm">
											Details
										</a>
										<a href="<?php echo esc_url( get_permalink( $course->course_id ) ); ?>" class="tutor-iconic-btn" target="_blank">
											<span class="tutor-icon-external-link"></span>
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
	</div>

	<div class="tutor-admin-page-pagination-wrapper tutor-mt-32">
		<?php
		/**
		 * Prepare pagination data & load template
		 */
		if($the_query->found_posts > $limit) {
			$pagination_data     = array(
				'total_items' => $the_query->found_posts,
				'per_page'    => $limit,
				'paged'       => $paged_filter,
			);
			$pagination_template = tutor()->path . 'views/elements/pagination.php';
			tutor_load_template_from_custom_path( $pagination_template, $pagination_data );
		}
		?>
	</div>
</div>
