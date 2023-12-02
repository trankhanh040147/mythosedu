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
<div style = " <?php echo $style;?> "  <?php tutor_post_class('tutor-full-width-course-top tutor-course-top-info tutor-page-wrap course-student-main'); ?>>

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
						//if(time() >= strtotime($tutor_course_start_date)){							
						//}
					?>
					<?php if($tutor_course_start_date): ?>
					<div class="tutor-course-details-widget tutor-course-details-widget-col-1 tutor-mt-lg-50 tutor-mt-32">
						<div class="tutor-course-details-widget-title tutor-mb-16">
							<span class="tutor-fs-5 tutor-fw-bold mb-3">
								<?php echo esc_html( apply_filters( 'tutor_course_benefit_title', __( "COURSE CONTENT", 'tutor' ) ) ); ?>
							</span>
						</div>
						<div>
							<?php
								$course_duration = get_tutor_course_duration_context(get_the_ID(), true);
							?>
							<div class="curriculum_head">
							<span class="">
								<?php
									$obj_name = tutor_utils()->get_topics( get_the_ID() );
									echo  $obj_name->post_count;
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
									$obj_name = tutor_utils()->get_course_content_ids_by( tutor()->lesson_post_type, tutor()->course_post_type, get_the_ID() );	
									$count_lectures = count($obj_name);
									echo $count_lectures;
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
							<?php 
								echo get_the_content();
							?>
						</div>
					</div>
					
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

					<?php do_action( 'tutor_course/single/enrolled/after/reviews' ); //end check startdate?>
					<?php endif; ?>
					<?php endif; ?>
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
									$course_price = tutor_utils()->get_course_price($course_id);
									
									if(!$course_price)
										echo  esc_html_e( 'Free','tutor'  );
									else
										echo tutor_utils()->tutor_price($course_price);
									$is_public = get_post_meta( $course_id, '_tutor_is_public_course', true ) == 'yes';
									$login_class = (!is_user_logged_in() && !$is_public) ? 'tutor-course-entry-box-login' : '';	
						
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
                                <span class="tutor-fs-7 tutor-fw-medium tutor-color-black"><?php echo $count_lectures; ?></span>
								<?php echo  esc_html_e( 'LECTURES','tutor'  ); ?>
                            </div>
							<span class="_courses_durations_ tutor-fs-4 tutor-fw-medium tutor-color-muted">
								<?php echo  esc_html_e( ' - ','tutor'  ); ?>
							</span>
							<div class="tutor-d-flex tutor-align-items-center">
                                <span class="meta-icon tutor-icon-clock-filled tutor-color-muted tutor-icon-20 tutor-mr-3"></span>
                                <span class="tutor-fs-7 tutor-fw-medium tutor-color-black"><?php echo $course_duration; ?></span>
                            </div>
							
						</div>
						<?php if($tutor_course_start_date): ?>
						<div class=" text-regular-body tutor-color-black-60 tutor-d-flex tutor-align-items-center">
							<div class="tutor-d-flex tutor-align-items-center">
								<span class=""><i class="_ic_date" style="margin-right: 5px"></i> </span>
								<span><?php echo $tutor_course_start_date;?></span>
                            </div>
						</div>
						<?php endif; ?>
						<?php
								if ( $is_public ) {
									$lesson_url          = tutor_utils()->get_course_first_lesson(get_the_ID(),tutor()->lesson_post_type);
									if(!$lesson_url) $lesson_url = "#";
									?>
										<div class="text-regular-caption tutor-color-muted tutor-mt-12 ">
											<span class="tutor-color-success">
											<?php esc_html_e( 'This course is public', 'tutor' ); ?>
											</span>
										</div>
										<div class="pl-5 pr-5">										
										<a href="<?php echo $lesson_url;?>">
										<button type="submit" class="tutor-btn add_to_cart_btn tutor-btn-primary tutor-btn-lg tutor-btn-full tutor-mt-16 tutor-enroll-course-button">
										<?php esc_html_e( 'Start Learning', 'tutor' ); ?>
										</button>
										</a>
										</div>
										
									<?php
									}
									else{
									?>
									<div class="<?php echo $login_class; ?>  addtocart_grp text-regular-body tutor-color-black-60 tutor-d-flex tutor-align-items-center tutor-justify-content-between">
							
									<?php 
									// check is public course
									if(__USING_ASA_SYSTEM == "YES") {
										$course_id = get_the_ID();
										$is_public = get_post_meta( $course_id, '_tutor_is_public_course', true ) == 'yes';
										//echo tutor_utils()->_tutor_is_public_course($course_id) . "++" . $course_id . "++";
										if($is_public) {
									?>

										<button type="submit" class="__check_enroll_course tutor-btn add_to_cart_btn tutor-btn-primary tutor-btn-lg tutor-btn-full tutor-mt-24 tutor-enroll-course-button">
										<?php
										if ( $course_price ) {
										esc_html_e( 'ADD TO CART', 'tutor' ); 
										}
										else{
											esc_html_e( 'Enroll', 'tutor' ); 
										}
										?>
										</button>


									<?php 
									}
									} else {
									?>

										<button type="submit" class="__check_enroll_course tutor-btn add_to_cart_btn tutor-btn-primary tutor-btn-lg tutor-btn-full tutor-mt-24 tutor-enroll-course-button">
										<?php
										if ( $course_price ) {
										esc_html_e( 'ADD TO CART', 'tutor' ); 
										}
										else{
											esc_html_e( 'Enroll', 'tutor' ); 
										}
										?>
										</button>

									<?php 
									}
									
									?>
										
									</div>	
									<?php
									}
								?>
						
						</div>
						
					</div>
					<?php
						if ( ! is_user_logged_in() ) {
							tutor_load_template_from_custom_path( tutor()->path . '/views/modal/login.php' );
						}
					?>
					<?php do_action('tutor_course/single/after/sidebar'); ?>
                </div>
            </div>
			
            <!-- end of /.tutor-course-details-page-main-right -->
        </div>
		<?php
		/*
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

							
									do_action('tutor_course/archive/before_loop_course');

									tutor_load_template('loop.course');

									
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
			<?php 
			*/
			?>
        <!-- end of /.tutor-course-details-page-main -->
    </div>
</div>

<?php do_action('tutor_course/single/after/wrap'); ?>

<?php
tutor_utils()->tutor_custom_footer();