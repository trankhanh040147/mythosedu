<?php

/**
 * Template for displaying frontend dashboard of student
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

$is_by_short_code = isset( $is_shortcode ) && $is_shortcode === true;
if ( ! $is_by_short_code && ! defined( 'OTLMS_VERSION' ) ) {
	tutor_utils()->tutor_custom_header();
}

global $wp_query;

$dashboard_page_slug = '';
$dashboard_page_name = '';
if (isset($wp_query->query_vars['tutor_dashboard_page']) && $wp_query->query_vars['tutor_dashboard_page']) {
	$dashboard_page_slug = $wp_query->query_vars['tutor_dashboard_page'];
	$dashboard_page_name = $wp_query->query_vars['tutor_dashboard_page'];
}
/**
 * Getting dashboard sub pages
 */
if (isset($wp_query->query_vars['tutor_dashboard_sub_page']) && $wp_query->query_vars['tutor_dashboard_sub_page']) {
	$dashboard_page_name = $wp_query->query_vars['tutor_dashboard_sub_page'];
	if ($dashboard_page_slug) {
		$dashboard_page_name = $dashboard_page_slug . '/' . $dashboard_page_name;
	}
}

$user_id                   = get_current_user_id();
$user                      = get_user_by('ID', $user_id);
$enable_profile_completion = tutor_utils()->get_option('enable_profile_completion');
$is_instructor             = tutor_utils()->is_instructor();

// URLS
$current_url  = tutor()->current_url;
$footer_url_1 = trailingslashit(tutor_utils()->tutor_dashboard_url($is_instructor ? '' : 'my-courses'));
$footer_url_2 = trailingslashit(tutor_utils()->tutor_dashboard_url($is_instructor ? 'question-answer' : 'my-quiz-attempts'));

// Footer links
$footer_links = array(
	array(
		'title'      => $is_instructor ? __('Dashboard', TPL_DOMAIN_LANG) : __('Courses', TPL_DOMAIN_LANG),
		'url'        => $footer_url_1,
		'is_active'  => $footer_url_1 == $current_url,
		'icon_class' => 'ttr tutor-icon-dashboard-filled',
	),
	array(
		'title'      => $is_instructor ? __('Q&A', TPL_DOMAIN_LANG) : __('Quiz Attempts' . TPL_DOMAIN_LANG),
		'url'        => $footer_url_2,
		'is_active'  => $footer_url_2 == $current_url,
		'icon_class' => $is_instructor ? 'ttr  tutor-icon-question-filled' : 'ttr tutor-icon-quiz-attempt-filled',
	),
	array(
		'title'      => __('Menu', TPL_DOMAIN_LANG),
		'url'        => '#',
		'is_active'  => false,
		'icon_class' => 'ttr tutor-icon-menu-line tutor-dashboard-menu-toggler',
	),
);

do_action('tutor_dashboard/before/wrap');
?>

<div class="tutor-wrap tutor-dashboard tutor-frontend-dashboard tutor-dashboard-student tutor-pb-80 dashboard-student-main">
	<div class="tutor-container">
		<!-- Sidebar and Content Part -->
		<div class="tutor-row tutor-frontend-dashboard-maincontent">
			<div class="tutor-col-12 tutor-dashboard-student-left tutor-col-md-5 tutor-col-lg-4 tutor-dashboard-left-menu">
				<div class="tutor-course-sidebar-card p-3">
					<div class="tutor-header-left-side tutor-dashboard-student-header tutor-dashboard-header tutor-d-flex tutor-align-items-center" style="border: none;">
						<div class="tutor-dashboard-header-avatar" style="background-image: url( <?php echo esc_url(get_avatar_url($user_id, array('size' => 150))); ?>)">
						</div>
						<div class="tutor-user-info tutor-ml-16">
							<div class="tutor-dashboard-header-display-name tutor-color-black">
								<div class="tutor-fs-5 tutor-fw-bold tutor-dashboard-header-username">
									<?php echo esc_html($user->display_name);?>
								</div>
								<div class="tutor-fw-normal tutor-dashboard-header-greetings">
									<?php echo esc_html($user->user_email);?>
								</div>									
							</div>
						</div>
					</div>
					<div class="tutor-dashboard-menu-divider"></div>
					<ul class="tutor-dashboard-permalinks">
						<?php
						$dashboard_pages = tutor_utils()->tutor_dashboard_student_nav_ui_items();
						// get reviews settings value.
						foreach ($dashboard_pages as $dashboard_key => $dashboard_page) {
							$menu_title = $dashboard_page;
							$menu_link  = tutor_utils()->get_tutor_dashboard_page_permalink($dashboard_key);
							$menu_icon  = '';

							if (is_array($dashboard_page)) {
								$menu_title     = tutor_utils()->array_get('title', $dashboard_page);
								$menu_icon_name = tutor_utils()->array_get('icon', $dashboard_page);
								if ($menu_icon_name) {
									$menu_icon = "<span class='{$menu_icon_name} tutor-dashboard-menu-item-icon tutor-icon-30'></span>";
								}
								// Add new menu item property "url" for custom link
								if (isset($dashboard_page['url'])) {
									echo $menu_link = $dashboard_page['url'];
								}
							}
							$li_class = "tutor-dashboard-menu-{$dashboard_key}";
							if ($dashboard_key === 'index') {
								$dashboard_key = '';
							}
							$active_class    = $dashboard_key == $dashboard_page_slug ? 'active' : '';
							$data_no_instant = 'logout' == $dashboard_key ? 'data-no-instant' : '';

							echo "<li class='tutor-dashboard-menu-item {$li_class}  {$active_class}'><a {$data_no_instant} href='" . $menu_link . "' class='tutor-dashboard-menu-item-link tutor-fs-6 tutor-fw-normal tutor-color-black'>{$menu_icon} <span class='tutor-dashboard-menu-item-text tutor-ml-12'>{$menu_title}</span></a></li>";
						}
						?>
					</ul>
				</div>
