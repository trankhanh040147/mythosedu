<?php
/**
 * Template for displaying single live meeting page
 *
 * @since v.1.7.1
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.7.1
 */

get_tutor_header();

global $post;
$currentPost  = $post;
$zoom_meeting = tutor_zoom_meeting_data( $post->ID );
$meeting_data = $zoom_meeting->data;
$browser_url  = "https://us04web.zoom.us/wc/join/{$meeting_data['id']}?wpk={$meeting_data['encrypted_password']}";
$browser_text = __( 'Join in Browser', 'tutor-pro' );

if ( get_current_user_id() == $post->post_author ) {
	$browser_url  = $meeting_data['start_url'];
	$browser_text = __( 'Start Meeting', 'tutor-pro' );
}

$enable_spotlight_mode = tutor_utils()->get_option( 'enable_spotlight_mode' );

$show_error = apply_filters( 'tutor_zoom/single/content', null );

// Get the ID of this content and the corresponding course.
$course_content_id = get_the_ID();
$topic_id          = wp_get_post_parent_id( $course_content_id );
$course_id         = wp_get_post_parent_id( $topic_id );
$course_progress   = tutor_utils()->get_course_completed_percent( $course_id, 0, true );
// Get total content cont.
$course_stats = tutor_utils()->get_course_completed_percent( $course_id, 0, true );
?>

