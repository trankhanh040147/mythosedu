<?php
/**
 * Gradebook List Template.
 *
 * @package Gradebook List
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \TUTOR\Tutor;
use TUTOR_GB\GradeBook;
$gradebook = new GradeBook();


/**
 * Short able params
 */
$user_id   = isset( $_GET['user_id'] ) ? $_GET['user_id'] : '';
$course_id = isset( $_GET['course-id'] ) ? $_GET['course-id'] : '';
$order     = isset( $_GET['order'] ) ? $_GET['order'] : 'DESC';
$date      = isset( $_GET['date'] ) ? tutor_get_formated_date( 'Y-m-d', $_GET['date'] ) : '';
$search    = isset( $_GET['search'] ) ? $_GET['search'] : '';

/**
 * Determine active tab
 */
$active_tab = isset( $_GET['data'] ) && $_GET['data'] !== '' ? esc_html__( $_GET['data'] ) : 'overview';

/**
 * Pagination data
 */


// $gradebook_list = tutor_utils()->get_gradebooks($offset, $per_page, $search, $user_id, $date, $order, $course_id );
// $total            = tutor_utils()->get_total_gradebooks($active_tab, $search, $user_id, $date, $course_id);

/**
 * Navbar data to make nav menu
 */
$url                        = get_pagenum_link();
$add_gradebook_url          = $url . '&sub_page=add_new_gradebook';
$add_gradebook_settings_url = $url . '&sub_page=gradebooks';

$filters = array(
	'bulk_action'   => false,
	'filters'       => true,
	'course_filter' => true,
);

$per_page     = get_tutor_option( 'pagination_per_page', 10 );
$current_page = isset( $_GET['paged'] ) ? $_GET['paged'] : 1;
$start        = max( 0, ( $current_page - 1 ) * $per_page );


$course_id  = (int) sanitize_text_field( tutor_utils()->array_get( 'course-id', $_GET ) );
$gradebooks = get_generated_gradebooks(
	array(
		'course_id' => $course_id,
		'start'     => $start,
		'limit'     => $per_page,
	)
);

$navbar_data = array(
	'page_title' => $gradebook->page_title,
	'tabs'       => $gradebook->tabs_key_value( $course_id ),
	'active'     => $active_tab,
);
?>

