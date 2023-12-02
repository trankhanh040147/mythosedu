<?php

/**
 * @package TutorLMS/Templates
 * @version 1.6.4
 */

use TUTOR\Input;
use \TUTOR_REPORT\Analytics;
global $wp_query, $wp;

$course_post_type 		= tutor()->course_post_type;
$user_id				= isset($_GET['sid']) ? sanitize_text_field($_GET['sid']) : '';
$course_id   	        = isset($_GET['cid']) ? sanitize_text_field($_GET['cid']) : '';

$paged    = 1;

?>
<div class="tutor-d-flex tutor-gx-lg-4" >
	<div class="tutor-col-lg-8 tutor-col-xl-8" >
		<div class=" tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16">
			<?php echo get_the_title( $course_id ); ?>
		</div>
	</div>	
	<div class="tutor-col-lg-4 tutor-col-xl-4 tutor-mb-16 tutor-mb-lg-16" >
		<span class=" tutor-fs-6 tutor-fw-small tutor-color-black">Student: 
		<?php $u_data = get_userdata($user_id );
		esc_html_e( $u_data->display_name ); ?>
		</span>
	</div>
</div>
<?php 
	$children_ids = trim(get_post_meta( $course_id, '_tutor_course_children', true ));
	$children_ids_arr = $children_ids? explode(" ",$children_ids):array();
	if (is_array($children_ids_arr) && count($children_ids_arr) ):
?>
		<div class="tutor-dashboard-content-inner">
			<table class="tutor-ui-table tutor-ui-table-responsive">
				<thead>
					<tr>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Childen Course', 'tutor' ); ?></span>
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
								<span class="text-regular-small"><?php esc_html_e( 'Status', 'tutor' ); ?></span>
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
					
						<?php
						foreach ( $children_ids_arr as $child_id ) :
							if ( !$child_id || 'publish' !== get_post_status( $child_id ) ) {
								continue;
							}
							$completed_percent = tutor_utils()->get_course_total_points( $child_id, $user_id );
							$is_completed_course = tutor_utils()->is_completed_course( $child_id, $user_id );
							$GPA = tutor_utils()->get_course_settings($child_id, '_tutor_grade_point_average');
							$status = "<span class='tutor-color-muted'>learning</span>";
							
							if($is_completed_course){
								if($completed_percent>=$GPA){
									$status = "<span class='tutor-color-success'>passed</span>";
								}	
								else {
									$status = "<span class='tutor-color-danger-100'>failed</span>";
								}
							}
							
							?>
							<tr>
								<td data-th="<?php esc_html_e( 'course', 'tutor' ); ?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php echo get_the_title( $child_id ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'progress', 'tutor' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-fw-normal tutor-color-black-60">
										<?php if($completed_percent)	echo $completed_percent."%"; ?>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'status', 'tutor' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-fw-normal tutor-color-black-60">
										<?php  echo $status;?>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'passing-grade', 'tutor' ); ?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php echo $GPA; ?>%
									</span>
								</td>
							</tr>
							<?php endforeach; ?>
						
				</tbody>
			</table>
		</div>
<?php		
else:
	
	global $post;
	$topics = tutor_utils()->get_topics( $course_id );
				if ( $topics->have_posts() ) {
					while ( $topics->have_posts() ) {
						$topics->the_post();
						$topic_id       = get_the_ID();
						$topic_title  = get_the_title();						
						?>
						<div class="h5p_detail_flex">
														<div class="h5p_detail_left">
														<span class="progress-percentage tutor-fs-7 tutor-fw-bold tutor-color-muted">
															<?php echo $topic_title;?>
														</span>
														</div>
														<div class="h5p_detail_right">
														
														</div>
														</div>
							<?php
								$lessons = tutor_utils()->get_course_contents_by_topic( $topic_id, -1 );								

								while ( $lessons->have_posts() ) {
									$lessons->the_post();
									/////////////////////////////////////////////////////////////
									if ( $post->post_type === 'tutor_quiz' ) {
										$quiz_of_course = $post;
										$passing_grade = tutor_utils()->get_grade_value($grade_category,$course_id);
												$attempt_of_quiz = tutor_utils()->get_quiz_attempt($quiz_of_course->ID,$user_id);
												
												$max_score =number_format($attempt_of_quiz->total_marks);
												$score =number_format($attempt_of_quiz->earned_marks);
												
												if($max_score){
													//$GPA = tutor_utils()->get_course_settings($course_id, '_tutor_grade_point_average');
													?>
													<div class="h5p_detail_flex">
													<div class="h5p_detail_left">
													<span class="progress-percentage tutor-fs-7 tutor-fw-normal tutor-color-muted">
														<?php echo $quiz_of_course->post_title; ?>
													</span>
													</div>
													<div class="h5p_detail_right">
													<span class="progress-percentage tutor-fs-7 tutor-fw-normal tutor-color-muted">
														<?php echo $score; ?>/<?php echo $max_score; ?>
													</span>
													</div>
													</div>
													
											
										<?php
												}
											
									} elseif ( $post->post_type === 'tutor_assignments' ) {
										
									} elseif ( $post->post_type === 'tutor_zoom_meeting' ) {
										
										
									} else {

										/**
										 * Lesson
										 */
										//echo $post->post_type;	
										$lession_of_course = $post;
										//echo $lession_of_course->ID;
										$h5p_id = tutor_utils()->get_h5p_option($lession_of_course->ID, 'h5p_id');
													if(!$h5p_id) continue;
													//echo $grade_category = tutor_utils()->get_h5p_option($lession_of_course->ID, 'grade_category');
													//if($grade_category!=$grade_key) continue;
													$passing_grade = tutor_utils()->get_grade_value($grade_category,$course_id);													
													$attempt_of_h5p = tutor_utils()->get_h5p_attempt($h5p_id,$user_id,$course_id);
													$max_score =$attempt_of_h5p->max_score;
													$score =$attempt_of_h5p->score;
													if($max_score){
													
														//$GPA = tutor_utils()->get_course_settings($course_id, '_tutor_grade_point_average');
														//$earned_percentage= number_format(($score/ $max_score)*$passing_grade);
														?>
														<div class="h5p_detail_flex">
														<div class="h5p_detail_left">
														<span class="progress-percentage tutor-fs-7 tutor-fw-normal tutor-color-muted">
															<?php echo $lession_of_course->post_title; ?>
														</span>
														</div>
														<div class="h5p_detail_right">
														<span class="progress-percentage tutor-fs-7 tutor-fw-normal tutor-color-muted">
															<?php echo $score; ?>/<?php echo $max_score; ?>
														</span>
														</div>
														</div>
														<?php
													}	
									}
								}
								$lessons->reset_postdata();
							?>
						<?php
					}
					$topics->reset_postdata();
					wp_reset_postdata();
				}
				endif; ?>		