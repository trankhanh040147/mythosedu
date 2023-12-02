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

$active_cid   	        = isset($_GET['cid']) ? sanitize_text_field($_GET['cid']) : '';
$GPA = tutor_utils()->get_course_settings($active_cid, '_tutor_grade_point_average');
$enrollments = get_posts( array(
							'fields'         => 'id,post_author',
							'post_type' 	 => 'tutor_enrolled',
							'post_status'    => 'completed',
							'post_parent'    => $active_cid,
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
$internal_count=0;
$external_count=0;

$male_count=0;
$female_count=0;
$others_count=0;

$age_total=0;
$age_count=0;

foreach ( $students as $student ) {
    $user_existed = get_userdata( $student );
	if ( $user_existed === false ) {
		continue;
	}
	$_tutor_vus_member = esc_attr( get_user_meta( $student, '_tutor_vus_member', true ) );
	if($_tutor_vus_member=='Internal') $internal_count+=1;
	else $external_count+=1;
	
	$_tutor_gender = esc_attr( get_user_meta( $student, '_tutor_gender', true ) );
	if($_tutor_gender=='Male') $male_count+=1;
	elseif($_tutor_gender=='Female') $female_count+=1;
	else $others_count+=1;
	
	$age = get_user_meta( $student, '_tutor_age', true );
	if($age){
	$tz  = new DateTimeZone('Asia/Ho_Chi_Minh');
	$_tutor_age = DateTime::createFromFormat('Y-m-d', $age, $tz)->diff(new DateTime('now', $tz))->y;
	$_tutor_age = intval($_tutor_age);
	if($_tutor_age) {
		$age_total+=$_tutor_age;
		$age_count+=1;
	}
	}
}
if($age_count)
		$average_age = round($age_total/$age_count);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js"></script>
<div class="tutor-d-flex tutor-gx-lg-4" >
	<div class="tutor-col-lg-8 tutor-col-xl-8" >
		<div class=" tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16">
			<?php _e( 'TEACHING CRITICAL THINKING', 'tutor' ); ?>
		</div>
	</div>
	<div class="tutor-col-lg-4 tutor-col-xl-4 tutor-mb-16 tutor-mb-lg-16" >
		<span class=" tutor-fs-6 tutor-fw-small tutor-color-black">
		<?php ( current_user_can( 'administrator' ) ) ? _e( 'All campuses / All learners', 'tutor' ):''; ?>
		</span>
	</div>	
</div>
<div class="popular-courses-heading-dashboard tutor-fs-6 tutor-fw-medium tutor-color-primary-main tutor-capitalize-text tutor-mb-24 tutor-mt-md-42 tutor-mt-0">
	<?php echo get_the_title( $active_cid ); ?>
</div>
<div class="tutor-row tutor-dashboard-cards-container">
	<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-6 tutor-col-lg-4">
		<p>
			<canvas id="myChart_internal_external" style="width:100%;max-width:600px"></canvas>
			<!--<?php echo $internal_count;?> - <?php _e( 'Internal', 'tutor' ); ?></br> -->
			<!--<?php echo $external_count;?> - <?php _e( 'External', 'tutor' ); ?>-->
		</p>
	</div>
	<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-6 tutor-col-lg-4">
		<p>
			<canvas id="myChart_male_female_other" style="width:100%;max-width:600px"></canvas>
			<!--<?php echo $male_count;?> - <?php _e( 'Male', 'tutor' ); ?></br> -->
			<!--<?php echo $female_count;?> - <?php _e( 'Female', 'tutor' ); ?></br>-->
			<!--<?php echo $others_count;?> - <?php _e( 'Others', 'tutor' ); ?>-->
		</p>
	</div>
	<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-6 tutor-col-lg-4">
		<p>
			<?php _e( 'Average Age', 'tutor' ); ?><br>
			<span id="average_age_tutor"><?php echo $average_age;?> </span>
		</p>
		
	</div>
</div>
		<div class="tutor-dashboard-content-inner">
			<table class="tutor-ui-table tutor-ui-table-responsive">
				<thead>
					<tr>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Teacher Code', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Campus', 'tutor' ); ?></span>
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
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Passing Grade', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
						<th class="">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small">Unenroll</span>
							</div>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php if (is_array($students) && count($students) ) : ?>					
						<?php
						foreach ( $students as $student ) :
                            $user_existed = get_userdata( $student );
							if ( $user_existed === false ) {
								continue;
							}
							$completed_percent = tutor_utils()->parent_course_percents_average($active_cid, $student);
							if ($completed_percent == "notparent")
									$completed_percent = tutor_utils()->get_course_total_points( $active_cid, $student);
							$completed_percent = intval($completed_percent);													
							$is_completed_course = tutor_utils()->is_completed_course( $active_cid, $student );
							$status="";
							if($completed_percent)
								$status = "<span class='tutor-color-muted'>learning</span>";
							if($is_completed_course){
								if($completed_percent>=$GPA){
									$status = "<span class='tutor-color-success'>passed</span>";
								}	
								else {
									$status = "<span class='tutor-color-danger-100'>failed</span>";
								}	
							}
							$u_data = get_userdata($student);
							?>
							<tr>
								<td data-th="<?php esc_html_e( 'teacher', 'tutor' ); ?>">
                                    <a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink( 'learning-analytics/course-student' );?>?cid=<?php echo $active_cid;?>&sid=<?php echo $student;?>">
										<span class="tutor-fs-7 tutor-fw-medium  tutor-color-primary-main">
											<?php esc_html_e( $u_data->display_name ); ?>
										</span>
									</a>
								</td>
								<td data-th="<?php esc_html_e( 'campus', 'tutor' ); ?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php esc_html_e( $u_data->Branch_Name ); ?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'progress', 'tutor' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-fw-normal tutor-color-black-60">
										<?php echo $completed_percent."%"; ?>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'status', 'tutor' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-fw-normal tutor-color-black-60">
										<?php  echo $status;?>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'gpa', 'tutor' ); ?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
										<?php
											echo round($GPA)."%";
										?>
									</span>
								</td>
								<td data-th="<?php esc_html_e( 'unenroll', 'tutor' ); ?>">
									<form class='tutor-enrol-course-form' method='post'>
										<input type='hidden' name='tutor_course_id' value='<?php echo $active_cid;?>'>
										<input type='hidden' name='tutor_student_id' value='<?php echo $student;?>'>
										<input type='hidden' name='tutor_course_action' value='_tutor_course_unenroll_now'>
										<button type='submit' class='tutor-btn add_to_cart_btn tutor-btn-primary tutor-btn-sm tutor-enroll-course-button'>
										Unenroll</button>
									</form>
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
		<script>
			//myChart_internal_external
			var ctx = document.getElementById("myChart_internal_external").getContext("2d");
			var xValues = ["Internal", "External"]
			var yValues = [<?php echo $internal_count; ?>,<?php echo $external_count; ?>]
			var barColors = ["#b91d47","#00aba9"];
			var chart = new Chart("myChart_internal_external", {
				type: "pie",
				data: {
				  labels: xValues,
				  datasets: [{
					backgroundColor: barColors,
					data: yValues
				  }]
				},
				options: {
					tooltips: {
						enabled: false
					  },
					  plugins: {
						title: {
							display: true,
							text: "Internal/External"
						},
						datalabels: {
						  formatter: (value, ctx) => {
							const datapoints = ctx.chart.data.datasets[0].data
							 const total = datapoints.reduce((total, datapoint) => total + datapoint, 0)
							const percentage = value / total * 100
							return percentage.toFixed(2) + "%";
						  },
						  color: '#fff',
						},
						legend: {
							position :'bottom',
							labels:{
								boxWidth:20,
							}
						},
					},
				},
				plugins: [ChartDataLabels],
			  });
			//myChart_male_female_other
			var ctx = document.getElementById("myChart_male_female_other").getContext("2d");
			var xValues = ["Male", "Female","Others"]
			var yValues = [<?php echo $male_count; ?>,<?php echo $female_count; ?>,<?php echo $others_count?>]
			var barColors = ["#b91d47","#00aba9","#2b5797"];
			var chart = new Chart("myChart_male_female_other", {
				type: "pie",
				data: {
				  labels: xValues,
				  datasets: [{
					backgroundColor: barColors,
					data: yValues
				  }]
				},
				options: {
					tooltips: {
						enabled: false
					  },
					  plugins: {
						title: {
							display: true,
							text: "Gender ratio"
						},
						legend: {
							position :'bottom',
							labels:{
								boxWidth:20,
							}
						},
						datalabels: {
							formatter: (value, ctx) => {
							  const datapoints = ctx.chart.data.datasets[0].data
							   const total = datapoints.reduce((total, datapoint) => total + datapoint, 0)
							  const percentage = value / total * 100
							  return percentage.toFixed(2) + "%";
							},
							color: '#fff',
						},
					},
				  },
				plugins: [ChartDataLabels],
			  });
		</script>