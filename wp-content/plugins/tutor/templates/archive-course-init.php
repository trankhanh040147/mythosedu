<?php
	do_action( 'tutor_course/archive/before_loop' );
	
	global $wp_query;
	$found_courses = $wp_query->found_posts;
	if(current_user_can('administrator') || current_user_can(tutor()->instructor_role)){
?>
		<div class="text-regular-caption tutor-color-black-60">
			<?php esc_html_e( 'Found courses: ', 'tutor' ); ?>
			<span class="tutor-fs-7 tutor-fw-medium tutor-color-black"><?php echo $found_courses; ?></span>
		</div>
<?php
	}
	
if ( have_posts() ) :
	/* Start the Loop */

	tutor_course_loop_start();

	while ( have_posts() ) :
		the_post();
		/**
		 * @hook tutor_course/archive/before_loop_course
		 * @type action
		 * Usage Idea, you may keep a loop within a wrap, such as bootstrap col
		 */
		do_action( 'tutor_course/archive/before_loop_course' );

		tutor_load_template( 'loop.course' );

		/**
		 * @hook tutor_course/archive/after_loop_course
		 * @type action
		 * Usage Idea, If you start any div before course loop, you can end it here, such as </div>
		 */
		do_action( 'tutor_course/archive/after_loop_course' );
		endwhile;

	tutor_course_loop_end();

	else :

		/**
		 * No course found
		 */
		// tutor_load_template('course-none');
		tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() );

	endif;
	if ( isset($_POST['action']) && 'tutor_course_filter_ajax' === $_POST['action'] ) {
		tutor_load_template( 'loop.tutor-pagination_ajax' );
	} else {
		tutor_course_archive_pagination();
	}
	do_action( 'tutor_course/archive/after_loop' );

