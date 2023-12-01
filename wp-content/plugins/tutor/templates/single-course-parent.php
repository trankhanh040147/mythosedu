<?php
/**
 * Template for displaying single course
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

// Prepare the nav items
$course_nav_item = apply_filters( 'tutor_course/single/nav_items', tutor_utils()->course_nav_items(), get_the_ID() );

tutor_utils()->tutor_custom_header();
do_action('tutor_course/single/before/wrap');
$bannerid = get_field('course_banner_image', get_the_ID());
if($bannerid)	$bannerurl = wp_get_attachment_url( $bannerid );
if($bannerurl)	$style = " background-image: url(".$bannerurl.")!important; ";
?>
<div style = " <?php echo $style;?> " <?php tutor_post_class('tutor-full-width-course-top tutor-course-top-info tutor-page-wrap course-student-main'); ?>>

    <div class="tutor-course-details-page tutor-container">
		<div class="tutor-course-details-page-main">
            <div class="tutor-course-details-page-main-left">
                <div class="tutor-container __course_info_top">
					<?php
					global $post, $authordata;
					?>
					<div class="tutor-course-details-category tutor-fs-7 tutor-fw-medium tutor-align-items-end">
						<div>
							<span>
								<?php
								$course_categories = get_tutor_course_categories();
								$cats_array = [];
								if (is_array($course_categories) && count($course_categories)) {
									foreach ($course_categories as $course_category) {
										$category_name = $course_category->name;
										$category_link = get_term_link($course_category->term_id);
										$cats_array[] = "<a href='$category_link'>$category_name</a>";
									}

									echo implode(', ', $cats_array);
								} else {
									_e('Uncategorized', 'tutor');
								}
								?>
							</span>
						</div>
					</div>
					
					<div class="tutor-course-details-title tutor-fs-4 tutor-fw-bold tutor-color-black tutor-mt-12">
						<?php do_action('tutor_course/single/title/before'); ?>
							<div class="tutor-fs-4 tutor-fw-bold"><?php the_title(); ?>
						</div>
					</div>
					<div class="_course_head_text">
						<p><?php echo get_the_content();?><p>
					</div>
					<?php
						$speaker = get_post_meta( get_the_ID(), '_tutor_course_speaker', true );
						if($speaker):
					?>	
					<div class="tutor-course-author tutor-mr-16">
						<div><?php _e('Speaker: ', 'tutor'); ?></div>
						<div class=" tutor-fw-bold"><?php echo $speaker; ?></div>
					</div>
					<?php
						endif;
					?>
				</div>
	            <?php do_action('tutor_course/single/before/inner-wrap'); ?>
                <div class="tutor-default-tab tutor-course-details-tab tutor-tab-has-seemore tutor-mt-32">
				<?php                 
					do_action( 'tutor_course/single/before/benefits' );


					$course_benefits = tutor_course_benefits();
					
					?>

					<?php if (is_array($course_benefits) && count($course_benefits)): ?>
						<div class="tutor-course-details-widget tutor-course-details-widget-col-1 tutor-mt-lg-50 tutor-mt-32">
							<div class="tutor-course-details-widget-title tutor-mb-16">
								<span class="tutor-fs-5 tutor-fw-bold mb-3">
									<?php echo esc_html( apply_filters( 'tutor_course_benefit_title', __( "WHAT YOU'LL LEARN", 'tutor' ) ) ); ?>
								</span>
							</div>
							<ul class="tutor-course-details-widget-list tutor-m-0 tutor-mt-16">
								<?php foreach ($course_benefits as $benefit): ?>
									<li class="tutor-d-flex tutor-color-black tutor-fs-6 tutor-fw-normal tutor-mb-12">
										<span class="tutor-icon-mark-filled tutor-color-design-brand tutor-mr-4"></span>
										<span><?php echo $benefit; ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

					<?php do_action('tutor_course/single/after/benefits'); 
					
					//begin check startdate
					$tutor_course_start_date = get_post_meta(get_the_ID(), '_tutor_course_start_date', true);
					$_tutor_show_feedback = get_post_meta(get_the_ID(), '_tutor_show_feedback', true);
					$tutor_course_show_feedback = 'no'===$_tutor_show_feedback ?  false : true;
					
					?>
					<?php //if($tutor_course_start_date): ?>
					
					<div class="course-parent-children tutor-course-details-widget tutor-course-details-widget-col-1 tutor-mt-lg-50 tutor-mt-32">
						<div class="tutor-course-details-widget-title tutor-mb-16">
							<span class="tutor-fs-5 tutor-fw-bold mb-3">
								<?php
									$title = __( 'CURRICULUM', 'tutor' );
									echo esc_html( apply_filters( 'tutor_course_topics_title', $title ) );	
									$courses_in_progress = tutor_utils()->get_courses_children( get_the_ID() );
									$courses_child_total = count($courses_in_progress);
									
									$course_duration = get_tutor_course_duration_context(get_the_ID(), true);
								?>
							</span>
						</div>
						<div class="curriculum_head">
							<span class="">
								<?php
									echo $courses_child_total;	
								?>
							</span>
							<span class="">
								<?php
									echo __( "courses", 'tutor' );	
								?>
							</span>
							<span class="">
								<?php
									echo __( "-", 'tutor' );	
								?>
							</span>
							<span class="">
								<?php
									echo tutor_utils()->get_total_courses_children_topics( get_the_ID() );	
								?>
							</span>
							<span class="">
								<?php
									echo __( "sections", 'tutor' );	
								?>
							</span>
							
							<span class="">
								<?php
									echo __( "-", 'tutor' );	
								?>
							</span>
							<span class="">
								<?php
									echo tutor_utils()->get_total_courses_children_lessons( get_the_ID() );	
								?>
							</span>
							<span class="">
								<?php
									echo __( "lessons", 'tutor' );	
								?>
							</span>
							
							<span class="">
								<?php
									echo __( "-", 'tutor' );	
								?>
							</span>
							<span class="">
								<?php
									echo $course_duration;	
								?>
							</span>
							<?php
							/*
							<span class="">
								<?php
									echo __( "Total length", 'tutor' );	
								?>
							</span>
							*/
							?>
						</div>
						
						<div>
							<div class="tutor-frontend-dashboard-course-porgress">
							<?php if (!empty($courses_in_progress) && count($courses_in_progress) ) :?>
								<?php
								global $post;
								$price_total_child = 0;
								foreach ($courses_in_progress as $post) :
								setup_postdata($post);
									$tutor_course_img = get_tutor_course_thumbnail_src();
									extract( tutor_utils()->get_course_duration( get_the_ID(), true ) );
									$course_progress  = tutor_utils()->get_course_completed_percent( get_the_ID(), 0, true );
									$completed_number = (int) $course_progress['total_count'];
									?>
								<div class="tutor-frontend-dashboard-course-porgress-cards">
									<div class="tutor-frontend-dashboard-course-porgress-card tutor-frontend-dashboard-course-porgress-card-horizontal tutor-course-listing-item tutor-course-listing-item-sm tutor-justify-content-start tutor-student-course-listing-item">
										<div class="tutor-course-listing-item-head tutor-d-flex">
											<a href="<?php the_permalink(); ?>" class="tutor-course-listing-thumb-permalink">
												<div class="tutor-course-listing-thumbnail" style="background-image:url(<?php echo empty( esc_url( $tutor_course_img ) ) ? $placeholder_img : esc_url( $tutor_course_img ); ?>)"></div>
											</a>
										</div>
										<div class="tutor-course-listing-item-body tutor-pl-32">
											<div class="list-item-title tutor-fs-5 tutor-fw-medium tutor-color-black">
												<a href="<?php the_permalink(); ?>">
													<?php the_title(); ?>
												</a>
											</div>
											<div class="list-item-steps course_speaker">
												<span class="tutor-fs-7 tutor-fw-normal tutor-color-muted">
													<?php esc_html_e( 'Speaker:', 'tutor' ); ?>
												</span>
												<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
													<span>
														<?php esc_html_e(get_the_author()); ?>
													</span>
												</span>
											</div>
											<div class="list-item-steps course_lesson_duration">
												<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
													<?php echo $completed_number; ?>
												</span>
												<span class="tutor-fs-7 tutor-fw-medium tutor-color-muted">
													<?php echo esc_html( _n( 'lesson', 'lessons', $completed_number, 'tutor' ) ); ?>
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
											<div class="list-item-steps course_child_price pt-1">
												<span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
													<span class = "rounded p-1 border border-primary text-primary">
														<?php 
														$course_child_price = tutor_utils()->get_course_price(get_the_ID());
														$price_total_child+=$course_child_price;
														if(!$course_child_price)
															echo  esc_html_e( 'Free','tutor'  );
														else
															echo tutor_utils()->tutor_price($course_child_price);
														?>
													</span>
												</span>
											</div>
											
											
										</div>
									</div>
								</div>
								<?php endforeach;
								wp_reset_postdata(); ?>
								
							<?php else : ?>
								<?php tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() ); ?>
							<?php endif; ?>
							</div>
						</div>
					</div>
					<?php if (is_user_logged_in() && time() >= strtotime($tutor_course_start_date)) :?>
					<div class="tutor-course-details-widget tutor-course-details-widget-col-1 tutor-mt-lg-50 tutor-mt-32">
						<div class="tutor-course-details-widget-title tutor-mb-16">
							<span class="tutor-fs-5 tutor-fw-bold mb-3">
								<?php echo esc_html( apply_filters( 'tutor_course_attachments_title', __( "DOCUMENTS", 'tutor' ) ) ); ?>
							</span>
						</div>
						<div>
							<?php
							$attachments    = tutor_utils()->get_attachments(get_the_ID());
							$open_mode_view = apply_filters( 'tutor_pro_attachment_open_mode', null ) == 'view' ? ' target="_blank" ' : null;

							do_action( 'tutor_global/before/attachments' );

							if ( is_array( $attachments ) && count( $attachments ) ) {
								?>
								<div class="tutor-exercise-files tutor-mt-20 tutor-course-listing-grid tutor-course-listing-grid-2">
									<?php
										foreach ($attachments as $attachment){
									?>
									<a href="<?php echo esc_url( $attachment->url ); ?>" <?php echo ($open_mode_view ? $open_mode_view : ' download="'.$attachment->name.'" ' ); ?>>
										<div class="tutor-instructor-card tutor-mb-12">
											<div class="tutor-icard-content">
												<h6 class="tutor-name tutor-fs-6 tutor-fw-normal tutor-color-black-70">
													<?php echo esc_html( $attachment->name ); ?>
												</h6>
												<div class="text-regular-small">
													<?php echo esc_html( $attachment->size ); ?>
												</div>
											</div>
											<div class="tutor-avatar tutor-is-xs flex-center tutor-flex-shrink-0">
												<span class="tutor-icon-24 tutor-icon-download-line tutor-color-design-brand"></span>
											</div>
										</div>
									</a>
									<?php } ?>
								</div>
							<?php } else {
								tutor_utils()->tutor_empty_state(__('No Attachment Found', 'tutor'));
							}

							do_action( 'tutor_global/after/attachments' ); ?>
						</div>
					</div>
					<?php endif; ?>
					<?php if($tutor_course_show_feedback): ?> 
					<?php
					$disable = ! get_tutor_option( 'enable_course_review' );
					if ( $disable ) {
						//return;
					}

					$per_page = tutor_utils()->get_option( 'pagination_per_page', 10 );
					$current_page = max(1, (int)tutor_utils()->avalue_dot('current_page', $_POST));
					$offset = ($current_page - 1) * $per_page;

					$course_id = isset($_POST['course_id']) ? (int)$_POST['course_id'] : get_the_ID();
					$is_enrolled = tutor_utils()->is_enrolled($course_id, get_current_user_id());

					$reviews = tutor_utils()->get_course_reviews($course_id, $offset, $per_page);
					$reviews_total = tutor_utils()->get_course_reviews($course_id, null, null, true);
					$rating = tutor_utils()->get_course_rating($course_id);
					$my_rating = tutor_utils()->get_reviews_by_user(0, 0, 150, false, $course_id);

					if(isset($_POST['course_id'])) {
						// It's load more
						tutor_load_template('single.course.reviews-loop', array('reviews' => $reviews));
						return;
					}

					do_action( 'tutor_course/single/enrolled/before/reviews' );
					?>

					<div class="tutor-pagination-wrapper-replacable">
						<div class="tutor-course-topics-header">
							<div class="tutor-course-topics-header-left tutor-mb-20">
								<div class="tutor-fs-5 tutor-fw-bold mb-3 mt-3">
									<span>
										<?php
											$review_title = apply_filters( 'tutor_course_reviews_section_title', 'FEEDBACK' );
											echo esc_html( $review_title, 'tutor' );
										?>
									</span>
								</div>
							</div>
						</div>

						<?php if(! is_array( $reviews ) || ! count( $reviews )): ?>
							<?php tutor_utils()->tutor_empty_state(__('No Review Yet', 'tutor')); ?>
						<?php else: ?>
							<div class="tutor-ratingsreviews">
								<div class="tutor-ratingsreviews-ratings">
									<div class="tutor-ratingsreviews-ratings-avg tutor-text-center">
										<div class="tutor-fs-1 tutor-fw-medium tutor-color-black tutor-mb-20">
											<?php echo number_format( $rating->rating_avg, 1 ); ?>
										</div>
										<?php tutor_utils()->star_rating_generator_v2( $rating->rating_avg, null, false, 'tutor-d-block', 'lg' ); ?>
										<div class="tutor-total-ratings-text tutor-fs-6 tutor-fw-normal text-subsued tutor-mt-12">
											<span class="tutor-rating-text-part">
												<?php esc_html_e( 'Total ', 'tutor' ); ?>
											</span>
											<span class="tutor-rating-count-part">
												<?php echo esc_html( count( $reviews ) ); ?>
											</span>
											<span class="tutor-rating-text-part">
												<?php echo esc_html( _n( ' Rating', ' Ratings', count( $reviews ), 'tutor' ) ); ?>
											</span>
										</div>
									</div>

									<div class="tutor-ratingsreviews-ratings-all">
										<?php foreach ( $rating->count_by_value as $key => $value ) : ?>
											<?php $rating_count_percent = ( $value > 0 ) ? ( $value * 100 ) / $rating->rating_count : 0; ?>
											<div class="rating-numbers">
												<div class="rating-progress">
													<div class="tutor-ratings tutor-is-sm">
														<div class="tutor-rating-stars">
															<span class="tutor-icon-star-line-filled"></span>
														</div>
														<div class="tutor-rating-text  tutor-fs-6 tutor-fw-medium  tutor-color-black">
															<?php echo $key; ?>
														</div>
													</div>
													<div class="progress-bar tutor-mt-12" style="--progress-value: <?php echo $rating_count_percent; ?>%">
														<span class="progress-value"></span>
													</div>
												</div>
												<div class="rating-num tutor-fs-7 tutor-fw-normal tutor-color-black-60">
													<?php
														echo $value . ' ';
														echo $value > 1 ? __( 'ratings', 'tutor' ) : __( 'rating', 'tutor' );
													?>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div>

								<div class="tutor-ratingsreviews-reviews">
									<ul class="review-list tutor-m-0 tutor-pagination-content-appendable">
										<?php tutor_load_template('single.course.reviews-loop', array('reviews' => $reviews)); ?>
									</ul>
								</div>
							</div>
						<?php endif; ?>

						<div class="tutor-row tutor-mt-40 tutor-mb-20">
							<div class="tutor-col">
								<?php if($is_enrolled): ?>
									<button class="tutor-btn write-course-review-link-btn">
										<i class="tutor-icon-star-line-filled tutor-icon-24 tutor-mr-4"></i>
										<?php
											$is_new = !$my_rating || empty($my_rating->rating) || empty($my_rating->comment_content);
											$is_new ? _e('Write a review', 'tutor') : _e('Edit review', 'tutor');
										?>
									</button>
								<?php endif; ?>
							</div>
							<div class="tutor-col-auto">
								<?php
									$pagination_data = array(
										'total_items' => $reviews_total,
										'per_page'    => $per_page,
										'paged'       => $current_page,
										'layout'	  => array(
											'type' => 'load_more',
											'load_more_text' => __('Load More', 'tutor')
										),
										'ajax'		  => array(
											'action' => 'tutor_single_course_reviews_load_more',
											'course_id' => $course_id,
										)
									);

									$pagination_template_frontend = tutor()->path . 'templates/dashboard/elements/pagination.php';
									tutor_load_template_from_custom_path( $pagination_template_frontend, $pagination_data );
								?>
							</div>
						</div>
					</div>

					<?php if($is_enrolled): ?>
						<div class="tutor-course-enrolled-review-wrap tutor-mt-16">
							<div class="tutor-write-review-form" style="display: none;">
								<form method="post">
									<div class="tutor-star-rating-container">
										<input type="hidden" name="course_id" value="<?php echo $course_id; ?>"/>
										<input type="hidden" name="review_id" value="<?php echo $my_rating ? $my_rating->comment_ID : ''; ?>"/>
										<input type="hidden" name="action" value="tutor_place_rating"/>
										<div class="tutor-form-group">
											<?php
												tutor_utils()->star_rating_generator(tutor_utils()->get_rating_value($my_rating ? $my_rating->rating : 0));
											?>
										</div>
										<div class="tutor-form-group">
											<textarea name="review" placeholder="<?php _e('write a review', 'tutor'); ?>"><?php echo stripslashes($my_rating ? $my_rating->comment_content : ''); ?></textarea>
										</div>
										<div class="tutor-form-group">
											<button type="submit" class="tutor_submit_review_btn tutor-btn">
												<?php _e('Submit Review', 'tutor'); ?>
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					<?php endif; ?>

					<?php do_action( 'tutor_course/single/enrolled/after/reviews' ); ?>
					<?php endif; ?>
					<?php //endif; ?>
                </div>
	            <?php do_action('tutor_course/single/after/inner-wrap'); ?>
            </div>
            <!-- end of /.tutor-course-details-page-main-left -->
            <div class="tutor-course-details-page-main-right course-student-page-right">
                <div class="tutor-single-course-sidebar">
                    <?php do_action('tutor_course/single/before/sidebar'); ?>
                    <div class="tutor-course-sidebar-card">
						<div class="tutor-price-box-thumbnail">
						<?php
						$login_class = (!is_user_logged_in()) ? 'tutor-course-entry-box-login' : '';	
						//course price
						//$course_price = tutor_utils()->get_course_price($course_id);
						$course_price = 0;//always set parent price is 0
						/* if(is_user_logged_in()){
							//check if free for internal						
							$vus_member            = nl2br( strip_tags( get_user_meta( get_current_user_id(), '_tutor_vus_member', true ) ) );
							if($vus_member=="Internal"){	//if internal member
								$course_type = get_post_meta($course_id, '_tutor_course_type', true);
								$course_type = maybe_unserialize($course_type);
								//if external coure but free for internal member
								if(isset($course_type['course_type']) && isset($course_type['internal_pay_ot_not']) &&  $course_type['course_type'] == 'forexternal' && $course_type['internal_pay_ot_not'] == 'on') 
									$course_price = 0;
							}
						} */
						if ( tutor_utils()->has_video_in_single() ) {
							tutor_course_video();
						} else {
							get_tutor_course_thumbnail();
						}
                        $course_students = tutor_utils()->count_enrolled_users_by_course();
						?>
						</div>
						<div class="student_course_rate">
						<div class="list-item-rating tutor-d-flex">
							<div class="tutor-ratings">
								<div class="tutor-rating-stars">
									<?php
										$course_rating = tutor_utils()->get_course_rating();
										tutor_utils()->star_rating_generator_course($course_rating->rating_avg);
									?>
								</div>
							</div>
						</div>
						</div>
						<div class="p-4">
						<div class="text-regular-body tutor-color-black-60 tutor-d-flex tutor-align-items-center tutor-justify-content-between">
							<div class="course-right-price">
                                <?php
									$course_price+=$price_total_child;	
									if(!$course_price)
										echo  esc_html_e( 'Free','tutor'  );
									else
										echo tutor_utils()->tutor_price($course_price);
										
								?>
                            </div>
							<span class="tutor-fs-4 tutor-fw-medium tutor-color-muted">
								<?php echo  esc_html_e( ' - ','tutor'  ); ?>
							</span>
							<div class="tutor-d-flex tutor-align-items-center">
                                <span class="meta-icon tutor-icon-man-user-filled tutor-color-muted"></span>
                                <span><?php echo $course_students; ?></span>
                            </div>
						</div>
						<div class=" text-regular-body tutor-color-black-60 tutor-d-flex tutor-align-items-center">
							
							<div class="_courses_durations_ tutor-d-flex tutor-align-items-center course_lesson_duration">
                                <span class="tutor-fs-7 tutor-fw-medium tutor-color-black"><?php echo $courses_child_total; ?></span>
								<?php echo  esc_html_e( 'COURSES','tutor'  ); ?>
                            </div>
							<span class="_courses_durations_ tutor-fs-4 tutor-fw-medium tutor-color-muted">
								<?php echo  esc_html_e( ' - ','tutor'  ); ?>
							</span>
							<div class="tutor-d-flex tutor-align-items-center">
                                <span class="meta-icon tutor-icon-clock-filled tutor-color-muted tutor-icon-20 tutor-mr-3"></span>
                                <span class="tutor-fs-7 tutor-fw-medium tutor-color-black"><?php echo $course_duration; ?></span>
                            </div>
							
						</div>
						<div class="<?php echo $login_class; ?> addtocart_grp text-regular-body tutor-color-black-60 tutor-d-flex tutor-align-items-center tutor-justify-content-between">
						<?php
						
						$product_id = tutor_utils()->get_course_product_id($course_id);
						$course_enrolled = tutor_utils()->is_enrolled($course_id);
						$course_added_to_cart = tutor_utils()->is_course_added_to_cart($course_id);
						
						
						if($course_enrolled){	// if course enrolled
							 ?>
								<div class="text-regular-caption tutor-color-muted tutor-mt-12 tutor-d-flex tutor-justify-content-center">
									<span class="tutor-icon-26 tutor-color-success tutor-icon-purchase-filled tutor-mr-8"></span>
									<span class="tutor-color-success">
									<?php esc_html_e( 'You enrolled in this course on', 'tutor' ); ?>
										<span class="text-bold-small tutor-color-success tutor-ml-4 tutor-enrolled-info-date">
										<?php echo esc_html( tutor_get_formated_date( get_option( 'date_format' ), $course_enrolled->post_date ) ); ?>
										</span>
									</span>
								</div>
							<?php
							$is_completed_course = tutor_utils()->is_completed_course($course_id);
							if($is_completed_course){	
							 ?>
							 </div>
							 <div class="text-regular-caption tutor-color-muted tutor-mt-12 tutor-d-flex tutor-justify-content-center">
									<span class="tutor-fs-5 text-bold-small tutor-color-success">
									<?php esc_html_e( 'Course Completed', 'tutor' ); ?>
									</span>
							</div>
							 <div class="text-regular-caption tutor-color-muted tutor-mt-12 tutor-d-flex tutor-justify-content-center">		
									<a href="<?php echo $lesson_url;?>">
									<button type="submit" class="tutor-btn add_to_cart_btn tutor-btn-primary tutor-btn-lg tutor-btn-full tutor-mt-16 tutor-enroll-course-button">
									<?php esc_html_e( 'Learn Again', 'tutor' ); ?>
									</button>
									</a>								
							 <?php
							} 
						}
						elseif ( $course_added_to_cart ) {
							?>
								<a href="/cart/">	
								<button type="submit" class="add_to_cart_btn tutor-mt-16 tutor-btn tutor-btn-tertiary tutor-is-outline tutor-btn-lg tutor-btn-full" name="complete_course_btn" value="complete_course">
								<?php _e('VIEW CART', 'tutor'); ?>					</button>
								</a>
							<?php
						} 
						elseif ( $course_price ) {
							//if($product_id){
							?>
								<div class="tutor-course-add-children-div">	
								<button type="submit" class="add_to_cart_btn tutor-mt-16 tutor-btn tutor-btn-tertiary tutor-is-outline tutor-btn-lg tutor-btn-full" name="complete_course_btn" value="complete_course">
								<?php _e('ADD TO CART', 'tutor'); ?>					</button>
								</div>
								<a href="#" class=" tutor-mt-16 tutor-btn-ghost tutor-btn-ghost-fd action-btn tutor-fs-6 tutor-fw-normal tutor-color-black tutor-course-wishlist-btn" data-course-id="<?php echo get_the_ID(); ?>">
									<i class="tutor-icon-heart-filled icon_heart"></i> <?php //_e('Wishlist', 'tutor'); ?>
								</a>
								<?php
									if ( is_user_logged_in() ) {
										tutor_load_template_from_custom_path( tutor()->path . '/views/modal/add-children.php' );
									}
								?>
							<?php
							//}
						}else {
							?>
								<div class="tutor-course-sidebar-card-btns">
									<form class="tutor-enrol-course-form" method="post">
									<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
										<input type="hidden" name="tutor_course_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
										<input type="hidden" name="tutor_course_action" value="_tutor_course_enroll_now">
										<?php 
										// check is public course
										//if(tutor_utils()->_tutor_is_public_course($course_id) == "yes") {
										?>
											<button type="submit" class="__check_enroll_course tutor-btn add_to_cart_btn tutor-btn-primary tutor-btn-lg tutor-btn-full tutor-mt-24 tutor-enroll-course-button">
											<?php esc_html_e( 'Enroll', 'tutor' ); 
											?>
											</button>
										<?php 
										//}
										?>
									</form>
								</div>
								<a href="#" class=" tutor-mt-16 tutor-btn-ghost tutor-btn-ghost-fd action-btn tutor-fs-6 tutor-fw-normal tutor-color-black tutor-course-wishlist-btn" data-course-id="<?php echo get_the_ID(); ?>">
									<i class="tutor-icon-heart-filled icon_heart"></i> <?php //_e('Wishlist', 'tutor'); ?>
								</a>
							<?php							
						}
						?>
						
						</div>
						</div>
						
					</div>
					<?php
						if ( ! is_user_logged_in() ) {
							tutor_load_template_from_custom_path( tutor()->path . '/views/modal/login.php' );
						}
					?>
					<?php do_action('tutor_course/single/after/sidebar'); ?>
					<?php do_action('tutor_course/single/after/sidebar'); ?>
                </div>
            </div>
			
            <!-- end of /.tutor-course-details-page-main-right -->
        </div>
		<div class=" tutor-align-items-center mt-4">
				<div class="tutor-fs-5 tutor-fw-bold mb-3">
					<?php _e('FREQUENTLY BOUGHT TOGETHER', 'tutor'); ?>
				</div>
				<div>
				<?php
					$wishlists    = tutor_utils()->get_courses_frequently(get_the_ID(),4);
					if (is_array($wishlists) && count($wishlists)): ?>
						<div class="tutor-course-listing-grid tutor-course-listing-grid-4">
							<?php
								foreach ($wishlists as $post) {
									setup_postdata($post);

									/**
									 * @hook tutor_course/archive/before_loop_course
									 * @type action
									 * Usage Idea, you may keep a loop within a wrap, such as bootstrap col
									 */
									do_action('tutor_course/archive/before_loop_course');

									tutor_load_template('loop.course');

									/**
									 * @hook tutor_course/archive/after_loop_course
									 * @type action
									 * Usage Idea, If you start any div before course loop, you can end it here, such as </div>
									 */
									do_action('tutor_course/archive/after_loop_course');
								}
								wp_reset_postdata();
							?>
						</div>
					<?php else: ?>
						<?php tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() ); ?>
					<?php endif; ?>	
				</div>
			</div>
        <!-- end of /.tutor-course-details-page-main -->
    </div>
</div>

<?php do_action('tutor_course/single/after/wrap'); ?>

<?php
tutor_utils()->tutor_custom_footer();