<!-- 				
				<div class="tutor-course-sidebar-card p-0 mt-4">
					<div class="tutor-course-sidebar-card-header p-3 bg-danger text-white tutor-fw-bold"><?php //_e('Due Soon', TPL_DOMAIN_LANG); ?></div>
					<div class="tutor-course-sidebar-card-content  scroll-pane">
						<?php
							//$past_due_courses = tutor_utils()->get_active_courses_by_user_learning_parent(get_current_user_id());
							//if (!empty($past_due_courses) && count($past_due_courses) ){
							//foreach ($past_due_courses as $course){
						?>
							<div class="course-list-item-course-due">
								<a class = " tutor-fw-bold" href="<?php //echo esc_url( get_permalink($course) ) ;?>"><?php //echo get_the_title($course); ?></a>
								<div class="list-item-course-due">
									<div class=" tutor-col-md-8 tutor-col-lg-8 tutor-fs-7 tutor-fw-normal tutor-color-muted">
										Not Started - Due today
									</div>
								</div>
							</div>
						<?php
						//}}
						?>
					</div>
					<link type="text/css" href="<?php //echo get_template_directory_uri();?>/assets/css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
					<script type="text/javascript" src="<?php //echo get_template_directory_uri();?>/assets/js/jquery.jscrollpane.min.js"></script>
					<script>
					jQuery(function($){					
						$('.scroll-pane').jScrollPane();
					});
					</script>
				</div> -->
					
			</div>

			<div class="tutor-col-12 tutor-col-md-7 tutor-col-lg-8">
				<div class="tutor-dashboard-content tutor-dashboard-student-content">
					<?php
						$completed_courses 		= tutor_utils()->get_completed_courses_ids_by_user();
						$completed_course_count = count( $completed_courses );
						$completed_course_count = str_pad($completed_course_count, 2, '0', STR_PAD_LEFT);
						
						$certificate = str_pad(0, 2, '0', STR_PAD_LEFT);//0 is example, need code later
					?>
					<div class="tutor-align-items-center bg-light p-5 dashboard-student-content-top">
						<div class="tutor-col-lg-4 col-completions">
							<div class="tutor-fs-2 text-danger tutor-fw-bold"><?php echo $completed_course_count;?></div>
							<div class="tutor-fs-5 tutor-fw-bold"><?php _e('Completions', TPL_DOMAIN_LANG); ?></div>
						</div>
						<div class="tutor-col-lg-4 col-ceeertificate">
							<div class="tutor-fs-2 text-danger tutor-fw-bold"><?php echo $certificate;?></div>
							<div class="tutor-fs-5 tutor-fw-bold"><?php _e('Certificate', TPL_DOMAIN_LANG); ?></div>
						</div>
						<div class="tutor-col-lg-4 col-ceeertificate">
							
						</div>
						
						
					</div>
					<div class="tutor-row tutor-align-items-center mt-4">
						<div class="tutor-fs-5 tutor-fw-bold">
							<?php _e('CONTINUE LEARNING', TPL_DOMAIN_LANG); ?>
						</div>
						<div>
						<?php
							$courses_in_progress = tutor_utils()->get_active_courses_by_user_learning( get_current_user_id() );
						?>
						<div class="tutor-frontend-dashboard-course-porgress">
						<?php if (!empty($courses_in_progress) && count($courses_in_progress) ) :?>
							<?php
							global $post;
							
							foreach ($courses_in_progress as $post) :
								setup_postdata($post);

								$post_id = get_the_ID();

								$_tutor_course_start_date = get_post_meta( $post_id, '_tutor_course_start_date', false );// echo $_tutor_course_start_date[0] . "---";
								$_tutor_course_start_time = get_post_meta( $post_id, '_tutor_course_start_time', false );
								$_tutor_course_start_date_time = $_tutor_course_start_date[0] . " " . $_tutor_course_start_time[0] .":00";
								$timestamp_start_date = strtotime($_tutor_course_start_date_time); //echo $timestamp_start_date . "<br/>"; // Outputs: 1557964800

								
								$_tutor_course_end_date = get_post_meta( $post_id, '_tutor_course_end_date', false );
								$_tutor_course_end_time = get_post_meta( $post_id, '_tutor_course_end_time', false );
								$_tutor_course_end_date_time = $_tutor_course_end_date[0] . " " . $_tutor_course_end_time[0] .":00";
								$timestamp_end_date = strtotime($_tutor_course_end_date_time); //echo $timestamp_end_date . "<br/>"; // Outputs: 1557964800

								// check course in time
								//if($timestamp_start_date <= $timestamp_current_date && $timestamp_current_date <= $timestamp_end_date) {
								if($_tutor_course_start_date[0] != "" || $_tutor_course_end_date[0] != "") {
									if(check_current_time_bettwen_start_end($timestamp_start_date, $timestamp_end_date)) {	
												
										$post_countsub	= $post->countsub;
										$tutor_course_img = get_tutor_course_thumbnail_src();
										extract( tutor_utils()->get_course_duration( get_the_ID(), true ) );
										$course_progress  = tutor_utils()->get_course_completed_percent( get_the_ID(), 0, true );
										$completed_number = 0 === (int) $course_progress['completed_count'] ? 1 : (int) $course_progress['completed_count'];
										$completed_percent = tutor_utils()->parent_course_percents(get_the_ID());
										$is_completed = tutor_utils()->is_completed_course( get_the_ID(), get_current_user_id() );
										if ($completed_percent == "notparent")
											$completed_percent = tutor_utils()->get_course_total_points( get_the_ID() );
										$GPA = tutor_utils()->get_course_settings(get_the_ID(), '_tutor_grade_point_average');								
										if($completed_percent>=$GPA){
											$status = "<span class='tutor-color-success'>passed</span>";
										}	
										else {
											$status = "<span class='tutor-color-danger-100'>failed</span>";
										}
										
										$sub_class = "not_course_sub_class";
										if(($post->rowadd) && ($post->rowadd == $rowadd)) {
											if($rowadd) $sub_class = "course_sub_class";
											
										}
										$rowadd = $post->rowadd;
										if($post->countsub && $post->firstchild){
											$lesson_url          = tutor_utils()->get_course_first_lesson($post->firstchild,tutor()->lesson_post_type);
										}
										elseif($sub_class == "course_sub_class"){
											$lesson_url = "#";
											if($is_completed || $post->unlock)
												$lesson_url = tutor_utils()->get_course_first_lesson(get_the_ID(),tutor()->lesson_post_type);
										}
										else
											$lesson_url          = tutor_utils()->get_course_first_lesson(get_the_ID(),tutor()->lesson_post_type);
											
										if(!$lesson_url) $lesson_url = "#";
										if($post->firstsub) {
											echo "<div class='collapse' id='countsub".$post->rowadd."'>";
										}
										?>
									<div class="tutor-frontend-dashboard-course-porgress-cards <?php echo $sub_class;?>">
										<div class="tutor-frontend-dashboard-course-porgress-card tutor-frontend-dashboard-course-porgress-card-horizontal tutor-course-listing-item tutor-course-listing-item-sm tutor-justify-content-start tutor-student-course-listing-item">
											<div class="tutor-course-listing-item-head tutor-d-flex">
												<a href="<?php echo $lesson_url;//the_permalink(); ?>" class="tutor-course-listing-thumb-permalink">
													<div class="tutor-course-listing-thumbnail" style="background-image:url(<?php echo empty( esc_url( $tutor_course_img ) ) ? $placeholder_img : esc_url( $tutor_course_img ); ?>)"></div>
												</a>
											</div>
											<div class="tutor-course-listing-item-body tutor-pl-32">
												<div class="list-item-title tutor-fs-5 tutor-fw-medium tutor-color-black">
													<a href="<?php echo $lesson_url;//the_permalink(); ?>">
														<?php the_title();?>
													</a>
												</div>
												<div class="list-item-steps course_speaker">
													<span class="tutor-fs-7 tutor-fw-normal tutor-color-muted">
														<?php esc_html_e( 'Speaker:', TPL_DOMAIN_LANG); ?> 
													</span>
													<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
														<span>
															<?php esc_html_e(get_the_author()); ?>
														</span>
													</span>
												</div>
												<?php if (!$post->countsub):?>
												<div class="list-item-steps course_lesson_duration">
													<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
														<?php echo esc_html( $course_progress['total_count'] ); ?>
													</span>
													<span class="tutor-fs-7 tutor-fw-medium tutor-color-muted">
														<?php echo esc_html( _n( 'lesson', 'lessons', $course_progress['total_count'], TPL_DOMAIN_LANG) ); ?>
													</span>
													<span class="tutor-fs-7 tutor-fw-medium tutor-color-muted">
														<?php echo  esc_html_e( ' - ','tutor'  ); ?>
													</span>
												
													<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
														<?php echo $durationHours ? $durationHours : '00'; ?><?php echo  esc_html_e( ':','tutor'  ); ?><?php echo $durationMinutes ? $durationMinutes : '00'; ?>
													</span>
													<span class="tutor-fs-7 tutor-fw-medium tutor-color-muted">
														<?php echo  esc_html_e( ' Hours','tutor'  ); ?>
													</span>
												</div>
												<?php endif; ?>
												<div class="list-item-progress mt-2">
													<div class="tutor-fs-6 tutor-fw-normal tutor-color-black-60 tutor-align-items-center tutor-justify-content-between">
														<div class="progress-bar tutor-mr-16" style="--progress-value:<?php echo esc_attr( $completed_percent ); ?>%"><span class="progress-value"></span></div>
														<div class="tutor-col-lg-12 tutor-d-flex">
															<div class="tutor-col-lg-8">
																<span class="progress-percentage tutor-fs-7 tutor-fw-normal tutor-color-muted">
																	<?php esc_html_e( 'Progress: ', TPL_DOMAIN_LANG); ?>
																	<span class="tutor-fs-7 tutor-fw-medium tutor-color-black ">
																		<?php echo esc_html( $completed_percent . '%' ); ?>
																	</span>
																	<?php	if($is_completed && !$post_countsub): ?>
																		<span class="tutor-fs-7 tutor-fw-medium tutor-color-muted">
																			<?php echo  esc_html_e( ' - ','tutor'  ); ?>
																		</span>
																		<?php echo $status;?>
																	<?php	endif; ?>
																</span>
															</div>
															<?php	if($sub_class == "course_sub_class" && !$post->unlock && !$is_completed): ?>
															<div class="tutor-col-lg-4 tutor-div-locked">
																<i class="tutor-icon-lock-filled tutor-icon-locked"></i>
																<span class="tutor-fs-7 tutor-fw-medium tutor-color-muted tutor-text-locked"><?php echo "locked";?></span>
															</div>
															<?php endif; ?>
														</div>
													</div>
												</div>
												<?php	if($post->countsub && ($sub_class == "not_course_sub_class")): ?>
												<div class="list-item-steps text-right">
													<button data-toggle="collapse" data-target="#countsub<?php echo $post->rowadd;?>" aria-expanded="false" aria-controls="multiCollapseExample" class="tutor-fs-7 tutor-fw-normal text-primary collapsed">
														<?php esc_html_e( 'Children Courses', TPL_DOMAIN_LANG); ?>
													</button>
												</div>
												
												<?php endif; ?>
											</div>
										</div>
									</div>
									<?php 
									if($post->lastsub) {
											echo "</div>";
										}
									//if($sub_class != "not_course_sub_class") break;
									} 
								} else {

									$post_countsub	= $post->countsub;
										$tutor_course_img = get_tutor_course_thumbnail_src();
										extract( tutor_utils()->get_course_duration( get_the_ID(), true ) );
										$course_progress  = tutor_utils()->get_course_completed_percent( get_the_ID(), 0, true );
										$completed_number = 0 === (int) $course_progress['completed_count'] ? 1 : (int) $course_progress['completed_count'];
										$completed_percent = tutor_utils()->parent_course_percents(get_the_ID());
										$is_completed = tutor_utils()->is_completed_course( get_the_ID(), get_current_user_id() );
										if ($completed_percent == "notparent")
											$completed_percent = tutor_utils()->get_course_total_points( get_the_ID() );
										$GPA = tutor_utils()->get_course_settings(get_the_ID(), '_tutor_grade_point_average');								
										if($completed_percent>=$GPA){
											$status = "<span class='tutor-color-success'>passed</span>";
										}	
										else {
											$status = "<span class='tutor-color-danger-100'>failed</span>";
										}
										
										$sub_class = "not_course_sub_class";
										if(($post->rowadd) && ($post->rowadd == $rowadd)) {
											if($rowadd) $sub_class = "course_sub_class";
											
										}
										$rowadd = $post->rowadd;
										if($post->countsub && $post->firstchild){
											$lesson_url          = tutor_utils()->get_course_first_lesson($post->firstchild,tutor()->lesson_post_type);
										}
										elseif($sub_class == "course_sub_class"){
											$lesson_url = "#";
											if($is_completed || $post->unlock)
												$lesson_url = tutor_utils()->get_course_first_lesson(get_the_ID(),tutor()->lesson_post_type);
										}
										else
											$lesson_url          = tutor_utils()->get_course_first_lesson(get_the_ID(),tutor()->lesson_post_type);
											
										if(!$lesson_url) $lesson_url = "#";
										if($post->firstsub) {
											echo "<div class='collapse' id='countsub".$post->rowadd."'>";
										}
										?>
									<div class="tutor-frontend-dashboard-course-porgress-cards <?php echo $sub_class;?>">
										<div class="tutor-frontend-dashboard-course-porgress-card tutor-frontend-dashboard-course-porgress-card-horizontal tutor-course-listing-item tutor-course-listing-item-sm tutor-justify-content-start tutor-student-course-listing-item">
											<div class="tutor-course-listing-item-head tutor-d-flex">
												<a href="<?php echo $lesson_url;//the_permalink(); ?>" class="tutor-course-listing-thumb-permalink">
													<div class="tutor-course-listing-thumbnail" style="background-image:url(<?php echo empty( esc_url( $tutor_course_img ) ) ? $placeholder_img : esc_url( $tutor_course_img ); ?>)"></div>
												</a>
											</div>
											<div class="tutor-course-listing-item-body tutor-pl-32">
												<div class="list-item-title tutor-fs-5 tutor-fw-medium tutor-color-black">
													<a href="<?php echo $lesson_url;//the_permalink(); ?>">
														<?php the_title();?>
													</a>
												</div>
												<div class="list-item-steps course_speaker">
													<span class="tutor-fs-7 tutor-fw-normal tutor-color-muted">
														<?php esc_html_e( 'Speaker:', TPL_DOMAIN_LANG); ?> 
													</span>
													<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
														<span>
															<?php esc_html_e(get_the_author()); ?>
														</span>
													</span>
												</div>
												<?php if (!$post->countsub):?>
												<div class="list-item-steps course_lesson_duration">
													<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
														<?php echo esc_html( $course_progress['total_count'] ); ?>
													</span>
													<span class="tutor-fs-7 tutor-fw-medium tutor-color-muted">
														<?php echo esc_html( _n( 'lesson', 'lessons', $course_progress['total_count'], TPL_DOMAIN_LANG) ); ?>
													</span>
													<span class="tutor-fs-7 tutor-fw-medium tutor-color-muted">
														<?php echo  esc_html_e( ' - ','tutor'  ); ?>
													</span>
												
													<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
														<?php echo $durationHours ? $durationHours : '00'; ?><?php echo  esc_html_e( ':','tutor'  ); ?><?php echo $durationMinutes ? $durationMinutes : '00'; ?>
													</span>
													<span class="tutor-fs-7 tutor-fw-medium tutor-color-muted">
														<?php echo  esc_html_e( ' Hours','tutor'  ); ?>
													</span>
												</div>
												<?php endif; ?>
												<div class="list-item-progress mt-2">
													<div class="tutor-fs-6 tutor-fw-normal tutor-color-black-60 tutor-align-items-center tutor-justify-content-between">
														<div class="progress-bar tutor-mr-16" style="--progress-value:<?php echo esc_attr( $completed_percent ); ?>%"><span class="progress-value"></span></div>
														<div class="tutor-col-lg-12 tutor-d-flex">
															<div class="tutor-col-lg-8">
																<span class="progress-percentage tutor-fs-7 tutor-fw-normal tutor-color-muted">
																	<?php esc_html_e( 'Progress: ', TPL_DOMAIN_LANG); ?>
																	<span class="tutor-fs-7 tutor-fw-medium tutor-color-black ">
																		<?php echo esc_html( $completed_percent . '%' ); ?>
																	</span>
																	<?php	if($is_completed && !$post_countsub): ?>
																		<span class="tutor-fs-7 tutor-fw-medium tutor-color-muted">
																			<?php echo  esc_html_e( ' - ','tutor'  ); ?>
																		</span>
																		<?php echo $status;?>
																	<?php	endif; ?>
																</span>
															</div>
															<?php	if($sub_class == "course_sub_class" && !$post->unlock && !$is_completed): ?>
															<div class="tutor-col-lg-4 tutor-div-locked">
																<i class="tutor-icon-lock-filled tutor-icon-locked"></i>
																<span class="tutor-fs-7 tutor-fw-medium tutor-color-muted tutor-text-locked"><?php echo "locked";?></span>
															</div>
															<?php endif; ?>
														</div>
													</div>
												</div>
												<?php	if($post->countsub && ($sub_class == "not_course_sub_class")): ?>
												<div class="list-item-steps text-right">
													<button data-toggle="collapse" data-target="#countsub<?php echo $post->rowadd;?>" aria-expanded="false" aria-controls="multiCollapseExample" class="tutor-fs-7 tutor-fw-normal text-primary collapsed">
														<?php esc_html_e( 'Children Courses', TPL_DOMAIN_LANG); ?>
													</button>
												</div>
												
												<?php endif; ?>
											</div>
										</div>
									</div>
									<?php 
									if($post->lastsub) {
											echo "</div>";
										}
									//if($sub_class != "not_course_sub_class") break;

								}
							endforeach;
							wp_reset_postdata(); ?>
							
						<?php else : ?>
							<?php tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() ); ?>
						<?php endif; ?>
					</div>
						<?php wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/js/bootstrap.min.js',  array(), null, true);?>
						</div>
					</div>
				</div>
			</div>
		</div>
