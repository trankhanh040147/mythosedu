<?php

/**
 * @package TutorLMS/Templates
 * @version 1.6.4
 */

use TUTOR\Input;
use \TUTOR_REPORT\Analytics;
global $wp_query, $wp;

$course_post_type 		= tutor()->course_post_type;
$user_id				= get_current_user_id();

$paged    = 1;

if ( isset( $_GET['current_page'] ) && is_numeric( $_GET['current_page'] ) ) {
	$paged = $_GET['current_page'];
}
$per_page    = tutor_utils()->get_option( 'pagination_per_page' );
$offset      = ( $per_page * $paged ) - $per_page;

$active_sid   	        = isset($_GET['sid']) ? sanitize_text_field($_GET['sid']) : '';

$enrolled_course_ids = tutor_utils()->get_enrolled_courses_ids_by_user( $active_sid );


?>
<div class="tutor-d-flex tutor-gx-lg-4" >
	<div class="tutor-col-lg-8 tutor-col-xl-8" >
		<div class=" tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16">
			<?php _e( 'STUDENT LEARNING', 'tutor' ); ?>
		</div>
	</div>
	<div class="tutor-col-lg-4 tutor-col-xl-4 tutor-mb-16 tutor-mb-lg-16" >
		<span class=" tutor-fs-6 tutor-fw-small tutor-color-black">
		
		</span>
	</div>	
</div>
<div class="popular-courses-heading-dashboard tutor-fs-6 tutor-fw-medium tutor-color-primary-main tutor-capitalize-text tutor-mb-24 tutor-mt-md-42 tutor-mt-0">
	<?php $student = get_user_by( 'id', $active_sid );echo $student->display_name; ?>
</div>

		<div class="tutor-dashboard-content-inner">
			<table class="tutor-ui-table tutor-ui-table-responsive">
				<thead>
					<tr>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Course', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Passing Grade', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Progress', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Status', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php if (is_array($enrolled_course_ids) && count($enrolled_course_ids) ) : ?>					
						<?php
						foreach ( $enrolled_course_ids as $course ) :
                            if ( 'publish' !== get_post_status( $course ) ) {
                                continue;
                            }
							$h5p_p = tutor_utils()->get_course_total_points( $course, $active_sid );
							//$h5p_p+= tutor_utils()->get_course_quiz_points( $course, $active_sid );
							$is_completed_course = tutor_utils()->is_completed_course( $course, $active_sid );
							if($h5p_p)
								$status = "<span class='tutor-color-muted'>learning</span>";
							if($is_completed_course){
								if($h5p_p>=$GPA){
									$status = "<span class='tutor-color-success'>passed</span>";
								}	
								else {
									$status = "<span class='tutor-color-danger-100'>failed</span>";
								}	
							}
							//$u_data = get_userdata($student);
                            $GPA = tutor_utils()->get_course_settings($course, '_tutor_grade_point_average');

							?>
							<tr>
								<td data-th="<?php esc_html_e( 'course', 'tutor' ); ?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php echo get_the_title( $course ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'gpa', 'tutor' ); ?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php
											echo round($GPA)."%";
										?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'progress', 'tutor' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-fw-normal tutor-color-black-60">
										<?php if($h5p_p)	echo $h5p_p."%"; ?>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'status', 'tutor' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-fw-normal tutor-color-black-60">
										<?php  echo $status;?>
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