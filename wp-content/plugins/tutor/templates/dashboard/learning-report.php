<?php

/**
 * @package TutorLMS/Templates
 * @version 1.6.4
 */

use TUTOR\Input;
use \TUTOR_REPORT\Analytics;
global $wpdb;

$course_post_type 		= tutor()->course_post_type;
$lesson_type      		= tutor()->lesson_post_type;
$user_id				= get_current_user_id();
$branchs_count			= ( current_user_can( 'administrator' ) ) ? count(tutor_utils()->get_branchs( )):tutor_utils()->get_user_manage_branchs_total_count($user_id);
$students_count			= ( current_user_can( 'administrator' ) ) ? count(get_users( array('role'    => 'subscriber'))):tutor_utils()->get_user_manage_users_total_count($user_id);
$staff_courses 			= tutor_utils()->get_courses_for_staff( $user_id );
$staff_courses_count 	= ( current_user_can( 'administrator' ) ) ? tutor_utils()->get_course_count():count($staff_courses);
?>

<div class="analytics-title tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16">
    <?php //_e( 'Dashboard', 'tutor' ); ?>
</div>
<div class="tutor-dashboard-content-inner">

	<div class="tutor-dashboard-inline-links">
		<?php
			tutor_load_template( 'dashboard.learning-report.nav-bar', array( 'active_setting_nav' => 'overview' ) );
		?>
	</div>

</div>
<div class="tutor-row tutor-dashboard-cards-container">
	<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-6 tutor-col-lg-4">
		<a href="#<?php //echo tutor_utils()->get_tutor_dashboard_page_permalink( 'learning-report/branchs' );?>">
		<p>
			<span class="tutor-dashboard-round-icon">
				<i class="tutor-icon-company-filled"></i>
			</span>
			<span class="tutor-dashboard-info-val"><?php echo $branchs_count;?></span>
			<span><?php _e( 'Campus', 'tutor' ); ?></span>
		</p>
		</a>
	</div>
	<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-6 tutor-col-lg-4">
		<a href="#<?php //echo tutor_utils()->get_tutor_dashboard_page_permalink( 'learning-report/students' );?>">
		<p>
			<span class="tutor-dashboard-round-icon">
				<i class="tutor-icon-user-graduate-filled"></i>
			</span>
			<span class="tutor-dashboard-info-val"><?php echo $students_count;?></span>
			<span><?php _e( 'Students', 'tutor' ); ?></span>
		</p>
		</a>
	</div>
	<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-6 tutor-col-lg-4">
		<a href="#<?php //echo tutor_utils()->get_tutor_dashboard_page_permalink( 'learning-report/learning' );?>">
		<p>
			<span class="tutor-dashboard-round-icon">
				<i class="tutor-icon-book-open-filled"></i>
			</span>
			<span class="tutor-dashboard-info-val"><?php echo $staff_courses_count;?></span>
			<span><?php _e( 'Courses', 'tutor' ); ?></span>
		</p>
		</a>
	</div>
</div>