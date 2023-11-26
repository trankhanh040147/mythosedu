<?php
/**
 * Template for displaying single lesson, assignment, quiz etc.
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

global $post;
global $previous_id;
global $next_id;

$currentPost = $post;

$method_map = array(
    'lesson' => 'tutor_lesson_content',
    'assignment' => 'tutor_assignment_content',
);

$content_id = tutor_utils()->get_post_id();
$course_id = tutor_utils()->get_course_id_by_subcontent( $content_id );
$contents = tutor_utils()->get_course_prev_next_contents_by_id($content_id);
$previous_id = $contents->previous_id;
$next_id = $contents->next_id;

$course_stats = tutor_utils()->get_course_completed_percent( $course_id, 0, true );

$jsonData                                 = array();
$jsonData['post_id']                      = get_the_ID();
$jsonData['best_watch_time']              = 0;
$jsonData['autoload_next_course_content'] = (bool) get_tutor_option( 'autoload_next_course_content' );

$best_watch_time = tutor_utils()->get_lesson_reading_info( get_the_ID(), 0, 'video_best_watched_time' );
if ( $best_watch_time > 0 ) {
	$jsonData['best_watch_time'] = $best_watch_time;
}

$is_comment_enabled = tutor_utils()->get_option( 'enable_comment_for_lesson' ) && comments_open();
$is_enrolled = tutor_utils()->is_enrolled( $course_id );
$enable_q_and_a_on_course   = tutor_utils()->get_option( 'enable_q_and_a_on_course' );
$enable_spotlight_mode = tutor_utils()->get_option( 'enable_spotlight_mode' );
extract($data); // $context, $html_content

function tutor_course_single_sidebar( $echo = true, $context='desktop' ) {
    ob_start();
    tutor_load_template( 'single.lesson.lesson_sidebar', array('context' => $context) );
    $output = apply_filters( 'tutor_lesson/single/lesson_sidebar', ob_get_clean() );

    if ( $echo ) {
        echo tutor_kses_html( $output );
    }

    return $output;
}

do_action( 'tutor/course/single/content/before/all', $course_id, $content_id );

$h5p_id = tutor_utils()->get_h5p_option($content_id, 'h5p_id');

get_tutor_header();

tutor_utils()->tutor_custom_header();

if($h5p_id) {
	$enable_h5p_points_to_course = tutor_utils()->get_h5p_option($content_id, 'enable_h5p_points_to_course');
	$grade_category = tutor_utils()->get_h5p_option($content_id, 'grade_category');
	$passing_grade = tutor_utils()->get_grade_value($grade_category,$course_id);
	$h5p_fullscreen = tutor_utils()->get_h5p_option($content_id, 'h5p_fullscreen');
} 
?>
<?php do_action('tutor_'.$context.'/single/before/wrap'); 
if(!$h5p_fullscreen):
?>
	<div class="tutor-container">
		<div class="tutor-topbar-left-item tutor-d-flex pb-3">
			<div class="tutor-topbar-item tutor-topbar-sidebar-toggle tutor-hide-sidebar-bar flex-center tutor-d-none tutor-d-xl-flex">
				<a  href="<?php echo esc_url( get_permalink($course_id) ); ?>" class="h5pleave h5p-leave">
					<span class="tutor-icon-icon-light-left-line tutor-color-black flex-center text-bold-caption"></span>
				</a>
			</div>
			<div class="tutor-topbar-item tutor-topbar-content-title-wrap flex-center ">
				<span class="text-regular-caption tutor-color-design-black text-bold-caption">
					<?php echo get_the_title($course_id); ?>				</span>
			</div>
		</div>
		<div class="tutor-lesson-page-main">
            <div class="tutor-lesson-page-main-right">
				<div class="text-medium-h7 tutor-color-text-brand pr-4">COURSE CONTENT</div>
				<?php
				$topics = tutor_utils()->get_topics( $course_id );
				if ( $topics->have_posts() ) {
					while ( $topics->have_posts() ) {
						$topics->the_post();
						$topic_id       = get_the_ID();
						$topic_title  = get_the_title();
						$topic_summery  = get_the_content();
						$total_contents = tutor_utils()->count_completed_contents_by_topic( $topic_id );
						?>

						<div class="tutor-topics-in-single-lesson tutor-topics-<?php echo $topic_id; ?>">
							<div class="pt-3 tutor-topic-group tutor-topic-group-<?php echo $topic_id; ?>">
								<span class='tutor-fs-6 tutor-icon-layer-filled'></span>								
								<span class="lesson_title tutor-fs-6 tutor-fw-bold tutor-color-black-70">
									<?php echo $topic_title;?>
								</span>								
							</div>
							<?php
								do_action( 'tutor/lesson_list/before/topic', $topic_id );
								$lessons = tutor_utils()->get_course_contents_by_topic( get_the_ID(), -1 );
								$is_enrolled = tutor_utils()->is_enrolled( $course_id, get_current_user_id() );

								while ( $lessons->have_posts() ) {
									$lessons->the_post();
									$show_permalink = !$_is_preview || $is_enrolled || get_post_meta( $post->ID, '_is_preview', true );
									if ( $post->post_type === 'tutor_quiz' ) {
										$quiz = $post;
										?>
											<div class="pl-2 tutor-lessons-under-topic" data-quiz-id="<?php echo $quiz->ID; ?>">
												<div class="tutor-single-lesson-items <?php echo ( $currentPost->ID == get_the_ID() ) ? 'active tutor-color-design-brand' : ''; ?>">
													<a href="<?php echo $show_permalink ? get_permalink( $quiz->ID ) : '#'; ?>" class="h5pleave h5p-leave tutor-single-quiz-a tutor-d-flex tutor-justify-content-between" data-quiz-id="<?php echo $quiz->ID; ?>">
														<div class="tutor-single-lesson-items-left tutor-d-flex">
															<span class="tutor-fs-6 tutor-icon-quiz-filled"></span>
															<span class="lesson_title tutor-fs-7 tutor-fw-normal tutor-color-black-70">
																<?php echo $quiz->post_title; ?>
															</span>
														</div>
														<div class="tutor-single-lesson-items-right tutor-d-flex tutor-lesson-right-icons">
															<span class="text-regular-caption tutor-color-black-70">
																<?php
																	$time_limit = tutor_utils()->get_quiz_option( $quiz->ID, 'time_limit.time_value' );
																	if ( $time_limit ) {
																		$time_type = tutor_utils()->get_quiz_option( $quiz->ID, 'time_limit.time_type' );

																		$time_type=='minutes' ? $time_limit=$time_limit*60 : 0;
																		$time_type=='hours' ? $time_limit=$time_limit*3660 : 0;
																		$time_type=='days' ? $time_limit=$time_limit*86400 : 0;
																		$time_type=='weeks' ? $time_limit=$time_limit*86400*7 : 0;

																		// To Fix: If time larger than 24 hours, the hour portion starts from 0 again. Fix later.
																		echo gmdate('H:i:s', $time_limit);
																	}
																	
																	$has_attempt = tutor_utils()->has_attempted_quiz( get_current_user_id(), $quiz->ID )
																?>

															</span>
														</div>
													</a>
												</div>
											</div>
										<?php
											
									} elseif ( $post->post_type === 'tutor_assignments' ) {
										/**
										 * Assignments
											 *
										 * @since this block v.1.3.3
										*/ 
										?>
										<!--
											<div class="tutor-lessons-under-topic">
												<div class="tutor-single-lesson-items <?php echo ( $currentPost->ID == get_the_ID() ) ? 'active tutor-color-design-brand' : ''; ?>">
													<a href="<?php echo $show_permalink ? get_permalink( $post->ID ) : '#'; ?>" class="tutor-single-assignment-a tutor-d-flex tutor-justify-content-between" data-assignment-id="<?php echo $post->ID; ?>">
														<div class="tutor-single-lesson-items-left tutor-d-flex">
															<span class="tutor-icon-assignment-filled"></span>
															<span class="lesson_title tutor-fs-7 tutor-fw-bold  tutor-color-black-70">
																<?php echo $post->post_title; ?>
															</span>
														</div>
														<div class="tutor-single-lesson-items-right tutor-d-flex tutor-lesson-right-icons">
															
														</div>
													</a>
												</div>
											</div>
										-->	
										<?php
									} elseif ( $post->post_type === 'tutor_zoom_meeting' ) {
										/**
										 * Zoom Meeting
											 *
										 * @since this block v.1.7.1
										 */
										?>
											<div class="tutor-lessons-under-topic">
												<div class="tutor-single-lesson-items <?php echo ( $currentPost->ID == get_the_ID() ) ? 'active tutor-color-design-brand' : ''; ?>">
													<a href="<?php echo $show_permalink ? esc_url( get_permalink( $post->ID ) ) : '#'; ?>" class="sidebar-single-zoom-meeting-a tutor-d-flex tutor-justify-content-between">
														<div class="tutor-single-lesson-items-left tutor-d-flex">
															<span class="tutor-icon-zoom"></span>
															<span class="lesson_title tutor-fs-7 tutor-fw-normal tutor-color-black-70">
																<?php echo esc_html( $post->post_title ); ?>
															</span>
														</div>
														<div class="tutor-single-lesson-items-right tutor-d-flex tutor-lesson-right-icons">
															
														</div>
													</a>
												</div>
											</div>
										<?php
										
									} else {

										/**
										 * Lesson
										 */

										$video = tutor_utils()->get_video_info();

										$play_time = false;
										if ( $video ) {
											$play_time = $video->playtime;
										}
										$is_completed_lesson = tutor_utils()->is_completed_lesson();
										?>
											<div class="pl-2 tutor-lessons-under-topic">
												<div class="tutor-single-lesson-items <?php echo ( $currentPost->ID == get_the_ID() ) ? 'active tutor-color-design-brand' : ''; ?>">
													<a href="<?php echo $show_permalink ? get_the_permalink() : '#'; ?>" class="h5pleave h5p-leave tutor-single-lesson-a" data-lesson-id="<?php the_ID(); ?>">
														<div class="tutor-single-lesson-items-left tutor-d-flex">
															<?php
																$tutor_lesson_type_icon = 'education-filled';//$play_time ? 'youtube-brand' : 'document-file';
																echo "<span class='tutor-fs-6 tutor-icon-$tutor_lesson_type_icon'></span>";
															?>
															<span class="lesson_title tutor-fs-6 tutor-fw-normal tutor-color-black-70">
																<?php the_title(); ?>
															</span>
														</div>
														<div class="tutor-single-lesson-items-right tutor-d-flex">
															<?php
																do_action( 'tutor/lesson_list/right_icon_area', $post );
																if ( $play_time ) {
																	//echo "<span class='text-regular-caption tutor-color-black-70 pl-4'>Class time: " . tutor_utils()->get_optimized_duration( $play_time ) . '</span>';
																}
																
															?>
														</div>
													</a>
												</div>
											</div>
										<?php
									}
								}
								$lessons->reset_postdata();
								do_action( 'tutor/lesson_list/after/topic', $topic_id );
							?>
						</div>
						<?php
					}
					$topics->reset_postdata();
					wp_reset_postdata();
				}
				?>
			
			</div>
			<div class="tutor-lesson-page-main-left">
			<?php if($context=='quiz'): ?>
			<?php echo isset($html_content) ? $html_content  : '' ; ?>
			<?php endif; ?>
			<?php if($context=='lesson'): ?>
				<?php
					$is_completed_lesson = tutor_utils()->is_completed_lesson($content_id,get_current_user_id());
					if ( ! $is_completed_lesson) {
						tutor_utils()->mark_lesson_complete( $content_id,get_current_user_id() );
					}
					$video = tutor_utils()->get_video_info();
					if ( $video ) {
						tutor_lesson_video();
					}
					else{
						the_content();
					}
				?>
			<div class="tutor-course-spotlight-wrapper">
	<div class="tutor-spotlight-tab tutor-default-tab tutor-course-details-tab">
		<div class="tab-header tutor-d-flex justify-content-left">
			<div class="tab-header-item flex-center<?php echo (!isset($page_tab) || 'overview'==$page_tab) ? ' is-active' : ''; ?>" data-tutor-spotlight-tab-target="tutor-course-spotlight-tab-1" data-tutor-query-string="overview">
				<span class="tutor-icon-document-alt-filled"></span>
				<span><?php _e( 'OVERVIEW', 'tutor' ); ?></span>
			</div>
			<div class="tab-header-item flex-center<?php echo 'files'==$page_tab ? ' is-active' : ''; ?>" data-tutor-spotlight-tab-target="tutor-course-spotlight-tab-2" data-tutor-query-string="files">
				<span class="tutor-icon-attach-filled"></span>
				<span><?php _e( 'DOCUMENTS', 'tutor' ); ?></span>
			</div>
			<?php if ( $is_comment_enabled ) : ?>
				<div class="tab-header-item flex-center<?php echo 'comments'==$page_tab ? ' is-active' : ''; ?>" data-tutor-spotlight-tab-target="tutor-course-spotlight-tab-3" data-tutor-query-string="comments">
					<span class="tutor-icon-comment-filled"></span>
					<span><?php _e( 'NOTES', 'tutor' ); ?></span>
				</div>
			<?php endif; ?>
			<?php if ( $enable_q_and_a_on_course ) : ?>
				<div class="tab-header-item flex-center<?php echo 'qna'==$page_tab ? ' is-active' : ''; ?>" data-tutor-spotlight-tab-target="tutor-course-spotlight-tab-4" data-tutor-query-string="qna">
					<span class="tutor-icon-question-filled"></span>
					<span><?php _e( 'Q & A', 'tutor' ); ?></span>
				</div>
			<?php endif; ?>
		</div>			
		<div class="tab-body tab-lesson-page">
			<div class="tab-body-item<?php echo (!isset($page_tab) || 'overview'==$page_tab) ? ' is-active' : ''; ?>" id="tutor-course-spotlight-tab-1" data-tutor-query-string-content="overview">
				<div class="text-medium-h6 tutor-color-black">
					<?php// _e( 'About Lesson', 'tutor' ); ?>
				</div>
				<div class="text-regular-body tutor-color-black-60 tutor-mt-12" style="min-height:293px;">
					<?php the_content(); echo do_shortcode( "[h5p id='".$h5p_id."']" );?>
				</div>
			</div>
			<div class="tab-body-item<?php echo 'files'==$page_tab ? ' is-active' : ''; ?>" id="tutor-course-spotlight-tab-2" data-tutor-query-string-content="files">
				<div class="text-medium-h6 tutor-color-black"><?php _e( 'Files', 'tutor' ); ?></div>
				<?php get_tutor_posts_attachments(); ?>
			</div>
			<?php if ( $is_comment_enabled ) : ?>
				<div class="tab-body-item<?php echo 'comments'==$page_tab ? ' is-active' : ''; ?>" id="tutor-course-spotlight-tab-3" data-tutor-query-string-content="comments">
					<?php require __DIR__ . '/single/lesson/comment.php'; ?>
				</div>
			<?php endif; ?>
			<?php if ( $enable_q_and_a_on_course ) : ?>
				<div class="tab-body-item<?php echo 'qna'==$page_tab ? ' is-active' : ''; ?>" id="tutor-course-spotlight-tab-4" data-tutor-query-string-content="qna">
					<?php require __DIR__ . '/single/lesson/sidebar_question_and_answer.php'; ?>
				</div>
			<?php endif; ?>
					</div>
	</div>
