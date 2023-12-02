<?php

/**
 * @package TutorLMS/Templates
 * @version 1.6.4
 */
global $wpdb;

$course_post_type 		= tutor()->course_post_type;
$lesson_type      		= tutor()->lesson_post_type;
$user_id				= get_current_user_id();
$active_cid   	        = isset($_GET['cid']) ? sanitize_text_field($_GET['cid']) : '';
$staff_courses 			= ( current_user_can( 'administrator' ) ) ? tutor_utils()->get_courses():tutor_utils()->get_courses_for_staff( $user_id );
$status_arr = array('p'=>'Passed','f'=>'Failed');
$st   	        = isset($_GET['st']) ? sanitize_text_field($_GET['st']) : '';
?>

<div class="analytics-title tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16">
    <?php //_e( 'Dashboard', 'tutor' ); ?>
</div>
<div class="tutor-dashboard-content-inner">

	<div class="tutor-dashboard-inline-links">
		<?php
			tutor_load_template( 'dashboard.learning-report.nav-bar', array( 'active_setting_nav' => 'learning' ) );
		?>
	</div>

</div>
<div class="tutor-dashboard-content-inner">
	<div class="tutor-row tutor-gx-lg-4" >
		<div class="tutor-col-lg-8 tutor-col-xl-8 tutor-mb-16 tutor-mb-lg-16" >
		<select class="tutor-form-select tutor-select-redirector">
			<option value="./?cid=&st=<?php echo $st;?>"><?php _e( 'Please select a course', 'tutor' ); ?></option>
                <?php
                    foreach ($staff_courses as $course) {
                        echo '<option value="./?cid=' . $course->ID . '&st='.$st.'" ' . ($active_cid == $course->ID ? 'selected="selected"' : '') . '>
                            ' . $course->post_title . '
                        </option>';
                    }
                ?>
        </select>
		</div>
		<div class="tutor-col-lg-4 tutor-col-xl-4 tutor-mb-16 tutor-mb-lg-16" >
		<select class="tutor-form-select tutor-select-redirector">
			<option value="./?cid=<?php echo $active_cid;?>&st="><?php _e( 'Status', 'tutor' ); ?></option>
                <?php
                    foreach ($status_arr as $key=>$val) {
                        echo '<option value="./?cid='.$active_cid.'&st=' . $key . '" ' . ($st == $key ? 'selected="selected"' : '') . '>
                            ' . $val . '
                        </option>';
                    }
                ?>
        </select> 
		</div>	
	</div>
</div>		
<?php
$students_all 	= tutor_utils()->get_students_for_course($active_cid,$user_id);
if($active_cid){
	$GPA 			= tutor_utils()->get_course_settings($active_cid, '_tutor_grade_point_average');
	?>
		<div class="popular-courses-heading-dashboard tutor-fs-6 tutor-fw-medium tutor-color-design-brand tutor-capitalize-text tutor-mt-24 tutor-mb-24 qs-progress">
			<center><?php esc_html_e( 'Passing Grade: ', 'tutor' ); ?><?php echo $GPA;?>%</center>
		</div>
<?php		
}
if (is_array($students_all) && count($students_all) ) {
	?>
		<div class="popular-courses-heading-dashboard tutor-fs-6 tutor-fw-medium tutor-color-black tutor-capitalize-text tutor-mb-24 tutor-mt-md-42 tutor-mt-0">
			
		</div>
		<div class="tutor-dashboard-content-inner">
			<table class="tutor-ui-table tutor-ui-table-responsive">
				<thead>
					<tr>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Student', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Enrolled At', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Earned Marks', 'tutor' ); ?></span>
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
								<span class="text-regular-small"><?php esc_html_e( 'Completed At', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( is_array($students_all) && count($students_all) ) : ?>
						<?php
						foreach ( $students_all as $student ) :
							$h5p_p = tutor_utils()->get_course_total_points( $active_cid, $student['ID'] );
							//$h5p_p+= tutor_utils()->get_course_quiz_points( $active_cid, $student['ID'] );
							$is_completed_course = tutor_utils()->is_completed_course( $active_cid, $student['ID'] );
							
							$status = "<span class='tutor-color-muted'>learning</span>";
							$completed_at = "";
							if($is_completed_course){
								$completed_at = $is_completed_course->completion_date;
								if($h5p_p>=$GPA){
									$status = "<span class='tutor-color-success'>passed</span>";
									if($st=='f') continue; 
								}	
								else {
									$status = "<span class='tutor-color-danger-100'>failed</span>";
									if($st=='p') continue;
								}	
							}
							else{
								$completed_at = "<form class='tutor-enrol-course-form' method='post'>
										<input type='hidden' name='tutor_course_id' value='".$active_cid."'>
										<input type='hidden' name='tutor_student_id' value='".$student['ID']."'>
										<input type='hidden' name='tutor_course_action' value='_tutor_course_unenroll_now'>
										<button type='submit' class='tutor-btn add_to_cart_btn tutor-btn-primary tutor-btn-sm tutor-enroll-course-button'>
										Unenroll</button>
									</form>";
							}
							?>
							<tr>
								<td data-th="<?php esc_html_e( 'Student', 'tutor' ); ?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php esc_html_e( $student['user_email'] ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'Enrolled At', 'tutor' ); ?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php esc_html_e( $student['enrolled_at'] ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'Earned Marks', 'tutor' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-fw-normal tutor-color-black-60">
										<?php esc_html_e( $h5p_p); ?>%
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Status', 'tutor' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-fw-normal tutor-color-black-60">
										<?php  echo $status;?>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Completed At', 'tutor' ); ?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php echo $completed_at; ?>
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
	<?php
}
?>