<div class="tutor-admin-wrap">
	<?php
		/**
		 * Load Templates with data.
		 */
		$navbar_template = tutor()->path . 'views/elements/navbar.php';
		tutor_load_template_from_custom_path( $navbar_template, $navbar_data );
		$filters_template = tutor()->path . 'views/elements/filters.php';
		tutor_load_template_from_custom_path( $filters_template, $filters );
	?>
	<div class="tutor-admin-body">
		<div class="tutor-table-wrapper tutor-mt-24">
			<table class="tutor-table tutor-table-responsive table-gradebook">
				<thead>
					<tr>
						<th class="tutor-table-rows-sorting">
							<div class="tutor-color-secondary">
							<span class="tutor-fs-7 tutor-ml-1"> <?php esc_html_e( 'Completed Date', 'tutor-pro' ); ?></span>
							<span class="a-to-z-sort-icon tutor-icon-ordering-a-z"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="tutor-color-secondary">
							<span class="tutor-fs-7 tutor-ml-1"> <?php esc_html_e( 'Course', 'tutor-pro' ); ?></span>
							<span class="a-to-z-sort-icon tutor-icon-ordering-a-z"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="tutor-color-secondary">
							<span class="tutor-fs-7"><?php esc_html_e( 'Name', 'tutor-pro' ); ?></span>
							<span class="a-to-z-sort-icon tutor-icon-ordering-a-z"></span>
							</div>
						</th>
						<th>
							<div class="tutor-color-secondary">
							<span class="tutor-fs-7"><?php esc_html_e( 'Quiz', 'tutor-pro' ); ?></span>
							</div>
						</th>
						<th>
							<div class="tutor-color-secondary">
							<span class="tutor-fs-7"><?php esc_html_e( 'Assignments', 'tutor-pro' ); ?></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="tutor-color-secondary">
							<span class="tutor-fs-7"><?php esc_html_e( 'Final Grade', 'tutor-pro' ); ?></span>
							<span class="tutor-icon-order-down up-down-icon"></span>
							</div>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php if ( is_array( $gradebooks->res ) && count( $gradebooks->res ) ) : ?>
					<?php
					$course_ids = array_column($gradebooks->res, 'course_id');
					$course_meta_data = tutor_utils()->get_course_meta_data($course_ids);
					$authors = array();

					foreach ( $gradebooks->res as $gradebook ) :
						$course_id_single = (int)$gradebook->course_id;
						$quiz_grade       = get_quiz_gradebook_by_course( $gradebook->course_id, $gradebook->user_id );
						$assignment_grade = get_assignment_gradebook_by_course( $gradebook->course_id, $gradebook->user_id );
						$total_quiz       = isset($course_meta_data[$course_id_single]) ? $course_meta_data[$course_id_single]['tutor_quiz'] : 0;
						$total_assignment = isset($course_meta_data[$course_id_single]) ? $course_meta_data[$course_id_single]['tutor_assignments'] : 0;

						!isset($authors[$gradebook->user_id]) ? $authors[$gradebook->user_id] = get_userdata( $gradebook->user_id ) : 0;
						$user_info = $authors[$gradebook->user_id];
						?>
							<tr>
								<td data-th="<?php esc_html_e( 'Completed Date ', 'tutor-pro' ); ?>" class="column-fullwidth">
									<span class="tutor-color-black tutor-fs-7">
										<?php echo esc_html( tutor_get_formated_date( get_option( 'date_format' ), $gradebook->update_date ) ); ?>,<br>
										<?php echo esc_html( tutor_get_formated_date( get_option( 'time_format' ), $gradebook->update_date ) ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'Course', 'tutor-pro' ); ?>">
									<div class="td-avatar">
										<span class="tutor-color-black tutor-fs-7">
										<?php echo esc_html( $gradebook->course_title ); ?>
										</span>
										<a href="<?php echo esc_url( get_permalink( $gradebook->course_id ) ); ?>" class="tutor-iconic-btn" target="_blank">
											<span class="tutor-icon-external-link"></span>
										</a>
									</div>
									<div class="tutor-d-flex tutor-fs-8 tutor-fw-medium">
										<div class="tutor-mr-12">
											<span class="tutor-color-secondary"><?php esc_html_e( 'Quiz Complete: ' ); ?></span><span ><?php echo esc_html( $gradebook->quiz_count . '/' . $total_quiz ); ?></span>
										</div>
										<div>
											<span class="tutor-color-secondary"><?php esc_html_e( 'Assignment Complete: ' ); ?></span><span ><?php echo esc_html( $gradebook->assignment_count . '/' . $total_assignment ); ?></span>
										</div>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Name', 'tutor-pro' ); ?>">
									<div class="td-avatar">
										<div>
											<?php echo tutor_utils()->get_tutor_avatar( $gradebook->user_id ); ?>
										</div>
										<div>
											<span class="tutor-color-black tutor-fs-6 tutor-fw-medium tutor-mr-12">
												<?php echo esc_html( $gradebook->display_name ); ?>
											</span>
											<div class="tutor-fs-7 tutor-my-0">
												<?php echo ($user_info && is_object($user_info)) ? esc_html( $user_info->user_email ) : ''; ?>
											</div>
										</div>

										<div>
											<a href="<?php echo esc_url( tutor_utils()->profile_url( $gradebook->user_id, false ) ); ?>" class="tutor-iconic-btn" target="_blank">
												<span class="tutor-icon-external-link"></span>
											</a>
										</div>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Quiz', 'tutor-pro' ); ?>">
									<div class="tutor-color-black tutor-fs-7">
										<span><?php echo wp_kses_post( tutor_generate_grade_html( $quiz_grade, 'outline' ) ); ?></span>
										<?php if ( $quiz_grade ) : ?>
											<span>(<?php echo esc_html( number_format( $quiz_grade->earned_grade_point, 2 ) . '/' . number_format( $quiz_grade->grade_point, 2 ) ); ?>)</span>
										<?php endif; ?>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Assignment', 'tutor-pro' ); ?>">
									<div>
										<span class="tutor-color-black tutor-fs-7">
											<?php echo wp_kses_post( tutor_generate_grade_html( $assignment_grade, 'outline' ) ); ?>
										</span>
										<?php if ( $assignment_grade ) : ?>
											<span>(<?php echo esc_html( number_format( $assignment_grade->earned_grade_point, 2 ) . '/' . number_format( $assignment_grade->grade_point, 2 ) ); ?>)</span>
										<?php endif; ?>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Final Grade', 'tutor-pro' ); ?>">
									<div>
										<span class="tutor-color-black tutor-fs-7">
											<?php echo wp_kses_post( tutor_generate_grade_html( $gradebook ) ); ?>
										</span>
										<span>(<?php echo esc_html( number_format( $gradebook->earned_grade_point, 2 ) . '/' . number_format( $gradebook->grade_point, 2 ) ); ?>)</span>
									</div>
								</td>
							</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr>
						<td colspan="100%"  class="column-empty-state">
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
		$total = $gradebooks ? $gradebooks->count : 0;
		if($total > $per_page) {
			$pagination_data     = array(
				'total_items' => $total,
				'per_page'    => $per_page,
				'paged'       => $current_page,
			);
			$pagination_template = tutor()->path . 'views/elements/pagination.php';
			tutor_load_template_from_custom_path( $pagination_template, $pagination_data );
		}
		?>
	</div>
</div>