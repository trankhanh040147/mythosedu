<?php
$course_id   = get_the_ID();
$zoom_object = new \TUTOR_ZOOM\Zoom( false );

// Get meetings for single course
$zoom_meetings = $zoom_object->get_meetings(
	$per_page  = 10,
	$paged     = 1,
	$_filter   = 'active',
	array(
		'course_id' => $course_id,
	),
	false
);

$is_enrolled           = tutor_utils()->is_enrolled( $course_id );
$is_administrator      = current_user_can( 'administrator' );
$is_instructor         = tutor_utils()->is_instructor_of_this_course();
$course_content_access = (bool) get_tutor_option( 'course_content_access_for_ia' );

if ( $is_enrolled || ( $course_content_access && ( $is_administrator || $is_instructor ) ) ) {
	if ( ! empty( $zoom_meetings ) ) {
		?>
		<div class="tutor-single-course-segment tutor-course-topics-wrap">
			<div class="tutor-course-topics-header">
				<div class="tutor-course-topics-header-left">
					<h4 class="tutor-segment-title"><?php esc_html_e( 'Zoom Live Meetings', 'tutor-pro' ); ?></h4>
				</div>
			</div>
			<div class="tutor-course-topics-contents">
				<?php
				$index = 0;
				foreach ( $zoom_meetings as $meeting ) {
					$zoom_meeting = tutor_zoom_meeting_data( $meeting->ID );
					$meeting_data = $zoom_meeting->data;

					if(empty($meeting_data['id'])){
						continue;
					}
					
					?>
					<div class="tutor-course-topic tutor-zoom-meeting <?php echo esc_html( ( 0 === $index ) ? 'tutor-active' : '' ); ?>">
						<div class="tutor-course-title">
							<div class="tutor-zoom-meeting-detail">
								<h3>
									<?php echo esc_html( $meeting->post_title ); ?>
									<?php
									if ( $meeting->is_expired ) {
										echo '<span class="tutor-zoom-label">' . __( 'Expired', 'tutor-pro' ) . '</span>';
									} elseif ( $meeting->is_running ) {
										echo '<span class="tutor-zoom-label tutor-zoom-live-label">' . __( 'Live', 'tutor-pro' ) . '</span>';
									}
									?>
								</h3>
								<div>
									<p><?php esc_html_e( 'ID', 'tutor-pro' ); ?>: <span><?php echo $meeting_data['id']; ?></span> <i class="tutor-icon-copy tutor-copy-text" data-text="<?php echo $meeting_data['id']; ?>"></i></p>
									<p><?php esc_html_e( 'Password', 'tutor-pro' ); ?>: <span><?php echo $meeting_data['password']; ?></span> <i class="tutor-icon-copy tutor-copy-text" data-text="<?php echo $meeting_data['password']; ?>"></i></p>
								</div>
							</div>
							<div class="tutor-zoom-meeting-toggle-icon">
								<i class="tutor-icon-angle-right"></i>
							</div>
						</div>
						<div class="tutor-course-lessons tutor-zoom-meeting-session" style="display: <?php echo ( $index == 0 ) ? 'block' : 'none'; ?>">
							<?php if ( $zoom_meeting->is_expired ) { ?>
								<div class="msg-expired-section">
									<img src="<?php echo esc_url( TUTOR_ZOOM()->url . 'assets/images/zoom-icon-expired.png' ); ?>" alt="" />
									<div>
										<h3><?php esc_html_e( 'The video conference has expired', 'tutor-pro' ); ?></h3>
										<p><?php esc_html_e( 'Please contact your instructor for further information', 'tutor-pro' ); ?></p>
									</div>
								</div>
								<?php
							} else {
								?>
								<div class="tutor-zoom-meeting-countdown" data-timer="<?php echo esc_attr( $zoom_meeting->countdown_date ); ?>" data-timezone="<?php echo esc_attr( $zoom_meeting->timezone ); ?>">
								</div>
								<div class="session-link">
									<p><?php esc_html_e( 'Host Email', 'tutor-pro' ); ?>: <?php echo esc_html( $meeting_data['host_email'] ); ?></p>
									<a href="<?php echo esc_url( get_permalink( $meeting->ID ) ); ?>" class="tutor-btn tutor-btn-outline-primary"><?php esc_html_e( 'Continue to Meeting', 'tutor-pro' ); ?></a>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
					$index++;
				}
				?>
			</div>
		</div>
		<?php
	}
} ?>