<?php ob_start(); ?>
	<!-- new topbar -->
	<div class="tutor-single-page-top-bar tutor-d-flex tutor-justify-between">
		<div class="tutor-topbar-left-item tutor-d-flex">
			<div class="tutor-topbar-item tutor-topbar-sidebar-toggle tutor-hide-sidebar-bar tutor-d-flex tutor-d-none tutor-d-xl-flex">
				<a href="javascript:;" class="tutor-lesson-sidebar-hide-bar tutor-d-flex tutor-align-center">
					<span class="tutor-icon-left tutor-color-white"></span>
				</a>
			</div>
			<div class="tutor-topbar-item tutor-topbar-content-title-wrap tutor-d-flex tutor-align-center">
				<span class="tutor-icon-brand-zoom-o tutor-color-white tutor-mr-8"></span>
				<span class="tutor-fs-7 tutor-color-white">
					<?php echo esc_html( $post->post_title ); ?>
				</span>
			</div>
		</div>
		<div class="tutor-topbar-right-item tutor-d-flex">
			<div class="tutor-topbar-assignment-details tutor-d-flex  tutor-align-center">
				<div class="tutor-fs-7 tutor-color-white">
					<?php if ( true == get_tutor_option( 'enable_course_progress_bar' ) ) : ?>
						<span class="tutor-progress-content color-primary-60">
							<?php esc_html_e( 'Your Progress:', 'tutor-pro' ); ?>
						</span>
						<span class="tutor-fs-7 tutor-fw-bold">
							<?php echo esc_html( isset( $course_progress['completed_count'] ) ? $course_progress['completed_count'] : '' ); ?>
						</span>
						<?php esc_html_e( 'of', 'tutor-pro' ); ?>
						<span class="tutor-fs-7 tutor-fw-bold">
							<?php echo esc_html( isset( $course_progress['total_count'] ) ? $course_progress['total_count'] : '' ); ?>
						</span>
						(<?php echo esc_html( $course_progress['completed_percent'] ); ?>%)
					<?php endif; ?>
				</div>
				<!-- <div class="tutor-topbar-complete-btn tutor-ml-32 pro"> -->
					<?php
					// show complete button if meeting ended.
					if ( $zoom_meeting->is_expired ) {
						tutor_lesson_mark_complete_html();
					}
					?>
				<!-- </div> -->
			</div>
			<div class="tutor-topbar-cross-icon tutor-ml-16 tutor-d-flex tutor-align-center">
				<a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>">
					<span class="tutor-icon-times tutor-color-white tutor-d-flex tutor-align-center"></span>
				</a>
			</div>
		</div>
	</div>
	<!-- new topbar end -->
	<!--zoom content-->
	<?php if ( $show_error ) : ?>
		<?php echo $show_error; ?>
	<?php else : ?>
		<div class="tutor-zoom-meeting-content">
			<?php if ( $zoom_meeting->is_expired ) { ?>
				<div class="tutor-zoom-meeting-expired-msg-wrap">
					<h2 class="meeting-title"><?php echo esc_html( $post->post_title ); ?></h2>
					<div class="msg-expired-section">
						<img src="<?php echo esc_url( TUTOR_ZOOM()->url . 'assets/images/zoom-icon-expired.png' ); ?>" alt="" />
						<div>
							<h3 class="tutor-mb-9"><?php esc_html_e( 'The video conference has expired', 'tutor-pro' ); ?></h3>
							<p><?php esc_html_e( 'Please contact your instructor for further information', 'tutor-pro' ); ?></p>
						</div>
					</div>
					<div class="meeting-details-section">
						<p><?php echo wp_kses_post( $post->post_content ); ?></p>
						<div>
							<div>
								<span><?php esc_html_e( 'Meeting Date', 'tutor-pro' ); ?>:</span>
								<p><?php echo esc_html( $zoom_meeting->start_date ); ?></p>
							</div>
							<div>
								<span><?php esc_html_e( 'Host Email', 'tutor-pro' ); ?>:</span>
								<p><?php echo esc_html( $meeting_data['host_email'] ); ?></p>
							</div>
						</div>
					</div>
				</div>
				<?php
			} else {
				?>
				<div class="zoom-meeting-countdown-wrap">
					<p><?php esc_html_e( 'Meeting Starts in', 'tutor-pro' ); ?></p>
					<div class="tutor-zoom-meeting-countdown" data-timer="<?php echo esc_attr( $zoom_meeting->countdown_date ); ?>" data-timezone="<?php echo esc_attr( $zoom_meeting->timezone ); ?>"></div>
					<div class="tutor-zoom-join-button-wrap">
						<a href="<?php echo esc_url( $browser_url ); ?>" target="_blank" class="tutor-btn tutor-d-block"><?php echo esc_html( $browser_text ); ?></a>
						<a href="<?php echo esc_url( $meeting_data['join_url'] ); ?>" target="_blank" class="tutor-btn tutor-is-outline tutor-d-block"><?php esc_html_e( 'Join in Zoom App', 'tutor-pro' ); ?></a>
					</div>
				</div>
				<div class="zoom-meeting-content-wrap">
					<h2 class="meeting-title"><?php echo esc_html( $post->post_title ); ?></h2>
					<p class="meeting-summary"><?php echo esc_html( $post->post_content ); ?></p>
					<div class="meeting-details">
						<div>
							<span><?php esc_html_e( 'Meeting Date', 'tutor-pro' ); ?></span>
							<p><?php echo esc_html( $zoom_meeting->start_date ); ?></p>
						</div>
						<div>
							<span><?php esc_html_e( 'Meeting ID', 'tutor-pro' ); ?></span>
							<p><?php echo esc_html( $meeting_data['id'] ); ?></p>
						</div>
						<div>
							<span><?php esc_html_e( 'Password', 'tutor-pro' ); ?></span>
							<p><?php echo esc_html( $meeting_data['password'] ); ?></p>
						</div>
						<div>
							<span><?php esc_html_e( 'Host Email', 'tutor-pro' ); ?></span>
							<p><?php echo esc_html( $meeting_data['host_email'] ); ?></p>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	<?php endif; ?>
<?php
	$html_content = ob_get_clean();
	tutor_load_template_from_custom_path(
		tutor()->path . '/templates/single-content-loader.php',
		array(
			'context'      => 'zoom',
			'html_content' => $html_content,
		),
		false
	);