</div>	
			<?php endif; ?>
			</div>
			
		</div>
			
	</div>
<?php 

else:
	
	echo do_shortcode( "[h5p id='".$h5p_id."']" );
?>
	<style>
		.h5p-iframe-wrapper{padding: 2% 10%!important;}
		header,footer{display:none!important;}
	</style>
<?php

endif;

do_action('tutor_'.$context.'/single/after/wrap');

tutor_utils()->tutor_custom_footer();
if($h5p_id):
?>
	<script>
	jQuery(function($){											
		$(document).on('click', 'a.h5p-leave', function (event) {
    		var href = $(this).attr('href');    
      		event.preventDefault();
      		event.stopImmediatePropagation();
			var popup;
			var data = {
						title: 'Abandon H5P?',
						description: 'Do you want to leave this page?',
						buttons: {
							keep: {
								title: 'Yes, leave',
								id: 'leave',
								"class": 'tutor-btn tutor-is-outline tutor-is-default',
								callback: function callback() {
									location.href = href;								
								}
							},
							reset: {
								title: 'Stay here',
								id: 'reset',
								"class": 'tutor-btn',
								callback: function callback() {
								popup.remove();
								}
							}
						}
					};
			popup = new window.tutor_popup($, '', 40).popup(data);
		});
	});				
 	</script>
<?php
endif;
?>