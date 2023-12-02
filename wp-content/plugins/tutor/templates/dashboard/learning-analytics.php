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

if(current_user_can( 'administrator' )){
	$staff_courses_count = count(get_posts( array(
												'fields'         => 'ids',				
												'post_type'  => $course_post_type,
												'post_status'    => 'publish',
												'posts_per_page' => '-1',
												'not_draft_search' 	=> 'Auto Draft',
				'meta_query' =>  [
									'relation' => 'OR',
									[
									  'key' => '_tutor_course_parent',
									  'compare' => 'NOT EXISTS',
									],
									[
									  'key' => '_tutor_course_parent',
									  'compare' => '=',
									  'value' => ''
									]
								 ],					
											) ));
	
	$staff_courses = get_posts( array(
									'post_type'  => $course_post_type,
									'post_status'    => 'publish',
									'posts_per_page' => $per_page,
									'offset'         => $offset	,
									'not_draft_search' 	=> 'Auto Draft',
				'meta_query' =>  [
									'relation' => 'OR',
									[
									  'key' => '_tutor_course_parent',
									  'compare' => 'NOT EXISTS',
									],
									[
									  'key' => '_tutor_course_parent',
									  'compare' => '=',
									  'value' => ''
									]
								 ],				
								) );		
}
elseif(current_user_can( 'shop_manager')||current_user_can( 'st_lt')){
	$staff_courses 			= tutor_utils()->get_courses_for_staff( $user_id );
}
?>
<div class="tutor-d-flex tutor-gx-lg-4" >
	<div class="tutor-col-lg-8 tutor-col-xl-8" >
		<div class=" tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16">
			<?php _e( 'OVERVIEW', 'tutor' ); ?>
		</div>
	</div>
	<div class="tutor-col-lg-4 tutor-col-xl-4 tutor-mb-16 tutor-mb-lg-16" >
		<span class=" tutor-fs-6 tutor-fw-small tutor-color-black">
		<?php ( current_user_can( 'administrator' ) ) ? _e( 'All campuses / All learners', 'tutor' ):''; ?>
		</span>
	</div>	
</div>
		<div class="popular-courses-heading-dashboard tutor-fs-6 tutor-fw-medium tutor-color-black tutor-capitalize-text tutor-mb-24 tutor-mt-md-42 tutor-mt-0">
			
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
								<span class="text-regular-small"><?php esc_html_e( 'Enrollment', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Active', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Average Grade', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Passing Grade', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php if (is_array($staff_courses) && count($staff_courses) ) : ?>					
						<?php
						foreach ( $staff_courses as $course ) :
							
							?>
							<tr>
								<td data-th="<?php esc_html_e( 'course', 'tutor' ); ?>">
									<a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink( 'learning-analytics/detail' );?>?cid=<?php echo $course->ID;?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-primary-main">
										<?php esc_html_e( $course->post_title ); ?>
									</span>
									</a>
								</td>
								<td data-th="<?php esc_html_e( 'enrollment', 'tutor' ); ?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php  $enrollments = get_posts( array(
																	'fields'         => 'id,post_author',
																	'post_type' 	 => 'tutor_enrolled',
																	'post_status'    => 'completed',
																	'post_parent'    => $course->ID,
																	'posts_per_page' => '-1'
																) );
												if(current_user_can( 'administrator' )){
													$students = array_column($enrollments,'post_author');		
												}
												elseif(current_user_can( 'shop_manager')||current_user_can( 'st_lt')){
													$post_author = array_column($enrollments,'post_author');
													$manage_students_all = tutor_utils()->get_user_manage_students_all($user_id, 0, 1000);
													$manage_students = array_column($manage_students_all,'ID');
													$students = array_intersect($post_author, $manage_students);													
												}				
												echo count($students);
										?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'active', 'tutor' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-fw-normal tutor-color-black-60">
										<?php  
											$active_students = 0;
											$average_rate = 0;
											foreach($students as $sid){	
												$completed_percent = tutor_utils()->parent_course_percents_average($course->ID, $sid);
												if ($completed_percent == "notparent")
														$completed_percent = tutor_utils()->get_course_total_points($course->ID, $sid);
												$completed_percent = intval($completed_percent);			
												if($completed_percent){													
													$average_rate+=$completed_percent;
												}
												$active_students+=1;
											}
											echo $active_students;
										?>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'averagepassrate', 'tutor' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-fw-normal tutor-color-black-60">
										<?php  
											if($active_students)
												echo $average_rate=round($average_rate/$active_students, 2)."%";
										?>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'gpa', 'tutor' ); ?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php  
											$GPA = tutor_utils()->get_course_settings($course->ID, '_tutor_grade_point_average');
											echo round($GPA)."%";
										?>
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
		<div class="tutor-mt-20">
			<?php
			if($staff_courses_count > $per_page) {
				$pagination_data = array(
					'total_items' => $staff_courses_count,
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