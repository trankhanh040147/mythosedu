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

get_tutor_header();
tutor_utils()->tutor_custom_header();

$lesson_url          = tutor_utils()->get_course_first_lesson($course_id,tutor()->lesson_post_type);
if(!$lesson_url) $lesson_url = "/dashboard";
?>

<?php do_action('tutor_'.$context.'/single/before/wrap'); ?>
	<div class="tutor-container">
		<div class="tutor-topbar-left-item tutor-d-flex pb-3">
			<div class="tutor-topbar-item tutor-topbar-sidebar-toggle tutor-hide-sidebar-bar flex-center tutor-d-none tutor-d-xl-flex">
				<a href="<?php echo $lesson_url;?>" class="">
					<span class="tutor-icon-icon-light-left-line tutor-color-black flex-center text-bold-caption"></span>
				</a>
			</div>
			<div class="tutor-topbar-item tutor-topbar-content-title-wrap flex-center ">
				<span class="text-regular-caption tutor-color-design-black text-bold-caption">
					<?php echo get_the_title($course_id); ?>				</span>
			</div>
		</div>
		<div class="tutor-lesson-page-main-quiz">
			<div class="tutor-lesson-page-main-left">
			<?php if($context=='quiz'): ?>
			<?php echo isset($html_content) ? $html_content  : '' ; ?>
			<?php endif; ?>
			<?php if($context=='lesson'): ?>
				<?php 
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
					<?php the_content(); ?>
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
<?php do_action('tutor_'.$context.'/single/after/wrap');

tutor_utils()->tutor_custom_footer();