<!-- 		
		<div class=" tutor-align-items-center mt-4">
			<div class="tutor-fs-5 tutor-fw-bold mb-3">
				<?php // _e('YOU MIGHT ALSO LIKE', TPL_DOMAIN_LANG); ?>
			</div>
			<div>
			<?php
				//$wishlists    = tutor_utils()->get_courses_for_students(6);
				//if (is_array($wishlists) && count($wishlists)): ?>
					<div class="tutor-course-listing-grid tutor-course-listing-grid-3">
						<?php
							//foreach ($wishlists as $post) {
							//	setup_postdata($post);

								/**
								 * @hook tutor_course/archive/before_loop_course
								 * @type action
								 * Usage Idea, you may keep a loop within a wrap, such as bootstrap col
								 */
//								do_action('tutor_course/archive/before_loop_course');

//								tutor_load_template('loop.course');

								/**
								 * @hook tutor_course/archive/after_loop_course
								 * @type action
								 * Usage Idea, If you start any div before course loop, you can end it here, such as </div>
								 */
//								do_action('tutor_course/archive/after_loop_course');
//							}
//							wp_reset_postdata();
						?>
					</div>
				<?php // else: ?>
					<?php //tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() ); ?>
				<?php // endif; ?>	
			</div>
		</div> -->
			
	</div>
	<div id="tutor-dashboard-footer-mobile">
		<div class="tutor-container">
			<div class="tutor-row">
				<?php foreach ($footer_links as $link) : ?>
					<a class="tutor-col-4 <?php echo $link['is_active'] ? 'active' : ''; ?>" href="<?php echo $link['url']; ?>">
						<i class="<?php echo $link['icon_class']; ?>"></i>
						<span><?php echo $link['title']; ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

<style>
	.site-content {
		overflow-y: hidden;
		padding-bottom: 0;
	}

	.tutor-frontend-dashboard {
		overflow-y: hidden;
	}
</style>

<?php do_action('tutor_dashboard/after/wrap'); ?>

<?php
if ( ! $is_by_short_code && ! defined( 'OTLMS_VERSION' ) ) {
	tutor_utils()->tutor_custom_footer();
}
